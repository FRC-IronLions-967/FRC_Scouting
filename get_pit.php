<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
require_once('db.php');
$sql = "SELECT * FROM pit WHERE team={$_GET['team']} AND event_key='{$_GET['event_key']}'";
$result = mysqli_query($conn,$sql);
$array = mysqli_fetch_assoc($result);
echo json_encode($array);
mysqli_close($conn);
?>