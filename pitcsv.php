<?php
require_once('db.php');
$sql = "SELECT team,event_key,scout_name,drive_type,motors_type,drive_motors,floor_pickup,climber,manipulator_A,manipulator_B,auto_plan,tele_plan,build_appearance,wiring_appearance,comments FROM pit ORDER BY team";
$result = mysqli_query($conn,$sql);
$filename = 'pitscouting.csv';
$f = fopen('php://memory', 'w'); 
fwrite($f, 'team,event,scout,drive,motors_type,motors,floor_pickup,climber,manipA,manipB,auto_plan,tele_plan,build,wiring,comments' . "\n");

while ($row=mysqli_fetch_assoc($result)){
	fputcsv($f,$row);
}
fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'";');
fpassthru($f);
mysqli_close($conn);
?>