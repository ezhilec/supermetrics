<?php

namespace App\Services;

use Exception;

class EnvService
{
    /**
     * @return void
     * @throws Exception
     */
    public static function init(): void
    {
        $sections = @parse_ini_file("/app/env.ini", true);

        if (!$sections) {
            throw new Exception("Can't find env file");
        }

        foreach ($sections as $sectionName => $variables) {
            foreach ($variables as $key => $value) {
                putenv("{$sectionName}_{$key}={$value}");
            }
        }

    }
}