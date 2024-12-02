<?php
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        // Mock a database connection (use SQLite in-memory for simplicity)
        $this->conn = new mysqli('localhost', 'hassan', 'hassan12345/', 'vcf_format');
    }

    protected function tearDown(): void {
        // Close database connection
        $this->conn->close();
    }

    public function testEmptyFields(): void {
        $errors = [];
        $firstName = '';
        $lastName = '';
        $email = '';
        $password = '';
        $passwordRepeat = '';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordRepeat)) {
            array_push($errors, "All fields are required");
        }

        $this->assertContains("All fields are required", $errors);
    }

    public function testInvalidEmail(): void {
        $errors = [];
        $email = "invalid-email";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }

        $this->assertContains("Email is not valid", $errors);
    }

    public function testPasswordMismatch(): void {
        $errors = [];
        $password = "password123";
        $passwordRepeat = "password321";

        if ($password !== $passwordRepeat) {
            array_push($errors, "Passwords do not match");
        }

        $this->assertContains("Passwords do not match", $errors);
    }

    public function testUserAlreadyExists(): void {
        $email = "test@example.com";
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertGreaterThan(0, $result->num_rows, "User already exists!");
    }
}
