<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Picture.php');

if (isset($_GET['fertig']) && $_GET['fertig'] == 'ja') {
	$tempname = $_FILES['file']['tmp_name'];
	$name = $_FILES['file']['name'];

	$type = $_FILES['file']['type'];
	$size = $_FILES['file']['size'];

	$pic = new Picture($tempname);
	try {
		$pic->resize('_mugshots/per'.$id.'.jpg');
		$msgs[] = _('The picture was added.');
	}
	catch (NoGDException $e) {
		$msgs[] = $e->getMessage();
	}

	$mode = 'person_display';
}
?>
