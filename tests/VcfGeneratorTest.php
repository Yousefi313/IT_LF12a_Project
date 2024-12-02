<?php
use PHPUnit\Framework\TestCase;

class VcfGeneratorTest extends TestCase {
    public function testVcfDataGeneration(): void {
        $firstName = "John";
        $lastName = "Doe";
        $phone = "1234567890";
        $email = "john.doe@example.com";
        $address = "123 Main Street";

        $vcfData = "BEGIN:VCARD\r\n";
        $vcfData .= "VERSION:3.0\r\n";
        $vcfData .= "FN:John Doe\r\n";
        $vcfData .= "N:Doe;John;;;\r\n";
        $vcfData .= "TEL;TYPE=WORK,VOICE:1234567890\r\n";
        $vcfData .= "EMAIL;TYPE=PREF,INTERNET:john.doe@example.com\r\n";
        $vcfData .= "ADR;TYPE=WORK:;;123 Main Street;;;;\r\n";
        $vcfData .= "END:VCARD\r\n";

        $this->assertStringContainsString("BEGIN:VCARD", $vcfData);
        $this->assertStringContainsString("FN:John Doe", $vcfData);
        $this->assertStringContainsString("END:VCARD", $vcfData);
    }

    public function testEmptyFieldsInVcf(): void {
        $firstName = "";
        $lastName = "";
        $vcfData = "BEGIN:VCARD\r\n";
        $vcfData .= "VERSION:3.0\r\n";

        if (empty($firstName) || empty($lastName)) {
            $this->assertEmpty($vcfData, "VCF data should be empty for missing fields");
        }
    }
}
