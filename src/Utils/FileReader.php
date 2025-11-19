<?php

namespace App\Utils;

class FileReader
{
   
     // Reads a JSON file and returns associative array.
     
    public static function readJson(string $filepath): array
    {
        if (!file_exists($filepath)) {
            throw new \Exception("File not found: $filepath");
        }

        $content = file_get_contents($filepath);

        if ($content === false) {
            throw new \Exception("Unable to read file: $filepath");
        }

        $data = json_decode($content, true);

        if ($data === null) {
            throw new \Exception("Invalid JSON format in: $filepath");
        }

        return $data;
    }
}
