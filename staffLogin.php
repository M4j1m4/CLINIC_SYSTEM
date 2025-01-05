<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UDM Clinic</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            background-image: url('images/UDMCLINIC_LOGO.png'); /* Add UDM logo as background */
            background-size: 800px; /* Adjust the size of the logo */
            background-repeat: no-repeat;
            background-position: 50px center;
            opacity: 0.9; /* Add slight transparency to the background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-left: auto;
            margin-right: 250px;
        }
        .login-form {
            padding: 20px;
        }
        .login-form input {
            width: 335px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #20B2AA; /* Sea green background */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-form button:hover {
            background-color: #1c9a94;
        }
        .login-form .forgot-password {
            display: block;
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #20B2AA;
            text-decoration: none;
            transition: color 0.3s;
        }
        .login-form .forgot-password:hover {
            color: #1c9a94;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
        .role-dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
        .role-dropdown select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Dropdown for role selection -->
    <div class="role-dropdown">
        <select id="role" name="role">
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
    </div>

    <div class="login-container">
        <form class="login-form" method="post" action="staffLoginBackEnd.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <!-- Display error message -->
            <?php
            if (isset($_GET['error'])) {
                echo "<div class='error-message'>" . htmlspecialchars($_GET['error']) . "</div>";
            }
            ?>

            <button type="submit">Login</button>
            <a href="forgotPassword.php" class="forgot-password">Forgot Password?</a>
        </form>
    </div>
</body>
</html>
