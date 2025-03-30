<?php

// Set upload directory and constraints
$uploadDir = "uploads/";
$allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$maxFileSize = 5 * 1024 * 1024; // 5MB
$maxFilesPerId = 100; // Limit the number of files per ID

// Initialize logging
function logMessage($message) {
    $logFile = 'upload_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Get client details
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown User Agent';

// Get and sanitize the ID
$id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['id'] ?? 'unknown');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("Received POST request with ID: $id from IP: $ipAddress, User Agent: $userAgent");

    // Check if a file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        logMessage("File uploaded: $fileName (Size: $fileSize bytes)");

        // Validate MIME type using finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $fileTmpName);
        finfo_close($finfo);

        if (!in_array($fileType, $allowedFileTypes)) {
            logMessage("Error: Invalid MIME type - $fileType");
            echo "Error: Invalid MIME type.";
            exit;
        }

        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            logMessage("Error: Invalid file extension - $fileExtension");
            echo "Error: Invalid file extension.";
            exit;
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            logMessage("Error: File size exceeds the maximum limit of 5MB.");
            echo "Error: File size exceeds the maximum limit of 5MB.";
            exit;
        }

        // Validate if the file is an image
        if (!getimagesize($fileTmpName)) {
            logMessage("Error: The uploaded file is not a valid image.");
            echo "Error: The uploaded file is not a valid image.";
            exit;
        }

        // Create directory for this ID if it doesn't exist
        $idDir = $uploadDir . $id . '/';
        if (!is_dir($idDir)) {
            mkdir($idDir, 0755, true);
            logMessage("Created directory: $idDir");
        }

        // Check file count limit
        $existingFiles = glob($idDir . '*');
        if (count($existingFiles) >= $maxFilesPerId) {
            logMessage("Error: Maximum file limit reached for this ID.");
            echo "Error: Maximum file limit reached for this ID.";
            exit;
        }

        // Create a unique file name
        $imageIndex = count($existingFiles) + 1;
        $newFileName = $id . '_' . $imageIndex . '.' . $fileExtension;
        $uploadPath = $idDir . $newFileName;

        // Move the uploaded file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            logMessage("File moved to: $uploadPath");

            // Send the file to Flask app
            $url = "http://127.0.0.1:5000/one_for_all";
            $ch = curl_init();
            logMessage($id);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'image' => new CURLFile($uploadPath), // Ensure $uploadPath is the full path to the image file
                'id' => $id // The ID to send
            ]);

            // Set cURL timeout and SSL verification (disable SSL verification for debugging)
            curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Increase the timeout
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for debugging (remove in production)

            // Execute the cURL request
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                $errorMessage = curl_error($ch);
                logMessage("cURL Error: $errorMessage");
                echo 'Error: ' . $errorMessage;
            } else {
                // Debugging: Print raw response from Flask
                // echo "Raw Response: " . $response . "<br>";

                // Decode the response
                $responseData = json_decode($response, true);

                // Handle the response from Flask
                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    logMessage("Flask Response: " . $responseData['message']);
                    echo $responseData['message'];
                } else {
                    $flaskError = $responseData['message'] ?? 'Unknown error.';
                    logMessage("Flask Error: $flaskError");
                    echo "Flask Error: $flaskError";
                }
            }

            curl_close($ch);
        } else {
            logMessage("Error: Failed to move uploaded file.");
            echo "Error: Failed to move uploaded file.";
        }
    } else {
        logMessage("Error: No file uploaded or there was an error during the upload.");
        echo "Error: No file uploaded or there was an error during the upload.";
    }
} else {
    logMessage("Error: Invalid request method.");
    echo "Error: Invalid request method.";
}