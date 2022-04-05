<?php

namespace App\ApiClients\Supermetrics;

use App\ApiClients\Base\ApiClientInterface;
use App\ApiClients\Base\ApiRequestInterface;
use App\ApiClients\Base\ApiResponseInterface;
use App\ApiClients\Base\BaseApiClient;
use App\Services\ConfigService;
use Exception;

class SupermetricsApiClient extends BaseApiClient implements ApiClientInterface
{
    protected const SESSION_TOKEN_NAME = 'supermetrics_token';
    private string $host;
    private string $authPath;
    private string $postsPath;
    private string $clientId;
    private string $email;
    private string $name;

    public function __construct()
    {
        $apiConfigs = ConfigService::getInstance()->get('supermetrics_api');

        $this->host = $apiConfigs['host'];
        $this->authPath = $apiConfigs['auth_path'];
        $this->postsPath = $apiConfigs['posts_path'];
        $this->clientId = $apiConfigs['client_id'];
        $this->email = $apiConfigs['email'];
        $this->name = $apiConfigs['name'];
    }

    /**
     * @return ApiResponseInterface
     * @throws Exception
     */
    public function authRequest(): ApiResponseInterface
    {
        $request = new SupermetricsApiRequest();
        $request
            ->setMethod('POST')
            ->setUrl($this->getUrl($this->authPath))
            ->setData([
                'client_id' => $this->clientId,
                'email' => $this->email,
                'name' => $this->name,
            ])
            ->setIsJson(false);

        $response = $this->request($request);

        if ($response->hasToken()) {
            $this->setToken($response->getToken());
        } else {
            throw new Exception("Can't login to Supermetrics API");
        }

        return $response;
    }

    /**
     * @param string $path
     * @return string
     */
    private function getUrl(string $path): string
    {
        return sprintf('%s%s', $this->host, $path);
    }

    /**
     * @param ApiRequestInterface $request
     * @return ApiResponseInterface
     * @throws Exception
     */
    public function request(ApiRequestInterface $request): ApiResponseInterface
    {
        $data = $this->baseRequest($request);

        return new SupermetricsApiResponse($data);
    }

    /**
     * @param int $page
     * @return SupermetricsApiResponse
     * @throws Exception
     */
    public function getPosts(int $page = 1): SupermetricsApiResponse
    {
        $request = new SupermetricsApiRequest();
        $request
            ->setMethod('GET')
            ->setUrl($this->getUrl($this->postsPath))
            ->setToken($this->getToken())
            ->setData([
                'page' => $page,
            ]);

        return $this->tokenizedRequest($request);
    }
}