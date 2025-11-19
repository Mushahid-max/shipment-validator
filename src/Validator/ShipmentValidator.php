<?php

namespace App\Validator;

use App\Models\Shipment;
use App\Models\TrackingEvent;

class ShipmentValidator
{
    private StateMachine $stateMachine;
    private TimeValidator $timeValidator;

    public function __construct()
    {
        $this->stateMachine = new StateMachine();
        $this->timeValidator = new TimeValidator();
    }

    
     // Validate a single shipment
    
    public function validateShipment(Shipment $shipment): array
    {
        $events = $shipment->getEvents();
        $anomalies = [];

        // Handle empty shipments
        if (count($events) === 0) {
            return [
                'status' => 'invalid',
                'current_status' => null,
                'anomalies' => ['Shipment contains no tracking events']
            ];
        }

        // Loop through events for validation
        for ($i = 0; $i < count($events) - 1; $i++) {
            
            $current = $events[$i];
            $next = $events[$i + 1];

            // Assign status and timestamps 
            $statusCurrent = $current->getStatus();
            $statusNext = $next->getStatus();
            $timeCurrent = $current->getTimestamp();
            $timeNext = $next->getTimestamp();

            // Validate state transition
            if (!$this->stateMachine->isValidTransition($statusCurrent, $statusNext)) {
                $anomalies[] = [
                    'type' => 'invalid_transition',
                    'from_status' => $statusCurrent,
                    'to_status' => $statusNext,
                    'message' => "Cannot transition from {$statusCurrent} to {$statusNext}",
                    'event_index' => $i + 1
                ];
            }

            // Validate chronological timestamps
            if (!$this->timeValidator->isChronological($timeCurrent, $timeNext)) {
                $anomalies[] = [
                    'type' => 'time_anomaly',
                    'message' => "Event timestamp out of order: {$timeCurrent} → {$timeNext}",
                    'event_index' => $i + 1
                ];
            }
        }

        // Determine final status
        $finalStatus = end($events)->getStatus();

        return [
            'status' => empty($anomalies) ? 'valid' : 'invalid',
            'current_status' => $finalStatus,
            'anomalies' => $anomalies
        ];
    }

    
 // Validate an array of Shipment objects
 
public function validateShipments(array $shipments): array
{
    $report = [];

    foreach ($shipments as $shipment) {
        $result = $this->validateShipment($shipment);

        $report[] = [
            'shipment_no' => $shipment->getShipmentId(),
            'status' => $result['status'],
            'current_status' => $result['current_status'],
            'anomalies' => $result['anomalies']
        ];
    }

    return $report;
}

}
