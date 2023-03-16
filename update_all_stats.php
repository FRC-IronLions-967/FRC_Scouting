<?php
// die('File is disabled.');
header ('Cache-Control: no-cache');
require_once('db.php');
$sql = "SELECT DISTINCT team FROM matches WHERE event_key='{$_GET['event_key']}' ORDER BY team";
$result = mysqli_query($conn,$sql);
$teams = [];
while ($row = mysqli_fetch_assoc($result)){
	$teams[] = intval($row['team']);
}
foreach($teams as $team){
	$curl = curl_init();
	$event_key = $_GET['event_key'];
	$url = "https://www.your_domain_name_here.com/calculate_stats.php?team=$team&event_key=$event_key";
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	echo $result;
	curl_close($curl);
}
mysqli_close($conn);
?>