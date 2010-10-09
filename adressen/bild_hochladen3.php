<?PHP

// ?bild=bilder/temp2.jpg&x1=108&y1=144&x2=400&y2=338

include('inc/varclean.inc.php');

$x1 = $_GET['x1'];
$x2 = $_GET['x2'];
$y1 = $_GET['y1'];
$y2 = $_GET['y2'];

$bildpfad = $_GET['bild'];
$nummer = substr($_GET['bild'], 11, strlen($_GET['bild'])-15);

$bildalt = imagecreatefromjpeg($bildpfad);
$bildneu = imagecreatetruecolor(300, 450);

$auswahl_breite = $x2-$x1;
$auswahl_hoehe = $y2-$y1;

if ($auswahl_breite > 300) {
	$tar_breite = 300;
	$tar_hoehe = round(300.0/$auswahl_breite * $auswahl_hoehe);
}
else {
	$tar_breite = $auswahl_breite;
	$tar_hoehe = $auswahl_hoehe;
}


$bildneu = imagecreatetruecolor($tar_breite, $tar_hoehe);

imagecopyresampled($bildneu, $bildalt, 0, 0, $x1, $y1, $tar_breite, $tar_hoehe, $auswahl_breite, $auswahl_hoehe);	

imagedestroy($bildalt);

header("Content-Type: image/jpeg");
imagejpeg($bildneu, 'bilder/per'.$nummer.'.jpg', 75);

imagedestroy($bildneu);

unlink($bildpfad);

header('location:personenanzeige.php?time='.time().'&id='.$nummer);
?>