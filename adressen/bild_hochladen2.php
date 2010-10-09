<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title></title>

	</head>
	<body>

	<?PHP

	$dateiname = 'bilder/temp'.$_GET['id'].'.jpg';

	if (file_exists($dateiname)) {

		$bilddaten = getimagesize($dateiname);
		
		echo '<applet code="BildAusschnitt" width="'.($bilddaten[0]).'" height="'.($bilddaten[1]+30).'">'."\n";
	
			
		echo '<param name="bildurl" value="'.$dateiname.'"></param>'."\n";
	
	
			
		echo '<param name="archive" value="ba.jar"></param>'."\n";
		echo '<param name="rot" value="255"></param>'."\n";
		echo '<param name="gruen" value="255"></param>'."\n";
		echo '<param name="blau" value="0"></param>'."\n";
		echo '<param name="rot2" value="0"></param>'."\n";
		echo '<param name="gruen2" value="255"></param>'."\n";
		echo '<param name="blau2" value="255"></param>'."\n";
		echo '<param name="anfasserbreite" value="5"></param>'."\n";
		echo '<param name="seitenv" value="0"></param>'."\n";
		echo '<param name="zieladresse" value="http://www.bonnmedia.de/adressen/bild_hochladen3.php"></param>'."\n";
		echo '</applet>'."\n";

	}

	?>


	</body>
</html>