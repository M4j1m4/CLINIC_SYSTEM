<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fix: Change $_POST['name'] to $_POST['username'] to match the form field name
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
        header("Location: forgotPassword.php?error=" . urlencode($error));
        exit();
    }

    // Query to check if the username exists
    $sql = "SELECT * FROM account WHERE name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Update the password for the user (without hashing)
        $update_sql = "UPDATE account SET Password = '$new_password' WHERE name = '$username'";

        if ($conn->query($update_sql) === TRUE) {
            $success = "Password successfully updated!";
            header("Location: forgotPassword.php?success=" . urlencode($success));
            exit();
        } else {
            $error = "Error updating password: " . $conn->error;
            header("Location: forgotPassword.php?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = "Username not found!";
        header("Location: forgotPassword.php?error=" . urlencode($error));
        exit();
    }
}

$conn->close();
?>