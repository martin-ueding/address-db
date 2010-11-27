<?PHP
session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

if (isset($_GET['id'])) {
	$id = (int)$_GET['id'];
}

// include libs
include('_config.inc.php');
include('inc/abfragen.inc.php');
include('inc/anzeigen.inc.php');
include('inc/select.inc.php');

// get current mode
$mode = $_GET['mode'];
	

$allowed_modes = array('', 'all_birthdays', 'car_inspection', 'list', 'main', 'no_title', 'person_create1', 'person_create2', 'person_delete', 'person_delete2', 'person_display', 'person_edit1', 'person_edit2', 'pic_remove', 'pic_upload1', 'pic_upload2', 'pic_upload3', 'search', 'verification_email', 'verification_email', 'integrity_check');

if (!in_array($mode, $allowed_modes)) {
	die('Entschuldigung, es gibt keine entsprechende Seite');
}
else if (empty($mode)) {
	$mode = 'main';
}

// If an email has to be sent, do it now. That script will change the mode back to person_display.
if ($mode == 'verification_email') {
	include('engines/verification_email.inc.php');
}

// If a pic was uploaded, save it now before giving out anything to the browser
if ($mode == 'pic_upload1') {
	include('engines/pic_upload1.inc.php');
}

// If this page is opened by the Java applet, handle the image stuff
if ($mode == 'pic_upload3') {
	include('engines/pic_upload3.inc.php');
}

if ($mode == 'person_delete2') {
	include('engines/person_delete2.inc.php');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<meta charset="ISO-8859-1"  />
		<link rel="STYLESHEET" type="text/css" href="gfx/main.css">
		<script type="text/javascript" src="js/addressdb_collection.js"></script>

		<script src="http://jquery.com/src/jquery-latest.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				// fade out the messages box
				$("#messages").fadeOut(0).fadeIn(500).delay(<?PHP echo 5000*count($msgs); ?>).slideUp(1000);
			});
		</script>
		
		<link rel="shortcut icon" type="image/x-icon" href="gfx/favicon.ico" />
		<title>PHP Family Address Database</title>
	</head>


	<?PHP
	echo '<body class="'.(strpos($mode, '_edit') || strpos($mode, '_create') ? 'maske' : 'linksluft').'">';

	// display header
	include('inc/header.inc.php');

	if (count($msgs) > 0) {
		echo '<div id="messages">';
		echo '<ul>';
		foreach ($msgs as $msg) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ul>';
		echo '</div>';
	}	

	include('pages/'.$mode.'.inc.php');
	?>

	</body>
</html>

