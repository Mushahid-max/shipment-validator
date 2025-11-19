<?php

namespace App\Models;

class TrackingEvent
{
    private string $status;
    private string $timestamp;

    public function __construct(string $status, string $timestamp)
    {
        $this->status    = $status;
        $this->timestamp = $timestamp;
    }

    // Getters
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }
}

