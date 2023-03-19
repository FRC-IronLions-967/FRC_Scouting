<!doctype html>
<html>
	<head>
		<title>Team Schedule</title>
  		<link rel='stylesheet' href="style.css">
  		<meta name=viewport content="width=device-width">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<script src="teamData.js?v=2"></script>
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
  			<select id="team" value = "967" name="team">
				<option value="967">967</option>
			</select><br>
			<table><tr><th>Match</th><th colspan="3">Red</th><th colspan="3">Blue</th></tr>
			<?php
			//Start on character 19, because the JS file includes "var scheduleData = " that we wish to ignore here.
			$team_num = $_GET['team'];
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
					$teams = array($red1, $red2, $red3, $blue1, $blue2, $blue3);
					if (in_array("$team_num",$teams)){						
						echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>Q $matchnum</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
						echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
					}
				}
			}
			foreach($sched as $s){
					if($s['comp_level']=='sf'){
						if (count($s['alliances']['red']['team_keys']) < 3){
							continue;
						}
						$matchnum = $s['set_number'] + 200;
						$red1 = substr($s['alliances']['red']['team_keys'][0],3);
						$red2 = substr($s['alliances']['red']['team_keys'][1],3);
						$red3 = substr($s['alliances']['red']['team_keys'][2],3);
						$blue1 = substr($s['alliances']['blue']['team_keys'][0],3);
						$blue2 = substr($s['alliances']['blue']['team_keys'][1],3);
						$blue3 = substr($s['alliances']['blue']['team_keys'][2],3);
						$teams = array($red1, $red2, $red3, $blue1, $blue2, $blue3);
						$matchnum_display = $matchnum - 200;
						if (in_array("$team_num",$teams)){			
							echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>SF $matchnum_display</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
							echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
						}
					}
			}
			foreach($sched as $s){
				if($s['comp_level']=='f'){
					if (count($s['alliances']['red']['team_keys']) < 3){
							continue;
						}
					$matchnum = $s['match_number'] + 300;
					$red1 = substr($s['alliances']['red']['team_keys'][0],3);
					$red2 = substr($s['alliances']['red']['team_keys'][1],3);
					$red3 = substr($s['alliances']['red']['team_keys'][2],3);
					$blue1 = substr($s['alliances']['blue']['team_keys'][0],3);
					$blue2 = substr($s['alliances']['blue']['team_keys'][1],3);
					$blue3 = substr($s['alliances']['blue']['team_keys'][2],3);
					$teams = array($red1, $red2, $red3, $blue1, $blue2, $blue3);
					$matchnum_display = $matchnum - 300;
					if (in_array("$team_num",$teams)){			
						echo "<tr><td><a href='match_preview.php?matchnum=$matchnum'>F $matchnum_display</a></td><td><a href=\"report.php?team=$red1\">$red1</a></td><td><a href=\"report.php?team=$red2\">$red2</a></td><td><a href=\"report.php?team=$red3\">$red3</a></td>\n";
						echo "<td class='b'><a href=\"report.php?team=$blue1\">$blue1</a></td><td class='b'><a href=\"report.php?team=$blue2\">$blue2</a></td><td class='b'><a href=\"report.php?team=$blue3\">$blue3</a></td></tr>\n";
					}
				}
			}
			?>
			</table>
		</div>
		<script>
			var currentTeam = <?php echo $team_num ?>;
			function updateTeams(arr){
				var teamList = [];
					for (i = 0; i < teamData.length; i++){
						teamList.push({num: parseInt(teamData[i]["team_number"]),
							nick: teamData[i]["nickname"]});
					}
				teamList.sort(function comp(a, b){return parseInt(a['num'])-parseInt(b['num'])});
				var choices = '';
				for(i = 0; i < teamList.length; i++){
					var num = teamList[i]['num'];
					var nick = teamList[i]['nick']
					choices += '<option value="'+num+'">'+num+' - '+nick.substring(0,22)+'</option>\n';
				}
				document.getElementById('team').innerHTML = choices;
				document.getElementById('team').value = currentTeam;
			}

			document.addEventListener("DOMContentLoaded", function() {
				updateTeams(teamData);
				document.getElementById('team').addEventListener("change", function(){
					window.location.href = 'team_schedule.php?team=' + document.getElementById('team').value;
				});
			});
		</script>
	</body>
</html>
