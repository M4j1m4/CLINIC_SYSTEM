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
    <title>Add New Patient</title>
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


        /* Popup Table Styles */
        .popup-table {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%; 
        max-width: 700px; 
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1002;
        padding: 20px;
        border-radius: 5px;
        }

        .popup-table .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #888;
        }

        .popup-table table {
            width: 100%;
            border-collapse: collapse;
        }   

        .popup-table th, .popup-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .popup-table th {
            background-color: #f1f1f1;
        }

        .popup-table td {
            background-color: #fafafa;
        }

        .sms-btn-container { 
            position: relative; 
            bottom: -10px; 
            right: 10px; 
            width: 100%; 
            text-align: right;
        }
        
        .sms-btn { 
            background-color: #28a745; 
            color: white; 
            padding: 5px 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        } 

        .sms-btn:hover { 
            background-color: #218838;
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

        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Header Section -->
    <div class="header">
        <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
        <h1>UDM Clinic</h1>
    </div>


    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><span class="glyphicon glyphicon-th"></span> Add New Patient</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="add_patient_backend.php">
                            <!-- Personal Details Fields -->
                            <div class="form-group">
                                <label class="required-field">Student Number</label>
                                <input type="text" class="form-control" name="StudentNo" required>
                                <label class="required-field">Last Name</label>
                                <input type="text" class="form-control" name="LastName" required>
                                <label class="required-field">First Name</label>
                                <input type="text" class="form-control" name="FirstName" required>
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="MiddleInitial">
                                <label class="required-field">Email</label>
                                <input type="text" class="form-control" name="email" required>
                                <label class="required-field">Sex (M/F)</label>
                                <input type="text" class="form-control" name="Sex" required>
                                <label class="required-field">Age</label>
                                <input type="number" class="form-control" name="age" required>
                                <label class="required-field">Civil Status</label>
                                <input type="text" class="form-control" name="civil_status" required>
                            </div>
                            <!-- Address and Contact Information -->
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="Address">
                                <label class="required-field">Cellphone Number</label>
                                <input type="tel" class="form-control" name="ContactNumber" pattern="\d{10}" title="Enter a valid 10-digit number" required>
                                <label>Emergency Number</label>
                                <input type="tel" class="form-control" name="emergency_number" pattern="\d{10}" title="Enter a valid 10-digit number">
                                <label>Parent/Guardian</label>
                                <input type="text" class="form-control" name="guardian">
                            </div>
                            <!-- Physical Attributes -->
                            <div class="form-group">
                                <label class="required-field">Height (cm)</label>
                                <input type="number" class="form-control" name="height" required>
                                <label>Weight (kg)</label>
                                <input type="number" class="form-control" name="weight">
                            </div>
                            <!-- Year Level -->
                            <div class="form-group">
                                <label class="required-field">Year Level</label>
                                <select class="form-control" id="yearLevel" name="yearLevel" required>
                                    <option value="">Select Year Level</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="5th Year">5th Year</option>
                                </select>
                            </div>
                            <!-- Program -->
                            <div class="form-group">
                                <label class="required-field">Program</label>
                                <select class="form-control" id="Program" name="Program" required>
                                    <option value="">Select Program</option>
                                    <option value="CET">CET - College of Engineering and Technology </option>
                                    <option value="CHS">CHS - College of Health and Science </option>
                                    <option value="CBA">CBA - College of Business Administration </option>
                                    <option value="CAS">CAS - College of Arts and Sciences </option>
                                    <option value="CCJ">CCJ - College of Criminal Justice </option>
                                    <option value="CED">CED - College of Education </option>
                                </select>
                            </div>                            
                            <!-- Special Cases -->
                            <div class="form-group">
                                <label>Special Cases</label>
                                <select class="form-control" id="specialCases" name="specialCases">
                                    <option value="">Select Special Case</option>
                                    <option value="Hepa B">Hepa B</option>
                                    <option value="PWD">PWD</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="APL > N">APL > N</option>
                                    <option value="PTB - Non Compliant">PTB - Non Compliant</option>
                                    <option value="PTB - Complied">PTB - Complied</option>
                                    <option value="For APL">For APL</option>
                                </select>
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" name="add_product" class="btn btn-primary btn-block">
                                <span class="glyphicon glyphicon-plus-sign"></span> Add New Patient
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
