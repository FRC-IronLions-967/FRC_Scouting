<?php
require_once('db.php');
$team = $_GET['team'];
$event_key = $_GET['event_key'];
$sql = "SELECT * FROM matches WHERE team={$_GET['team']} AND event_key='{$_GET['event_key']}' ORDER BY matchnum";
$result = mysqli_query($conn,$sql);
$matches = [];
$totals = [];
$averages = [];
$numeric_keys = ['auto_high_made', 'auto_high_missed', 'auto_mid_made', 'auto_mid_missed', 'auto_low_made', 'auto_low_missed', 'auto_high_made_B', 'auto_high_missed_B', 'auto_mid_made_B', 'auto_mid_missed_B', 'auto_low_made_B', 'auto_low_missed_B', 'tele_high_made', 'tele_high_missed', 'tele_mid_made', 'tele_mid_missed', 'tele_low_made', 'tele_low_missed', 'tele_high_made_B', 'tele_high_missed_B', 'tele_mid_made_B', 'tele_mid_missed_B', 'tele_low_made_B', 'tele_low_missed_B', 'fouls'];
$string_keys = ['preload', 'auto_location', 'human_feeder', 'floor_pickup'];
$preload = [];
$auto_location = [];
$human_feeder = [];
$floor_pickup = [];
$tele_action = [];

$auto_move_values = array( '3'=>3, 'X'=>0, '-'=>0, ''=>0);
$totals['auto_move'] = 0;
$averages['auto_move'] = 0;

$auto_action_values = array( 'E'=>12, 'D'=>8, 'X'=>0, '-'=>0, ''=>0);
$totals['auto_action'] = 0;
$averages['auto_action'] = 0;

$endgame_values = array( 'E'=>10, 'D'=>6, 'P'=>2, 'X'=>0, '-'=>0, ''=>0);
$totals['endgame'] = 0;
$averages['endgame'] = 0;

$totals['defense'] = 0;
$averages['defense'] = 0;
$totals['incapacitated'] = 0;
$averages['incapacitated'] = 0;


while ($row = mysqli_fetch_assoc($result)){
	$matches[] = $row;
}

foreach ($numeric_keys as $k){
	$totals[$k] = 0;
	$averages[$k] = 0;
}

foreach ($matches as $m){
	foreach($numeric_keys as $k){
		$totals[$k] += intval($m[$k]);
		// echo intval($matches[$k]);
	}
	$totals['auto_move'] += $auto_move_values[$m['auto_move']];
	$totals['auto_action'] += $auto_action_values[$m['auto_action']];
	$totals['endgame'] += $endgame_values[$m['endgame']];
	$totals['defense'] += intval($m['defense']);
	$totals['incapacitated'] += intval($m['incapacitated']);

	$preload[] = $m['preload'];
	$auto_location[] = $m['auto_location'];
	$human_feeder[] = $m['human_feeder'];
	$floor_pickup[] = $m['floor_pickup'];
	$tele_action[] = $m['tele_action'];

}

// preload average equals most common non-blank result; tie goes to cone.
$preload_freq = ['cone'=>0, 'cube'=>0, 'none'=>0, ''=>0];
foreach ($preload as $val){
	if(array_key_exists($val, $preload_freq)){
		$preload_freq[$val] = $preload_freq[$val] + 1;
	}
}
if ($preload_freq['cone'] > 0 && $preload_freq['cone'] >= $preload_freq['cube']){
	$averages['preload'] = 'cone';
}
else if ($preload_freq['cube'] > 0){
	$averages['preload'] = 'cube';
}
else {
	$averages['preload'] = "-";
}

// auto location is a string that includes "n", "m", "f" if they ever started "near", "mid" and/or "far"
$auto_location_string = "";
if (in_array('far', $auto_location)){
	$auto_location_string .= 'f';
}
if (in_array('mid', $auto_location)){
	$auto_location_string .= 'm';
}
if (in_array('near', $auto_location)){
	$auto_location_string .= 'n';
}
$averages['auto_location'] = $auto_location_string;
echo "auto_location: ". $averages['auto_location'].'<br>';

// human_feeder is "12" if both feeders; equals "1-" or "-2" if only one is ever used or "--" if none ever used.
$human_feeder_string = "";
if (in_array('12', $human_feeder) || ((in_array('1-', $human_feeder))&&(in_array('-2', $human_feeder))) ){
	$human_feeder_string = '12';
}
else if (in_array('1-', $human_feeder)){
	$human_feeder_string = '1-';
}
else if (in_array('-2', $human_feeder)){
	$human_feeder_string = '-2';
}
else {
	$human_feeder_string = '--';
}
$averages['human_feeder'] = $human_feeder_string;
echo "human_feeder: ". $averages['human_feeder'].'<br>';

