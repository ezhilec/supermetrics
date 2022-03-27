<?php

namespace App\Views;

class JsonView implements ViewInterface
{
    public static function render(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $result = [
            'success' => true,
            'count' => count($data),
            'data' => $data
        ];

        echo json_encode($result);
    }
}