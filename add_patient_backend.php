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

// Retrieve and sanitize input
$last_name = $connection->real_escape_string($_POST['LastName']);
$first_name = $connection->real_escape_string($_POST['FirstName']);
$middle_initial = $connection->real_escape_string($_POST['MiddleInitial']);
$sex = strtoupper($connection->real_escape_string($_POST['Sex'])); // Ensure consistent format (M/F)
$age = intval($_POST['age']);
$email = $connection->real_escape_string($_POST['email']);
$Program = $connection->real_escape_string($_POST['Program']);
$StudentNo = $connection->real_escape_string($_POST['StudentNo']);  // Fixed here
$civil_status = $connection->real_escape_string($_POST['civil_status']);
$address = $connection->real_escape_string($_POST['Address']);
$contact_number = $connection->real_escape_string($_POST['ContactNumber']);
$emergency_number = $connection->real_escape_string($_POST['emergency_number']);
$guardian = $connection->real_escape_string($_POST['guardian']);
$height = floatval($_POST['height']);
$weight = floatval($_POST['weight']);
$year_level = $connection->real_escape_string($_POST['yearLevel']);
$special_cases = $connection->real_escape_string($_POST['specialCases']);

// Validate inputs
$errors = [];
if (!in_array($sex, ['M', 'F'])) {
    $errors[] = "Invalid value for Sex. Please use 'M' or 'F'.";
}
if (!preg_match('/^\d{10}$/', $contact_number)) {
    $errors[] = "Invalid Contact Number. Please enter a 10-digit number.";
}
if (!empty($emergency_number) && !preg_match('/^\d{10}$/', $emergency_number)) {
    $errors[] = "Invalid Emergency Number. Please enter a 10-digit number.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<script>alert('$error');</script>";
    }
    echo "<script>window.history.back();</script>";
    exit;
}

// Insert query
$sql = "INSERT INTO patients (LastName, FirstName, MiddleInitial, sex, age, civil_status, Address, ContactNumber, emergency_number, guardian, height, weight, yearLevel, specialCases, Student_Num, Program, email)
        VALUES ('$last_name', '$first_name', '$middle_initial', '$sex', $age, '$civil_status', '$address', '$contact_number', '$emergency_number', '$guardian', $height, $weight, '$year_level', '$special_cases', '$StudentNo', '$Program', '$email')";

if ($connection->query($sql) === TRUE) {
    echo "<script>alert('New patient added successfully!'); window.location.href='index.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Close connection
$connection->close();
?>
