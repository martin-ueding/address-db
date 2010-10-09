<?PHP session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Nicht-mehr-aktuell</title>
<link rel="STYLESHEET" type="text/css" href="../css/main.css">
<script type="text/javascript">
function show (id) {
	document.getElementById("portrait_ho").src = "bilder/per"+id+".jpg";
}
</script>

</head>
	<body class="karteikasten">

	<?PHP
	$titel = $_GET["titel"];
	include('../inc/login.inc.php');
	
	echo 'Mit Emailadresse:<br />';
	
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE last_check<'.(time()-3600*24*180).' && person_lr=p_id && fmg_lr='.$_SESSION['f'].' && (email_privat<>"" || email_arbeit<>"" || email_aux<>"") ORDER BY last_check';
	else
		$sql = 'SELECT * FROM ad_per WHERE last_check<'.(time()-3600*24*180).' && (email_privat<>"" || email_arbeit<>"" || email_aux<>"") ORDER BY last_check;';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$daten[] = '<tr onmouseover="show('.$l['p_id'].');"><td><a href="../personenanzeige.php?id='.$l['p_id'].'">&raquo;</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['nachname'].'</a></td><td>'.date('d.m.y', $l['last_check']).'</td></tr>';
	}

	/* Daten anzeigen */
	
	if (count($daten) > 0) {	
		echo '<table id="liste">';
	
		foreach($daten as $zeile)
			echo $zeile;	
		
		echo '</table>';
	}
	
	else
		echo 'Nichts gefunden';
		
	$daten = null;
		
		
	echo '<br />Ohne Emailadresse:<br />';
		
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE last_check<'.(time()-3600*24*180).' && person_lr=p_id && fmg_lr='.$_SESSION['f'].' && (email_privat="" && email_arbeit="" && email_aux="") ORDER BY last_check';
	else
		$sql = 'SELECT * FROM ad_per WHERE last_check<'.(time()-3600*24*180).' && (email_privat="" && email_arbeit="" && email_aux="") ORDER BY last_check;';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$daten[] = '<tr onmouseover="show('.$l['p_id'].');"><td><a href="../personenanzeige.php?id='.$l['p_id'].'">&raquo;</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['nachname'].'</a></td><td>'.date('d.m.y', $l['last_check']).'</td></tr>';
	}

	/* Daten anzeigen */
	
	if (count($daten) > 0) {	
		echo '<table id="liste">';
	
		foreach($daten as $zeile)
			echo $zeile;	
		
		echo '</table>';
	}
	
	else
		echo 'Nichts gefunden';
	
	?>

	</body>
</html>