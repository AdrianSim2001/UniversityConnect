<?php
    session_start();
    include "system_functions.php";
if (!isset($_SESSION['profile_name'])) {
    header("Location: index.php");
} else {
    $profile_name = $_SESSION['profile_name'];
}

if (isset($_GET['friend_id']) && isset($_GET['user_id']) && (!isset($_GET['rate']))) {
    $unfriend_id = $_GET['friend_id'];
    $user_id = $_GET['user_id'];
    Unfriend($unfriend_id, $user_id);
}

if (isset($_GET['friend_id']) && isset($_GET['user_id']) && (isset($_GET['rate']))) {
    $friend_id = $_GET['friend_id'];
    $user_id = $_GET['user_id'];
    $rating = $_GET['rate'];
    Ratefriend($friend_id, $user_id, $rating);
}
?>

<?php
            include "settings.php";
            // Create connection
            $conn = @mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
        if (!$conn) {
            die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
        }

            // change default database to '101225244' database
            $dbSelect = @mysqli_select_db($conn, 101225244);

        if (!$dbSelect) {
            die("<p>The database is not available.</p>");
        }

            $sql = "SELECT * FROM users WHERE profile_name =?";

            $prepared_stmt = mysqli_prepare($conn, $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 's', $profile_name);

            //Execute prepared statement
            mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_fetch_row($queryResult);

            $user_id = $row[0];
            $num_of_friends = $row[5];

            $sql = "SELECT friend_id FROM myfriends WHERE user_id = ?";

            $prepared_stmt = mysqli_prepare($conn, $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 's', $user_id);

            //Execute prepared statement
            mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_fetch_row($queryResult);

            $user_friends = array();

        while ($row) {
                $sql = "SELECT * FROM users WHERE user_id =?";

                $prepared_stmt = mysqli_prepare($conn, $sql);

                //Bind input variables to prepared statement
                mysqli_stmt_bind_param($prepared_stmt, 's', $row[0]);

                //Execute prepared statement
                mysqli_stmt_execute($prepared_stmt);

                // Get resultset
                $queryResult_new =  mysqli_stmt_get_result($prepared_stmt)
                    or die("<p>Unable to select from database table</p>");

                // Close the prepared statement
                @mysqli_stmt_close($prepared_stmt);

                $record = mysqli_fetch_row($queryResult_new);

                array_push($user_friends, array($row[0],$record[3],$user_id));
                $row = mysqli_fetch_row($queryResult);
        }

            $_SESSION["user_friends"] = $user_friends;

            @mysqli_close($conn);


        ?>

<!DOCTYPE html>

<html lang="en">
    <!-- Description: Assignment 2 -->
    <!-- Author: Adrian Sim Huan Tze -->
    <!-- Date: 5th November 2020 -->
    <!-- Validated: 5th November 2020-->

    <head>
        <title>UniversityConnect - Discussion Board</title>
        <meta charset="utf-8">
        <meta name="author" content="Adrian Sim Huan Tze">
        <meta name="description" content="Assignment 2">
        <meta name="keywords" content="job, vacancy, posting">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="icon" href="images/icon.png">
    </head>

    <body>
        <header>
            <img src = 'images/companylogo.png' alt='icon'>
            <td><a href="friendlist.php">Friend Lists</a></td>
            <td>
                <?php 
                    echo "<a class = 'navigate' href='friendadd.php?user_id=" .
                        $user_id . "&num_of_friends=" .
                        $num_of_friends . "'><span></span><span></span><span></span><span></span>Add Friends</a>" 
                ?>
            </td>
            <td><a href="logout.php">Log Out</a></td>
        </header>
        
        <h1>
            University Connect
        </h1>

        <div class="text">
            <h2>Discussion Board</h2>
        </div>

    </body>

    <?php include "footer_login.php" ?>

</html>