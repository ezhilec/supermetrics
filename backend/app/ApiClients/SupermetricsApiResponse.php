<?php

namespace App\ApiClients;

class SupermetricsApiResponse implements ApiResponseInterface
{
    private ?array $data = null;

    private ?array $error = null;

    public function __construct(array $data)
    {
        $this->data = $data['data'] ?? null;
        $this->error = $data['error'] ?? null;
    }

    public function getData(): array
    {
        return $this->data ?? [];
    }

    public function hasToken(): bool
    {
        return (bool)$this->getToken();
    }

    public function getToken(): ?string
    {
        if (isset($this->data['sl_token'])) {
            return $this->data['sl_token'];
        }

        return null;
    }

    public function getError(): string
    {
        if (isset($this->error['message'])) {
            return $this->error['message'];
        }

        return 'Undefined error';
    }

    public function hasError(): bool
    {
        return (bool)$this->error;
    }

    public function hasTokenError(): bool
    {
        if ($this->getError() === 'Invalid SL Token') {
            return true;
        }

        return false;
    }
}