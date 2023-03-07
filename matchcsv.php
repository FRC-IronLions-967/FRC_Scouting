<?php
$event_key = $_GET['event_key'];
$event_key = '2023iacf';
$field_list = file('db_fields.txt', FILE_IGNORE_NEW_LINES);
$fields = implode(',',$field_list);

require_once('db.php');
$sql = "SELECT $fields FROM matches WHERE event_key='$event_key' ORDER BY team, matchnum";
$result = mysqli_query($conn,$sql);
$filename = 'matches.csv';
$f = fopen('php://memory', 'w'); 

fputcsv($f, $field_list);
while ($row=mysqli_fetch_assoc($result)){
	fputcsv($f,$row);
}
fseek($f, 0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'";');
fpassthru($f);

mysqli_close($conn);
?>

