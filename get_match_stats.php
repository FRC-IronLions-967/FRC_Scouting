<?php
header ('Cache-Control: no-cache');
require_once('db.php');	
$event_key = trim(mysqli_real_escape_string($conn, $_GET['event_key']));
$red1 = trim(mysqli_real_escape_string($conn, $_GET['red1']));
$red2 = trim(mysqli_real_escape_string($conn, $_GET['red2']));
$red3 = trim(mysqli_real_escape_string($conn, $_GET['red3']));
$blue1 = trim(mysqli_real_escape_string($conn, $_GET['blue1']));
$blue2 = trim(mysqli_real_escape_string($conn, $_GET['blue2']));
$blue3 = trim(mysqli_real_escape_string($conn, $_GET['blue3']));
$sql = "SELECT * FROM stats WHERE event_key='$event_key' AND team in ($red1,$red2,$red3,$blue1,$blue2,$blue3) ORDER BY FIELD(team,$red1,$red2,$red3,$blue1,$blue2,$blue3)";
$result = mysqli_query($conn,$sql);
// echo '<table>'; // table tags are in the preview page
echo '<tr><th>Pos</th><th>Team</th><th>A-Bal</th><th>Auto</th><th>TeleOp</th><th>Links</th><th>E-Bal</th><th>Total</th></tr>';
function numdash($x){
	if (intval($x)==0){
		return '-';
	}
	else {
		return $x;
	}
}
$positions = array("R1", "R2", "R3", "B1", "B2", "B3");
$j = 0;
// echo "<p>".mysqli_num_rows($result)." rows</p>";
$pts_total = 0;
$max_auto_balance = 0;
$total_auto_total = 0;
$total_high = 0;
$total_mid = 0;
$total_low = 0;
$total_endgame = 0;
$link_pts = 0;
$total_tele_total = 0;
while ($row = mysqli_fetch_assoc($result)){
	// $pts_total += floatval($row['overall_total']);
	if (floatval($row['auto_action']) > $max_auto_balance){
		$max_auto_balance = floatval($row['auto_action']);
	}
	$total_auto_total += floatval($row['auto_total']);
	$total_high += floatval($row['auto_high_made']) + floatval($row['auto_high_made_B']) + floatval($row['tele_high_made']) + floatval($row['tele_high_made_B']);
	$total_mid += floatval($row['auto_mid_made']) + floatval($row['auto_mid_made_B']) + floatval($row['tele_mid_made']) + floatval($row['tele_mid_made_B']);
	$total_low += floatval($row['auto_low_made']) + floatval($row['auto_low_made_B']) + floatval($row['tele_low_made']) + floatval($row['tele_low_made_B']);
	$total_endgame += floatval($row['endgame']);
	$total_tele_total += floatval($row['tele_total']);

	echo '<tr>';
	echo '<td>'.$positions[$j].'</td>'; 
	echo '<td><a href="report.php?team='.$row['team'].'">'.$row['team'].'</a></td>'; 
	echo '<td>'.numdash($row['auto_action']).'</td>';
	echo '<td>'.numdash($row['auto_total']).'</td>';
	echo '<td>'.numdash($row['tele_total']).'</td>';
	echo '<td>'.numdash($row['link_pts']).'</td>';
	echo '<td>'.numdash($row['endgame']).'</td>';
	echo '<td>'.numdash($row['overall_total']).'</td>';
	echo '</tr>';
	if ($j%3==2){
		$pts_total = $max_auto_balance + $total_auto_total + $total_tele_total + $total_endgame;
		$total_high = min($total_high, 9);
		$total_mid = min($total_mid, 9);
		$total_low = min($total_low, 9);
		$link_pts = floor($total_high/3)*5 + 0.556*($total_high%3)**2;
		$link_pts += floor($total_mid/3)*5 + 0.556*($total_mid%3)**2;
		$link_pts += floor($total_low/3)*5 + 0.556*($total_low%3)**2;
		$link_pts = round(10*$link_pts)/10;
		echo '<tr>';
		echo '<td></td>';
		echo '<td></td>';
		echo "<td>" . numdash($max_auto_balance) . "</td>";
		echo "<td>" . numdash($total_auto_total) . "</td>";
		echo "<td>" . numdash($total_tele_total) . "</td>";
		echo "<td>" . numdash($link_pts) . "</td>";
		echo "<td>" . numdash($total_endgame) . "</td>";
		echo "<td>" . numdash($pts_total) . "</td>";
		echo '</tr>';
		echo '<tr><td>-</td></tr>';	
		$pts_total = 0;
		$max_auto_balance = 0;
		$total_auto_total = 0;
		$total_high = 0;
		$total_mid = 0;
		$total_low = 0;
		$total_endgame = 0;
		$total_tele_total = 0;
	}
	$j += 1;
}
// echo '</table>'; // table tags are in the preview page
mysqli_close($conn);
?>
</div>
</body>
</html>