<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

if (isset($_GET['fertig']) && $_GET['fertig'] == 'ja') {
	$id = (int)$_POST['id'];

	$tempname = $_FILES['file']['tmp_name'];
	$name = $_FILES['file']['name'];

	$type = $_FILES['file']['type'];
	$size = $_FILES['file']['size'];


	if($size > "2000000") {
		$err[] = _('The file that you want to upload is too big!').'<br />'.
			_('Maximum file size is 2 MB!');
	}

	if(empty($err)) {
		if ($_GET['fertig'] == 'ja') {
			$bilddaten = getimagesize($tempname);

			if ($bilddaten[0] <= 300) {
				copy($tempname, '_mugshots/per'.$id.'.jpg');
				$mode = 'person_display';
			}
			else {
				copy($tempname, '_mugshots/temp'.$id.'.jpg');
				$mode = 'pic_upload2';
			}
		}
	}

	else {
		foreach($err as $error)
		echo "$error<br>";
	}
}

?>
