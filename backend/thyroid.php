<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    // Get JSON input from request body
    $input_data = file_get_contents("php://input");
    $data = json_decode($input_data, true);

    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
        exit;
    }

    // Flask API endpoint
    $flask_api_url = "http://127.0.0.1:5000/predict_thyroid_cancer"; 

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $flask_api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute request
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo json_encode(["status" => "error", "message" => "cURL error: " . curl_error($ch)]);
    } else {
        echo json_encode([
            "status" => $http_status === 200 ? "success" : "error",
            "response" => json_decode($response, true)
        ]);
    }

    curl_close($ch);
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>
