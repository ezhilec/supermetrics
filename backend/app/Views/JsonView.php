<?php

namespace App\Views;

class JsonView implements ViewInterface
{
    /**
     * @param array $data
     * @return void
     */
    public static function render(bool $success, array $data): void
    {
        header("Content-Type: application/json; charset=utf-8");

        $result = [
            "success" => $success,
            "data" => $data
        ];

        echo json_encode($result);
    }
}