<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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
            font-size: 32px;
        }

        .content {
            margin-top: 100px;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .details-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 800px;
            position: relative;
        }

        .details {
            text-align: left;
        }

        .details h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 28px;
        }

        .details p {
            margin: 12px 0;
            color: #555;
            font-size: 18px;
        }

        .picture-holder {
            position: absolute;
            top: 50px;
            right: 50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #20B2AA;
            overflow: hidden;
            cursor: pointer;
        }

        .picture-holder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .picture-holder input {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="header">
        <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
        <h1>UDM Clinic</h1>
    </div>

    <div class="content">
        <div class="details-container">
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

                // Fetch patient details
                $query = "SELECT FirstName, MiddleInitial, LastName, email, Sex, Age, civil_status, ContactNumber, yearLevel, Program, specialCases
                          FROM patients
                          WHERE Student_Num = '$patientID'";
                $result = $connection->query($query);

                // Fetch patient picture
                $imgQuery = "SELECT patient_pic FROM patients WHERE Student_Num = '$patientID'";
                $imgResult = $connection->query($imgQuery);

                $imgPath = "images/default_avatar.jpg"; // Default image
                if ($imgResult->num_rows > 0) {
                    $imgRow = $imgResult->fetch_assoc();
                    if (!empty($imgRow['patient_pic'])) {
                        // Use full path or relative path
                        $imgPath = htmlspecialchars($imgRow['patient_pic']);
                    }
                }

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h1>Patient Details</h1>";
                    echo "<p><strong>First Name:</strong> " . htmlspecialchars($row['FirstName']) . "</p>";
                    echo "<p><strong>Middle Initial:</strong> " . htmlspecialchars($row['MiddleInitial']) . "</p>";
                    echo "<p><strong>Last Name:</strong> " . htmlspecialchars($row['LastName']) . "</p>";
                    echo "<p><strong>Email:</strong> <a href='email_module/index.html?email=" . urlencode($row['email']) . "' style='color: #20B2AA; text-decoration: none;'>" . htmlspecialchars($row['email']) . "</a></p>";
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

            <!-- Picture holder -->
            <div class="picture-holder" onclick="document.getElementById('imageInput').click();">
                <img src="<?php echo $imgPath; ?>" alt="Patient Photo">
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="file" id="imageInput" name="image" accept="image/png, image/jpeg" onchange="uploadImage(<?php echo $patientID; ?>)">
                </form>
            </div>

        </div>
    </div>

    <script>
        function uploadImage(patientID) {
            const input = document.getElementById('imageInput');
            const formData = new FormData();
            formData.append('image', input.files[0]);
            formData.append('id', patientID);

            fetch('upload_image.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === 'success') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading the image.');
                });
        }
    </script>
</body>
</html>
