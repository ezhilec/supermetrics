<?php

namespace App\ApiClients\Base;

interface ApiRequestInterface
{
    public function getMethod(): string;

    public function setMethod(string $method): self;

    public function getUrl(): string;

    public function setUrl(string $url): self;

    public function getData(): array;

    public function setData(array $data): self;

    public function getIsJson(): bool;

    public function setIsJson(bool $isJson): self;

    public function getToken(): ?string;

    public function setToken(?string $token): self;
}