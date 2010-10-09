<?PHP session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Listenanzeige</title>
<link rel="STYLESHEET" type="text/css" href="css/main.css">

</head>
	<body class="karteikasten">

	<?PHP
	$titel = $_GET["titel"];
	include('inc/includes.inc.php');
	/* Daten sammeln */
	/* Suche nach Buchstabe */
	if (!empty($_GET['b'])) {
		if ($_SESSION['f'] != 0)
			$sql = 'SELECT * FROM ad_per, ad_flinks WHERE nachname like "'.$_GET['b'].'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
		else
			$sql = 'SELECT * FROM ad_per WHERE nachname like "'.$_GET['b'].'%" ORDER BY nachname, vorname;';
	}
	/* Suche nach Gruppe */
	if (!empty($_GET['g'])) {
		if ($_SESSION['f'] != 0)
			$sql = 'SELECT * FROM ad_per, ad_glinks, ad_flinks WHERE ad_glinks.person_lr=p_id && gruppe_lr='.$_GET['g'].' && ad_flinks.person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
		else
			$sql = 'SELECT * FROM ad_per, ad_glinks WHERE person_lr=p_id && gruppe_lr='.$_GET['g'].' ORDER BY nachname, vorname;';
	}
	/* Suche nach Bezug */
	if (!empty($_GET['f'])) {
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' ORDER BY nachname, vorname;';
	}

	/* Daten anzeigen */
	if (!empty($sql)) {
		echo '<table id="liste">';
		
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {

			echo '<tr><td><a href="personenanzeige.php?id='.$l['p_id'].'">&raquo;</a></td><td><a href="personenanzeige.php?id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="personenanzeige.php?id='.$l['p_id'].'">'.$l['nachname'].'</a></td>';

			$check = $l['last_check'];

			$anzahl_level = 3;
			$veraltet_nach = 365;
			
			$letzter_check_vor = round((time()-$check)/3600/24);
			
			$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
			echo '<td>';	
			echo '<div style="padding-left: 10px;">';
			
			if ($check == 0)
				$aktuell_level = 0;
			else {
				$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
			}
			
			for ($i = $anzahl_level-1; $i >= 0 ; $i--) {
				echo '<img height="10" src="eicons/balken_'.($i < $aktuell_level ? 'aktiv' : 'inaktiv').'.png" title="Zuletzt am '.date("d.m.y", $check).' (vor '.$letzter_check_vor.' Tagen) &uuml;berp&uuml;rft." />';
			}
				
			echo '<div>';

			echo '</td></tr>';
			$emailadressen[] = $l['email_privat'];
		}

		if (!empty($_GET['b'])) {
			if(mysql_num_rows($erg) == 1) {
				echo 'Die Suche nach Nachnamen mit <em>'.$_GET['b'].'</em> brachte '.mysql_num_rows($erg).' Ergebnis:<br /><br />';
			}
			else {
				echo 'Die Suche nach Nachnamen mit <em>'.$_GET['b'].'</em> brachte '.mysql_num_rows($erg).' Ergebnisse:<br /><br />';
			}
		}

		else if (!empty($titel)) {
			if(mysql_num_rows($erg) == 1) {
				echo 'Die Gruppe <em>'.$titel.'</em> enth&auml;lt '.mysql_num_rows($erg).' Person:<br /><br />';
			}
			else {
				echo 'Die Gruppe <em>'.$titel.'</em> enth&auml;lt '.mysql_num_rows($erg).' Personen:<br /><br />';
			}
		}

		if (!empty($_GET['f'])) {
			if(mysql_num_rows($erg) == 1) {
				echo 'F&uuml;r <em>'.$titel.'</em> ist '.mysql_num_rows($erg).' Person gespeichert:<br /><br />';
			}
			else {
				echo 'F&uuml;r <em>'.$titel.'</em> sind '.mysql_num_rows($erg).' Personen gespeichert:<br /><br />';
			}
		}

		echo '</table>';
	}


	
	
	if (!empty($_SESSION['f'])) {
		echo '<br /><br />';
		echo '<a href="vcard_fmg.php?f='.$_SESSION['f'].'">Diese Liste als VCard exportieren</a>';
		echo '<br />';
		echo '<a href="csv.php?f='.$_SESSION['f'].'">Diese Liste als CSV exportieren</a>';
		echo '<br />';
		echo '<a href="export812_fmg.php?f='.$_SESSION['f'].'">Diese Liste als TeX f&uuml;r Kalenderbl&auml;tter exportieren</a>';
		
	}
	
	if (!empty($emailadressen)) {
		echo '<br /><br />Emailadressen aller Personen:<br /><textarea rows="5" cols="30">';
		foreach ($emailadressen as $ad) {
			if (!empty($ad))
				echo $ad."\n";
		}
		echo '</textarea>';
	}

	?>
	
<!--	<img id="portrait_ho" />	-->

	</body>
</html>
