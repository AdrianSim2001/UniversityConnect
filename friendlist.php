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
        <title>UniversityConnect - Friend List</title>
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
            <td>
                <?php 
                    echo "<a class = 'navigate' href='friendadd.php?user_id=" .
                        $user_id . "&num_of_friends=" .
                        $num_of_friends . "'><span></span><span></span><span></span><span></span>Add Friends</a>" 
                ?>
            </td>
            <td><a href="posting.php">Discussion</a></td>
            <td><a href="logout.php">Log Out</a></td>
        </header>
        
        <h1>
            University Connect
        </h1>

        <div class="text">
            <h2><?php echo $profile_name . "'s Friend List" ?></h2>
            <p class="friendlist"><?php echo "Total number of friends is " . $num_of_friends ?></p>
        </div>

        <table id="friendlist">
                <th>
                    <tr>
                        <td>
                            Name of Friends
                        </td>
                        <td>
                            Action
                        </td>
                        <td>
                            Rate your friends
                        </td>
                    </tr>
                </th>
                <?php
                if (count($user_friends) == 0) {
                        echo "<p class = 'friendlist'>You have not added any friends yet</p>";
                        echo "<a id = 'addFriend' href='friendadd.php?user_id=" .
                                $user_id . "&num_of_friends=" .
                                $num_of_friends . "'><span></span><span></span><span></span><span></span>Add Friends</a>";
                } else {
                    foreach ($user_friends as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $value[1] . "</td>";
                            echo "<td><a class = 'unfriend' href='friendlist.php?friend_id=" . $value[0] .
                             "&user_id=" . $user_id . "'>Unfriend</a></td>";
                            echo "<td><a href='friendlist.php?rate=1&friend_id=" . $value[0] . "&user_id=" .
                             $user_id . "'><img src = 'images/rating1.png' alt = 'rating1'></a>
                             <a href='friendlist.php?rate=2&friend_id=" .
                              $value[0] . "&user_id=" . $user_id .
                               "'><img src = 'images/rating2.png' alt = 'rating2'></a>
                               <a href='friendlist.php?rate=3&friend_id=" .
                               $value[0] . "&user_id=" . $user_id .
                                "'><img src = 'images/rating3.png' alt = 'rating3'></a>
                                <a href='friendlist.php?rate=4&friend_id=" .
                                $value[0] . "&user_id=" . $user_id .
                                 "'><img src = 'images/rating4.png' alt = 'rating4'></a>
                                 <a href='friendlist.php?rate=5&friend_id=" .
                                 $value[0] . "&user_id=" . $user_id .
                                  "'><img src = 'images/rating5.png' alt = 'rating5'></a></td>";
                            echo "</tr>";
                    }
                }
                ?>
        </table>
    </body>

    <?php include "footer_login.php" ?>

</html>