<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit(); // Added exit to prevent further execution
}
include "db_conn.php";
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$username = isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : "Guest";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Contact Form to VCF</title>
</head>

<body>
    <h1>Fügen Sie ein:</h1>
    <form action="generate_vcf.php" method="post">
        <label for="first_name">Vorname:</label><br>
        <input type="text" id="first_name" name="first_name" required><br>

        <label for="last_name">Nachname:</label><br>
        <input type="text" id="last_name" name="last_name" required><br>

        <label for="phone">Handy Nummer:</label><br>
        <input type="text" id="phone" name="phone" required><br>

        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br>

        <label for="website">Website URL:</label><br>
        <input type="url" id="website" name="website"><br><br>

        <input type="submit" value="Generate VCF"><br><br>
    </form>
    <a class="btn btn-danger" onclick="return myFunction()" href="logout.php">Logout</a>

    <script>
        function myFunction() {
            return confirm("Do you really want to logout?");
        }
    </script>

</body>

</html>