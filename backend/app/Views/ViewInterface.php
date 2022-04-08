<?php

namespace App\Views;

interface ViewInterface
{
    public static function render(bool $success, array $data): void;
}