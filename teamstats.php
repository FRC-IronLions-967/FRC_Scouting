<?php
header ('Cache-Control: no-cache');
require_once('db.php');
$sql = "SELECT team, overall_total FROM stats WHERE event_key='{$_GET['event_key']}' ORDER BY overall_total DESC";
$result = mysqli_query($conn,$sql);
echo '<table>';
echo '<tr><th>Team</th><th>Overall Avg Pts</th></tr>';
while ($row = mysqli_fetch_assoc($result)){
	echo '<tr><td>';
	echo $row['team'] . '</td><td>' . $row['overall_total'];
	echo '</td></tr>';
}
echo '</table>';
mysqli_close($conn);
?>