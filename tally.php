<?php
// Database connection code remains the same
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinic_data";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Existing queries remain the same
$query = "SELECT specialCases, COUNT(*) as tally FROM patients GROUP BY specialCases";
$result = $connection->query($query);

$colorMapping = [
    "Hepa B" => "#FFD700",
    "PWD" => "#FF6347",
    "Pregnant" => "#32CD32",
    "APL > N" => "#1E90FF",
    "PTB - Non Compliant" => "#FF4500",
    "PTB - Complied" => "#00CED1",
    "For APL" => "#8A2BE2"
];

$assessmentQuery = "
    SELECT c.Assessment, COUNT(DISTINCT CONCAT(p.FirstName, p.MiddleInitial, p.LastName, p.Student_Num)) AS tally
    FROM consultations c
    JOIN patients p ON c.PatientID = p.PatientID
    GROUP BY c.Assessment
";
$assessmentResult = $connection->query($assessmentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDM Clinic Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
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

        /* Updated container styles */
        .container {
            margin-left: 270px; /* Space for sidebar */
            padding: 20px;
            margin-top: 80px; /* Height of header */
            width: calc(100% - 270px); /* Full width minus sidebar */
            max-width: none; /* Override Bootstrap's max-width */
            overflow-y: auto; /* Enable scrolling */
        }

        .mission-vision-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mission-vision-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #20B2AA;
        }

        .core-values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .core-value-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #20B2AA;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: #20B2AA;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #20B2AA;
        }

        .value-letter {
            font-weight: bold;
            color: #20B2AA;
            margin-right: 5px;
        }

        .panel {
            border-radius: 10px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .panel-heading {
            background-color: #20B2AA;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        /* Special case colors */
        .special-case {
            font-weight: bold;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        /* Add spacing for better readability */
        .table {
            margin-bottom: 0;
        }

        .panel-body {
            padding: 20px;
        }

        /* Make sure content doesn't overlap with fixed header */
        .main-content {
            padding-top: 20px;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="header d-flex align-items-center">
    <img src="images/UDMCLINIC_LOGO.png" alt="Logo" class="logo">
    <h1>UDM Clinic</h1>
</div>

<div class="container">
    <div class="main-content">
        <!-- Mission, Vision, and Core Values Section -->
        <div class="mission-vision-section">
            <h2 class="section-title">About UDM Clinic</h2>
            
            <div class="mission-vision-card">
                <h3 class="text-primary">Mission</h3>
                <p>To dismantle barriers to healthcare for underserved students and personnel of Universidad de Manila and provide an accessible clinic facility that offers exceptional primary healthcare treatment and preventive medicine through comprehensive education and counseling.</p>
            </div>

            <div class="mission-vision-card">
                <h3 class="text-primary">Vision</h3>
                <p>In a world where the wonders of modern medicine can seem beyond reach, the belief is in transforming lives by health awareness and advocating for early prevention through patient education and counseling, the aim is to elevate health and, in turn, enhance lives through healthcare provision where individuals will not only be more productive in the workforce but will also make lasting contributions to their communities.</p>
            </div>

            <div class="core-values-grid">
                <div class="core-value-item">
                    <span class="value-letter">H</span> - Holistic Care
                    <p class="small text-muted">We prioritize a holistic approach to healthcare, addressing physical, mental, and emotional well-being of our students and staff.</p>
                </div>
                <div class="core-value-item">
                    <span class="value-letter">E</span> - Empathy
                    <p class="small text-muted">We strive to understand and connect with every individual, showing compassion and empathy in all interactions.</p>
                </div>
                <div class="core-value-item">
                    <span class="value-letter">A</span> - Access
                    <p class="small text-muted">We are committed to providing accessible and inclusive health services for all members of our university community.</p>
                </div>
                <div class="core-value-item">
                    <span class="value-letter">L</span> - Leadership
                    <p class="small text-muted">We lead by example, fostering a culture of excellence and innovation in healthcare.</p>
                </div>
                <div class="core-value-item">
                    <span class="value-letter">T</span> - Teamwork
                    <p class="small text-muted">We value collaboration and teamwork among our staff and with other departments to enhance the health and well-being of our community.</p>
                </div>
                <div class="core-value-item">
                    <span class="value-letter">H</span> - Health Promotion
                    <p class="small text-muted">We actively promote and educate on healthy lifestyles, disease prevention, and wellness.</p>
                </div>
            </div>
        </div>

        <!-- Special Cases Tally Section -->
        <div class="panel">
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
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $specialCase = $row['specialCases'];
                                    $color = $colorMapping[$specialCase] ?? "#808080";
                                    echo "<tr>
                                        <td><span class='special-case' style='background-color: $color;'>" . htmlspecialchars($specialCase) . "</span></td>
                                        <td>" . htmlspecialchars($row['tally']) . "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' class='no-data'>No special cases found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Assessment Tally Section -->
        <div class="panel">
            <div class="panel-heading">
                <h4>Assessment Tally</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Assessment</th>
                                <th>Tally</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($assessmentResult->num_rows > 0) {
                                while ($row = $assessmentResult->fetch_assoc()) {
                                    echo "<tr>
                                        <td><a href='assessment_details.php?assessment=" . urlencode($row['Assessment']) . "'>" . htmlspecialchars($row['Assessment']) . "</a></td>
                                        <td>" . htmlspecialchars($row['tally']) . "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No assessments found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="index.php" class="btn btn-info btn-block mb-4">Add New Patient</a>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>

<?php $connection->close(); ?>