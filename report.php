<!DOCTYPE HTML>
<html>
<head>
    <title>Report</title>
    <link rel='stylesheet' href="style.css">
    <meta name=viewport content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="teamData.js"></script>
    <script src="eventData.js"></script>
    <style type="text/css">
        td, th{
            text-align:center;
            padding-left:3px;
            padding-right:3px;
        }
        #mcomments tr td {
            text-align: left;
        }
    </style>
</head>
<body class="w3-theme-d3">
<?php require_once 'navmenu.php'; ?>
<div id="linknum" style="display:none;"><?php echo $_GET['team']; ?></div>
<div>
    <h4>Team Reports</h4>
    <p class="status"></p>
    <label for="team">Team Number</label><br>
    <select id="team" value = "167" name="team">
        <option value="167">167</option>
        <option value="525">525</option>
        <option value="967">967</option>
    </select><br>

    <p><img src="" alt="No picture" id="robot_picture" style='max-width: 300px'></p>

    <p>
    <strong>Drive: </strong>
    <span id="drive_type"></span>
    <span id="motors_type"></span>
    <span id="drive_motors"></span>
    <br>
    <p id='comments'></p>
    </p>
  
    <div id="mtable">Match Info Table</div>
    <div id="mcomments">Match Comments Table</div>
    </div>
<script>

function lookupMatchData(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
            matches = JSON.parse(xhr.responseText);
            var matchnum = [];
            var auto_move = [];
            var preload = [];
            var auto_location = [];
            var auto_action = [];
            var auto_high_made = [];
            var auto_high_missed = [];
            var auto_mid_made = [];
            var auto_mid_missed = [];
            var auto_low_made = [];
            var auto_low_missed = [];
            var auto_high_made_B = [];
            var auto_high_missed_B = [];
            var auto_mid_made_B = [];
            var auto_mid_missed_B = [];
            var auto_low_made_B = [];
            var auto_low_missed_B = [];
            var tele_high_made = [];
            var tele_high_missed = [];
            var tele_mid_made = [];
            var tele_mid_missed = [];
            var tele_low_made = [];
            var tele_low_missed = [];
            var tele_high_made_B = [];
            var tele_high_missed_B = [];
            var tele_mid_made_B = [];
            var tele_mid_missed_B = [];
            var tele_low_made_B = [];
            var tele_low_missed_B = [];
            var fouls = [];
            var endgame = [];
            var endgame_B = [];
            var tele_action = [];
            var human_feeder = [];
            var floor_pickup = [];
            var defense = [];
            var incapacitated = [];
            //Loop 1st time for overall stats
            for (i=0; i < matches.length; i++){
                matchnum.push(matches[i]['matchnum']);
                auto_move.push(matches[i]['auto_move']);
                preload.push(matches[i]['preload']);
                auto_location.push(matches[i]['auto_location']);
                auto_action.push(matches[i]['auto_action']);
                auto_high_made.push(matches[i]['auto_high_made']);
                auto_high_missed.push(matches[i]['auto_high_missed']);
                auto_mid_made.push(matches[i]['auto_mid_made']);
                auto_mid_missed.push(matches[i]['auto_mid_missed']);
                auto_low_made.push(matches[i]['auto_low_made']);
                auto_low_missed.push(matches[i]['auto_low_missed']);
                auto_high_made_B.push(matches[i]['auto_high_made_B']);
                auto_high_missed_B.push(matches[i]['auto_high_missed_B']);
                auto_mid_made_B.push(matches[i]['auto_mid_made_B']);
                auto_mid_missed_B.push(matches[i]['auto_mid_missed_B']);
                auto_low_made_B.push(matches[i]['auto_low_made_B']);
                auto_low_missed_B.push(matches[i]['auto_low_missed_B']);
                tele_high_made.push(matches[i]['tele_high_made']);
                tele_high_missed.push(matches[i]['tele_high_missed']);
                tele_mid_made.push(matches[i]['tele_mid_made']);
                tele_mid_missed.push(matches[i]['tele_mid_missed']);
                tele_low_made.push(matches[i]['tele_low_made']);
                tele_low_missed.push(matches[i]['tele_low_missed']);
                tele_high_made_B.push(matches[i]['tele_high_made_B']);
                tele_high_missed_B.push(matches[i]['tele_high_missed_B']);
                tele_mid_made_B.push(matches[i]['tele_mid_made_B']);
                tele_mid_missed_B.push(matches[i]['tele_mid_missed_B']);
                tele_low_made_B.push(matches[i]['tele_low_made_B']);
                tele_low_missed_B.push(matches[i]['tele_low_missed_B']);
                fouls.push(matches[i]['fouls']);
                endgame.push(matches[i]['endgame']);
                endgame_B.push(matches[i]['endgame_B']);
                tele_action.push(matches[i]['tele_action']);
                human_feeder.push(matches[i]['human_feeder']);
                floor_pickup.push(matches[i]['floor_pickup']);
                defense.push(matches[i]['defense']);
                incapacitated.push(matches[i]['incapacitated']);
            }
              
            var n = matches.length; // the length of any of the lists will do
            var t = "";
            t += "<table>";

            // header row
            t += "<tr>";
            t += "<th>M#</th>";
            t += "<th>Hi Cone</th>";
            t += "<th>Hi Cube</th>";
            t += "</tr>";

            var ct = "<table>";
            ct += "<tr><th>M#</th><th>Comments</th></tr>";

            // data rows
            for (var i = 0; i < n; i++){
                t += "<tr>";
                t += "<td>" + matchnum[i] + "</td>";
                t += "<td>" + tele_high_made[i] + "</td>";
                t += "<td>" + tele_high_made_B[i] + "</td>";
                t += "</tr>";

                ct += "<tr><td>" + matches[i]['matchnum'] + "</td>"; 
                ct += "<td>" + matches[i]['comments'] + "</td></tr>";


            }
            
            t += "</table>";
            ct += "</table>";

            document.getElementById('mtable').innerHTML = t;
            document.getElementById('mcomments').innerHTML = ct;
        }
    }
    xhr.open('GET', 'get_team_matches.php?team=' + document.getElementById('team').value + "&event_key=" + eventData['key']);
    xhr.send();

}

