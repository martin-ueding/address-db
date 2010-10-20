<?PHP
session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

// get current mode
$mode = $_GET['mode'];
	

$allowed_modes = array('', 'all_birthdays', 'car_inspection', 'list', 'main', 'no_title', 'person_create1', 'person_create2', 'person_delete', 'person_display', 'person_edit1', 'person_edit2', 'pic_remove', 'pic_upload1', 'pic_upload2', 'pic_upload3', 'search', 'verification_email');

if (!in_array($mode, $allowed_modes)) {
	die('Entschuldigung, es gibt keine entsprechende Seite');
}
else if (empty($mode)) {
	$mode = 'main';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link rel="STYLESHEET" type="text/css" href="css/main.css">
		<script type="text/javascript" src="js/addressdb_collection.js"></script>
		
		<title>PHP Family Address Database</title>
	</head>


	<?PHP
	echo '<body class="'.(strpos($mode, '_edit') || strpos($mode, '_create') ? 'maske' : 'linksluft').'">';
	// include libs
	include('inc/login.inc.php');
	include('inc/abfragen.inc.php');
	include('inc/anzeigen.inc.php');
	include('inc/select.inc.php');

	// display header
	include('inc/header.inc.php');

		

	include('pages/'.$mode.'.inc.php');
	?>

	</body>
</html>

