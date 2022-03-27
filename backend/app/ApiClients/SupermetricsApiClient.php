<?php

namespace App\ApiClients;

use App\Services\ConfigService;

class SupermetricsApiClient extends BaseApiClient implements ApiClientInterface
{
    private string $host;
    private string $authPath;
    private string $postsPath;
    private string $clientId;
    private string $email;
    private string $name;

    private const SESSION_TOKEN_NAME = 'supermetrics_token';

    public function __construct()
    {
        $apiConfigs = (new ConfigService())->get('supermetrics_api');

        $this->host = $apiConfigs['host'];
        $this->authPath = $apiConfigs['auth_path'];
        $this->postsPath = $apiConfigs['posts_path'];
        $this->clientId = $apiConfigs['client_id'];
        $this->email = $apiConfigs['email'];
        $this->name = $apiConfigs['name'];
    }

    private function getUrl(string $path): string
    {
        return sprintf('%s%s', $this->host, $path);
    }

    public function request(ApiRequestInterface $request): ApiResponseInterface
    {
        $data = $this->baseRequest($request);

        $response = new SupermetricsApiResponse($data);

        return $response;
    }

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
            throw new \Exception("Can't login to Supermetrics API");
        }

        return $response;
    }

    public function getPosts($page = 1): SupermetricsApiResponse
    {
        $request = new SupermetricsApiRequest();
        $request
            ->setMethod('GET')
            ->setUrl($this->getUrl($this->postsPath))
            ->setToken($this->getToken())
            ->setData([
                'sl_token' => $this->getToken(),
                'page' => $page,
            ]);


        return $this->tokenizedRequest($request);
    }
}