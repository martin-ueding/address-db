<?PHP
if (!empty($id)) {
	echo 'M&ouml;chten Sie wirklich das Bild f&uuml;r <em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em> l&ouml;schen?';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=pic_remove2&id='.$id.'">Ja, Bild l&ouml;schen!</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$_GET['id'].'">Abbrechen</a>';
}

?>
