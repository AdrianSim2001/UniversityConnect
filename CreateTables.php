<div>
<?php
include "settings.php";

// Create connection
$conn = @mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS `users`(
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_email VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL,
    profile_name VARCHAR(30) NOT NULL,
    date_started DATE NOT NULL,
    num_of_friends INT UNSIGNED
    )";

if (@mysqli_query($conn, $sql)) {
    $sql = "CREATE TABLE IF NOT EXISTS `myfriends`(
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    ratings INT   
        )";
    if (!@mysqli_query($conn, $sql)) {
        die("<p>Failed creating tables: " . mysqli_error($conn) . "</p>");
    }else {
        $sql = "CREATE TABLE IF NOT EXISTS `comments`(
            user_id INT NOT NULL,
            profile_name VARCHAR(50) NOT NULL,
            comment VARCHAR(255),
            post_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP   
                )";
        if(!@mysqli_query($conn, $sql)) {
            die("<p>Failed creating tables: " . mysqli_error($conn) . "</p>");
        }
    }
}else {
    die("<p>Failed creating tables: " . mysqli_error($conn) . "</p>");
}

@mysqli_close($conn);
?>
</div>