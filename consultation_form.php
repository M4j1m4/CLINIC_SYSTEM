<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Form</title>
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

<?php include 'sidebar.php'; ?>

<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clinic_data";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    // Fetch patient names from the database
    $patientsQuery = "SELECT PatientID, FirstName, LastName, MiddleInitial FROM patients";
    $patientsResult = $connection->query($patientsQuery);
?>

<!-- Header Section with Logo -->
<div class="header">
    <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
    <h1>UDM Clinic</h1>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><span class="glyphicon glyphicon-th"></span> Consultation Form</h4>
                </div>
                <div class="panel-body">
                    <form action="save_consultation.php" method="POST">
                        <!-- Dropdown for Patient Name -->
                        <div class="form-group">
                            <label for="PatientID">Patient Name:</label>
                            <select class="form-control" id="PatientID" name="patient_id" required>
                                <option value="">-- Select Patient --</option>
                                <?php
                                if ($patientsResult->num_rows > 0) {
                                    while ($row = $patientsResult->fetch_assoc()) {
                                        $patientID = $row['PatientID'];
                                        $fullName = $row['LastName'] . ', ' . $row['FirstName'] . ' ' . $row['MiddleInitial'] . '.';
                                        echo "<option value='$patientID'>$fullName</option>";
                                    }
                                } else {
                                    echo "<option value=''>No patients available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Course/Section Field -->
                        <div class="form-group">
                            <label for="course_section">Course/Section:</label>
                            <input type="text" class="form-control" id="course_section" name="course_section" required>
                        </div>

                        <!-- Date, Time In, and Time Out -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date">Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_in">Time In:</label>
                                    <input type="time" class="form-control" id="time_in" name="time_in" required>
                                </div>
                                <div class="form-group">
                                    <label for="time_out">Time Out:</label>
                                    <input type="time" class="form-control" id="time_out" name="time_out" required>
                                </div>
                            </div>

                            <!-- SOAP Fields -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="subjective">Subjective:</label>
                                    <textarea class="form-control" id="subjective" name="subjective" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="objective">Objective:</label>
                                    <textarea class="form-control" id="objective" name="objective" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="assessment">Assessment:</label>
                                    <textarea class="form-control" id="assessment" name="assessment" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="plan">Plan:</label>
                                    <textarea class="form-control" id="plan" name="plan" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="plan_date">Plan Date:</label>
                                    <input type="date" class="form-control" id="plan_date" name="plan_date">
                                </div>
                            </div>
                        </div>

                        <!-- Saved By Field -->
                        <div class="form-group">
                            <label for="saved_by">Saved By:</label>
                            <input type="text" class="form-control" id="saved_by" name="saved_by">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">
                            <span class="glyphicon glyphicon-save"></span> Save Consultation
                        </button>
                    </form>
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
