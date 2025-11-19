<?php

namespace App\Validator;

class StateMachine
{
    // Define allowed status transitions
   private array $transitions = [
    '1010' => ['1200'],
    '1200' => ['1220'],
    '1220' => ['1700'],
    '1700' => ['1900'],
    '1900' => [] 
];

    public function isValidTransition(string $from, string $to): bool
    {
        
        if (!isset($this->transitions[$from])) {
            return false;
        }
        return in_array($to, $this->transitions[$from]);
    }
}
