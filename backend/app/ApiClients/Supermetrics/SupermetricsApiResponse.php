<?php

namespace App\ApiClients\Supermetrics;

use App\ApiClients\Base\ApiResponseInterface;

class SupermetricsApiResponse implements ApiResponseInterface
{
    private ?array $data = null;

    private ?array $error = null;

    public function __construct(array $data)
    {
        $this->data = $data['data'] ?? null;
        $this->error = $data['error'] ?? null;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data ?? [];
    }

    /**
     * @return bool
     */
    public function hasToken(): bool
    {
        return (bool)$this->getToken();
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        if (isset($this->data['sl_token'])) {
            return $this->data['sl_token'];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        if (isset($this->error['message'])) {
            return $this->error['message'];
        }

        return 'Undefined error';
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return (bool)$this->error;
    }

    /**
     * @return bool
     */
    public function hasTokenError(): bool
    {
        if ($this->getError() === 'Invalid SL Token') {
            return true;
        }

        return false;
    }
}