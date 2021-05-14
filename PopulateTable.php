<div>
<?php
include_once "settings.php";
include "system_functions.php";

// Create connection to database
$conn = @mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("<p>Connection failed: " . mysqli_connect_error() . "</p>");
}

$user_email_arr = array("johnDoe@gmail.com", "CarlieChin1997@gmail.com",
"BarkleyDrex@gmail.com", "AdamSmith67@gmail.com", "EmmaWatson@gmail.com",
"55JaneMary@gmail.com", "ButterflyHun@gmail.com", "JaniceGyu@gmail.com",
"CameroBrooke12@gmail.com", "GaryChin@gmail.com");

$user_password_arr = array("080867John","Chin1997Carlie", "DrexlerAmazing123",
"Smith_909087", "EmmaWatson897654", "SpidermanHunting", "Sky_34_butterfly",
"Janice_@1236", "BrookeTheBest", "Chin67_#$56");

$user_profile_arr = array("johnDoe", "CarlieChin", "DrexBarkley", "AdamSmith",
"EmmaWatson", "JaneMary", "HunButterfly", "JaniceGyu", "CameroBrooke", "GaryChin");

$date_created = array("2016-2-12", "2016-4-30", "2012-9-22", "2020-1-21", "2009-3-21",
"2018-7-23", "2016-6-10", "2013-12-3", "2015-4-21", "2017-12-31");

$user_friends_num = array(4,2,0,1,3,0,3,2,3,2);

$myfriends_id = array(array(2,5,7,8), array(1,4), array(), array(2), array(1,9,10),
    array(), array(1,8,9), array(1,7), array(5,10,7), array(5,9));

$sql = "SELECT * FROM users";

$queryResult = @mysqli_query($conn, $sql) or die("<p>Unable to access to database table.</p>");

$row = mysqli_num_rows($queryResult);

if ($row <= 0) {
    $result = populatetables_users($conn, $user_email_arr, $user_password_arr, $user_profile_arr, $date_created, $user_friends_num);

    $result1 = populatetables_myfriends($conn, $myfriends_id);

    if ($result1 && $result) {
        echo "<p>Tables successfully created and populated</p>";
    }
}

@mysqli_close($conn);
?>
</div>