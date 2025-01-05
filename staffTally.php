<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch the special cases tally
$query = "SELECT * FROM special_cases_tally";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Case Tally Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
        }

        /* Header Styles */
        .header {
            position: fixed; /* Fixed to the top */
            top: 0;
            left: 0;
            width: 100%;
            height: 80px; /* Adjust height as needed */
            background-color: #20B2AA;
            color: white;
            display: flex; /* Flexbox for alignment */
            align-items: center; /* Center vertically */
            padding: 0 20px; /* Add padding for spacing */
            z-index: 1000; /* Ensure it's above the sidebar */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
        }

        .header .logo {
            width: 50px; /* Adjust logo size */
            height: auto;
            margin-right: 10px; /* Space between logo and text */
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Main Content */
        .container {
            margin-left: 270px; /* Leave space for the sidebar */
            margin-top: 100px; /* Leave space for the header */
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
    </style>
</head>
<body>
<?php include 'staffSideBar.php'; ?>
<!-- Header Section with Logo -->
<div class="header d-flex align-items-center">
    <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
    <h1>UDM Clinic</h1>
</div>

<div class="container" style="max-width: 1200px;"> <!-- Increased the width -->
    <div class="row justify-content-center">
        <div class="col-md-12"> <!-- Changed from col-md-10 to col-md-12 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Special Case Tally Dashboard</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Special Case</th>
                                    <th>Tally</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Check if there are any rows in the result
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . $row['case_name'] . "</td>
                                            <td>" . $row['tally'] . "</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2' class='no-data'>No special cases found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="index.php" class="btn btn-info btn-block">Add New Patient</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$connection->close();
?>