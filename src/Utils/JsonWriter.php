<?php

namespace App\Utils;

class JsonWriter
{
    public static function write(string $filePath, array $data): void
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        if (file_put_contents($filePath, $json) === false) {
            throw new \Exception("Failed to write JSON to {$filePath}");
        }
    }
}
