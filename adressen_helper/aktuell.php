<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Daten sind aktuell</title>
	</head>
	<body>
	
	<?PHP
	
	$id = $_GET['id'];
	$code = $_GET['code'];
	include('../adressen/inc/varclean.inc.php');
	include('../adressen/_config.inc.php');
	include('../adressen/inc/abfragen.inc.php');
	
	$erg = select_person_alles($id);
	$l = mysql_fetch_assoc($erg);
	
	
	if ($code == md5($l['last_check'])) {
	
	
		echo '<h3>Danke!</h3>Guten Tag '.$l['vorname'].' '.$l['nachname'].',<br /><br />Vielen Dank, dass Sie sich die Zeit genommen haben, Ihre Daten zu überprüfen und zu bestätigen.';
		
		$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.$id.';';
		mysql_query($sql);
	
	}
	else
		echo 'Entschuldigung, aber der Code stimmt nicht. Haben Sie vielleicht schon einmal auf den Link geklickt?';
	
	?>

	</body>
</html>
