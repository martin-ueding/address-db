<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('model/Person.php');
require_once('component/Template.php');
require_once('controller/HeaderController.php');

session_start();
if (isset($_GET['f'])) {
	$_SESSION['f'] = (int)$_GET['f'];
}

if (!isset($_SESSION['f'])) {
	$_SESSION['f'] = 0;
}

if (isset($_GET['g'])) {
	$_SESSION['g'] = (int)$_GET['g'];
}

if (!isset($_SESSION['g'])) {
	$_SESSION['g'] = 0;
}

// set up gettext support
include('inc/setup_gettext.inc.php');

// include libs
if (file_exists('_config.inc.php')) {
	include('_config.inc.php');
}
else {
	header('location:../install/install.php');
}

// import id and get everything there is to know about that person
if (isset($_GET['id'])) {
	$id = (int)$_GET['id'];
}
if (isset($_POST['id'])) {
	$id = (int)$_POST['id'];
}
if (isset($id)) {
	$erg = Person::select_person_alles($id);
	$person_loop = mysql_fetch_assoc($erg);
}

// get current mode
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

$allowed_modes = array('', 'all_birthdays', 'list', 'main', 'no_association', 'no_birthday', 'no_group', 'no_email', 'no_title', 'person_checked', 'person_create1', 'person_create2', 'person_delete', 'person_delete2', 'person_display', 'person_edit1', 'person_edit2', 'pic_remove', 'pic_remove2', 'pic_upload1', 'pic_upload2', 'pic_upload3', 'verification_email', 'integrity_check', 'search');

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
	if (isset($person_loop)) {
		$page_title = _('Address DB').': '.$person_loop['vorname'].' '.$person_loop['nachname'];
	}
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
	if (isset($person_loop)) {
		$page_title = _('Address DB').': '.sprintf(_('upload %s\'s picture'), $person_loop['vorname'].' '.$person_loop['nachname']);
	}
	break;
case 'search':
	$page_title = _('Address DB').': '.sprintf(_('search for &bdquo;%s&ldquo;'), $_GET['suche']);
	break;
case 'verification_email':
	if (isset($person_loop)) {
		$page_title = _('Address DB').': '.sprintf(_('verification mail for %s'), $person_loop['vorname'].' '.$person_loop['nachname']);
	}
	break;
case 'integrity_check':
	$page_title = _('Address DB').': '._('database check');
	break;
}

if (!isset($page_title)) {
	$page_title = _('PHP Family Address DB');
}


$index_template = new Template('index');
$index_template->set('body_class', (strpos($mode, '_edit') || strpos($mode, '_create') ? 'maske' : 'linksluft'));

# TODO
$header_controller = new HeaderController();
$header_controller->set_current_mode($mode);
$index_template->set('header', $header_controller->view());


# TODO
if (isset($msgs) && count($msgs) > 0) {
	echo '<div id="messages">';
	echo '<ul>';
	foreach ($msgs as $msg) {
		echo '<li>'.$msg.'</li>';
	}
	echo '</ul>';
	echo '</div>';
}
$index_template->set('messages', null);

# TODO
switch ($mode) {
case 'all_birthdays':
	require_once('controller/BirthdayController.php');
	$content_controller = new BirthdayController();
	$content = $content_controller->all_birthdays();
	break;
case 'main':
	require_once('controller/BirthdayController.php');
	$content_controller = new BirthdayController();
	$content = $content_controller->upcoming_birthdays();
	break;
default:
	$content = _('No Content.');
	break;
}
$index_template->set('content', $content);
$index_template->set('page_title', $content_controller->get_page_title());


$version_array = file('version.txt');
$index_template->set('version_string', $version_array[0]);

echo $index_template->html();
?>
