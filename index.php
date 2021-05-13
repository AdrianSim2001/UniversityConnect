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
        <h1>
            University Connect
        </h1>
        <div class="content">
            <div class="text">
                <h2>Join us to widen your friend cycle</h2>
                <p>
                    Improve relationship between university students by enhancing communication
                    so that they can expand their social circle
                </p>
            </div>

            <div class="action">
                <img src = 'images/companylogo.png' alt='icon'>
                <a href="login.php" class="learnMore">Log In</a>
                <a href="about.php" class="learnMore">Learn More</a>
            </div>
        </div>


        <?php
            include_once "CreateDatabase.php";
            include "CreateTables.php";
            include_once "PopulateTable.php";
        ?>

        
        <?php include 'footer.php' ?>
    </body>

</html>