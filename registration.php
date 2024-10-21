<?php
// Start a new session or resume an existing one
session_start();

// Check if the user is already logged in
// If the 'user' session variable is set, redirect to the index.php page
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit(); // It's important to call exit() after a redirect to stop further script execution
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character encoding and responsive design -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title of the page -->
    <title>Registration Form</title>

    <!-- Bootstrap CDN for styling and responsiveness -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- Link to the custom CSS file for additional styling -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Container for the registration form -->
    <div class="container">

        <?php
        // Check if the form is submitted
        if (isset($_POST["submit"])) {
            // Collect the form data and store them in variables
            $firstName = $_POST["firstname"];
            $lastName = $_POST["lastname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            // Hash the password using the default algorithm (Bcrypt in this case)
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Array to store any validation errors
            $errors = array();

            // Validate the form fields
            if (empty($firstName) or empty($lastName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }

            // Validate the email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }

            // Ensure the password is at least 8 characters long
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }

            // Check if the password matches the repeated password
            if ($password !== $passwordRepeat) {
                array_push($errors, "Passwords do not match");
            }

            // Include the database connection file to connect to the MySQL database
            require_once "db_conn.php";

            // Query to check if the email is already registered
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);

            // If the email is already taken, add an error message
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }

            // If there are any validation errors, display them
            else if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                // Prepare the SQL statement to insert the user into the database
                $sql = "INSERT INTO user (first_name,last_name, email, password) VALUES ( ?, ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

                // Bind the form data to the SQL statement and execute it
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);

                    // Display a success message after registration
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";

                    // Redirect the user to the login page after successful registration
                    header("Location:login.php");
                } else {
                    // If there was an issue with the SQL execution, terminate the script with an error
                    die("Something went wrong");
                }
            }
        }
        ?>

        <!-- Registration form -->
        <form action="registration.php" method="post">
            <div class="form-group">
                <!-- Input for first name -->
                <input type="text" class="form-control" name="firstname" placeholder="First Name:">
            </div>
            <div class="form-group">
                <!-- Input for last name -->
                <input type="text" class="form-control" name="lastname" placeholder="Last Name:">
            </div>
            <div class="form-group">
                <!-- Input for email address -->
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <!-- Input for password -->
                <input type="password" class="form-control" name="password" placeholder="Password:" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters">
            </div>
            <div class="form-group">
                <!-- Input for repeat password -->
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <!-- Submit button to register -->
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <!-- Link for users who are already registered -->
        <div>
            <div>
                <p>Already Registered? <a href="login.php">Login Here</a></p>
            </div>
        </div>
    </div>
</body>

</html>
