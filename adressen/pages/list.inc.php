<?PHP
$titel = $_GET["titel"];
/* Daten sammeln */
/* Suche nach Buchstabe */
if (!empty($_GET['b'])) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE nachname like "'.$_GET['b'].'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
	else
		$sql = 'SELECT * FROM ad_per WHERE nachname like "'.$_GET['b'].'%" ORDER BY nachname, vorname;';
}
/* Suche nach Gruppe */
else if (!empty($_GET['g'])) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_glinks, ad_flinks WHERE ad_glinks.person_lr=p_id && gruppe_lr='.$_GET['g'].' && ad_flinks.person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
	else
		$sql = 'SELECT * FROM ad_per, ad_glinks WHERE person_lr=p_id && gruppe_lr='.$_GET['g'].' ORDER BY nachname, vorname;';
}
/* Suche nach Bezug */
else if (!empty($_GET['f'])) {
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' ORDER BY nachname, vorname;';
}
else {
	$sql = 'SELECT * FROM ad_per ORDER BY nachname, vorname;';
}
/* Daten anzeigen */
if (!empty($sql)) {
	echo '<table id="liste" cellpadding="0" cellspacing="0">';
	
	$erg = mysql_query($sql);
	$i = 0;
	while ($l = mysql_fetch_assoc($erg)) {
		echo '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'">';
		echo '<td><a href="?mode=person_display&id='.$l['p_id'].'">&raquo;</a></td><td align="right"><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['nachname'].'</a></td>';

		echo '</tr>';
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
		// get name for person
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			$f_name = $name['fmg'];
		}
		if(mysql_num_rows($erg) == 1) {
			echo 'F&uuml;r <em>'.$f_name.'</em> ist '.mysql_num_rows($erg).' Person gespeichert:<br /><br />';
		}
		else {
			echo 'F&uuml;r <em>'.$f_name.'</em> sind '.mysql_num_rows($erg).' Personen gespeichert:<br /><br />';
		}
	}

	echo '</table>';
}




if (!empty($_GET['f'])) {
	echo '<br /><br />';
	echo '<a href="vcard_fmg.php?f='.$_SESSION['f'].'">Diese Liste als VCard exportieren</a>';
	echo '<br />';
	echo '<a href="export812_fmg.php?f='.$_SESSION['f'].'">Diese Liste als TeX f&uuml;r Kalenderbl&auml;tter exportieren</a>';
	
}

if (!empty($emailadressen)) { 
	echo '<br /><br />';
	echo '<a href="mailto:?bcc='.implode(',', $emailadressen).'">Email an alle</a>';
}

?>
