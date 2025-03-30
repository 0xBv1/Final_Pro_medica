<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    // Function to sanitize input and prevent XSS
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $required_fields = ["gender", "age", "smoking", "yellow_fingers", "anxiety", "peer_pressure", "chronic_disease", 
                        "fatigue", "allergy", "wheezing", "alcohol_consumption", "coughing", 
                        "shortness_of_breath", "swallowing_difficulty", "chest_pain"];

    $data = [];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            echo json_encode(["status" => "error", "message" => "Missing required field: $field"]);
            exit;
        }
        $data[$field] = sanitize($_POST[$field]);
    }

    // Convert data to JSON format
    $json_data = json_encode($data);

    // Flask API endpoint (ensure Flask is running)
    $flask_api_url = "http://127.0.0.1:5000/predict_lung_cancer";  // Change to the actual URL if Flask is running on a different host

    // Initialize cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $flask_api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    // Execute the cURL request
    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo json_encode(["status" => "error", "message" => "cURL error: " . curl_error($ch)]);
    } else {
        echo json_encode(["status" => $http_status === 200 ? "success" : "error", "response" => json_decode($response, true)]);
    }

    curl_close($ch);
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>
