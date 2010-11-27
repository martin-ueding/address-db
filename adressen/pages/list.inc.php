<?PHP
$titel = $_GET["titel"];
$from_with_get = 'mode=list';
if (!empty($titel)) {
	$from_with_get .= '&titel='.urlencode($titel);
}
/* Daten sammeln */
/* Suche nach Buchstabe */
if (!empty($_GET['b'])) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_flinks WHERE nachname like "'.$_GET['b'].'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
	else
		$sql = 'SELECT * FROM ad_per WHERE nachname like "'.$_GET['b'].'%" ORDER BY nachname, vorname;';
	$from_with_get .= '&b='.$_GET['b'];
}
/* Suche nach Gruppe */
else if (!empty($_GET['g'])) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_per, ad_glinks, ad_flinks WHERE ad_glinks.person_lr=p_id && gruppe_lr='.$_GET['g'].' && ad_flinks.person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
	else
		$sql = 'SELECT * FROM ad_per, ad_glinks WHERE person_lr=p_id && gruppe_lr='.$_GET['g'].' ORDER BY nachname, vorname;';
	$from_with_get .= '&g='.$_GET['g'];
}
/* Suche nach Bezug */
else if (!empty($_SESSION['f'])) {
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
	$from_with_get .= '&f='.$_SESSION['f'];
}
else if (!empty($_GET['suche'])) {
	$suche = $_GET['suche'];

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
	$from_with_get .= '&suche='.$suche;
}
else {
	$sql = 'SELECT * FROM ad_per ORDER BY nachname, vorname;';
}

/* Daten anzeigen */
if (!empty($sql)) {
	$erg = mysql_query($sql);

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

	else if (!empty($_SESSION['f'])) {
		// get name for person
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_SESSION['f'].';';
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

	else if (!empty($_GET['suche'])) {
		if(mysql_num_rows($erg) == 1) {
			echo 'Die Suche nach dem Begriff <em>[ '.$suche.' ]</em> brachte '.mysql_num_rows($erg).' Ergebnis:<br /><br />';
		}
		else {
			echo 'Suche nach  dem Begriff <em>[ '.$suche.' ]</em> brachte '.mysql_num_rows($erg).' Ergebnisse:<br /><br />';
		}
	}

	else {
		if(mysql_num_rows($erg) == 1) {
			echo 'Es gibt '.mysql_num_rows($erg).' Eintrag:<br /><br />';
		}
		else {
			echo 'Es gibt '.mysql_num_rows($erg).' Eintr&auml;ge:<br /><br />';
		}
	}

	echo '<table id="liste" cellpadding="0" cellspacing="0">';
	$i = 0;
	while ($l = mysql_fetch_assoc($erg)) {
		echo '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'">';
		echo '<td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">&raquo;</a></td><td align="right"><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['nachname'].'</a></td>';

		echo '</tr>';

		// collect email address from everybody to send off a mass email
		if ($l['email_privat'] != "") {
			$emailadressen[] = $l['email_privat'];
		}
		else if ($l['email_arbeit'] != "") {
			$emailadressen[] = $l['email_arbeit'];
		}
		else if ($l['email_aux'] != "") {
			$emailadressen[] = $l['email_aux'];
		}
	}
	echo '</table>';
}

if (!empty($_GET['f'])) {
	echo '<br /><br />';
	echo '<a href="export/vcard_fmg.php?f='.$_SESSION['f'].'">Diese Liste als VCard exportieren</a>';
	echo '<br />';
	echo '<a href="export/export812_fmg.php?f='.$_SESSION['f'].'">Diese Liste als TeX f&uuml;r Kalenderbl&auml;tter exportieren</a>';
	
}

if (!empty($emailadressen)) { 
	echo '<br /><br />';
	echo '<a href="mailto:?bcc='.implode(',', $emailadressen).'">Email an alle</a>';
}

?>
