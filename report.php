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

        .cube, .cone{
            background-color: #fbb3ae;
            text-align: center;
        }
        .cone {
            color: yellow;
        }
        .cube {
            color: transparent;
            text-shadow: 0 0 0 rgb(128, 0, 128);
            font-size: 1.3em;
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
    <strong>Floor Pickup: </strong><span id="floor_pickup"></span><br>
    <strong>Balance: </strong><span id="climber"></span><br>
    <strong>Cones: </strong><span id="manipulator_A"></span><br>
    <strong>Cubes: </strong><span id="manipulator_B"></span><br>
    <strong>Auto Plans: </strong><span id="auto_plan"></span><br>
    <strong>TeleOp Plans: </strong><span id="tele_plan"></span><br>
    <strong>Build Appearance: </strong><span id="build_appearance"></span><br>
    <strong>Wiring Appearance: </strong><span id="wiring_appearance"></span><br>
    <p id='comments'></p>
    </p>
  
    <div id="atable">Auto Info Table</div>
    <div id="ttable">Teleop Info Table</div>
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
                auto_high_made.push(parseInt(matches[i]['auto_high_made']));
                auto_high_missed.push(parseInt(matches[i]['auto_high_missed']));
                auto_mid_made.push(parseInt(matches[i]['auto_mid_made']));
                auto_mid_missed.push(parseInt(matches[i]['auto_mid_missed']));
                auto_low_made.push(parseInt(matches[i]['auto_low_made']));
                auto_low_missed.push(parseInt(matches[i]['auto_low_missed']));
                auto_high_made_B.push(parseInt(matches[i]['auto_high_made_B']));
                auto_high_missed_B.push(parseInt(matches[i]['auto_high_missed_B']));
                auto_mid_made_B.push(parseInt(matches[i]['auto_mid_made_B']));
                auto_mid_missed_B.push(parseInt(matches[i]['auto_mid_missed_B']));
                auto_low_made_B.push(parseInt(matches[i]['auto_low_made_B']));
                auto_low_missed_B.push(parseInt(matches[i]['auto_low_missed_B']));
                tele_high_made.push(parseInt(matches[i]['tele_high_made']));
                tele_high_missed.push(parseInt(matches[i]['tele_high_missed']));
                tele_mid_made.push(parseInt(matches[i]['tele_mid_made']));
                tele_mid_missed.push(parseInt(matches[i]['tele_mid_missed']));
                tele_low_made.push(parseInt(matches[i]['tele_low_made']));
                tele_low_missed.push(parseInt(matches[i]['tele_low_missed']));
                tele_high_made_B.push(parseInt(matches[i]['tele_high_made_B']));
                tele_high_missed_B.push(parseInt(matches[i]['tele_high_missed_B']));
                tele_mid_made_B.push(parseInt(matches[i]['tele_mid_made_B']));
                tele_mid_missed_B.push(parseInt(matches[i]['tele_mid_missed_B']));
                tele_low_made_B.push(parseInt(matches[i]['tele_low_made_B']));
                tele_low_missed_B.push(parseInt(matches[i]['tele_low_missed_B']));
                fouls.push(parseInt(matches[i]['fouls']));
                endgame.push(matches[i]['endgame']);
                endgame_B.push(matches[i]['endgame_B']);
                tele_action.push(matches[i]['tele_action']);
                human_feeder.push(matches[i]['human_feeder']);
                floor_pickup.push(matches[i]['floor_pickup']);
                defense.push(parseInt(matches[i]['defense']));
                incapacitated.push(parseInt(matches[i]['incapacitated']));
            }
            var triangle = "<span class='cone'>&#9650;</span>";
            var square   = "<span class='cube'>&#9632;</span>";
            var slow_triangle = "<span class='cone'>&#9651;</span>";
            var slow_square = "<span class='cube'>&#9633;</span>";
            var stopsign = "<span style='font-size:0.8em'>&#128721;</span>";
            var fence = "&#10624;";
            var n = matches.length; // the length of any of the lists will do
            var at = "";
            at += "<table>";
            // header category row
            at += "<th>Auto</th>";
            at += "<th class='cone'>&#9650;&#9650;&#9650;</th>";
            at += "<th class='cube'>&#9632;&#9632;&#9632;</th>";
            at += "<th colspan='4'></th>";
            // header row
            at += "<tr>";
            at += "<th>M#</th>";
            at += "<th style='color:yellow'>TMB</th>";
            at += "<th style='color:purple'>TMB</th>";
            at += "<th>Mob</th>";
            at += "<th>Bal</th>";
            at += "<th>Loc</th>";
            at += "<th>Pre</th>";
            at += "</tr>";
            

            var tt = "";
            tt += "<table>";
            // header category row
            tt += "<th>Tele</th>";
            tt += "<th class='cone'>&#9650;&#9650;&#9650;</th>";
            tt += "<th class='cube'>&#9632;&#9632;&#9632;</th>";
            tt += "<th>Miss</th>";
            tt += "<th colspan='5'></th>";
            // header row
            tt += "<tr>";
            tt += "<th>M#</th>";
            tt += "<th style='color:yellow'>TMB</th>";
            tt += "<th style='color:purple'>TMB</th>";
            tt += "<th><span class='cone'>&#9650;</span>,<span class='cube'>&#9632;</span></th>";
            tt += "<th>Flr</th>";
            tt += "<th>SS</th>";
            tt += "<th>Bal</th>";
            tt += "<th>Fou</th>";
            tt += "<th>D</th>";
            tt += "<th>IC</th>";
            tt += "</tr>";

            var ct = "<table>";
            ct += "<tr><th>M#</th><th>Comments</th></tr>";

            // data rows
            for (var i = 0; i < n; i++){
                var acones = auto_high_made[i] + auto_mid_made[i] + auto_low_made[i];
                var acubes = auto_high_made_B[i] + auto_mid_made_B[i] + auto_low_made_B[i];
                var tele_miss_cone = tele_high_missed[i] + tele_mid_missed[i] + tele_low_missed[i]; 
                var tele_miss_cube = tele_high_missed_B[i] + tele_mid_missed_B[i] + tele_low_missed_B[i];

                // auto data row
                at += "<tr>";
                at += "<td>" + matchnum[i] + "</td>";
                at += "<td>"+ dashnum(auto_high_made[i]) + "" + dashnum(auto_mid_made[i]) + "" + dashnum(auto_low_made[i]) + "</td>";
                at += "<td>"+ dashnum(auto_high_made_B[i]) + "" + dashnum(auto_mid_made_B[i]) + "" + dashnum(auto_low_made_B[i]) + "</td>";
                at += "<td>" + auto_move[i] + "</td>";
                at += "<td>" + auto_action[i] + "</td>";
                at += "<td>" + auto_location[i] + "</td>";
                at += "<td>"; // start of preload
                if (preload[i] == 'cone'){
                    at += triangle;
                }
                else if (preload[i] == 'cube'){
                    at += square;
                }
                else {
                    at += preload[i];
                }
                at += "</td>"; // end of preload
                at += "</tr>";

                // teleop data row
                tt += "<td>" + matchnum[i] + "</td>";
                tt += "<td>" + dashnum(tele_high_made[i]) + "" + dashnum(tele_mid_made[i]) + "" + dashnum(tele_low_made[i]) + "</td>";
                tt += "<td>" + dashnum(tele_high_made_B[i]) + "" + dashnum(tele_mid_made_B[i]) + "" + dashnum(tele_low_made_B[i]) + "</td>";
                tt += "<td>" + dashnum(tele_miss_cone) + "," + dashnum(tele_miss_cube) +"</td>";
                tt += "<td>"; // start of floor pickup
                if (floor_pickup[i] == 'fast'){
                    tt += triangle;
                }
                else if (floor_pickup[i] == 'slow'){
                    tt += slow_triangle;
                }
                else {
                    tt += floor_pickup[i];
                }
                if (tele_action[i] == 'fast'){
                    tt += square;
                }
                else if (tele_action[i] == 'slow'){
                    tt += slow_square;
                }
                else {
                    tt += tele_action[i];
                }
                tt += "</td>"; // finish floor pickup
                tt += "<td>"+ human_feeder[i] +"</td>";
                tt += "<td>"+ endgame[i] + "-" + endgame_B[i] +"</td>";
                tt += "<td>"+ dashnum(fouls[i]) +"</td>";
                if (defense[i] == 1){
                    tt += "<td>" + fence + "</td>";
                }
                else {
                    tt += "<td></td>";
                }
                if (incapacitated[i] == 1){
                    tt += "<td>" + stopsign + "</td>";
                }
                else {
                    tt += "<td></td>";
                }
                tt += "</tr>";

                ct += "<tr><td>" + matches[i]['matchnum'] + "</td>"; 
                ct += "<td>" + matches[i]['comments'] + "</td></tr>";
            }
            
            at += "</table>";
            tt += "</table>";
            ct += "</table>";

            document.getElementById('atable').innerHTML = at;
            document.getElementById('ttable').innerHTML = tt;
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

                document.getElementById('floor_pickup').innerHTML = data['floor_pickup'];
                document.getElementById('climber').innerHTML = data['climber'];
                document.getElementById('manipulator_A').innerHTML = data['manipulator_A'];
                document.getElementById('manipulator_B').innerHTML = data['manipulator_B'];
                document.getElementById('auto_plan').innerHTML = data['auto_plan'];
                document.getElementById('tele_plan').innerHTML = data['tele_plan'];
                document.getElementById('build_appearance').innerHTML = data['build_appearance'];
                document.getElementById('wiring_appearance').innerHTML = data['wiring_appearance'];
                document.getElementById('comments').innerHTML = data['comments'];

                if(data['comments'].length >0){
                    document.getElementById('comments').innerHTML = '<strong>Pit comments: </strong>'+data['comments'];                
                }
                else {
                    document.getElementById('comments').innerHTML = "";                   
                }
            }
            else {
                status("No data found.");
                document.getElementById('drive_type').innerHTML = "";
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

function dashnum(x){
    if (x == 0 ){
        return "-";
    }
    return x;
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