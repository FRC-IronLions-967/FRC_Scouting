<?php
header ('Cache-Control: no-cache');
require_once('db.php');
$team = $_GET['team'];
$event_key = $_GET['event_key'];
$sql = "SELECT * FROM matches WHERE team={$_GET['team']} AND event_key='{$_GET['event_key']}' AND matchnum > 0 ORDER BY matchnum";
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

$averages['auto_location'] = $auto_location_string;

// floor_pickup (cone floor pickup) = most common non-blank value of "fast" or "slow"
// tie goes to "fast"
$floor_pickup_freq = array('fast'=>0, 'slow'=>0, 'X'=>0, '-'=>0, ''=>0);
foreach ($floor_pickup as $val){
	if(array_key_exists($val, $floor_pickup_freq)){
		$floor_pickup_freq[$val] = $floor_pickup_freq[$val] + 1;
	}
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
 
// tele_action (cube floor pickup) = most common non-blank value of "fast" or "slow"
// tie goes to "fast"
$tele_action_freq = array('fast'=>0, 'slow'=>0, 'X'=>0, '-'=>0, ''=>0);
foreach ($tele_action as $val){
	if(array_key_exists($val, $tele_action_freq)){
		$tele_action_freq[$val] = $tele_action_freq[$val] + 1;
	}
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

$n = count($matches);
foreach ($numeric_keys as $k){
	$averages[$k] = round(100*$totals[$k]/$n)/100;
}
$averages['auto_move'] = round(100*$totals['auto_move']/$n)/100;
$averages['auto_action'] = round(100*$totals['auto_action']/$n)/100;
$averages['endgame'] = round(100*$totals['endgame']/$n)/100;
$averages['defense'] = round(100*$totals['defense']/$n)/100;
$averages['incapacitated'] = round(100*$totals['incapacitated']/$n)/100;

// Calculate total box score stats
// $auto = total autonomous game piece and mobility scoring. Excludes balancing since only one robot can balance. Handled separately.
$auto_total = $averages['auto_high_made']*6 + $averages['auto_high_made_B']*6 + $averages['auto_mid_made']*4 + $averages['auto_mid_made_B']*4 + $averages['auto_low_made']*3 + $averages['auto_low_made_B']*3 + $averages['auto_move'];
// $tele = TeleOp game piece scoring total points on average
$tele_total = $averages['tele_high_made']*6 + $averages['tele_high_made_B']*6 + $averages['tele_mid_made']*4 + $averages['tele_mid_made_B']*4 + $averages['tele_low_made']*3 + $averages['tele_low_made_B']*3;
$overall_total = $averages['auto_action'] + $auto_total + $tele_total + $averages['endgame'];

$fields = 'team, event_key, auto_high_made ,auto_high_missed ,auto_mid_made ,auto_mid_missed ,auto_low_made ,auto_low_missed ,auto_high_made_B ,auto_high_missed_B ,auto_mid_made_B ,auto_mid_missed_B ,auto_low_made_B ,auto_low_missed_B ,tele_high_made ,tele_high_missed ,tele_mid_made ,tele_mid_missed ,tele_low_made ,tele_low_missed ,tele_high_made_B ,tele_high_missed_B ,tele_mid_made_B ,tele_mid_missed_B ,tele_low_made_B ,tele_low_missed_B ,fouls, auto_move, auto_action, endgame, defense, incapacitated, preload, auto_location, human_feeder, floor_pickup, tele_action, auto_total, tele_total, overall_total';

$values_array = [];
$values_array[] = $team;
$values_array[] = "'$event_key'";
foreach($numeric_keys as $k){
	$values_array[] = "{$averages[$k]}";
}
$values_array[] = "{$averages['auto_move']}";
$values_array[] = "{$averages['auto_action']}";
$values_array[] = "{$averages['endgame']}";
$values_array[] = "{$averages['defense']}";
$values_array[] = "{$averages['incapacitated']}";
$values_array[] = "'{$averages['preload']}'";
$values_array[] = "'{$averages['auto_location']}'";
$values_array[] = "'{$averages['human_feeder']}'";
$values_array[] = "'{$averages['floor_pickup']}'";
$values_array[] = "'{$averages['tele_action']}'";
$values_array[] = "$auto_total";
$values_array[] = "$tele_total";
$values_array[] = "$overall_total";


$values_string = implode(', ', $values_array);


$sql="DELETE FROM stats WHERE team=$team AND event_key='$event_key'";
if(mysqli_query($conn, $sql)){
	echo "Deleted old stats record.<br>";
} 
else {
	echo "<br>Error:<br>".$sql."<br>".mysqli_error($conn);
}

$sql = "INSERT INTO stats ($fields) VALUES ($values_string)";
if(mysqli_query($conn, $sql)){
	echo "Team $team stats updated successfully.<br>";
	// echo "Team $team average is {$overall_total} <br>".
} 
else {
	echo mysqli_error($conn)."\n".$sql;
}
mysqli_close($conn);
?>