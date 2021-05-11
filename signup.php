<!DOCTYPE html>

<html lang="en">
    <!-- Description: Assignment 2 -->
    <!-- Author: Adrian Sim Huan Tze -->
    <!-- Date: 30th October 2020 -->
    <!-- Validated: OK 30th September 2020-->
    
    <head>
        <title>MyFriend - Sign Up</title>
        <meta charset="utf-8">
        <meta name="author" content="Adrian Sim Huan Tze">    
        <meta name="description" content="Assignment 2">
        <meta name="keywords" content="job, vacancy, posting, searching">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="icon" href="images/companylogo.png">
    </head>

    <body>

        <?php
        require "system_functions.php";
        require "settings.php";

        $btnclicked = false;
        if (!empty($_POST["register"])) {
            $formvalidate = false;
            $btnclicked = true;
            [$email_msg, $emailOK, $email_previous] = chkEmail($_POST["email"]);
            [$profile_msg, $profileOk, $profile_previous] = chkProfileName($_POST["profile"]);
            [$password_msg, $passwordOk] = chkPassword($_POST["password"], $_POST["confirm_password"]);
            if ($emailOK && $profileOk && $passwordOk) {
                $formvalidate = true;
                $email = $_POST["email"];
                $profile = $_POST["profile"];
                $user_password = $_POST["password"];
                $user_password = hash("sha256", $user_password);
                $date = date("Y-m-d");
                include "settings.php";
                
                $conn = @mysqli_connect($servername, $username, $password, $dbname);
                
                if (!$conn) {
                    die("<p>Connection failed: " . mysqli_connect_error() . "</p>"); 
                }

                // change default database to '101225244' database
                $dbSelect = @mysqli_select_db($conn, 101225244);

                if (!$dbSelect) {
                    die("<p>The database is not available.</p>");
                }

                $sql = "INSERT INTO users (user_email, password, profile_name, date_started, num_of_friends)
                        VALUES ('$email', '$user_password', '$profile', '$date', 0)";

                $queryResult = @mysqli_query($conn, $sql) or die("<p>Unable register an account to database</p>");

                if ($queryResult) {
                    header('Location: friendadd.php');
                }
            }else{
                $formvalidate = false;
            }
        } else {
            $btnclicked = false;
        }
        ?>

        <h1>
            My Friend System
        </h1>

        <h2>
            Registration Page
        </h2>

        <form method="post" action="signup.php" novalidate = "novalidate">
            <fieldset>
                <legend>Sign Up</legend>

                <label for="email">Email:</label>   </br>
                <input type="email" name="email" id="email" placeholder="Enter your email" required = "required" <?php 
                    if ($btnclicked) {
                        if (!$formvalidate) {
                            echo"value = " . $email_previous;
                        }
                    }
                ?> />  
                <?php 
                if ($btnclicked) {
                    if (!$emailOK) {
                        echo"<p>" . $email_msg . "</p>";
                    }
                }
                ?>
                </br>

                <label for="profile">Profile Name:</label>   </br>
                <input type="text" name="profile" id="profile" placeholder="Enter your profile name" required = "required" <?php 
                    if ($btnclicked) {
                        if (!$formvalidate) {
                            echo"value = " . $profile_previous;
                        }
                    }
                ?> />  
                <?php
                if ($btnclicked) {
                    if (!$profileOk) {
                        echo"<p>" . $profile_msg . "</p>";
                    }
                }
                ?>
                </br>

                <label for="password">Password:</label> </br>
                <input type="password" name="password" id="password" placeholder="password" required = "required"/> </br>

                <label for="confirm_password">Confirm Password:</label> </br>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password" required = "required"/> 
                <?php
                    if ($btnclicked) {
                        if (!$passwordOk) {
                            echo"<p>" . $password_msg . "</p>";
                        }
                    }
                ?> </br>
            </fieldset>

            <input type="submit" value="Register" name="register"/>
            <input type="reset" value="Clear"/>
        </form>

        <table>
            <tbody>
                <tr>
                    <td><a href="index.php">Home</a></td>
                    <td><a href="login.php">Log In</a></td>
                    <td><a href="about.php">About</a></td>
                </tr>
            </tbody>
        </table>

        
        <?php include ("footer.php") ?>
    </body>


</html>
