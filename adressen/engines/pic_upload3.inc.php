<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

$x1 = (int)$_GET['x1'];
$x2 = (int)$_GET['x2'];
$y1 = (int)$_GET['y1'];
$y2 = (int)$_GET['y2'];

$bildpfad = $_GET['bild'];
$nummer = substr($_GET['bild'], 14, strlen($_GET['bild'])-18);
# _mugshots/temp1.jpg

$id = $nummer;
// data has to be gained here, since no ID is given by the java applet
$erg = Queries::select_person_alles($id);
$person_loop = mysql_fetch_assoc($erg);

if (file_exists($bildpfad)) {
	$bildalt = imagecreatefromjpeg($bildpfad);
	$bildneu = imagecreatetruecolor(300, 450);

	$auswahl_breite = $x2-$x1;
	$auswahl_hoehe = $y2-$y1;

	// calculate the height and width for the picture so that it does not
	// exceed 300 px in width
	if ($auswahl_breite > 300) {
		$tar_breite = 300;
		$tar_hoehe = round(300.0/$auswahl_breite * $auswahl_hoehe);
	}
	else {
		$tar_breite = $auswahl_breite;
		$tar_hoehe = $auswahl_hoehe;
	}


	$bildneu = imagecreatetruecolor($tar_breite, $tar_hoehe);

	// crop and resize the uploaded image the way the Java applet told
	imagecopyresampled($bildneu, $bildalt, 0, 0, $x1, $y1, $tar_breite,
			$tar_hoehe, $auswahl_breite, $auswahl_hoehe);


	// save the new, cropped picture and delete the old one
	imagedestroy($bildalt);
	imagejpeg($bildneu, '_mugshots/per'.$nummer.'.jpg', 75);
	imagedestroy($bildneu);
	unlink($bildpfad);

	$msgs[] = _('The picture was added.');
}
else {
	$msgs[] = _('The temporary file could not be found. If you just have reloaded this page, this is normal.');
}
$mode = 'person_display';
?>
