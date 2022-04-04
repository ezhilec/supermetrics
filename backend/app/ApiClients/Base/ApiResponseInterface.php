<?php

namespace App\ApiClients\Base;

interface ApiResponseInterface
{
    public function getData(): array;

    public function hasToken(): bool;

    public function getToken(): ?string;

    public function getError(): ?string;

    public function hasError(): bool;

    public function hasTokenError(): bool;
}