<?php
header ('Cache-Control: no-cache');
require_once 'db.php';

try{
	$timestamp = "NOW()";
	$event_key = trim(mysqli_real_escape_string($conn, $_POST['event_key']));
	$matchnum = trim(mysqli_real_escape_string($conn, $_POST['matchnum']));
	$practice = trim(mysqli_real_escape_string($conn, $_POST['practice']));
	$team = trim(mysqli_real_escape_string($conn, $_POST['team']));
	$scout_name = trim(mysqli_real_escape_string($conn, $_POST['scout_name']));
	$auto_move = trim(mysqli_real_escape_string($conn, $_POST['auto_move']));
	$preload = trim(mysqli_real_escape_string($conn, $_POST['preload']));
	$auto_location = trim(mysqli_real_escape_string($conn, $_POST['auto_location']));
	$auto_action = trim(mysqli_real_escape_string($conn, $_POST['auto_action']));
	$auto_high_made = trim(mysqli_real_escape_string($conn, $_POST['auto_high_made']));
	$auto_high_missed = trim(mysqli_real_escape_string($conn, $_POST['auto_high_missed']));
	$auto_mid_made = trim(mysqli_real_escape_string($conn, $_POST['auto_mid_made']));
	$auto_mid_missed = trim(mysqli_real_escape_string($conn, $_POST['auto_mid_missed']));
	$auto_low_made = trim(mysqli_real_escape_string($conn, $_POST['auto_low_made']));
	$auto_low_missed = trim(mysqli_real_escape_string($conn, $_POST['auto_low_missed']));
	$auto_high_made_B = trim(mysqli_real_escape_string($conn, $_POST['auto_high_made_B']));
	$auto_high_missed_B = trim(mysqli_real_escape_string($conn, $_POST['auto_high_missed_B']));
	$auto_mid_made_B = trim(mysqli_real_escape_string($conn, $_POST['auto_mid_made_B']));
	$auto_mid_missed_B = trim(mysqli_real_escape_string($conn, $_POST['auto_mid_missed_B']));
	$auto_low_made_B = trim(mysqli_real_escape_string($conn, $_POST['auto_low_made_B']));
	$auto_low_missed_B = trim(mysqli_real_escape_string($conn, $_POST['auto_low_missed_B']));
	$tele_high_made = trim(mysqli_real_escape_string($conn, $_POST['tele_high_made']));
	$tele_high_missed = trim(mysqli_real_escape_string($conn, $_POST['tele_high_missed']));
	$tele_mid_made = trim(mysqli_real_escape_string($conn, $_POST['tele_mid_made']));
	$tele_mid_missed = trim(mysqli_real_escape_string($conn, $_POST['tele_mid_missed']));
	$tele_low_made = trim(mysqli_real_escape_string($conn, $_POST['tele_low_made']));
	$tele_low_missed = trim(mysqli_real_escape_string($conn, $_POST['tele_low_missed']));
	$tele_high_made_B = trim(mysqli_real_escape_string($conn, $_POST['tele_high_made_B']));
	$tele_high_missed_B = trim(mysqli_real_escape_string($conn, $_POST['tele_high_missed_B']));
	$tele_mid_made_B = trim(mysqli_real_escape_string($conn, $_POST['tele_mid_made_B']));
	$tele_mid_missed_B = trim(mysqli_real_escape_string($conn, $_POST['tele_mid_missed_B']));
	$tele_low_made_B = trim(mysqli_real_escape_string($conn, $_POST['tele_low_made_B']));
	$tele_low_missed_B = trim(mysqli_real_escape_string($conn, $_POST['tele_low_missed_B']));
	$fouls = trim(mysqli_real_escape_string($conn, $_POST['fouls']));
	$tele_action = trim(mysqli_real_escape_string($conn, $_POST['tele_action']));
	$human_feeder = trim(mysqli_real_escape_string($conn, $_POST['human_feeder']));
	$floor_pickup = trim(mysqli_real_escape_string($conn, $_POST['floor_pickup']));
	$endgame = trim(mysqli_real_escape_string($conn, $_POST['endgame']));
	$endgame_B = trim(mysqli_real_escape_string($conn, $_POST['endgame_B']));
	$defense = trim(mysqli_real_escape_string($conn, $_POST['defense']));
	$incapacitated = trim(mysqli_real_escape_string($conn, $_POST['incapacitated']));
	$comments = trim(mysqli_real_escape_string($conn, $_POST['comments']));


	$fields = "event_key, matchnum, timestamp, practice, team, scout_name, auto_move, preload, auto_location, auto_action, auto_high_made, auto_high_missed, auto_mid_made, auto_mid_missed, auto_low_made, auto_low_missed, auto_high_made_B, auto_high_missed_B, auto_mid_made_B, auto_mid_missed_B, auto_low_made_B, auto_low_missed_B, tele_high_made, tele_high_missed, tele_mid_made, tele_mid_missed, tele_low_made, tele_low_missed, tele_high_made_B, tele_high_missed_B, tele_mid_made_B, tele_mid_missed_B, tele_low_made_B, tele_low_missed_B, fouls, tele_action, human_feeder, floor_pickup, endgame, endgame_B, defense, incapacitated, comments";
	$values = "'$event_key', '$matchnum', '$timestamp', '$practice', '$team', '$scout_name', '$auto_move', '$preload', '$auto_location', '$auto_action', '$auto_high_made', '$auto_high_missed', '$auto_mid_made', '$auto_mid_missed', '$auto_low_made', '$auto_low_missed', '$auto_high_made_B', '$auto_high_missed_B', '$auto_mid_made_B', '$auto_mid_missed_B', '$auto_low_made_B', '$auto_low_missed_B', '$tele_high_made', '$tele_high_missed', '$tele_mid_made', '$tele_mid_missed', '$tele_low_made', '$tele_low_missed', '$tele_high_made_B', '$tele_high_missed_B', '$tele_mid_made_B', '$tele_mid_missed_B', '$tele_low_made_B', '$tele_low_missed_B', '$fouls', '$tele_action', '$human_feeder', '$floor_pickup', '$endgame', '$endgame_B', '$defense', '$incapacitated', '$comments'";
}

catch (Exception $e) {
	//Stop the page before deleting old records if the POST data isn't found
	die($fields."\n".$values."\nException:\n" . $e->getMessage());
}

//delete old versions of this team/matchnum combination
$sql="DELETE FROM matches WHERE matchnum='{$_POST['matchnum']}' AND team='{$_POST['team']}' AND event_key='{$_POST['event_key']}'";
mysqli_query($conn, $sql);

$sql="INSERT INTO matches ($fields) VALUES ($values)";

if(mysqli_query($conn, $sql)){
	echo "Match $matchnum, Team $team saved successfully.<br>";
	$curl = curl_init();
	$event_key = $_POST['event_key'];
	$url = "https://www.your_domain_name_here.com/calculate_stats.php?team=$team&event_key=$event_key";
	echo $url . '<br>';
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	echo $result;
	curl_close($curl);
} 
else {
	echo mysqli_error($conn)."\n".$sql;
}

mysqli_close($conn);

?>