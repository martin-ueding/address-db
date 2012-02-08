<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('view/Missing.php');

echo '<h1>'._('entries without an email address').'</h1>';
$from_with_get = 'mode=no_email';

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('email_privat IS NULL');
$filter->add_where('email_arbeit IS NULL');
$filter->add_where('email_aux IS NULL');

$missing = new Missing($filter, $from_with_get);
echo $missing->html();
?>
