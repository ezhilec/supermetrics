<?php

namespace App\Views;

class JsonView implements ViewInterface
{
    public static function render(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}