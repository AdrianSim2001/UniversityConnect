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
    <link rel="icon" href="images/companylogo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src = 'images/companylogoNoText.png' alt='icon'><span class="company-name">University Connect</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item active"><a href="login.php" class="nav-link">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
    
    <form method="post" action="login.php" novalidate="novalidate">
        <fieldset>
            <legend>Log In</legend>

            <label for="email">Student Email:</label> </br>
            <input type="email" name="email" id="email" placeholder="Enter your student email" required="required" 
            <?php
            if ($btnclicked) {
                if (!$loginOk) {
                    echo "value = '" . $email_previous . "'";
                }
            }
            ?> />
            <?php
            if ($btnclicked) {
                if ($errorfield == "email") {
                    echo "<p>" . $login_msg . "</p>";
                }
            }
            ?>
            </br>

            <label for="login_password">Password:</label> </br>
            <input type="password" name="login_password" id="login_password" placeholder="Enter your password" required="required" />
            <?php
            if ($btnclicked) {
                if ($errorfield == "password") {
                    echo "<p>" . $login_msg . "</p>";
                }
            }
            ?>
            </br>
        </fieldset>

        <input type="submit" value="Log In" name="login" />
        <input type="reset" value="Clear" />
    </form>

    <?php include "footer.php" ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>