<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form has been submitted and the file is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $patientID = $_POST['id']; // Get patient ID from POST
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    // Check if the file has an allowed extension
    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        $uploadDir = 'uploads/';
        $newFileName = $patientID . '.' . $fileExtension; // Create a unique name based on PatientID
        $uploadPath = $uploadDir . $newFileName;

        // Move the uploaded file to the server's upload directory
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // Update the patient's image path in the database
            $query = "UPDATE patients SET patient_pic = '$uploadPath' WHERE Student_Num = '$patientID'";
            if ($connection->query($query) === TRUE) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Image uploaded and database updated successfully!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update the database.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to upload the image.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid file type. Only JPG, JPEG, and PNG files are allowed.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No file uploaded or file error.'
    ]);
}

$connection->close();
?>
