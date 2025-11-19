 Shipment Status Validator :

A simple PHP-based command-line tool to validate shipment tracking events
based on predefined status transition rules.
The script reads shipment data from a JSON file, validates each shipment
detects anomalies, and generates a clean JSON report.

1. Requirements:

PHP 8 or later

No external dependencies or Composer packages

A JSON input file containing shipments



 2. Running the Validator:
  php validate_shipments.php Sample_shipment.json output.json


3.  Assumptions Made

All shipments contain:

shipment_no, origin_pincode, destination_pincode

A list of tracking events (optional)

Each event contains:

status_code, status_name, timestamp, location, comment (optional)

Status transitions must follow the defined state machine rules.

If a shipment has any invalid transition, it becomes invalid.

Timestamps must always be in chronological order.

If tracking events are empty, the shipment is considered valid.






4. Sample Output:

   {
  "summary": {
    "total_shipments": 49,
    "valid_shipments": 29,
    "invalid_shipments": 20,
    "total_anomalies": 20
  },
  "shipments": [
    {
      "shipment_no": "SHIP001",
      "status": "valid",
      "current_status": "1900",
      "anomalies": []
    },
    {
      "shipment_no": "SHIP002",
      "status": "invalid",
      "current_status": "1220",
      "anomalies": [
        {
          "type": "invalid_transition",
          "from_status": "1010",
          "to_status": "1900",
          "event_index": 1
        }
      ]
    }
  ]
}

               
               



 5. Brief Explanation of the Approach

This project uses a simple state machine approach to validate shipment status codes. Each shipment contains a sequence of tracking events, and we check whether every status transition is valid based on predefined rules. We also check timestamps to ensure the event order is correct.

For every shipment, we collect anomalies such as invalid transitions or incorrect event order. A final report is generated showing valid/invalid shipments and a summary of all anomalies.              
