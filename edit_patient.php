<?php
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page with an error message
    header("Location: login.php?error=" . urlencode("Please log in to access this page."));
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

// Check if PatientID is passed in the URL
if (isset($_GET['id'])) {
    $patient_id = $connection->real_escape_string($_GET['id']);

    // Fetch patient details
    $query = "SELECT * FROM patients WHERE PatientID = '$patient_id'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        die("Patient not found.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_num = $connection->real_escape_string($_POST['student_num']);
    $first_name = $connection->real_escape_string($_POST['first_name']);
    $middle_initial = $connection->real_escape_string($_POST['middle_initial']);
    $last_name = $connection->real_escape_string($_POST['last_name']);
    $sex = $connection->real_escape_string($_POST['sex']);

    $update_query = "UPDATE patients 
                     SET Student_Num = '$student_num', 
                         FirstName = '$first_name', 
                         MiddleInitial = '$middle_initial', 
                         LastName = '$last_name', 
                         Sex = '$sex' 
                     WHERE PatientID = '$patient_id'";

    if ($connection->query($update_query) === TRUE) {
        echo "<script>alert('Patient details updated successfully'); window.location.href = 'viewpatient.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . $connection->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #0066cc;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004b99;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Patient</h2>
        <form method="POST">
            <div class="form-group">
                <label for="student_num">Student Number</label>
                <input type="text" id="student_num" name="student_num" class="form-control" value="<?php echo htmlspecialchars($patient['Student_Num']); ?>" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($patient['FirstName']); ?>" required>
            </div>
            <div class="form-group">
                <label for="middle_initial">Middle Initial</label>
                <input type="text" id="middle_initial" name="middle_initial" class="form-control" value="<?php echo htmlspecialchars($patient['MiddleInitial']); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($patient['LastName']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex</label>
                <select id="sex" name="sex" class="form-control" required>
                    <option value="Male" <?php if ($patient['Sex'] === 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($patient['Sex'] === 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="viewpatient.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
