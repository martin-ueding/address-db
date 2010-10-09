<?PHP
include('inc/varclean.inc.php');
include('inc/login.inc.php');
include('inc/abfragen.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" href="stil.css" type="text/css" />
		<title>Person l&ouml;schen</title>

	</head>
	<body>

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



	</body>
</html>