<?php

namespace App\Validator;

class TimeValidator
{
   
     // Checks if timestamps are in chronological order
    
    public function isChronological(string $current, string $next): bool
    {
        $timeCurrent = strtotime($current);
        $timeNext = strtotime($next);

        return $timeCurrent <= $timeNext;
    }
}

