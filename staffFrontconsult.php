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
    <title>Consultation Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .container {
            margin-top: 150px;
        }

        .card {
            margin-top: 50px; /* Adjust the margin to your preference */
        }

        .header .notification-icon {
        margin-left: 20px; /* Pushes the notification icon to the right */
        display: flex;
        align-items: center; /* Aligns the bell icon and badge vertically */
        }
    </style>
</head>

<body>
    <?php include 'staffSideBar.php'; ?>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clinic_data";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }
    ?>
    <div class="header">
        <div class="d-flex align-items-center">
            <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
            <h1>UDM Clinic</h1>
        </div>


    </div>  
    <!-- JavaScript -->
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notification-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function(event) {
            const notificationIcon = document.querySelector('.notification-icon');
            const dropdown = document.getElementById('notification-dropdown');

            if (!notificationIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <!-- Search Patient Table -->
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Search Patient
                    </div>
                    <div class="card-body">
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
                        <!-- Table for displaying search results -->
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
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
                                            $conditions[] = "PatientID LIKE '%$part%'";          // Match Patient ID
                                            $conditions[] = "FirstName LIKE '%$part%'";          // Match First Name
                                            $conditions[] = "LastName LIKE '%$part%'";           // Match Last Name
                                            $conditions[] = "CONCAT(FirstName, ' ', LastName) LIKE '%$part%'"; // Match Full Name
                                            $conditions[] = "CONCAT(FirstName, ' ', MiddleInitial, ' ', LastName) LIKE '%$part%'"; // Match with Middle Initial
                                        }

                                        $searchQuery = " WHERE " . implode(" OR ", $conditions);
                                    }
                                    $query = "SELECT PatientID, FirstName, MiddleInitial, LastName, Sex FROM patients" . $searchQuery;
                                    $result = $connection->query($query);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $fullName = $row['FirstName'] . " " . ($row['MiddleInitial'] ? $row['MiddleInitial'] . " " : "") . $row['LastName'];
                                            echo "<tr onclick=\"selectPatient('" . $row['PatientID'] . "', '" . $fullName . "')\">";
                                            echo "<td>" . $row['PatientID'] . "</td>";
                                            echo "<td>" . $row['FirstName'] . "</td>";
                                            echo "<td>" . $row['MiddleInitial'] . "</td>";
                                            echo "<td>" . $row['LastName'] . "</td>";
                                            echo "<td>" . $row['Sex'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Consultation Form -->
            <div class="col-md-6">
                <div id="consultation-form" class="card d-none">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span>Consultation Form</span>
                        <button type="button" class="btn btn-danger btn-sm" onclick="closeConsultationForm()">X</button>
                    </div>
                    <div class="card-body">
                        <form action="save_consultation.php" method="POST">
                            <input type="hidden" id="patient_id" name="patient_id">
                            <div class="form-group">
                                <label for="selected_patient">Selected Patient</label>
                                <input type="text" id="selected_patient" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="time_in">Time In</label>
                                <input type="time" id="time_in" name="time_in" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="subjective">Subjective</label>
                                <textarea id="subjective" name="subjective" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="objective">Objective</label>
                                <textarea id="objective" name="objective" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="assessment">Assessment</label>
                                <select id="assessment" name="assessment" class="form-control" required>
                                    <option value="" disabled selected>Select an option</option>
                                    <option value="ophthalmology">Ophthalmology</option>
                                    <option value="cardiovascular">Cardiovascular</option>
                                    <option value="digestive">Digestive/GIT</option>
                                    <option value="endocrine">Endocrine</option>
                                    <option value="integumentary">Integumentary</option>
                                    <option value="lymphatic">Lymphatic</option>
                                    <option value="muscular">Muscular</option>
                                    <option value="nervous">Nervous</option>
                                    <option value="respiratory">Respiratory</option>
                                    <option value="reproductive">Reproductive</option>
                                    <option value="skeletal">Skeletal</option>
                                    <option value="urinary">Urinary/GUT</option>
                                    <option value="dental">Dental</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="cases">Cases</option>
                                    <option value="animal_bite">Animal Bite</option>
                                    <option value="teleconsult">Teleconsult</option>
                                    <option value="teledentistry">Teledentistry</option>
                                    <option value="medical_certificate">Medical Certificate</option>
                                    <option value="hospital_referral">Hospital Referral</option>
                                    <option value="ent">ENT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="plan">Plan</label>
                                <textarea id="plan" name="plan" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="plan_date">Follow Up Date</label>
                                <input type="date" id="plan_date" name="plan_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="time_out">Time Out</label>
                                <input type="time" id="time_out" name="time_out" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="saved_by">Saved By</label>
                                <input type="text" id="saved_by" name="saved_by" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Save Consultation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
    <div class="col-md-8 text-center">
        <a href="staffRecordTable.php" class="btn btn-primary">View Patient Records</a>
    </div>
    </div>
    <!-- JavaScript -->
    <script>
        function selectPatient(patientID, patientName) {
            document.getElementById('patient_id').value = patientID;
            document.getElementById('selected_patient').value = patientName;
            document.getElementById('consultation-form').classList.remove('d-none');
        }

        function closeConsultationForm() {
        document.getElementById('consultation-form').classList.add('d-none');
    }
    </script>
    

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>