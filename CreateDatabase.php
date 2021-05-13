<div>
<?php
// set the servername,username and password
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
//The mysqli_connect() function attempts to open a connection to the MySQL Server
$conn = @mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    //The die() function is an alias of the exit() function
    die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
}

$sql = "CREATE DATABASE `101225244`";

if (@mysqli_query($conn, $sql)) {
    false;
}
@mysqli_close($conn);
?>
</div>