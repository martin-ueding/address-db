<?PHP
session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

// set up gettext support
include('../inc/setup_gettext.inc.php');

// include libs
if (file_exists('_config.inc.php')) {
	include('_config.inc.php');
}
else {
	header('location:../install/install.php');
}
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
	die(_('Sorry, I could not find a site like that.'));
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
		$page_title = _('Address DB').': '._('all birthdays');
		break;
	case 'list':
		if (!empty($_GET['b'])) {
			$page_title = _('Address DB').': '.sprintf(_('letter &bdquo;%s&ldquo;'), $_GET['b']);
		}
		else if (!empty($_GET['titel'])) {
			$page_title = _('Address DB').': '.sprintf(_('group &bdquo;%s&ldquo;'), $_GET['titel']);
		}
		else if (!empty($_GET['f'])) {
			// get name for person
			$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
			$name_erg = mysql_query($name_sql);
			if ($name = mysql_fetch_assoc($name_erg)) {
				$f_name = $name['fmg'];
			}
			$page_title = _('Address DB').': '.sprintf(_('entries for %s'), $f_name);
		}
		else {
			$page_title = _('Address DB').': '._('list');
		}
		break;
	case 'main':
		$page_title = _('Address DB').': '._('current birthdays');
		break;
	case 'no_title':
		$page_title = _('Address DB').': '._('no form of address');
		break;
	case 'person_create1':
	case 'person_create2':
		$page_title = _('Address DB').': '._('create entry');
		break;
	case 'person_delete':
	case 'person_delete2':
		$page_title = _('Address DB').': '.sprintf(_('delete %s'), $person_loop['vorname'].' '.$person_loop['nachname']);
		break;
	case 'person_display':
		$page_title = _('Address DB').': '.$person_loop['vorname'].' '.$person_loop['nachname'];
		break;
	case 'person_edit1':
	case 'person_edit2':
		$page_title = _('Address DB').': '.sprintf(_('edit %s'), $person_loop['vorname'].' '.$person_loop['nachname']);
		break;
	case 'pic_remove':
		$page_title = _('Address DB').': '.sprintf(_('delete %s\'s picture'), $person_loop['vorname'].' '.$person_loop['nachname']);
		break;
	case 'pic_upload1':
	case 'pic_upload2':
	case 'pic_upload3':
		$page_title = _('Address DB').': '.sprintf(_('upload %s\'s picture'), $person_loop['vorname'].' '.$person_loop['nachname']);
		break;
	case 'search':
		$page_title = _('Address DB').': '.sprintf(_('search for &bdquo;%s&ldquo;'), $_GET['suche']);
		break;
	case 'verification_email':
		$page_title = _('Address DB').': '.sprintf(_('verification mail for %s'), $person_loop['vorname'].' '.$person_loop['nachname']);
		break;
	case 'integrity_check':
		$page_title = _('Address DB').': '._('database check');
		break;
	default:
		$page_title = _('PHP Family Address DB');
		break;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<meta charset="ISO-8859-1"  />
		<link rel="STYLESHEET" type="text/css" href="gfx/main.css">

		<script src="http://jquery.com/src/jquery-latest.js" type="text/javascript"></script>
		<script type="text/javascript">
			var menuActive = false;
			var slidingTime = 100;
			function menuItemClickHandler (item) {
					$(".nav_item").children(":visible").slideUp(slidingTime);
					$(item+":hidden").slideToggle(slidingTime);
					menuActive = !menuActive;
			}
			function menuItemMouseEnterHandler (item) {
				if (menuActive) {
					$(".nav_item").children(":visible").not(item).slideUp(slidingTime);
					$(item).slideDown(slidingTime);
				}
			}

			$(document).ready(function(){
				// fade out the messages box
				$("#messages").fadeOut(0).fadeIn(500).delay(<?PHP echo 5000*count($msgs); ?>).slideUp(1000);

				// open up all the slidedown boxes
				$(".slidedown").fadeOut(0).delay(300).slideDown(800);

				// add action to the menu items
				$("#spezial").parent().click(function() { menuItemClickHandler("#spezial") });
				$("#mitglieder").parent().click(function() { menuItemClickHandler("#mitglieder") });
				$("#gruppen").parent().click(function() { menuItemClickHandler("#gruppen") });
				$("#languages").parent().click(function() { menuItemClickHandler("#languages") });

				$("#spezial").parent().mouseenter(function() { menuItemMouseEnterHandler("#spezial") });
				$("#mitglieder").parent().mouseenter(function() { menuItemMouseEnterHandler("#mitglieder") });
				$("#gruppen").parent().mouseenter(function() { menuItemMouseEnterHandler("#gruppen") });
				$("#languages").parent().mouseenter(function() { menuItemMouseEnterHandler("#languages") });
			});

			function _switch(object) {
				if (document.getElementById(object).style.display != "block") {
					document.getElementById(object).style.display = "block";
				}
				else {
					document.getElementById(object).style.display = "none";
				}
			}

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

	$version_array = file('../version.txt');
	$version_string = $version_array[0];

	echo '<div id="version"><span class="graytext">'._('version').'</span> '.$version_string.'</div>';
	?>

	</body>
</html>

