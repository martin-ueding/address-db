<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Template.php');
require_once('controller/HeaderController.php');
require_once('model/Person.php');

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

// get current mode
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

if (empty($mode)) {
	$mode = 'main';
}

// generate page title
switch ($mode) {
case 'list':
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


if (isset($mode)) {
	$content_controller = Controller::get_controller($mode);

	if ($content_controller != null) {
		$content = Controller::call($mode);
		$index_template->set('page_title', $content_controller->get_page_title());
	}
}


if (!isset($content)) {
	$content = _('No content here.');
}

$index_template->set('content', $content);


$version_array = file('version.txt');
$index_template->set('version_string', $version_array[0]);

echo $index_template->html();
?>
