<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

$dateiname = '_mugshots/temp'.$id.'.jpg';

if (file_exists($dateiname)) {

	$bilddaten = getimagesize($dateiname);

	echo '<applet code="BildAusschnitt" width="'.($bilddaten[0]).'" height="'.($bilddaten[1]+30).'">';
	echo '<param name="bildurl" value="'.$dateiname.'"></param>';
	echo '<param name="archive" value="ba.jar"></param>';
	echo '<param name="rot" value="255"></param>';
	echo '<param name="gruen" value="255"></param>';
	echo '<param name="blau" value="0"></param>';
	echo '<param name="rot2" value="0"></param>';
	echo '<param name="gruen2" value="255"></param>';
	echo '<param name="blau2" value="255"></param>';
	echo '<param name="anfasserbreite" value="5"></param>';
	echo '<param name="seitenv" value="0"></param>';
	echo '<param name="zieladresse" value="'.$url_to_server.'adressen/index.php?mode=pic_upload3"></param>';
	echo '</applet>';

}
else {
	printf(_('There is no file %s.'), $dateiname);
}

?>
