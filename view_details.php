<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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
            color: white;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            margin: 8px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="header">
        <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
        <h1>UDM Clinic</h1>
    </div>

    <div class="container">
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

        // Get PatientID from URL
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $patientID = $connection->real_escape_string($_GET['id']);

            // Fetch patient details using Student_Num
            $query = "SELECT FirstName, MiddleInitial, LastName, email, Sex, Age, civil_status, ContactNumber, yearLevel, Program, specialCases
                      FROM patients
                      WHERE Student_Num = '$patientID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h1>Patient Details</h1>";
                echo "<p><strong>First Name:</strong> " . htmlspecialchars($row['FirstName']) . "</p>";
                echo "<p><strong>Middle Initial:</strong> " . htmlspecialchars($row['MiddleInitial']) . "</p>";
                echo "<p><strong>Last Name:</strong> " . htmlspecialchars($row['LastName']) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                echo "<p><strong>Sex:</strong> " . htmlspecialchars($row['Sex']) . "</p>";
                echo "<p><strong>Age:</strong> " . htmlspecialchars($row['Age']) . "</p>";
                echo "<p><strong>Civil Status:</strong> " . htmlspecialchars($row['civil_status']) . "</p>";
                echo "<p><strong>Contact Number:</strong> " . htmlspecialchars($row['ContactNumber']) . "</p>";
                echo "<p><strong>Year Level:</strong> " . htmlspecialchars($row['yearLevel']) . "</p>";
                echo "<p><strong>Program:</strong> " . htmlspecialchars($row['Program']) . "</p>";
                echo "<p><strong>Special Case:</strong> " . htmlspecialchars($row['specialCases']) . "</p>";
            } else {
                echo "<p>No details found for the given Patient ID.</p>";
            }
        } else {
            echo "<p>No Patient ID provided.</p>";
        }

        $connection->close();
        ?>
    </div>
</body>
</html>
