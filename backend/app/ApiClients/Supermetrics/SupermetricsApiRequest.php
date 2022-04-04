<?php

namespace App\ApiClients\Supermetrics;

use App\ApiClients\Base\ApiRequestInterface;

class SupermetricsApiRequest implements ApiRequestInterface
{
    private string $method = 'GET';
    private string $url;
    private array $data = [];
    private bool $isJson = true;
    private ?string $token = null;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): SupermetricsApiRequest
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): SupermetricsApiRequest
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): SupermetricsApiRequest
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsJson(): bool
    {
        return $this->isJson;
    }

    /**
     * @param bool $isJson
     * @return $this
     */
    public function setIsJson(bool $isJson): SupermetricsApiRequest
    {
        $this->isJson = $isJson;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return $this
     */
    public function setToken(?string $token): SupermetricsApiRequest
    {
        $this->token = $token;
        $this->data['sl_token'] = $token;

        return $this;
    }

}