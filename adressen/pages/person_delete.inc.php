<?PHP
if (!empty($id)) {
	if ($_GET['okay'] == 'ja') {
		delete_person_id($id);

		echo 'Die Person wurde gel&ouml;scht. <a href="index.php">Zur&uuml;ck</a>';
	}

	else {
		$erg = select_person_alles($id);
		$l = mysql_fetch_assoc($erg);
		echo 'M&ouml;chten Sie wirklich die Person <em>'.$l['vorname'].' '.$l['nachname'].'</em> l&ouml;schen?';
		echo '<br />';
		echo '<br />';
		echo '<form action="index.php" method="GET">';
		echo '<input type="checkbox" name="okay" value="ja" /> Ja';
		echo '<br />';
		echo '<input type="hidden" name="mode" value="person_delete" />';
		echo '<input type="hidden" name="id" value="'.$id.'" />';
		echo '<input type="submit" value="L&Ouml;SCHEN" />';
		echo '</form>';
		echo '<br />';
		echo '<a href="index.php?mode=person_display&id='.$id.'">Abbrechen</a>';
	}
}

?>
