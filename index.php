<?php
// Start the session
session_start();

// Check if the user is logged in by verifying the 'user' session variable
if (!isset($_SESSION["user"])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit(); // Exit to ensure no further code is executed after redirection
}

// Include the database connection file to interact with the MySQL database
include "db_conn.php";

// Query to fetch all records from the 'user' table
$sql = "SELECT * FROM user";

// Execute the query and store the result in the $result variable
$result = $conn->query($sql);

// Check if the 'first_name' session variable is set; if not, default to 'Guest'
$username = isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : "Guest";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta information for character encoding and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> <!-- Link to custom CSS (if any) -->
    <title>Contact Form to VCF</title> <!-- Page title -->

    <style>
        body {
            background-color: #f8f9fa; /* Light grey background */
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff; /* White background for the form */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .logout-btn {
            margin-top: 20px;
        }
        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <!-- Main container for form and dashboard -->
    <div class="container">
        <!-- Display welcome message using the user's first name, defaulting to 'Guest' if not available -->
        <h2>Welcome to the Dashboard, <?php echo ucfirst($username); ?>!</h2>

        <h5>Fügen Sie ein:</h5> <!-- This is German for "Add a new entry:" -->

        <!-- Form to collect contact details and generate a VCF file -->
        <form action="generate_vcf.php" method="post">
            <!-- First name input field -->
            <div class="mb-3">
                <label for="first_name" class="form-label">Vorname:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" required>
            </div>

            <!-- Last name input field -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Nachname:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" required>
            </div>

            <!-- Phone number input field -->
            <div class="mb-3">
                <label for="phone" class="form-label">Handy Nummer:</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" required>
            </div>

            <!-- Email input field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required>
            </div>

            <!-- Address input field -->
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" required>
            </div>

            <!-- Optional website URL input field -->
            <div class="mb-3">
                <label for="website" class="form-label">Website URL:</label>
                <input type="url" id="website" name="website" class="form-control" placeholder="Enter Website (Optional)">
            </div>

            <!-- Submit button to generate VCF file -->
            <button type="submit" class="btn btn-custom w-100">Generate VCF</button>

            <!-- Logout button styled as a Bootstrap danger button -->
            <a class="btn btn-danger w-100 logout-btn" onclick="return myFunction()" href="logout.php">Logout</a>
        </form>
    </div>

    <!-- JavaScript function to confirm the user's intention to log out -->
    <script>
        function myFunction() {
            return confirm("Do you really want to logout?");
        }
    </script>

    <!-- Bootstrap JS for interactivity (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2DkTn7c68SWeOdzKN3d5eYVRRTaHv5a5lGl2N5rv0Eu3u5MGK2Adk5K2/2" crossorigin="anonymous"></script>
</body>

</html>
