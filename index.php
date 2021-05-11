<!DOCTYPE html>

<html lang="en">
    <!-- Description: Assignment 2 -->
    <!-- Author: Adrian Sim Huan Tze -->
    <!-- Date: 24th October 2020 -->
    <!-- Validated: 25th October 2020-->

    <head>
        <title>MyFriend - Home</title>
        <meta charset="utf-8">
        <meta name="author" content="Adrian Sim Huan Tze">	
        <meta name="description" content="Assignment 2">
        <meta name="keywords" content="job, vacancy, posting">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="icon" href="images/companylogo.png">
    </head>

    <body>

        <h1>
            My Friend System
        </h1>

        <h2>Assignment Home Page</h2>

        <table>
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        Adrian Sim Huan Tze
                    </td>
                </tr>
                <tr>
                    <td>
                        Student ID:
                    </td>
                    <td>
                        101225244
                    </td>
                </tr>
                <tr>
                    <td>
                        Email:
                    </td>
                    <td id="email">
                        <a href="mailto: 101225244@students.swinburne.edu.my">101225244@students.swinburne.edu.my</a>
                    </td>
                </tr>
        </table>

        <div id="declaration">
            <p>
                I declare that this assignment is my individual work. I have not worked collaboratively
                 nor have I copied from any other student's work or from any other source.
            </p>
        </div>

        <?php
            include_once "CreateDatabase.php";
            include "CreateTables.php";
            include_once "PopulateTable.php";
        ?>

        <table>
            <tbody>
                <tr>
                    <td><a href="signup.php">Sign-Up</a></td>
                    <td><a href="login.php">Log-In</a></td>
                    <td><a href="about.php">About</a></td>
                </tr>
            </tbody>
        </table>

        
        <?php include 'footer.php' ?>
    </body>

</html>