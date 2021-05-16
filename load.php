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
$sql = "SELECT * FROM comments";

$prepared_stmt = mysqli_prepare($conn, $sql);

//Execute prepared statement
mysqli_stmt_execute($prepared_stmt);

// Get resultset
$queryResult =  mysqli_stmt_get_result($prepared_stmt)
    or die("<p>Unable to select from database table</p>");

// Close the prepared statement
@mysqli_stmt_close($prepared_stmt);

$i = 0;
while($row = mysqli_fetch_row($queryResult)){
	$name=$row[1];
	$comment=$row[2];
    $time=$row[3];
    $i++;
?>
<div class="chats">
    <p id="msg"><strong><?=$name?>:</strong> <?=$comment?></p><p style="text-align: right;"><?=date("j/m/Y g:i:sa", strtotime($time))?></p>
</div>
<?php
}
@mysqli_close($conn);
?>