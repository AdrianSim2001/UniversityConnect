<?php namespace App\Libraries;

class Validate{

    function checkNotEmpty($field)
    {
        if (empty($field) == false) {
            return true;
        } else {
            return false;
        }
    }

    function chkProfileName($input)
    {
        $profileOk = false;
        $profile_msg = "";
        $profileName = $input;
        if ($this->checkNotEmpty($input)) {
            // validate the format of the profile name using regular expresssion
            // only letters and spaces are allowed
            $pattern = "/^[a-zA-Z ]+$/";
            if (preg_match($pattern, $profileName)) {
                $profileOk = true;
            } else {
                $profileOk = false;
                $profile_msg = "Profile Name should only contain letters. Please try again!";
            }
        } else {
            $profileOk = false;
            $profile_msg = "Profile Name input cannot be empty. Please try again!";
        }

        return [$profile_msg, $profileOk, $profileName];
    }

    function chkEmail($input)
    {
        $emailOK = false;
        $email_msg = "";
        $email = $input;
        // validate the format of the email using regular expresssion
        if (!empty($input)) {
            $email = strval($email);
            $pattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
            if (preg_match($pattern, $email) == 1) {
                $emailOK = true;
            } else {
                $emailOK = false;
                $email_msg = "The email format is not valid. Please try again!";
            }
        } else {
            $emailOK = false;
            $email_msg = "Email input cannot be empty. Please try again!";
        }
        return [$email_msg, $emailOK, $email];
    }

    function ChkEmailPasswordForLogin($emailInput, $passwordInput)
    {
        $email = $emailInput;
        $login_password = $passwordInput;
        $login_msg = "";
        $LoginOK = false;
        $error = "email";
        $profile = "";

        [$login_msg, $LoginOK, $email] = $this->chkEmail($email);

        if($LoginOK){
            include "settings.php";
            // Create connection
            $conn = @mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
            }

            // change default database to 'universityconnect' database
            $dbSelect = @mysqli_select_db($conn, 'universityconnect');

            if (!$dbSelect) {
                die("<p>The database is not available.</p>");
            }

            $email = mysqli_escape_string($conn, $email);
            $login_password = mysqli_escape_string($conn, $login_password);
            $login_password = substr($login_password, 0, 20);

            // check if the input email already exists or not by getting them from the database
            $sql = "SELECT * FROM users WHERE user_email = ?";

            $prepared_stmt = @mysqli_prepare($conn, $sql);

            //Bind input variables to prepared statement
            @mysqli_stmt_bind_param($prepared_stmt, 's', $email);

            //Execute prepared statement
            @mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_num_rows($queryResult);

            if ($row <= 0) {
                $error = "email";
                $login_msg = "Cannot find your account. Please register before you login.";
                $LoginOK = false;
                $profile = "";
            } else if ($row == 1) {
                $profile = $row[3];
                $row = mysqli_fetch_row($queryResult);
                if ($row[2] == $login_password) {
                    $LoginOK = true;
                    $profile = $row[3];
                } else {
                    $error = "password";
                    $login_msg = "Incorrect Password. Please try again.";
                    $LoginOK = false;
                }
            }

            @mysqli_close($conn);
        }


        return [$login_msg, $LoginOK, $email, $error, $profile];
    }

    function PostingFeature($user_comm, $user_name, $user_id){

        include "settings.php";
        // Create connection
        $conn = @mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
        die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
        }
        
        // change default database to 'universityconnect' database
        $dbSelect = @mysqli_select_db($conn, 'universityconnect');
        
        if (!$dbSelect) {
        die("<p>The database is not available.</p>");
        }
        
            $comment=$user_comm;
            $name=$user_name;
        
            $sql = "INSERT INTO `comments`(`user_id`, `profile_name`, `comment`) VALUES (?,?,?)";
        
            $prepared_stmt = mysqli_prepare($conn, $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 'sss', $user_id, $name, $comment);
        
            //Execute prepared statement
            mysqli_stmt_execute($prepared_stmt);

            $result = mysqli_stmt_get_result($prepared_stmt);
        
            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);
            return $result;
    }
}
?>