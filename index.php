<?php
# Copyright © 2011-2014 Martin Ueding <dev@martin-ueding.de>

/**
 * @mainpage Address Database
 * 
 * This is a PHP powered address database for a single family. It supports
 * multiple family members, but does not provide access control on them. All
 * data is acessible by every member of the family.
 */

require_once('component/History.php');
require_once('component/Login.php');
require_once('component/NoSuchLayoutException.php');
require_once('component/Template.php');
require_once('controller/HeaderController.php');
require_once('model/Person.php');

date_default_timezone_set('UTC');

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

// import id and get everything there is to know about that person
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}
if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
}

// get current mode
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'Birthday::upcoming_birthdays';

$controller_info = Controller::get_controller($mode);

require_once($controller_info['file']);

$content_controller = new $controller_info['controller']();
$content = $content_controller->$controller_info['function']();


switch ($content_controller->get_layout()) {
case 'default':
    $index_template = new Template('index');
    $index_template->set('body_class',
        $mode == 'Person::edit' || $mode == 'Person::create' ? 'maske' : '');
    $index_template->set('page_title', $content_controller->get_page_title());

    $header_controller = new HeaderController();
    $header_controller->set_current_mode($mode);
    $index_template->set('header', $header_controller->view());

    if (!isset($content)) {
        $content = _('No content here.');
    }

    $index_template->set('content', $content);

    $messages_template = new Template('messages');
    $index_template->set('messages', $messages_template->html());


    $version_array = file('version.txt');
    $index_template->set('version_string', $version_array[0]);

    echo $index_template->html();
    break;

case 'ajax':
case 'media':
    echo $content;
    break;

default:
    throw new NoSuchLayoutException(sprintf(
        _('No Layout %s found.'), $content_controller->get_layout()
    ));
}

# vim: spell
?>
