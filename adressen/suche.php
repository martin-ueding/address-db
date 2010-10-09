<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Listenanzeige</title>
<link rel="STYLESHEET" type="text/css" href="css/main.css">
</head>
	<body class="suchseite">

	<?PHP

	include('inc/login.inc.php');
	include('inc/abfragen.inc.php');

	foreach ($_POST as $key => $wert) {
		$_POST[$key] = strip_tags($_POST[$key]);
		$_POST[$key] = addslashes($_POST[$key]);
		$_POST[$key] = htmlspecialchars($_POST[$key], ENT_QUOTES);
		$_POST[$key] = trim($_POST[$key]);
	}
	
	$suche = $_POST['suche'];


	$sql = 'SELECT * FROM ad_per WHERE nachname like "%'.$suche.'%" '
		.'OR vorname like "%'.$suche.'%" '
		.'OR mittelname like "%'.$suche.'%" '
		.'OR geburtsname like "%'.$suche.'%" '
		
		.'OR tel_privat like "%'.$suche.'%" '
		.'OR tel_arbeit like "%'.$suche.'%" '
		.'OR tel_mobil like "%'.$suche.'%" '
		.'OR tel_fax like "%'.$suche.'%" '
		.'OR tel_aux like "%'.$suche.'%" '
		
		.'OR email_privat like "%'.$suche.'%" '
		.'OR email_arbeit like "%'.$suche.'%" '
		.'OR email_aux like "%'.$suche.'%" '
		
		.'OR hp1 like "%'.$suche.'%" '
		.'OR hp2 like "%'.$suche.'%" '

		
		.'OR chat_aim like "%'.$suche.'%" '
		.'OR chat_msn like "%'.$suche.'%" '
		.'OR chat_icq like "%'.$suche.'%" '
		.'OR chat_yim like "%'.$suche.'%" '
		.'OR chat_skype like "%'.$suche.'%" '
		.'OR chat_aux like "%'.$suche.'%" '
		
		.'OR pnotizen like "%'.$suche.'%" '
		.'ORDER BY nachname, vorname;';
	$erg = mysql_query($sql);
	echo mysql_error();
/* .. */
if(mysql_num_rows($erg) == 1)
	{
	echo 'Die Suche nach dem Begriff <em>[ '.$suche.' ]</em> brachte '.mysql_num_rows($erg).' Ergebnis:<br /><br />';
	}
else
	{
	echo 'Suche nach  dem Begriff <em>[ '.$suche.' ]</em> brachte '.mysql_num_rows($erg).' Ergebnisse:<br /><br />';
	}
/* .. */
while ($l = mysql_fetch_assoc($erg)) {
		echo '<a href="personenanzeige.php?id='.$l['p_id'].'">&raquo; '.$l['vorname'].' '.$l['nachname'].'</a><br />';
	}

	if (mysql_num_rows($erg) == 0)
		echo 'Es gibt keine passenden Personen. ';


	?>

	</body>
</html>