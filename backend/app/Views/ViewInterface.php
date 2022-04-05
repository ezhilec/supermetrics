<?php

namespace App\Views;

interface ViewInterface
{
    public static function render(array $data): void;
}