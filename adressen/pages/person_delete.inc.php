<?PHP
if (!empty($id)) {
	echo 'M&ouml;chten Sie wirklich die Person <em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em> l&ouml;schen?';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_delete2&id='.$id.'&back='.urlencode($_GET['back']).'">Ja, weg damit!</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">Nein, Abbrechen</a>';
}

?>
