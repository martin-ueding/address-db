<?PHP
if (!empty($id)) {
	$erg = select_person_alles($id);
	$l = mysql_fetch_assoc($erg);
	echo 'M&ouml;chten Sie wirklich die Person <em>'.$l['vorname'].' '.$l['nachname'].'</em> l&ouml;schen?';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_delete2&id='.$id.'&back='.urlencode($_GET['back']).'">Ja, weg damit!</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">Nein, Abbrechen</a>';
}

?>
