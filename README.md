# FRC_Scouting
 Web based FRC scouting

**Overview**

This is code for an FRC (FIRST Robotics Competition) scouting website used to gather scouting data and robot pictures using phones. 

It uses a MYSQL database and vanilla PHP server side code. The front end uses vanilla JavaScript code to make AJAX requests.

The admin page requests event, team, and schedule data from TheBlueAlliance.com's API.

Data can be viewed and updated as individual team and match records or viewed on team report pages, which summarize a team's matches and pit scouting. CSV files can also be generated for pit and match data.

The database fields are generic in an attempt to make the database and PHP code reusable from season to season. The HTML files can be updated to display season-specific labels for the data, and unneeded entry fields can be hidden.