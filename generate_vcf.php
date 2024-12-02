<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $website = isset($_POST['website']) ? trim($_POST['website']) : '';

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email)) {
        // Return an error message if required fields are missing
        header('Content-Type: text/plain');
        echo "Error: First Name, Last Name, and Email are required fields.";
        exit;
    }

    // Create a vCard string
    $vcfData = "BEGIN:VCARD\r\n";
    $vcfData .= "VERSION:3.0\r\n";
    $vcfData .= "FN:{$firstName} {$lastName}\r\n";
    $vcfData .= "N:{$lastName};{$firstName};;;\r\n";

    // Add optional fields if provided
    if (!empty($phone)) {
        $vcfData .= "TEL;TYPE=WORK,VOICE:{$phone}\r\n";
    }
    $vcfData .= "EMAIL;TYPE=PREF,INTERNET:{$email}\r\n";

    if (!empty($address)) {
        $vcfData .= "ADR;TYPE=WORK:;;{$address};;;;\r\n";
    }

    if (!empty($website)) {
        $vcfData .= "URL:{$website}\r\n";
    }

    $vcfData .= "END:VCARD\r\n";

    // Set the filename
    $fileName = "{$firstName}_{$lastName}.vcf";

    // Set headers to force download of the VCF file
    header('Content-Type: text/vcard; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($vcfData));

    // Output the VCF data
    echo $vcfData; // Ensure the output is UTF-8 encoded
    exit;
}
?>
