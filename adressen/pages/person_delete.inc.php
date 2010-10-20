<?PHP
if (!empty($_GET['id'])) {
	if ($_GET['okay'] == 'ja') {
		delete_person_id($_GET['id']);

		echo 'Die Person wurde gel&ouml;scht. <a href="main.php">Zur&uuml;ck</a>';
	}

	else {
		echo '<form action="person_loeschen.php" method="get">';
		echo '<input type="hidden" name="id" value="'.$_GET['id'].'" />';
		echo '<input type="checkbox" name="okay" value="ja" />';
		echo '<input type="submit" value="L&Ouml;SCHEN" />';
		echo '</form>';
		echo '<a href="personenanzeige.php?id='.$_GET['id'].'">Abbrechen</a>';
	}
}

?>
