<?php


return [

   
    // All Status Codes
    
    'status_names' => [
        1000 => "Booking Pending",
        1010 => "Shipment Booked",
        1011 => "Dead Status",
        1020 => "Shipment Manifested",
        1025 => "Cancel Requested",
        1039 => "Missed Pickup",
        1050 => "Pickup Cancelled",
        1070 => "Pickup Scheduled",
        1083 => "Pickup Re-scheduled",
        1100 => "Out for Pickup",

        1200 => "Picked Up from Origin",
        1220 => "Shipment In-Transit",
        1250 => "Shipment Cancelled",
        1280 => "Received at Origin Hub",
        1300 => "Shipment On-Hold",
        1400 => "Received at Destination Hub",

        1440 => "Shipment Misrouted",
        1500 => "Shipment Lost",
        1550 => "Shipment Damaged",
        1560 => "Unexpected Challenge",
        1570 => "Address Incorrect",
        1616 => "Delay in Delivery expected",

        1700 => "Shipment Out for Delivery",
        1770 => "Delivery Attempt Failed",
        1800 => "Partial Delivery",
        1850 => "Pending",
        1880 => "Contact Customer Support",
        1900 => "Delivered",

        2000 => "RTO Initiated",
        2020 => "RTP In Transit",
        2025 => "RTO Exception",
        2030 => "RTO Delivered",

        8000 => "Tracking Closed"
    ],

    
    // Terminal States
   
    'terminal_states' => [
        1900, // Delivered
        2030, // RTO Delivered
        8000, // Tracking Closed
        1250, // Shipment Cancelled
        1050  // Pickup Cancelled
    ],

   
    // Allowed State Transitions
   
    'allowed_transitions' => [
        
        1000 => [1010],
        1010 => [1200, 1020, 1070, 1100],

        1200 => [1220, 1280, 1250],
        1220 => [1400, 1300, 1700, 1250],
        1280 => [1220, 1400, 1250],

        1400 => [1700, 1250],
        1300 => [1220, 1250],

        1700 => [1770, 1800, 1900, 1250],
        1770 => [1700, 1900, 1250],
        1800 => [1900, 1250],

        1900 => [2000],                
        2000 => [2020],
        2020 => [2030],
        2030 => [],                    

        1250 => [],                    
        1050 => [],                    
        8000 => []                     
    ]
];
