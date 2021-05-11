<?php
function populatetables_users($link, $user_email, $user_password, $user_profile, $date_created, $friends_num){
    $success = true;

    for ($i=0; $i < 10; $i++) { 

        $user_password[$i] = hash("sha256", $user_password[$i]);
        $sql = "INSERT INTO users (user_email, password, profile_name, date_started, num_of_friends)
                VALUES ('$user_email[$i]', '$user_password[$i]', '$user_profile[$i]', '$date_created[$i]', '$friends_num[$i]')";
        if (@mysqli_query($link, $sql)) {
            false;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($link);
            $success = false;
        }
    }
    return $success;
}

function populatetables_myfriends(string $link, $myfriends){
    $success = true;

    for ($i=0; $i < count($myfriends); $i++) { 
        if ($i == 2 || $i == 5) {
            false;
        }else{
            for ($j=0; $j < count($myfriends[$i]); $j++) {
                $row = 0;
                $row = $i + 1; 
                $friends_id = $myfriends[$i];
                $sql = "INSERT INTO myfriends (user_id, friend_id) VALUES ('$row','$friends_id[$j]')";

                if (@mysqli_query($link, $sql)) {
                    false;
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($link);
                    $success = false;
                }
            }
        }
    }

    return $success;
}

function checkNotEmpty($field){
    if(empty($field)==false){
        return true;
    }else{
        return false;
    }
}

function chkEmail($input){
    $emailOK = false;
    $email_msg = "";
    $email = $input;
    if(checkNotEmpty($input)){
        $email = strval($email);
        $pattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
        if(preg_match($pattern, $email)==1){
            include "settings.php";
            // Create connection
            $conn = @mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("<p>Connection failed: " . mysqli_connect_error()."</p>"); 
            }

            // change default database to '101225244' database
            $dbSelect = @mysqli_select_db($conn, 101225244);

            if(!$dbSelect){
                die("<p>The database is not available.</p>");
            }

            $sql = "SELECT * FROM users WHERE user_email = '$email'";

            $queryResult = @mysqli_query($conn, $sql) or die("<p>Unable to select from database table</p>");

            $row = mysqli_num_rows($queryResult);

            if($row > 0){
                $emailOK = false;
                $email_msg = "The email entered is being used by another user. Please try again!";
            }else{
                $emailOK = true;
            }
        }else{
            $emailOK = false;
            $email_msg = "The email format is not valid. Please try again!";
        }
        
    }else{
        $emailOK = false;
        $email_msg = "Email input cannot be empty. Please try again!";
    }
    return [$email_msg, $emailOK, $email];
}

function chkProfileName($input){
    $profileOk = false;
    $profile_msg = "";
    $profileName = $input;
    if (checkNotEmpty($input)){
        $pattern = "/^[a-zA-Z]+$/";
        if(preg_match($pattern, $profileName)){
            $profileOk = true;
        }else{
            $profileOk = false;
            $profile_msg = "Profile Name should only contain letters. Please try again!";
        }

    }else{
        $profileOk = false;
        $profile_msg = "Profile Name input cannot be empty. Please try again!";
    }

    return [$profile_msg, $profileOk, $profileName];
}

function chkPassword($input, $confirmInput){
    $passwordOk = false;
    $password_msg = "";
    if (checkNotEmpty($input) && checkNotEmpty($confirmInput)){
        $password = $input;
        $confirm_password = $confirmInput;
        if(strcmp($password, $confirm_password) == 0){
            $pattern = "/^[a-zA-Z0-9]+$/";
            if(preg_match($pattern, $password)){
                $passwordOk = true;
            }else{
                $passwordOk = false;
                $password_msg = "Passwword should contain only letters and numbers. Please try again!";
            }
        }else{
            $passwordOk = false;
            $password_msg = "Password does not match with Confirm Password. Please try again!";
        }

    }else{
        $passwordOk = false;
        $password_msg = "Password and Confirm Password inputs cannot be empty. Please try again!";
    }

    return [$password_msg, $passwordOk];
}

function ChkEmailPasswordForLogin($emailInput, $passwordInput){
    $email = $emailInput;
    $login_password = $passwordInput;
    //echo "Input: ".$login_password;
    //$login_password = hash("sha256", $login_password);
    $login_msg = "";
    $LoginOK = false;
    $error = "";

    include "settings.php";
    // Create connection
    $conn = @mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("<p>Connection failed: " . mysqli_connect_error()."</p>"); 
    }

    // change default database to '101225244' database
    $dbSelect = @mysqli_select_db($conn, 101225244);

    if(!$dbSelect){
        die("<p>The database is not available.</p>");
    }

    $sql = "SELECT * FROM users WHERE user_email = '$email'";

    $queryResult = mysqli_query($conn, $sql) or die("<p>Unable to retrieve data from database table</p>");

    $row = mysqli_num_rows($queryResult);

    if($row <= 0){
        $error = "email";
        $login_msg = "Cannot find your account. Please register before you login.";
        $LoginOK = false;
    }else if($row == 1){
        $row = mysqli_fetch_row($queryResult);
        if(password_verify($login_password, $row[2])){
            $LoginOK = true;
        }else{
            $error = "password";
            $login_msg = "Incorrect Password. Please try again.";
            $LoginOK = false;
        }
    }
    return [$login_msg, $LoginOK, $email, $error];
}
?>