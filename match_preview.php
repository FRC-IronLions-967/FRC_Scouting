<!doctype html>
<?php
	header ('Cache-Control: no-cache');
?>
<html>
<head>
	<title>Match Preview</title>
		<link rel='stylesheet' href="style.css">
		<meta name=viewport content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="eventData.js?v=1"></script>
		<script src="teamData.js?v=1"></script>
		<script src="scheduleData.js?v=1"></script>
<?php
	echo "\t\t<script>\n";
	echo "\t\t\tvar matchnum = " . $_GET['matchnum'] . ";\n";
	echo "\t\t</script>\n";
?>
</head>
<body>
<?php require_once 'navmenu.php'; ?>	
<div>
	<h4 id="titleDiv">Match Preview</h4>
	<table id="dataTable"></table>
</div>
<script>
	var matchtype = "Qualification";
	var comp_level = "qm";
	if (matchnum >= 300){
		console.log('comp_level f');
		matchtype = "Finals";
		comp_level = "f";
		matchnum -= 300;
	}
	else if (matchnum >= 200){
		matchtype = "Semifinal";
		console.log('comp_level sf');
		comp_level = "sf";
		matchnum -= 200;
	}
	else {
		console.log('comp_level qm');
	}

	function getTeams(arr){

		var teamList = [];
		if(arr.length > 0){
			for (i = 0; i < arr.length; i++) {
				if ((arr[i]["comp_level"]==comp_level && arr[i]["match_number"]==matchnum) || (arr[i]["comp_level"]==comp_level && arr[i]["set_number"]==matchnum) || (arr[i]["comp_level"]==comp_level && arr[i]["match_number"]==matchnum)){
					// matchnum is set by PHP as a global
						var red = arr[i]['alliances']['red']['team_keys'];
						var blue = arr[i]['alliances']['blue']['team_keys'];
						teamList.push(parseInt(red[0].slice(3)));
						teamList.push(parseInt(red[1].slice(3)));
						teamList.push(parseInt(red[2].slice(3)));
						teamList.push(parseInt(blue[0].slice(3)));
						teamList.push(parseInt(blue[1].slice(3)));
						teamList.push(parseInt(blue[2].slice(3)));
						return teamList
				}
			}
			return teamList;
		}
	}
	var xhr;
	function getStats(teamList){
		// console.log('get stats called');
		teams = getTeams(scheduleData);
		if (teams.length != 6){
			console.log('Bad team list.');
			return;
		}
		xhr = new XMLHttpRequest();
		var params = '?event_key=' + eventData['key'];
		params += '&red1=' + teams[0];
		params += '&red2=' + teams[1];
		params += '&red3=' + teams[2];
		params += '&blue1=' + teams[3];
		params += '&blue2=' + teams[4];
		params += '&blue3=' + teams[5];
		xhr.onreadystatechange = function(){
			if(this.readyState == 4 & this.status == 200){
				// console.log('ready state 4 status 200');
				if (xhr.responseText != 'null'){
					document.getElementById('dataTable').innerHTML = xhr.responseText;
					document.getElementById('titleDiv').innerHTML = matchtype + " Match " + matchnum + " Preview";
				}
				else {
					document.getElementById('dataTable').innerHTML = "null response";	
				}
			}
			else {
				document.getElementById('dataTable').innerHTML = "no response";
			}
		}
		var url = 'get_match_stats.php' + params;
		console.log('url');
		xhr.open('GET', url);
		xhr.send();
	}

	var teams = getTeams(scheduleData);
	getStats(teams);
</script>
</body>
</html>
