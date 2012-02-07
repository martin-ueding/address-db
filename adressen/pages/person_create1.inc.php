<?PHP
// Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Template.php');

$template = new Template('person_form');

$template->set('checked_fmgs', array($_SESSION['f']));
$template->set('checked_groups', array($_SESSION['g']));
$template->set('form_target', 'person_create2.php');
$template->set('heading', _('create a new entry'));
$template->set('person_loop', array());

echo $template->html();
?>
