<?php
require_once('db.php');
$sql = "SELECT * FROM matches WHERE matchnum = {$_GET['matchnum']} AND team={$_GET['team']} 
AND event_key='{$_GET['event_key']}'";
$result = mysqli_query($conn,$sql);
$array = mysqli_fetch_assoc($result);
echo json_encode($array);
mysqli_close($conn);
?>