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
    <link rel="stylesheet" href="style.css"> <!-- Link to custom CSS -->
    <title>Contact Form to VCF</title> <!-- Page title -->
</head>

<body>

    <!-- Display welcome message using the user's first name, defaulting to 'Guest' if not available -->
    <h2>Welcome to Dashboard, <?php echo ucfirst($username); ?></h2><br>

    <h5>Fügen Sie ein:</h5> <!-- This is German for "Add a new entry:" -->

    <!-- Form to collect contact details and generate a VCF file -->
    <form action="generate_vcf.php" method="post">
        <!-- First name input field -->
        <label for="first_name">Vorname:</label><br />
        <input type="text" id="first_name" name="first_name" required /><br />

        <!-- Last name input field -->
        <label for="last_name">Nachname:</label><br />
        <input type="text" id="last_name" name="last_name" required /><br />

        <!-- Phone number input field -->
        <label for="phone">Handy Nummer:</label><br />
        <input type="text" id="phone" name="phone" required /><br />

        <!-- Email input field -->
        <label for="email">Email Address:</label><br />
        <input type="email" id="email" name="email" required /><br />

        <!-- Address input field -->
        <label for="address">Address:</label><br />
        <input type="text" id="address" name="address" required /><br />

        <!-- Optional website URL input field -->
        <label for="website">Website URL:</label><br />
        <input type="url" id="website" name="website" /><br /><br />

        <!-- Submit button to generate VCF file -->
        <input type="submit" value="Generate VCF" />

        <!-- Logout button styled as a Bootstrap danger button -->
        <a class="btn btn-danger" onclick="return myFunction()" href="logout.php">Logout</a>
    </form>

    <!-- JavaScript function to confirm the user's intention to log out -->
    <script>
        function myFunction() {
            // Confirmation dialog for logout action
            return confirm("Do you really want to logout?");
        }
    </script>
</body>

</html>
