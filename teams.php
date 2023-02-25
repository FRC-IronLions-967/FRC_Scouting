<!doctype html>
<html>
	<head>
	  	<link rel='stylesheet' href="w3.css">
	  	<link rel='stylesheet' href="w3-theme-red.css">
	  	<link rel='stylesheet' href="tablestylesheet.css">
	  	<meta name=viewport content="width=device-width">
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  	<style>
	  	th {
	  		text-align: left;
	  	}
	  	</style>

	</head>
	
	<body class="w3-theme-d3">
		<?php require_once 'navmenu.php'; ?>
  		<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-text-white w3-margin-left w3-margin-right">

  			<p><a href="teams_pics.php">Load Team Pictures</a></p>
			<table><tr><th>Team</th><th>Nickname</th><th>Location</th></tr>
			<?php
			//Start on character 15, because the JS file includes "var teamData = " that we wish to ignore here.
			$string =substr(file_get_contents("teamData.js"),15);
			$teams = json_decode($string, true);
			
			//Sort array by team_number
			foreach ($teams as $key => $row) {
			    $teamnumber[$key]  = $row['team_number'];
			}
			array_multisort($teamnumber, SORT_ASC, $teams);
			
			foreach($teams as $t){
				$teamnum = $t['team_number'];
				$nickname = $t['nickname'];
				$locality = $t['city'] . ',' . $t['state_prov'];
				echo "<tr><td><a href=\"report.php?team=$teamnum\">$teamnum</a></td><td>$nickname</td><td>{$locality}\n";
			}
			
			// $blue1 = $sched[36]['alliances']['blue']['teams'][0];
			// echo "Blue 1: ".$blue1;
			//echo "<br>".gettype($sched);
			?>
			</table>

		</div>
	</body>
</html>
