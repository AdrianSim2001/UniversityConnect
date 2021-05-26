<?php
// this function will take 6 arguments which are connection and all arrays, the arrays stores details of the users
function populatetables_users($link, $user_email, $user_password, $user_profile, $date_created, $friends_num)
{
    $success = true;

    // the function will loop through each of the element in the arrays and insert them into the Database Table 'users'
    for ($i = 0; $i < count($user_email); $i++) {

        // $user_password[$i] = hash("sha256", $user_password[$i]);
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

// this function will take 2 arguments which are connection and arrays, the arrays stores details of the users'friends id
function populatetables_myfriends($link, $myfriends)
{
    $success = true;

    // the function will loop through each of the element in the arrays and insert them into the Database Table 'myfriends'
    for ($i = 0; $i < count($myfriends); $i++) {
        // initially set user 2 and user 5 to have no friends, therefore skip their turns
        if ($i == 2 || $i == 5) {
            false;
        } else {
            for ($j = 0; $j < count($myfriends[$i]); $j++) {
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

function checkNotEmpty($field)
{
    if (empty($field) == false) {
        return true;
    } else {
        return false;
    }
}

function chkEmail($input)
{
    $emailOK = false;
    $email_msg = "";
    $email = $input;
    // validate the format of the email using regular expresssion
    if (checkNotEmpty($input)) {
        $email = strval($email);
        $pattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
        if (preg_match($pattern, $email) == 1) {
            /*include "settings.php";
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

            $sql = "SELECT * FROM users WHERE user_email = ?";

            $prepared_stmt = mysqli_prepare($conn, $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 's', $email);

            //Execute prepared statement
            mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_num_rows($queryResult);

            // if the returned results is more than 1 , means there are users with the same email
            if ($row > 0) {
                $emailOK = false;
                $email_msg = "The email entered is being used by another user. Please try again!";
            } else {
                $emailOK = true;
            }

            @mysqli_close($conn);*/
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

function chkProfileName($input)
{
    $profileOk = false;
    $profile_msg = "";
    $profileName = $input;
    if (checkNotEmpty($input)) {
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

function chkPassword($input, $confirmInput)
{
    $passwordOk = false;
    $password_msg = "";
    if (checkNotEmpty($input) && checkNotEmpty($confirmInput)) {
        $password = $input;
        $confirm_password = $confirmInput;
        if (strcmp($password, $confirm_password) == 0) {
            // validate the format of the password using regular expresssion
            // only alphanumerics are allowed
            $pattern = "/^[a-zA-Z0-9]+$/";
            if (preg_match($pattern, $password)) {
                $passwordOk = true;
            } else {
                $passwordOk = false;
                $password_msg = "Passwword should contain only letters and numbers. Please try again!";
            }
        } else {
            $passwordOk = false;
            $password_msg = "Password does not match with Confirm Password. Please try again!";
        }
    } else {
        $passwordOk = false;
        $password_msg = "Password and Confirm Password inputs cannot be empty. Please try again!";
    }

    return [$password_msg, $passwordOk];
}

function ChkEmailPasswordForLogin($emailInput, $passwordInput)
{
    $email = $emailInput;
    $login_password = $passwordInput;
    $login_msg = "";
    $LoginOK = false;
    $error = "email";
    $profile = "";

    [$login_msg, $LoginOK, $email] = chkEmail($email);

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
            $login_msg = "Cannot find your account.";
            $LoginOK = false;
            $profile = "";
        } else if ($row == 1) {
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

function Unfriend($friend_id, $user_id)
{
    $user_id = $user_id;
    $friend_id = $friend_id;
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

    $sql = "DELETE FROM myfriends WHERE friend_id = $friend_id AND user_id = $user_id";

    if (!@mysqli_query($conn, $sql)) {
        die("Unable to delete data from server");
    }

    $sql = "SELECT * FROM myfriends WHERE user_id = $user_id";

    if (!@mysqli_query($conn, $sql)) {
        die("Unable to retrieve data from server");
    }

    $queryResult = @mysqli_query($conn, $sql);

    $num_of_friends = mysqli_num_rows($queryResult);

    $sql = "UPDATE users SET num_of_friends= $num_of_friends WHERE user_id = $user_id";

    if (!@mysqli_query($conn, $sql)) {
        die("Unable to update data from server");
    }
}

function Ratefriend($friend_id, $user_id, $rating)
{
    $user_id = $user_id;
    $friend_id = $friend_id;
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

    $sql = "UPDATE myfriends SET ratings = $rating WHERE friend_id = $friend_id AND user_id = $user_id";

    if (!@mysqli_query($conn, $sql)) {
        die(mysqli_error($conn));
    }

    function_alert("Thanks for your rating!");
}

function function_alert($message)
{
    echo "<script>alert('$message')</script>";
}

function Addfriend($friend_id, $user_id, $user_friends)
{
    $user_id = $user_id;
    $friend_id = $friend_id;
    $user_friends = $user_friends;
    $friend_added = false;

    foreach ($user_friends as $key => $value) {
        if (in_array($friend_id, $value)) {
            $friend_added = true;
            break;
        }
    }

    if (!$friend_added) {
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

        $sql = "INSERT INTO myfriends (user_id, friend_id) VALUES ('$user_id', '$friend_id')";

        if (!@mysqli_query($conn, $sql)) {
            die("Unable to insert data from server");
        }

        $sql = "SELECT * FROM myfriends WHERE user_id = $user_id";

        if (!@mysqli_query($conn, $sql)) {
            die("Unable to retrieve data from server");
        }

        $queryResult = @mysqli_query($conn, $sql);

        $num_of_friends = mysqli_num_rows($queryResult);

        $sql = "UPDATE users SET num_of_friends= $num_of_friends WHERE user_id = $user_id";

        if (!@mysqli_query($conn, $sql)) {
            die("Unable to update data from server");
        }
    }
}
?>