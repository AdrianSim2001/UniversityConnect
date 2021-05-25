<?php

use PHPUnit\Framework\TestCase;
use App\Libraries\Validate;

final class ValidationTest extends TestCase{

    public function testCheckNotEmpty(){

        $validator = new Validate;

        $this->assertTrue($validator->checkNotEmpty("Testing"));
        $this->assertFalse($validator->checkNotEmpty(""));

    }

    public function testCheckProfileNameInput(){

        $validator = new Validate;
        $profile_name = "Adrian";
        $profile_name_mocks = [
            "1Ben",
            "$%^Gyun",
            "Mary_",
            ". Chin"
        ];

        $this->assertEquals(["", true, $profile_name], $validator->chkProfileName($profile_name));

        foreach($profile_name_mocks as $mock){
            $this->assertEquals(["Profile Name should only contain letters. Please try again!", false, $mock], $validator->chkProfileName($mock));
        }

        $this->assertEquals(["Profile Name input cannot be empty. Please try again!", false, null], $validator->chkProfileName(null));

    }

    public function testCheckEmailInput(){

        $validator = new Validate;
        $email_value = "test@hotmail.com";
        $email_value_mocks = [
            "124234@.com",
            "test@gmail",
            "$^&&^@gmail.com",
            "adrfifjijgmail.com"
        ];

        $this->assertEquals(["", true, $email_value], $validator->chkEmail($email_value));

        foreach($email_value_mocks as $mock){
            $this->assertEquals(["The email format is not valid. Please try again!", false, $mock], $validator->chkEmail($mock));
        }
    }

    public function testCheckEmailPasswordforLogin(){

        $validator = new Validate;
        $login_attempts = [
            ["", true, "loong@gmail.com", "email", "Loong"],
            ["Cannot find your account. Please register before you login.", false, "samu@gmail.com", "email", null],
            ["Incorrect Password. Please try again.", false, "JohnDoe@gmail.com", "password", null]

        ];

        $passwords = [
            "loong", "wrongAccount", "IncorrectPassword"
        ];

        foreach($login_attempts as $index=>$login){
            $this->assertEquals($login, $validator->ChkEmailPasswordForLogin($login[2], $passwords[$index]));
        }

    }

    public function testPostingFeature(){

        $validator = new Validate;

        $result = $validator->PostingFeature("a", "Loong", 11);

        $this->assertFalse($result);

    }

}

?>