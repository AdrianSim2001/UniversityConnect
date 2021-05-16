<?php
session_start();
include "system_functions.php";
if (!isset($_SESSION['profile_name'])) {
    header("Location: index.php");
} else {
    $profile_name = $_SESSION['profile_name'];
    if (isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
    } else {
        $user_id = $_SESSION["user_id"];
    }
    $num_of_friends = 0;
    $user_friends = array();
    // to check for pagination purpose
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    // set up the pagination page by setting the number of records to be displayed in one page
    $no_of_records_per_page = 5;
    $offset = ($pageno - 1) * $no_of_records_per_page;
}

if (isset($_GET['user_id']) && isset($_GET['num_of_friends']) && isset($_SESSION["user_friends"])) {
    $num_of_friends = $_GET['num_of_friends'];
    $user_id = $_GET['user_id'];
    $user_friends = $_SESSION["user_friends"];

    // to check for pagination purpose
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    // set up the pagination page by setting the number of records to be displayed in one page
    $no_of_records_per_page = 5;
    $offset = ($pageno - 1) * $no_of_records_per_page;
}

if (isset($_GET['friend_id']) && isset($_GET['user_id'])) {
    // to check for pagination purpose
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    // set up the pagination page by setting the number of records to be displayed in one page
    $no_of_records_per_page = 5;
    $offset = ($pageno - 1) * $no_of_records_per_page;

    $unfriend_id = $_GET['friend_id'];
    $user_id = $_GET['user_id'];
    $user_friends = $_SESSION["user_friends2"];
    Addfriend($unfriend_id, $user_id, $user_friends);
    include "settings.php";
    // Create connection
    $conn = @mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    // change default database to 'universityconnect' database
    $dbSelect = @mysqli_select_db($conn, "universityconnect");

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

        array_push($user_friends, array($row[0], $record[3], $user_id));
        $row = mysqli_fetch_row($queryResult);
    }

    @mysqli_close($conn);
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

$sql = "SELECT * FROM users WHERE profile_name != ?";

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

$not_user_friends = array();

while ($row) {
    array_push($not_user_friends, $row);
    $row = mysqli_fetch_row($queryResult);
}

foreach ($not_user_friends as $key => $value) {
    foreach ($user_friends as $key1 => $value1) {
        if (in_array($value[0], $value1)) {
            unset($not_user_friends[$key]);
        }
    }
}

$last_page = ceil(count($not_user_friends) / $no_of_records_per_page);

// slice the array elements according to the pagination requirements which is 5
$not_user_friends_pagination = array_slice($not_user_friends, $offset, $no_of_records_per_page);

$friends_to_display = array();

foreach ($not_user_friends_pagination as $key => $value) {
    // to search for mutual friends through myfriends table from database

    $sql2 = "SELECT friend_id FROM myfriends WHERE user_id = '$user_id'";

    $queryResult2 = @mysqli_query($conn, $sql2) or die("<p>Unable to select from database table</p>");

    $my_friends_row = mysqli_fetch_row($queryResult2);

    $mutual_friend_count = 0;

    while ($my_friends_row) {
        // start with selecting all friends of friend
        $sql = "SELECT * FROM myfriends WHERE user_id = ?";

        $prepared_stmt = mysqli_prepare($conn, $sql);

        //Bind input variables to prepared statement
        mysqli_stmt_bind_param($prepared_stmt, 's', $value[0]);

        //Execute prepared statement
        mysqli_stmt_execute($prepared_stmt);

        // Get resultset
        $queryResult =  mysqli_stmt_get_result($prepared_stmt)
            or die("<p>Unable to select from database table</p>");

        // Close the prepared statement
        @mysqli_stmt_close($prepared_stmt);

        $friend_friends_row = mysqli_fetch_row($queryResult);

        while ($friend_friends_row) {
            if ($friend_friends_row[1] == $my_friends_row[0]) {
                $mutual_friend_count += 1;
            }
            $friend_friends_row = mysqli_fetch_row($queryResult);
        }
        $my_friends_row = mysqli_fetch_row($queryResult2);
    }

    array_push($value, $mutual_friend_count);

    array_push($friends_to_display, $value);
}

$_SESSION['user_friends2'] = $user_friends;

@mysqli_close($conn);
?>

<!DOCTYPE html>

<html lang="en">
<!-- Description: Assignment 2 -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 6th November 2020 -->
<!-- Validated: 6th November 2020-->

<head>
    <title>UniversityConnect - Add Friend</title>
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
            <a class="navbar-brand"><img src='images/companylogoNoText.png' alt='icon'><span class="company-name">University Connect</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto mr-md-3">
                    <li class="nav-item"><a href="friendlist.php" class="nav-link">Friend Lists</a></li>
                    <li class="nav-item active"><a href="friendadd.php" class="nav-link">Add Friends</a></li>
                    <li class="nav-item"><a href="posting.php" class="nav-link">Discussion</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <h1>Add Friends</h1>

    <div class="text">
        <h2>Hey <?php echo $profile_name ?>, add your friend now !!!</h2>
        <p class="friendlist"><?php echo "Total number of friends: " . $num_of_friends ?></p>
    </div>

    <table id="addfriendTable">
        <?php
        if (count($not_user_friends) == 0) {
            echo "<p>There is no new friend at the moment. You have added all users as your friends!</p>";
        } else {
            foreach ($friends_to_display as $key => $value) {
                echo "<tr>";
                echo "<td>" . $value[3] . "</td>";
                echo "<td> " . $value[count($value) - 1] . " mutual friend(s) </td>";
                echo "<td><a href='friendadd.php?pageno=" . $pageno . "&friend_id=" .
                    $value[0] . "&user_id=" . $user_id . "'>Add as friend</a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <table id="pre-next-nav">
        <tr>
            <?php
            if ($pageno <= 1) {
                echo "
                        <td class='nav-inactive'><button disabled>First</button></td>
                        <td class='nav-inactive'><button disabled>Previous</button></td>";
            } else {
                echo "
                        <td>
                            <a href = 'friendadd.php?pageno=1&user_id=" . $user_id .
                            "&num_of_friends=" . $num_of_friends . "'><button>First</button></a>
                        </td>
                        <td>
                            <a href = 'friendadd.php?pageno=" . ($pageno - 1) . "&user_id=" . $user_id .
                            "&num_of_friends=" . $num_of_friends . "'><button>Previous</button></a>
                        </td>";
            }
            if ($pageno >= $last_page) {
                echo "
                        <td class='nav-inactive'><button disabled>Next</button></td>
                        <td class='nav-inactive'><button disabled>Last</button></td>";
            } else {
                echo "
                        <td>
                            <a href = 'friendadd.php?pageno=" . ($pageno + 1) . "&user_id=" . $user_id .
                            "&num_of_friends=" . $num_of_friends . "'><button>Next</button></a>
                        </td>
                        <td>
                            <a href = 'friendadd.php?pageno=" . $last_page . "&user_id=" . $user_id .
                            "&num_of_friends=" . $num_of_friends . "'><button>Last</button></a>
                        </td>";
            }
            ?>
        </tr>
    </table>
    <?php include 'footer_login.php' ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>