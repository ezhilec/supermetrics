<?php

namespace App\Controllers;

use App\Views\JsonView;

class ErrorController
{
    /**
     * @return void
     */
    public function show404(): void
    {
        header("HTTP/1.1 404 Not Found");

        JsonView::render(false, ["'message' => 'error 404'"]);
    }

    public function exceptionError(string $error = "Unknown error"):void
    {
        header("HTTP/1.1 400 Bad Request");

        JsonView::render(false, ["message" => $error]);
    }
}