<?php

namespace App\Models;

class Shipment
{
    private string $shipmentId;
    private string $origin;
    private string $destination;
    private array $events = [];
    private ?string $created_at = null; 

    public function __construct(string $shipmentId, string $origin, string $destination)
    {
        $this->shipmentId  = $shipmentId;
        $this->origin      = $origin;
        $this->destination = $destination;
    }

    
    // Setters
    
    public function setCreatedAt(string $createdAt): void
    {
        $this->created_at = $createdAt;
    }

    
    // Event Handling
    
    public function addEvent(TrackingEvent $event): void
    {
        $this->events[] = $event;
    }

    
    // Getters
   
    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
}