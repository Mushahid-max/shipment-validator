<?php

require_once __DIR__ . '/config/status_codes.php';
require_once __DIR__ . '/src/Models/Shipment.php';
require_once __DIR__ . '/src/Models/TrackingEvent.php';
require_once __DIR__ . '/src/Validator/StateMachine.php';
require_once __DIR__ . '/src/Validator/TimeValidator.php';
require_once __DIR__ . '/src/Validator/ShipmentValidator.php';
require_once __DIR__ . '/src/Utils/FileReader.php';
require_once __DIR__ . '/src/Utils/JsonWriter.php';
require_once __DIR__ . '/src/Utils/Helpers.php';

use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Validator\ShipmentValidator;
use App\Utils\FileReader;
use App\Utils\JsonWriter;

// Check CLI arguments
if ($argc < 3) {
    echo "Usage: php validate_shipments.php <input_json> <output_json>\n";
    exit(1);
}

$inputFile  = $argv[1];
$outputFile = $argv[2];

try {
    // Read shipments JSON
    $shipmentsData = FileReader::readJson($inputFile);

    $shipments = [];

    foreach ($shipmentsData as $shipmentData) {
        $shipment = new Shipment(
            $shipmentData['shipment_no'],
            $shipmentData['origin_pincode'],
            $shipmentData['destination_pincode']
        );

        // Set tracking events
        if (!empty($shipmentData['tracking_events'])) {
            foreach ($shipmentData['tracking_events'] as $event) {
                $trackingEvent = new TrackingEvent(
                    $event['status_code'],
                    $event['status_name'],
                    $event['timestamp'],
                    $event['location'],
                    $event['comment'] ?? ''
                );
                $shipment->addEvent($trackingEvent);
            }
        }

        $shipments[] = $shipment;
    }

    // Validate all shipments
    $validator = new ShipmentValidator();
    $results = $validator->validateShipments($shipments);

  
    $validCount = 0;
    $invalidCount = 0;
    $anomalyCount = 0;

    foreach ($results as $shipmentResult) {

        
        if ($shipmentResult["status"] === "valid") {
             $validCount++;
        } else {
             $invalidCount++;
        }


        //  anomaly count
        if (!empty($shipmentResult["anomalies"]) && is_array($shipmentResult["anomalies"])) {
            $anomalyCount += count($shipmentResult["anomalies"]);
        }
    }

    
    $finalOutput = [
        "summary" => [
            "total_shipments"   => count($results),
            "valid_shipments"   => $validCount,
            "invalid_shipments" => $invalidCount,
            "total_anomalies"   => $anomalyCount
        ],
        "shipments" => $results
    ];

    // Write JSON output file
    JsonWriter::write($outputFile, $finalOutput);

    echo "Validation completed. Report saved to {$outputFile}\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