$averages['auto_location'] = $auto_location_string;
echo "auto_location: ". $averages['auto_location'].'<br>';

// floor_pickup (cone floor pickup) = most common non-blank value of "fast" or "slow"
// tie goes to "fast"
$floor_pickup_freq = array('fast'=>0, 'slow'=>0, 'X'=>0, '-'=>0, ''=>0);
foreach ($floor_pickup as $val){
	if(array_key_exists($val, $floor_pickup_freq)){
		$floor_pickup_freq[$val] = $floor_pickup_freq[$val] + 1;
	}
	else {
		echo "array key $val does not exist<br>";
	}
}
foreach ($floor_pickup_freq as $key => $value){
	echo $key . ": " . $value . '<br>';
}
if ($floor_pickup_freq['fast'] > 0 && $floor_pickup_freq['fast'] >= $floor_pickup_freq['slow']){
	$averages['floor_pickup'] = 'fast';
}
else if ($floor_pickup_freq['slow'] > 0){
	$averages['floor_pickup'] = 'slow';
}
else if ($floor_pickup_freq['X'] > 0){
	$averages['floor_pickup'] = 'X';
}
else {
	$averages['floor_pickup'] = "-";
}
echo "floor_pickup: " . $averages['floor_pickup'] . '<br>';

 
// tele_action (cube floor pickup) = most common non-blank value of "fast" or "slow"
// tie goes to "fast"
$tele_action_freq = array('fast'=>0, 'slow'=>0, 'X'=>0, '-'=>0, ''=>0);
foreach ($tele_action as $val){
	if(array_key_exists($val, $tele_action_freq)){
		$tele_action_freq[$val] = $tele_action_freq[$val] + 1;
	}
	else {
		echo "array key $val does not exist<br>";
	}
}
foreach ($tele_action_freq as $key => $value){
	echo $key . ": " . $value . '<br>';
}
if ($tele_action_freq['fast'] > 0 && $tele_action_freq['fast'] >= $tele_action_freq['slow']){
	$averages['tele_action'] = 'fast';
}
else if ($tele_action_freq['slow'] > 0){
	$averages['tele_action'] = 'slow';
}
else if ($tele_action_freq['X'] > 0){
	$averages['tele_action'] = 'X';
}
else {
	$averages['tele_action'] = "-";
}
echo "tele_action: " . $averages['tele_action'] . '<br>';


$n = count($matches);
echo 'n: ' . $n . '<br>';
foreach ($numeric_keys as $k){
	$averages[$k] = round(100*$totals[$k]/$n)/100;
	// echo "$k: $averages[$k]<br>";
}
$averages['auto_move'] = round(100*$totals['auto_move']/$n)/100;
$averages['auto_action'] = round(100*$totals['auto_action']/$n)/100;
$averages['endgame'] = round(100*$totals['endgame']/$n)/100;
$averages['defense'] = round(100*$totals['defense']/$n)/100;
$averages['incapacitated'] = round(100*$totals['incapacitated']/$n)/100;
// echo "auto_move: ".$averages['auto_move']."<br>";
// echo "auto_action: ".$averages['auto_action']."<br>";
// echo "endgame: ".$averages['endgame']."<br>";
// echo "defense: ".$averages['defense']."<br>";
// echo "incapacitated: ".$averages['incapacitated']."<br>";



$fields = 'team, event_key, auto_high_made ,auto_high_missed ,auto_mid_made ,auto_mid_missed ,auto_low_made ,auto_low_missed ,auto_high_made_B ,auto_high_missed_B ,auto_mid_made_B ,auto_mid_missed_B ,auto_low_made_B ,auto_low_missed_B ,tele_high_made ,tele_high_missed ,tele_mid_made ,tele_mid_missed ,tele_low_made ,tele_low_missed ,tele_high_made_B ,tele_high_missed_B ,tele_mid_made_B ,tele_mid_missed_B ,tele_low_made_B ,tele_low_missed_B ,fouls, auto_move, auto_action, endgame, defense, incapacitated';

$values_array = [];
$values_array[] = $team;
$values_array[] = "'$event_key'";
foreach($numeric_keys as $k){
	$values_array[] = "'{$averages[$k]}'";
}
$values_array[] = "'{$averages['auto_move']}'";
$values_array[] = "'{$averages['auto_action']}'";
$values_array[] = "'{$averages['endgame']}'";
$values_array[] = "'{$averages['defense']}'";
$values_array[] = "'{$averages['incapacitated']}'";

$values_string = implode(', ', $values_array);

$sql = "INSERT INTO stats ($fields) VALUES ($values_string)";
// echo $sql;

if(mysqli_query($conn, $sql)){
	echo "Team $team stats updated successfully.";
} 
else {
	echo mysqli_error($conn)."\n".$sql;
}

mysqli_close($conn);
?>