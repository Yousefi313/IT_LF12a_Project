<?php

$hostName = "localhost";
$dbUser = "hassan";
$dbPassword = "hassan12345/";
$dbName = "vcf_format";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connectin Failed". $conn->connect_error);
}
