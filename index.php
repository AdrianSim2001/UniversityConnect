<!DOCTYPE html>

<html lang="en">
<!-- Description: Assignment 2 -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 24th October 2020 -->
<!-- Validated: 25th October 2020-->

<head>
    <title>UniversityConnect - Home</title>
    <meta charset="utf-8">
    <meta name="author" content="Adrian Sim Huan Tze">
    <meta name="description" content="Assignment 2">
    <meta name="keywords" content="job, vacancy, posting">
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
                    <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h1>Welcome to<br/>University Connect</h1>
    <div class="content">
        <div class="text">
            <h2>Join us to widen your friend cycle</h2>
            <p>
                Improve relationship between university students by enhancing communication
                so that they can expand their social circle
            </p>
        </div>

        <div class="action">
            <img src='images/companylogo.png' alt='icon'>
            <a href="login.php" class="learnMore">Log In</a>
            <a href="about.php" class="learnMore">Learn More</a>
        </div>
    </div>


    <?php
    include_once "CreateDatabase.php";
    include "CreateTables.php";
    include_once "PopulateTable.php";
    include 'footer.php'
    ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>