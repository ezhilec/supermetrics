<?php
namespace App\Controllers;

class ErrorController
{
    /**
     * @return void
     */
    public function show404(): void
    {
        header("HTTP/1.1 404 Not Found");
        echo 'error 404';
    }
}