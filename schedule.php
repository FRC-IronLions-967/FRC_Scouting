<!doctype html>
<html>
	<head>
		<title>Schedule</title>
  		<link rel='stylesheet' href="style.css">
  		<meta name=viewport content="width=device-width">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<style type="text/css">
	  		table {
			    border-spacing: 5px;
			}

			.b{
				background-color: #79bff8;
			}

			.right{
				margin-right: 50%;
			}
  		</style>
	</head>
	
	<body>
		<?php require_once 'navmenu.php'; ?>
  		<div>
			<table><tr><th>Match</th><th colspan="3">Red</th><th colspan="3">Blue</th></tr>
			<?php
			//Start on character 19, because the JS file includes "var scheduleData = " that we wish to ignore here.
			$string =substr(file_get_contents("scheduleData.js"),19);
			$sched = json_decode($string, true);

			function num_sort($a, $b) {
				if ($a['comp_level']=='qm' && $b['comp_level']=='qm'){
					// positive means $b comes before $a
				    return intval($a['match_number']) - intval($b['match_number']);
				}
				else if ($a['comp_level']=='sf' && $b['comp_level']=='sf'){
				    return intval($a['set_number']) - intval($b['set_number']);
				}
				else if ($a['comp_level']=='f' && $b['comp_level']=='f'){
				    return intval($a['match_number']) - intval($b['match_number']);
				}
				else if ($a['comp_level']=='f'){
					// this means $b is either 'sf' or 'qm' since ($a=='f' && $b=='f') is handled above)
					// therefore $b comes before $a and we return a positive value
				    return 1;
				}	
				else if ($a['comp_level']=='sf' && $b['comp_level']=='qm'){
					return 1;
				}
				else {
					// if all the above are false, then either ($b=='sf' && $a=='qm') or ($b=='f' && $a=='sf')
					return -1;
				}
			}
			usort($sched, 'num_sort');
			foreach($sched as $s){
				if($s['comp_level']=='qm'){
					$matchnum = $s['match_number'];
					$red1 = substr($s['alliances']['red']['team_keys'][0],3);
					$red2 = substr($s['alliances']['red']['team_keys'][1],3);
					$red3 = substr($s['alliances']['red']['team_keys'][2],3);
					$blue1 = substr($s['alliances']['blue']['team_keys'][0],3);
					$blue2 = substr($s['alliances']['blue']['team_keys'][1],3);
					$blue3 = substr($s['alliances']['blue']['team_keys'][2],3);
					echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>Q $matchnum</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
					echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
				}
			}
			foreach($sched as $s){
				if($s['comp_level']=='sf'){
					$matchnum = $s['set_number'] + 200;
					$red1 = substr($s['alliances']['red']['team_keys'][0],3);
					$red2 = substr($s['alliances']['red']['team_keys'][1],3);
					$red3 = substr($s['alliances']['red']['team_keys'][2],3);
					$blue1 = substr($s['alliances']['blue']['team_keys'][0],3);
					$blue2 = substr($s['alliances']['blue']['team_keys'][1],3);
					$blue3 = substr($s['alliances']['blue']['team_keys'][2],3);
					$matchnum_display = $matchnum - 200;
					echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>SF $matchnum_display</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
					echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
				}
			}
			foreach($sched as $s){
				if($s['comp_level']=='f'){
					$matchnum = $s['match_number'] + 300;
					$red1 = substr($s['alliances']['red']['team_keys'][0],3);
					$red2 = substr($s['alliances']['red']['team_keys'][1],3);
					$red3 = substr($s['alliances']['red']['team_keys'][2],3);
					$blue1 = substr($s['alliances']['blue']['team_keys'][0],3);
					$blue2 = substr($s['alliances']['blue']['team_keys'][1],3);
					$blue3 = substr($s['alliances']['blue']['team_keys'][2],3);
					$matchnum_display = $matchnum - 300;
					echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>F $matchnum_display</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
					echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
				}
			}
			?>
			</table>
		</div>
	</body>
</html>
