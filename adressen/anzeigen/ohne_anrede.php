<?PHP session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Ohne Anrede</title>
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
	
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE anrede_r=1 && person_lr=p_id && fmg_lr='.$_SESSION['f'].'';
	else
		$sql = 'SELECT * FROM ad_per WHERE anrede_r=1';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$daten[] = '<tr onmouseover="show('.$l['p_id'].');"><td><a href="../personenanzeige.php?id='.$l['p_id'].'">&raquo;</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="../personenanzeige.php?id='.$l['p_id'].'">'.$l['nachname'].'</a></td></tr>';
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
		
//	echo $sql;
	
	?>

	</body>
</html>