<?php

namespace App\Utils;

class Helpers
{
     //Safely get an array value 
    
    public static function get(array $arr, string $key, $default = null)
    {
        return $arr[$key] ?? $default;
    }
     // Format error strings
     
    public static function formatError(string $message): string
    {
        return "[ERROR] " . $message;
    }
}
