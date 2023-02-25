<!doctype html>
<html>
	<head>
	  	<link rel='stylesheet' href="w3.css">
	  	<link rel='stylesheet' href="w3-theme-red.css">
	  	<link rel='stylesheet' href="tablestylesheet.css">
	  	<meta name=viewport content="width=device-width">
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body class="w3-theme-d3">
		<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-center"><h1>2017 FRC Team List</h1></div>
		<?php require_once 'navmenu.php'; ?>
  		<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-text-white w3-margin-left w3-margin-right">

			<table>
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
				$region = $t['region'];
				echo "<tr><td>$teamnum $nickname<br>\n";
				echo "<img src='pics/{$teamnum}.jpg' alt='No Picture' style='max-width: 250px'><br></td></tr>\n";
			}
			?>
			</table>

		</div>
	</body>
</html>