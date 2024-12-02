<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli('localhost', 'hassan', 'hassan12345/', 'vcf_format');
    }

    protected function tearDown(): void {
        $this->conn->close();
    }

    public function testUserDoesNotExist(): void {
        $email = "nonexistent@example.com";
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertEquals(0, $result->num_rows, "User does not exist!");
    }

    public function testIncorrectPassword(): void {
        $password = "wrongpassword";
        $hash = password_hash("correctpassword", PASSWORD_DEFAULT);

        $this->assertFalse(password_verify($password, $hash), "Password does not match");
    }

    public function testSuccessfulLogin(): void {
        $password = "correctpassword";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($password, $hash), "Login successful");
    }
}
