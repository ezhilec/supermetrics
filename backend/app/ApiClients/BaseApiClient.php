<?php

namespace App\ApiClients;

use \Exception;

abstract class BaseApiClient
{
    private const SESSION_TOKEN_NAME = 'token';

    /**
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
            throw new \Exception("Can't connect to API");
        }
        curl_close($curl);

        return json_decode($curlResponse, true);
    }

    protected function tokenizedRequest(ApiRequestInterface $request): ApiResponseInterface
    {
        if (!$request->getToken()) {
            $this->authRequest();
            $request->setToken($this->getToken());

            if (!$this->getToken()) {
                throw new \Exception("Can't login to API");
            }
        }

        $response = $this->request($request);

        if ($response->hasTokenError()) {
            $this->authRequest();
            $request->setToken($this->getToken());

            $response = $this->request($request);
        } elseif ($response->hasError()) {
            $message = $response->getError();
            throw new \Exception("API connection error: $message");
        }

        return $response;
    }

    protected function setToken($token): void
    {
        $_SESSION[self::SESSION_TOKEN_NAME] = $token;
    }

    protected function getToken(): ?string
    {
        return $_SESSION[self::SESSION_TOKEN_NAME] ?? null;
    }

    abstract public function request(ApiRequestInterface $request): ApiResponseInterface;

    abstract public function authRequest(): ApiResponseInterface;
}