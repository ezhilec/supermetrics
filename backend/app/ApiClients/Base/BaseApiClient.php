<?php

namespace App\ApiClients\Base;

use Exception;

abstract class BaseApiClient
{
    private const SESSION_TOKEN_NAME = 'token';

    /**
     * @param ApiRequestInterface $request
     * @return array
     * @throws Exception
     */
    protected function baseRequest(ApiRequestInterface $request): array
    {
        $method = $request->getMethod();
        $url = $request->getUrl();
        $data = $request->getData();
        $isJson = $request->getIsJson();

        $curl = curl_init();
        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                if ($data) {
                    $url = sprintf('%s?%s', $url, http_build_query($data));
                }
        }

        curl_setopt($curl, CURLOPT_URL, $url);

        if ($isJson) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $curlResponse = curl_exec($curl);
        if (!$curlResponse) {
            throw new Exception("Can't connect to API");
        }
        curl_close($curl);

        return json_decode($curlResponse, true);
    }

    /**
     * @param ApiRequestInterface $request
     * @return ApiResponseInterface
     * @throws Exception
     */
    protected function tokenizedRequest(ApiRequestInterface $request): ApiResponseInterface
    {
        if (!$request->getToken()) {
            $this->authRequest();
            if (!$this->getToken()) {
                throw new Exception("Can't login to API");
            }
        }

        $request->setToken($this->getToken());
        $response = $this->request($request);

        if ($response->hasTokenError()) {
            $this->authRequest();

            $request->setToken($this->getToken());
            $response = $this->request($request);
        } elseif ($response->hasError()) {
            $message = $response->getError();
            throw new Exception("API connection error: $message");
        }

        return $response;
    }

    /**
     * @param string $token
     * @return void
     */
    protected function setToken(string $token): void
    {
        $_SESSION[static::SESSION_TOKEN_NAME] = $token;
    }

    /**
     * @return string|null
     */
    protected function getToken(): ?string
    {
        return $_SESSION[static::SESSION_TOKEN_NAME] ?? null;
    }

    /**
     * @param ApiRequestInterface $request
     * @return ApiResponseInterface
     */
    abstract public function request(ApiRequestInterface $request): ApiResponseInterface;

    /**
     * @return ApiResponseInterface
     */
    abstract public function authRequest(): ApiResponseInterface;
}