<?php

namespace App\DTOs;

trait CollectionFromDatabaseTrait
{
    public static function collectionFromDatabase(array $array): array
    {
        return array_map(fn($item): self => (new self())->fromDatabase($item), $array);
    }
}