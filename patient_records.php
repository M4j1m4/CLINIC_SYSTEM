<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page with an error message
    header("Location: login.php?error=" . urlencode("Please log in to access this page."));
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* Header Styles */
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
            color: white;
        }

        .container {
            margin-top: 150px;
        }

        /* Prevent text overflow */
        .table td, .table th {
            word-wrap: break-word;
            white-space: normal;
        }

        .table td {
            max-width: 150px;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        /* Make the table scrollable */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }

        /* Hide unnecessary elements in print */
        @media print {
            body * {
                visibility: hidden;
            }

            .printable-area, .printable-area * {
                visibility: visible;
            }

            .printable-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php include 'SideBar.php'; ?>
    <div class="header">
        <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
        <h1>UDM Clinic</h1>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clinic_data";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    if (isset($_GET['id'])) {
        $patientID = intval($_GET['id']);

        // Fetch the patient's information
        $patientQuery = "SELECT * FROM patients WHERE PatientID = ?";
        $stmt = $connection->prepare($patientQuery);
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $patientResult = $stmt->get_result();
        $patient = $patientResult->fetch_assoc();

        if (!$patient) {
            echo "<div class='alert alert-danger'>Patient not found.</div>";
            exit;
        }

        // Fetch all consultations for this patient
        $consultationsQuery = "
            SELECT c.*, 
                CONCAT(p.FirstName, ' ', IFNULL(p.MiddleInitial, ''), ' ', p.LastName) AS FullName,
                p.Student_Num, p.Program
            FROM consultations c
            JOIN patients p ON c.PatientID = p.PatientID
            WHERE c.PatientID = ?
            ORDER BY c.Date DESC
        ";

        $stmt = $connection->prepare($consultationsQuery);
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $consultationsResult = $stmt->get_result();
    } else {
        echo "<div class='alert alert-danger'>Patient ID is missing.</div>";
        exit;
    }
    ?>

    <div class="container printable-area">
        <div class="d-flex justify-content-between mb-4">
            <h2>Patient Records</h2>
            <button class="btn btn-secondary" onclick="window.print()">Print</button>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Patient Records for: <?= htmlspecialchars($patient['FirstName'] . ' ' . $patient['LastName']) ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Subjective</th>
                                <th>Objective</th>
                                <th>Assessment</th>
                                <th>Plan</th>
                                <th>Follow Up Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($consultationsResult->num_rows > 0) {
                                while ($record = $consultationsResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($record['Program']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['Date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['TimeIn']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['TimeOut']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['Subjective']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['Objective']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['Assessment']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['Plan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['PlanDate']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
