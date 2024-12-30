<?php
// control.php

// Allow cross-origin requests if your frontend and backend are hosted separately
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Check if POST data has been received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize the input data
    $latitude = isset($_POST['latitude']) ? filter_var($_POST['latitude'], FILTER_SANITIZE_STRING) : null;
    $longitude = isset($_POST['longitude']) ? filter_var($_POST['longitude'], FILTER_SANITIZE_STRING) : null;
    $action = isset($_POST['action']) ? filter_var($_POST['action'], FILTER_SANITIZE_STRING) : null; // 'launch' or 'land'

    // Validate the latitude and longitude
    if (isValidCoordinate($latitude, $longitude)) {
        // You can now integrate the backend drone control API here
        // Example: sending data to a drone API or command system (pseudo-code)
        
        if ($action === 'launch') {
            // Launch drone at the specified coordinates
            // Example: callBackendDroneAPI('launch', $latitude, $longitude);
            $response = [
                'status' => 'success',
                'message' => 'Drone launching at coordinates: ' . $latitude . ', ' . $longitude,
            ];
        } elseif ($action === 'land') {
            // Land the drone
            // Example: callBackendDroneAPI('land');
            $response = [
                'status' => 'success',
                'message' => 'Drone landing at current position.',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid action specified.',
            ];
        }
    } else {
        // Invalid coordinates
        $response = [
            'status' => 'error',
            'message' => 'Invalid latitude or longitude provided.',
        ];
    }

    // Return the response in JSON format
    echo json_encode($response);

} else {
    // Handle invalid request method
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Use POST to submit data.',
    ]);
}

// Function to validate latitude and longitude
function isValidCoordinate($latitude, $longitude) {
    // Convert to float and validate range
    $lat = floatval($latitude);
    $lon = floatval($longitude);

    return ($lat >= -90 && $lat <= 90) && ($lon >= -180 && $lon <= 180);
}

// Example of backend drone API integration (Pseudo-code)
/*
function callBackendDroneAPI($action, $latitude = null, $longitude = null) {
    // Implement your logic to control the drone here (e.g., using cURL or some other API interface)
    // Example:
    $droneApiUrl = "https://drone-backend-api.com/action";
    $postData = [
        'action' => $action,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];

    // Use cURL to send the POST request (optional)
    // curlPost($droneApiUrl, $postData);
}
*/
?>
