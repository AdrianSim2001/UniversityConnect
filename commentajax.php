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

if(isset($_POST['user_comm']) && isset($_POST['user_name']) && isset($_POST['user_id']))
{
    $comment=$_POST['user_comm'];
    $name=$_POST['user_name'];
    $user_id = $_POST['user_id'];
  
    $sql = "INSERT INTO `comments`(`user_id`, `profile_name`, `comment`) VALUES (?,?,?)";

    $prepared_stmt = mysqli_prepare($conn, $sql);

    //Bind input variables to prepared statement
    mysqli_stmt_bind_param($prepared_stmt, 'sss', $user_id, $name, $comment);

    //Execute prepared statement
    mysqli_stmt_execute($prepared_stmt);

    // Get resultset
    $queryResult =  mysqli_stmt_get_result($prepared_stmt)
        or die(mysqli_error($conn));

    // Close the prepared statement
    @mysqli_stmt_close($prepared_stmt);
}
?>