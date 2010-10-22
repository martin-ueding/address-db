<?PHP
if (!empty($_GET['id'])) {
	if ($_GET['okay'] == 'ja') {
		delete_person_id($_GET['id']);

		echo 'Die Person wurde gel&ouml;scht. <a href="index.php">Zur&uuml;ck</a>';
	}

	else {
		echo '<form action="index.php" method="GET">';
		echo '<input type="checkbox" name="okay" value="ja" />';
		echo '<input type="hidden" name="mode" value="person_delete" />';
		echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
		echo '<input type="submit" value="L&Ouml;SCHEN" />';
		echo '</form>';
		echo '<a href="index.php?mode=person_display&id='.$_GET['id'].'">Abbrechen</a>';
	}
}

?>
