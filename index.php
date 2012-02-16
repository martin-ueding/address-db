<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/History.php');
require_once('component/Template.php');
require_once('controller/HeaderController.php');
require_once('model/Person.php');

session_start();

if (!isset($_SESSION['history'])) {
	$_SESSION['history'] = new History();
}

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
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'Birthday::upcoming_birthdays';

$index_template = new Template('index');
$index_template->set('body_class',
	$mode == 'Person::edit' || $mode == 'Person::create' ? 'maske' : '');

$header_controller = new HeaderController();
$header_controller->set_current_mode($mode);
$index_template->set('header', $header_controller->view());

if (isset($mode)) {
	$content_controller = Controller::get_controller($mode);

	if ($content_controller != null) {
		$content = Controller::call($mode);
		$index_template->set('page_title',
			$content_controller->get_page_title());
	}
}


if (!isset($content)) {
	$content = _('No content here.');
}

$index_template->set('content', $content);

$messages_template = new Template('messages');
$index_template->set('messages', $messages_template->html());


$version_array = file('version.txt');
$index_template->set('version_string', $version_array[0]);

echo $index_template->html();
?>
