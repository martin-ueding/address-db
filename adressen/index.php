<?PHP
session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

// include libs
include('inc/login.inc.php');
include('inc/abfragen.inc.php');
include('inc/anzeigen.inc.php');
include('inc/select.inc.php');

// get current mode
$mode = $_GET['mode'];
	

$allowed_modes = array('', 'all_birthdays', 'car_inspection', 'list', 'main', 'no_title', 'person_create1', 'person_create2', 'person_delete', 'person_display', 'person_edit1', 'person_edit2', 'pic_remove', 'pic_upload1', 'pic_upload2', 'pic_upload3', 'search', 'verification_email', 'verification_email');

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link rel="STYLESHEET" type="text/css" href="css/main.css">
		<script type="text/javascript" src="js/addressdb_collection.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />	
		<title>PHP Family Address Database</title>
	</head>


	<?PHP
	echo '<body class="'.(strpos($mode, '_edit') || strpos($mode, '_create') ? 'maske' : 'linksluft').'">';

	// display header
	include('inc/header.inc.php');

	if (count($msgs) > 0) {
		echo '<div id="messages">';
		foreach ($msgs as $msg) {
			echo $msg;
			echo '<br />';
		}
		echo '</div>';
	}	

	include('pages/'.$mode.'.inc.php');
	?>

	</body>
</html>

