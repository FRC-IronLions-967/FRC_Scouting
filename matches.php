<!doctype html>
<html>
	<head>
		<title>List Match Data</title>
	  	<link rel='stylesheet' href="w3.css">
	  	<link rel='stylesheet' href="w3-theme-red.css">
	  	<link rel='stylesheet' href="tablestylesheet.css">
	  	<meta name=viewport content="width=device-width">
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  	<style>
	  	th {
	  		text-align: left;
	  	}
	  	table {
		    border-collapse: collapse;
		}

		table, th, td {
		    border: 1px solid black;
		}
	  	</style>
	</head>
	<body class="w3-theme-d3">
		<?php require_once 'navmenu.php'; ?>
		<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-text-white w3-margin-left w3-margin-right">
			<h5>Active Scouts:</h5>
			<div id="active"></div>			
		</div>
  		<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-text-white w3-margin-left w3-margin-right">
  			<h5>Recently Completed:</h5>
			<table><tr><th>Match</th><th>Team</th><th>Scout</th><th>Comments</th></tr>
			<?php
				require_once('db.php');
				$sql = "SELECT matchnum, team, scout_name, comments FROM matches ORDER BY matchnum DESC, team;";
				$result = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($result)){
					echo "<tr>";
					echo "<td>{$row['matchnum']}</td>";
					echo "<td>{$row['team']}</td>";
					echo "<td>{$row['scout_name']}</td>";
					echo "<td>{$row['comments']}</td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				getActive();
				setInterval(getActive, 3000);
				// getActive();
			});
			function getActive(){
				xhr = new XMLHttpRequest();
				xhr.open("GET", "getactive.php", true)
				xhr.onload = function() {
					var r = JSON.parse(this.responseText);
					populateActive(r);
				};
				xhr.send();
			}
			function populateActive(data){
				var t = "<table><tr><th>Match</th><th>Team</th><th>Scout</th><th>Timestamp</th></tr>";
				for (var i = 0; i < data.length; i++){
					t += "<tr>";
					t += "<td>"+data[i]['matchnum']+"</td>";
					t += "<td>"+data[i]['team']+"</td>";
					t += "<td>"+data[i]['scout']+"</td>";
					t += "<td>"+data[i]['timestamp']+"</td>";
					t += "</tr>";					
				}
				t += "</table";
				document.getElementById('active').innerHTML = t;
			}
		</script>
	</body>
</html>
