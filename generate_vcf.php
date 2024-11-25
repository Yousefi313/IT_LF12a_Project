<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $website = isset($_POST['website']) ? $_POST['website'] : '';

    // Create a vCard string
    $vcfData = "BEGIN:VCARD\r\n";
    $vcfData .= "VERSION:3.0\r\n";
    $vcfData .= "FN:{$firstName} {$lastName}\r\n";
    $vcfData .= "N:{$lastName};{$firstName};;;\r\n";
    $vcfData .= "TEL;TYPE=WORK,VOICE:{$phone}\r\n";
    $vcfData .= "EMAIL;TYPE=PREF,INTERNET:{$email}\r\n";
    $vcfData .= "ADR;TYPE=WORK:;;{$address};;;;\r\n";

    // Add website if provided
    if (!empty($website)) {
        $vcfData .= "URL:{$website}\r\n";
    }

    $vcfData .= "END:VCARD\r\n";

    // Set the filename
    $fileName = "{$firstName}_{$lastName}.vcf";

    // Set headers to force download of the VCF file
    header('Content-Type: text/vcard');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($vcfData));

    // Output the VCF data
    echo $vcfData;  //It should be encoded using utf 8
    exit;
}
?>