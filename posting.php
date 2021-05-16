<?php
session_start();
include "system_functions.php";
if (!isset($_SESSION['profile_name'])) {
    header("Location: index.php");
} else {
    $profile_name = $_SESSION['profile_name'];
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

// change default database to 'universityconnect' database
$dbSelect = @mysqli_select_db($conn, 'universityconnect');

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
            <a class="navbar-brand"><img src='images/companylogoNoText.png' alt='icon'><span class="company-name">University Connect</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="friendlist.php" class="nav-link">Friend Lists</a></li>                    
                    <li class="nav-item">
                        <?php
                        echo "<a class = 'navigate nav-link' href='friendadd.php?user_id=" .
                            $user_id . "&num_of_friends=" .
                            $num_of_friends . "'>Add Friends</a>"
                        ?>
                    </li>
                    <li class="nav-item active"><a href="posting.php" class="nav-link">Discussion</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <h1>Discussion Board</h1>

    <div id="container">
        <div id="result-wrapper">
            <div id="result">
                <?php
                include("load.php");
                ?>
            </div>
        </div>

        <form method='post' action="#" onsubmit="return post();" id="my_form" name="my_form">
            <div class="form-text">
                <input type="text" style="display:none" id="username" value="<?= $_SESSION['profile_name'] ?>">
                <input type="hidden" id="user_id" value="<?= $user_id ?>">
                <textarea id="comment"></textarea>
            </div>
            <div class="form-btn">
                <input type="submit" value="Send" id="btn" name="btn" />
            </div>
        </form>
    </div>

    <?php include "footer_login.php" ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            $(document).bind('keypress', function(e) {
                if (e.keyCode == 13) {
                    $('#my_form').submit();
                    $('#comment').val("");
                }
            });
        });
    </script>
    <script type="text/javascript">
        function post() {
            var comment = document.getElementById("comment").value;
            var name = document.getElementById("username").value;
            var id = document.getElementById("user_id").value;
            if (comment && name) {
                $.ajax({
                    type: 'POST',
                    url: 'commentajax.php',
                    data: {
                        user_id: id,
                        user_comm: comment,
                        user_name: name
                    },
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        document.getElementById("comment").value = "";
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }
                });
            }

            return false;
        }
    </script>
    <script>
        function autoRefresh_div() {
            $("#result").load("load.php").show(); // a function which will load data from other file after x seconds
        }

        setInterval('autoRefresh_div()', 2000);
    </script>
</body>

</html>