function lookupTeamData(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
            if (xhr.responseText != 'null'){
                status("Data found for team " + document.getElementById('team').value);
                var data = JSON.parse(xhr.responseText);
                document.getElementById('drive_type').innerHTML = data['drive_type'];
                document.getElementById('drive_motors').innerHTML = data['drive_motors'];
                document.getElementById('motors_type').innerHTML = data['motors_type'];
                if(data['comments'].length >0){
                    document.getElementById('comments').innerHTML = '<strong>Pit comments: </strong>'+data['comments'];                
                }
                else {
                    document.getElementById('comments').innerHTML = "";                   
                }
            }
            else {
                status("No data found.");
                document.getElementById('drivetype').innerHTML = "";
                document.getElementById('drive_motors').innerHTML = "";
                document.getElementById('motors_type').innerHTML = "";
                document.getElementById('comments').innerHTML = "";
            }
        }
        else {
            status("Looking for team " + document.getElementById('team').value + " data...");
        }
    };

    xhr.open('GET', 'get_pit.php?team=' + document.getElementById('team').value + "&event_key=" + eventData['key']);
    xhr.send();
}

function lookupPicture(){
    var xhr = new XMLHttpRequest();
    var params = 'team=' + document.getElementById('team').value;
    console.log(params);
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
        document.getElementById('robot_picture').src = xhr.responseText.trim();
        }
    }
    
    xhr.open("POST", "get_pic_name.php", true); 
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(encodeURI(params));
}

function updateTeams(arr){
    var teamList = [];
    for (i = 0; i < teamData.length; i++){
        teamList.push({num: parseInt(teamData[i]["team_number"]), nick: teamData[i]["nickname"]});
    }

    teamList.sort(function comp(a, b){return parseInt(a['num'])-parseInt(b['num'])});

    var choices = '';
    for(i = 0; i < teamList.length; i++){
        var num = teamList[i]['num'];
        var nick = teamList[i]['nick']
        choices += '<option value="'+num+'">'+num+' - '+nick.substring(0,22)+'</option>\n';
    }
    document.getElementById('team').innerHTML = choices;
}

function status(m){
    document.getElementsByClassName('status')[0].innerHTML = m;
    // document.getElementsByClassName('status')[1].innerHTML = m;
}

document.addEventListener("DOMContentLoaded", function() {
    //Document ready function
    updateTeams(teamData);
    if (parseInt(document.getElementById('linknum').innerHTML) > 0){    
        document.getElementById('team').value = parseInt(document.getElementById('linknum').innerHTML); 
    }
    else {
        //no GET value specified
    }


    document.getElementById('team').addEventListener("change", function(){
        lookupTeamData();
        lookupMatchData();
        lookupPicture();
        // document.getElementById('robot_picture').src = "pics/"+document.getElementById('team').value+".jpg";
    });

    if (parseInt(document.getElementById('linknum').innerHTML) > 0){    
        lookupTeamData();
        lookupMatchData();
    }
    lookupPicture();

}); //end document ready function

</script>
</body>
</html>