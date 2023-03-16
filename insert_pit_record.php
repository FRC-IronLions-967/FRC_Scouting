<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
header ('Cache-Control: no-cache');
require_once 'db.php';
$team = trim(mysqli_real_escape_string($conn, $_POST['team']));
$event_key = trim(mysqli_real_escape_string($conn, $_POST['event_key']));
$scout_name = trim(mysqli_real_escape_string($conn, $_POST['scout_name']));
$drive_type = trim(mysqli_real_escape_string($conn, $_POST['drive_type']));
$motors_type = trim(mysqli_real_escape_string($conn, $_POST['motors_type']));
$drive_motors = trim(mysqli_real_escape_string($conn, $_POST['drive_motors']));
$floor_pickup = trim(mysqli_real_escape_string($conn, $_POST['floor_pickup']));
$climber = trim(mysqli_real_escape_string($conn, $_POST['climber']));
$manipulator_A = trim(mysqli_real_escape_string($conn, $_POST['manipulator_A']));
$manipulator_B = trim(mysqli_real_escape_string($conn, $_POST['manipulator_B']));
$auto_plan = trim(mysqli_real_escape_string($conn, $_POST['auto_plan']));
$tele_plan = trim(mysqli_real_escape_string($conn, $_POST['tele_plan']));
$build_appearance = trim(mysqli_real_escape_string($conn, $_POST['build_appearance']));
$wiring_appearance = trim(mysqli_real_escape_string($conn, $_POST['wiring_appearance']));
$comments = trim(mysqli_real_escape_string($conn, $_POST['comments']));
$picture_filename = trim(mysqli_real_escape_string($conn, $_POST['picture_filename']));

$fields = "team,event_key,scout_name,drive_type,motors_type,drive_motors,floor_pickup,climber,manipulator_A,manipulator_B,auto_plan,tele_plan,build_appearance,wiring_appearance,comments,picture_filename";
$values = "'$team','$event_key','$scout_name','$drive_type','$motors_type','$drive_motors','$floor_pickup','$climber','$manipulator_A','$manipulator_B','$auto_plan','$tele_plan','$build_appearance','$wiring_appearance','$comments','$picture_filename'";

$sql="DELETE FROM pit WHERE team=$team AND event_key='$event_key'";

if(mysqli_query($conn, $sql)){
	echo "Deleted old record.<br>";
} 
else {
	echo "<br>Error:<br>".$sql."<br>".mysqli_error($conn);
}

$sql="INSERT INTO pit ($fields) VALUES ($values)";

if(mysqli_query($conn, $sql)){
	echo "Pit Scouting record saved successfully.";
} 
else {
	echo "<br>Error:<br>".$sql."<br>".mysqli_error($conn);
}

mysqli_close($conn);

?>