<?php

session_start();

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

// Create database connection
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $connection->real_escape_string($_POST['delete_id']);

    // Delete dependent records
    $deleteConsultations = "DELETE FROM consultations WHERE PatientID = '$delete_id'";
    if (!$connection->query($deleteConsultations)) {
        echo "<script>alert('Error deleting consultations: " . $connection->error . "');</script>";
    }

    // Delete the patient
    $deleteQuery = "DELETE FROM patients WHERE PatientID = '$delete_id'";
    if ($connection->query($deleteQuery) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href = 'viewpatient.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $connection->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            margin: 0;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: #20B2AA;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            margin-left: 270px;
            margin-top: 100px;
            padding: 20px;
        }

        .panel {
            border-radius: 10px;
        }

        .panel-heading {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #0066cc;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004b99;
        }

        .error, .text-danger {
            color: red;
        }

        .search-results {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="header d-flex align-items-center">
        <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
        <h1>UDM Clinic</h1>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><span class="glyphicon glyphicon-user"></span> Patient List</h4>
                    </div>
                    <div class="panel-body">
                        <!-- Search Form -->
                        <form action="" method="GET">
                            <div class="form-group">
                                <label for="search">Search by Name or ID</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Enter Name or ID" list="suggestions">
                                <datalist id="suggestions">
                                    <?php
                                    $suggestionQuery = "SELECT PatientID, FirstName, LastName FROM patients";
                                    $suggestionResult = $connection->query($suggestionQuery);
                                    while ($row = $suggestionResult->fetch_assoc()) {
                                        echo "<option value='" . $row['PatientID'] . " - " . $row['FirstName'] . " " . $row['LastName'] . "'>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        <!-- Search Results Table -->
                        <div class="search-results mt-3">
                            <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Student Number</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Sex</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $searchQuery = "";
                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                    $searchTerm = $connection->real_escape_string($_GET['search']);
                                    $searchParts = explode(" ", $searchTerm);
                                    $conditions = [];

                                    foreach ($searchParts as $part) {
                                        $part = $connection->real_escape_string($part);
                                        $conditions[] = "PatientID LIKE '%$part%'";
                                        $conditions[] = "Student_Num LIKE '%$part%'";
                                        $conditions[] = "FirstName LIKE '%$part%'";
                                        $conditions[] = "LastName LIKE '%$part%'";
                                        $conditions[] = "CONCAT(FirstName, ' ', LastName) LIKE '%$part%'";
                                        $conditions[] = "CONCAT(FirstName, ' ', MiddleInitial, ' ', LastName) LIKE '%$part%'";
                                    }

                                    $searchQuery = " WHERE " . implode(" OR ", $conditions);
                                }

                                $query = "SELECT PatientID, Student_Num, FirstName, MiddleInitial, LastName, Sex FROM patients" . $searchQuery;
                                $result = $connection->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['PatientID']) . "</td>";
                                        echo "<td><a href='view_details.php?id=" . htmlspecialchars($row['Student_Num']) . "'>" . htmlspecialchars($row['Student_Num']) . "</a></td>";
                                        echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['MiddleInitial']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Sex']) . "</td>";
                                        echo "<td>
                                            <a href='edit_patient.php?id=" . $row['PatientID'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                            <form method='POST' action='' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this record?\");'>
                                                <input type='hidden' name='delete_id' value='" . $row['PatientID'] . "'>
                                                <button type='submit' class='btn btn-danger btn-sm'>Remove</button>
                                            </form>
                                        </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>

                        <a href="tally.php" class="btn btn-primary mt-3">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
