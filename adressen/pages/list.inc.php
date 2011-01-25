<?PHP
if (isset($_GET['titel'])) {
	$titel = urldecode($_GET['titel']);
}
echo '<h1>'._('list').'</h1>';
$from_with_get = 'mode=list';
if (isset($titel)) {
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
else if (!empty($_GET['f'])) {
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' ORDER BY nachname, vorname;';
	$from_with_get .= '&f='.$_GET['f'];
}
else {
	$sql = 'SELECT * FROM ad_per ORDER BY nachname, vorname;';
}

/* Daten anzeigen */
if (!empty($sql)) {
	$erg = mysql_query($sql);

	if (!empty($_GET['b'])) {
		if(mysql_num_rows($erg) == 1) {
			printf(_('The search for last names with the letter %s yielded 1 result:'), '<em>'.$_GET['b'].'</em>').'<br /><br />';
		}
		else {
			printf(_('The search for last names with the letter %s yielded %d results:'), '<em>'.$_GET['b'].'</em>', mysql_num_rows($erg));
			echo '<br /><br />';
		}
	}

	else if (!empty($titel)) {
		if(mysql_num_rows($erg) == 1) {
			printf(_('The group %s contains 1 entry:'), '<em>'.$titel.'</em>').'<br /><br />';
		}
		else {
			printf(_('The group %s contains %d entries:'), '<em>'.$titel.'</em>', mysql_num_rows($erg));
		}
	}

	else if (!empty($_GET['f'])) {
		// get name for person
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			$f_name = $name['fmg'];
		}
		if(mysql_num_rows($erg) == 1) {
			printf(_('For %s, there is %d entry:'), '<em>'.$f_name.'</em>', mysql_num_rows($erg));
		}
		else {
			printf(_('For %s, there are %d entries:'), '<em>'.$f_name.'</em>', mysql_num_rows($erg));
		}
	}


	else {
		if(mysql_num_rows($erg) == 1) {
			echo _('There is 1 entry:');
		}
		else {
			printf(_('There are %d entries:'), mysql_num_rows($erg));
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
	echo '<a href="export/vcard_fmg.php?f='.$_SESSION['f'].'">'._('export this list as a VCard').'</a>';
	echo '<br />';
	echo '<a href="export/export812_fmg.php?f='.$_SESSION['f'].'">'._('export this list as a LaTeX for day planner sheets').'</a>';
	
}

if (!empty($emailadressen)) { 
	echo '<br /><br />';
	echo '<a href="mailto:?bcc='.implode(',', $emailadressen).'">'._('send an email to everybody in this list').'</a>';
}

?>
