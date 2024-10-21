<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];   //Retrieving the values of email and
            $password = $_POST["password"]; // password fields from the submitted form using $_POST

            require_once "db_conn.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";    //Construcing an SQL query to select all columns from the users table where the "email" column matches the submitted email value
            $result = mysqli_query($conn, $sql);    //Executing the SQL query by passing the database object ($conn) and the SQL query string ($sql) as parameters
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC); //Fetch user data
            //The above line fetches a single row from the result set as an associative array (MYSQLI_ASSOC) and assigns it to the $user variable. It retrieves the user data based on the email provided.

            if ($user) { //If there is such a user then the following statements happen
                if (password_verify($password, $user["password"])) { //It checks if the submitted password matches the hashed password stored in the database. 
                    $_SESSION["user"] = "yes"; //This session variable will be used to check the user's authentication status.

                    $_SESSION["userID"] = $user["ID"];

                    $_SESSION["first_name"] = $user["first_name"]; //This session variable will be used to print the user's first name on the main page

                    $username = $_SESSION["first_name"];
                    //error_log(var_export($_SESSION, 1));
                    header("Location: index.php");
                    //die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not registered yet <a href="registration.php">Register Here</a></p>
        </div>
    </div>
</body>

</html>