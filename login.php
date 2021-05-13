<html lang="en">
    <!-- Description: Assignment 2 -->
    <!-- Author: Adrian Sim Huan Tze -->
    <!-- Date: 30th October 2020 -->
    <!-- Validated: OK 30th September 2020-->

    <head>
        <title>UniversityConnect - Log In</title>
        <meta charset="utf-8">
        <meta name="author" content="Adrian Sim Huan Tze">
        <meta name="description" content="Assignment 2">
        <meta name="keywords" content="job, vacancy, posting, searching">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="icon" href="images/companylogo.png">
    </head>

    <header>

        <a class='footerAnchor' href='index.php'><img src = 'images/companylogo.png' alt='icon'></a>
        <td><a href="index.php">Home</a></td>
        <td><a href="about.php">About</a></td>
        <td><a href="login.php">Log In</a></td>

    </header>

    <body>

        <?php
            include "system_functions.php";
            include "settings.php";

            $btnclicked = false;
        if (!empty($_POST["login"])) {
            $btnclicked = true;
            [$login_msg, $loginOk, $email_previous, $errorfield, $profile] =
             ChkEmailPasswordForLogin($_POST["email"], $_POST["login_password"]);

            if ($loginOk) {
                session_start();
                // Set session variables
                $_SESSION['profile_name'] = $profile;
                header('Location: friendlist.php');
            }
        } else {
            $btnclicked = false;
        }
        ?>

        <h1>
            University Connect
        </h1>

        <form method="post" action="login.php" novalidate = "novalidate">
            <fieldset>
                <legend>Log In</legend>

                <label for="email">Student Email:</label>   </br>
                <input type="email" name="email" id="email" placeholder="Enter your student email" required = "required" <?php
                if ($btnclicked) {
                    if (!$loginOk) {
                        echo"value = '" . $email_previous . "'";
                    }
                }
                ?>/>  
                <?php
                if ($btnclicked) {
                    if ($errorfield == "email") {
                        echo"<p>" . $login_msg . "</p>";
                    }
                }
                ?>
                </br>

                <label for="login_password">Password:</label> </br>
                <input type="password" name="login_password" id="login_password" 
                placeholder="password" required = "required"/> 
                <?php
                if ($btnclicked) {
                    if ($errorfield == "password") {
                        echo"<p>" . $login_msg . "</p>";
                    }
                }
                ?>
                </br>
            </fieldset>

            <input type="submit" value="Log In" name="login"/>
            <input type="reset" value="Clear"/>
        </form>

        
        <?php include "footer.php" ?>
    </body>


</html>
