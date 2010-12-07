<?PHP
session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

putenv('LC_MESSAGES=de_DE');
setlocale(LC_MESSAGES, 'de_DE');
bindtextdomain("main", "../locale/");
bind_textdomain_codeset("main", "iso-8859-1");
textdomain("main");


// include libs
include('_config.inc.php');
include('inc/abfragen.inc.php');
include('inc/anzeigen.inc.php');
include('inc/select.inc.php');

// import id and get everything there is to know about that person
if (isset($_GET['id'])) {
	$id = (int)$_GET['id'];
	$erg = select_person_alles($id);
	$person_loop = mysql_fetch_assoc($erg);
}

// get current mode
$mode = $_GET['mode'];
	

$allowed_modes = array('', 'all_birthdays', 'list', 'main', 'no_email', 'no_title', 'person_checked', 'person_create1', 'person_create2', 'person_delete', 'person_delete2', 'person_display', 'person_edit1', 'person_edit2', 'pic_remove', 'pic_remove2', 'pic_upload1', 'pic_upload2', 'pic_upload3', 'verification_email', 'integrity_check', 'search');

if (!in_array($mode, $allowed_modes)) {
	die(_('Entschuldigung, es gibt keine entsprechende Seite'));
}
else if (empty($mode)) {
	$mode = 'main';
}

if ($mode == 'person_checked') {
	include('engines/person_checked.inc.php');
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

if ($mode == 'pic_remove2') {
	include('engines/pic_remove2.inc.php');
}

// generate page title
switch ($mode) {
	case 'all_birthdays':
		$page_title = _('AdressDB: Alle Geburtstage');
		break;
	case 'list':
		if (!empty($_GET['b'])) {
			$page_title = 'AdressDB: Buchstabe &bdquo;'.$_GET['b'].'&ldquo;';
		}
		else if (!empty($_GET['titel'])) {
			$page_title = 'AdressDB: Gruppe &bdquo;'.$_GET['titel'].'&ldquo;';
		}
		else if (!empty($_GET['f'])) {
			// get name for person
			$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
			$name_erg = mysql_query($name_sql);
			if ($name = mysql_fetch_assoc($name_erg)) {
				$f_name = $name['fmg'];
			}
			$page_title = _('AdressDB: Personen f&uuml;r').' '.$f_name.'';
		}
		else {
			$page_title = _('AdressDB: Liste');
		}
		break;
	case 'main':
		$page_title = _('AdressDB: aktuelle Geburtstage');
		break;
	case 'no_title':
		$page_title = _('AdressDB: keine Anrede');
		break;
	case 'person_create1':
	case 'person_create2':
		$page_title = _('AdressDB: Person erstellen');
		break;
	case 'person_delete':
	case 'person_delete2':
		$page_title = 'AdressDB: '.$person_loop['vorname'].' '.$person_loop['nachname'].' l&ouml;schen?';
		break;
	case 'person_display':
		$page_title = 'AdressDB: '.$person_loop['vorname'].' '.$person_loop['nachname'];
		break;
	case 'person_edit1':
	case 'person_edit2':
		$page_title = 'AdressDB: '.$person_loop['vorname'].' '.$person_loop['nachname'].' bearbeiten';
		break;
	case 'pic_remove':
		$page_title = 'AdressDB: Bild f&uuml;r '.$person_loop['vorname'].' '.$person_loop['nachname'].' l&ouml;schen';
		break;
	case 'pic_upload1':
	case 'pic_upload2':
	case 'pic_upload3':
		$page_title = 'AdressDB: Bild f&uuml;r '.$person_loop['vorname'].' '.$person_loop['nachname'].' hochladen';
		break;
	case 'search':
		$page_title = 'AdressDB: Suche nach &bdquo;'.$_GET['suche'].'&ldquo;';
		break;
	case 'verification_email':
		$page_title = 'AdressDB: &Uuml;berpr&uuml;fungsmail f&uuml;r '.$person_loop['vorname'].' '.$person_loop['nachname'];
		break;
	case 'integrity_check':
		$page_title = _('AdressDB: Daten&uuml;berpr&uuml;fung');
		break;
	default:
		$page_title = _('PHP Familien Adressdatenbank');
		break;
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

				// open up all the slidedown boxes
				$(".slidedown").fadeOut(0).delay(300).slideDown(800);
			});
		</script>
		
		<link rel="shortcut icon" type="image/x-icon" href="gfx/favicon.ico" />
		<title><?PHP echo $page_title; ?></title>
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

