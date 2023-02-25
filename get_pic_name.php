<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
if (file_exists("pics/{$_POST['team']}.jpg")) {   
	$picfile = "pics/{$_POST['team']}.jpg";
}
else if (file_exists("pics/{$_POST['team']}.jpeg")) {   
	$picfile = "pics/{$_POST['team']}.jpeg";
}
else if (file_exists("pics/{$_POST['team']}.png")) {   
	$picfile = "pics/{$_POST['team']}.png";
}
else if (file_exists("pics/{$_POST['team']}.JPG")) {   
	$picfile = "pics/{$_POST['team']}.JPG";
}
else if (file_exists("pics/{$_POST['team']}.JPEG")) {   
	$picfile = "pics/{$_POST['team']}.JPEG";
}
else if (file_exists("pics/{$_POST['team']}.PNG")) {   
	$picfile = "pics/{$_POST['team']}.PNG";
}
else {
	$picfile ="pics/none.jpg";
}
echo $picfile;
?>