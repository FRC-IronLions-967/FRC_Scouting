<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);

require_once('db.php');
$sql = "SELECT * FROM matches WHERE team={$_GET['team']} AND event_key='{$_GET['event_key']}' ORDER BY matchnum";
$result = mysqli_query($conn,$sql);
$array = [];
while ($row = mysqli_fetch_assoc($result)){
$array[] = $row;
}

echo json_encode($array);
mysqli_close($conn);
?>