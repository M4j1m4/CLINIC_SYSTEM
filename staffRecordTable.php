<?php
session_start();

// Check if the staff is logged in
if (!isset($_SESSION['staff_loggedin']) || $_SESSION['staff_loggedin'] !== true) {
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
    </style>
</head>

<body>
    <?php include 'staffSideBar.php'; ?>
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

    $startDate = $endDate = $programSearch = $nameSearch = "";
    $whereClause = "";

    // Handle date range search
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_date'])) {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        if (!empty($startDate) && !empty($endDate)) {
            $whereClause = "WHERE c.Date BETWEEN ? AND ?";
        }
    }

    // Handle program search
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_program'])) {
        $programSearch = $_POST['program'];

        if (!empty($programSearch)) {
            $whereClause = "WHERE p.Program LIKE ?";
        }
    }

    // Handle name search
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_name'])) {
        $nameSearch = $_POST['name'];

        if (!empty($nameSearch)) {
            $whereClause = "WHERE CONCAT(p.FirstName, ' ', IFNULL(p.MiddleInitial, ''), ' ', p.LastName) LIKE ?";
        }
    }

    // Handle delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $deleteId = intval($_POST['delete_id']);
        $deleteQuery = "DELETE FROM consultations WHERE ConsultationID = ?";
        $stmt = $connection->prepare($deleteQuery);
        $stmt->bind_param("i", $deleteId);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Record deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting record: " . $connection->error . "</div>";
        }

        $stmt->close();
    }
    ?>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Search Records
            </div>
            <div class="card-body">
                <form method="POST" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <label for="start_date" class="mr-2">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
                    </div>
                    <div class="form-group mr-2">
                        <label for="end_date" class="mr-2">End Date:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
                    </div>
                    <button type="submit" name="search_date" class="btn btn-success">Search by Date</button>
                </form>

                <form method="POST" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="program" class="mr-2">Program:</label>
                        <input type="text" name="program" id="program" class="form-control" value="<?= htmlspecialchars($programSearch) ?>" placeholder="Enter Program">
                    </div>
                    <button type="submit" name="search_program" class="btn btn-info">Search by Program</button>
                </form>

                <!-- Search by Name -->
                <form method="POST" class="form-inline mt-3">
                    <div class="form-group mr-2">
                        <label for="name" class="mr-2">Patient Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($nameSearch) ?>" placeholder="Enter Full Name">
                    </div>
                    <button type="submit" name="search_name" class="btn btn-warning">Search by Name</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                Patient Records
            </div>
            <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student_Num</th>
                            <th>Full Name</th>
                            <th>Program</th>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Subjective</th>
                            <th>Objective</th>
                            <th>Assessment</th>
                            <th>Plan</th>
                            <th>Follow Up Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Updated query to show only the most recent consultation for each patient
                        $recordsQuery = "
                            SELECT c.*, 
                                CONCAT(p.FirstName, ' ', IFNULL(p.MiddleInitial, ''), ' ', p.LastName) AS FullName,
                                p.Student_Num, p.Program
                            FROM consultations c
                            JOIN patients p ON c.PatientID = p.PatientID
                            $whereClause
                            AND c.Date = (
                                SELECT MAX(c2.Date)
                                FROM consultations c2
                                WHERE c2.PatientID = c.PatientID
                            )
                            GROUP BY c.PatientID
                            ORDER BY c.Date DESC
                        ";

                        if (!empty($whereClause)) {
                            $stmt = $connection->prepare($recordsQuery);

                            if (isset($_POST['search_date'])) {
                                $stmt->bind_param("ss", $startDate, $endDate);
                            } elseif (isset($_POST['search_program'])) {
                                $programSearch = "%" . $programSearch . "%";
                                $stmt->bind_param("s", $programSearch);
                            } elseif (isset($_POST['search_name'])) {
                                $nameSearch = "%" . $nameSearch . "%";
                                $stmt->bind_param("s", $nameSearch);
                            }

                            $stmt->execute();
                            $recordsResult = $stmt->get_result();
                        } else {
                            $recordsResult = $connection->query($recordsQuery);
                        }

                        if ($recordsResult->num_rows > 0) {
                            while ($record = $recordsResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($record['Student_Num']) . "</td>";
                                echo "<td><a href='staffpatient_records.php?id=" . htmlspecialchars($record['PatientID']) . "'>" . htmlspecialchars($record['FullName']) . "</a></td>";
                                echo "<td>" . htmlspecialchars($record['Program']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['Date']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['TimeIn']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['TimeOut']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['Subjective']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['Objective']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['Assessment']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['Plan']) . "</td>";
                                echo "<td>" . htmlspecialchars($record['PlanDate']) . "</td>";
                                echo "<td>
                                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this record?\");'>
                                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($record['ConsultationID']) . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
