<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

include('../inc/setup_gettext.inc.php');
?><!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title><?php echo _('data is up to date'); ?></title>
	</head>
	<body>

	<?php

	$id = $_GET['id'];
	$code = $_GET['code'];
	include('../adressen/inc/varclean.inc.php');
	include('../adressen/_config.inc.php');
	include('../adressen/inc/abfragen.inc.php');

	$erg = select_person_alles($id);
	$l = mysql_fetch_assoc($erg);


	if ($code == md5($l['last_check'])) {


		echo '<h3>'._('Thank you!').'</h3>'.sprintf(_('Hello %s'), $l['vorname'].' '.$l['nachname']).',<br /><br />'._('Thank you for taking the time to review and confirm your data.');

		$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.$id.';';
		mysql_query($sql);

	}
	else
		echo _('Sorry, but that code seems to be wrong. Have you clicked on that link before maybe?');

	?>

	</body>
</html>
