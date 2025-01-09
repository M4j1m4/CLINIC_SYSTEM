<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

// Database connection
$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $connection->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['id'])) {
    $patientID = $connection->real_escape_string($_POST['id']);
    $image = $_FILES['image'];

    // Validate the image
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed.']);
        exit;
    }

    // Generate a unique file name and save the file
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = uniqid('patient_', true) . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($image['tmp_name'], $filePath)) {
        // Update the database
        $updateQuery = "UPDATE patients SET patient_pic = '$filePath' WHERE Student_Num = '$patientID'";
        if ($connection->query($updateQuery) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Image uploaded successfully.', 'imagePath' => $filePath]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the database: ' . $connection->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload the file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

$connection->close();
