<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

require_once('../helpers/Filter.php');

if (isset($_GET['titel'])) {
	$titel = urldecode($_GET['titel']);
}
echo '<h1>'._('list').'</h1>';
$from_with_get = 'mode=list';
if (isset($titel)) {
	$from_with_get .= '&titel='.urlencode($titel);
}
/* Daten sammeln */
$filter = new Filter($_SESSION['f'], $_SESSION['g']);

/* Suche nach Buchstabe */
if (!empty($_GET['b'])) {
	$from_with_get .= '&b='.$_GET['b'];
	$filter->add_where('nachname like "'.$_GET['b'].'%"');
}
/* Suche nach Gruppe */
else if (!empty($_GET['g'])) {
	$from_with_get .= '&g='.$_GET['g'];
}
/* Suche nach Bezug */
else if (!empty($_GET['f'])) {
	$from_with_get .= '&f='.$_GET['f'];
}

$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';

/* Daten anzeigen */
if (!empty($sql)) {
	$erg = mysql_query($sql);

	if (!empty($_GET['b'])) {
		if (!isset($_SESSION['f']) || $_SESSION['f'] == 0) {
			printf(ngettext('The search for entries with last names starting with the letter %s yielded %d result:', 'The search for entries with last names starting with the letter %s yielded %d results:', mysql_num_rows($erg)), '<em>'.$_GET['b'].'</em>', mysql_num_rows($erg));
		}
		else {
			printf(ngettext('The search for entries that %s knows with last names starting with the letter %s yielded %d result:', 'The search for entries that %s knows with last names starting with the letter %s yielded %d results:', mysql_num_rows($erg)), '<em>'.$aktuell_name.'</em>', '<em>'.$_GET['b'].'</em>', mysql_num_rows($erg));
		}
		echo '<br /><br />';
	}

	else if (!empty($titel)) {
		if (!isset($_SESSION['f']) || $_SESSION['f'] == 0) {
			printf(ngettext('The group %s contains %d entry:', 'The group %s contains %d entries:', mysql_num_rows($erg)), '<em>'.$titel.'</em>', mysql_num_rows($erg));
		}
		else {
			printf(ngettext('The group %s contains %d entry that %s knows:', 'The group %s contains %d entries that %s knows:', mysql_num_rows($erg)), '<em>'.$titel.'</em>', mysql_num_rows($erg), '<em>'.$aktuell_name.'</em>');
		}
		echo '<br /><br />';
	}

	else if (!empty($_GET['f'])) {
		// get name for person
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			$f_name = $name['fmg'];
		}
		printf(ngettext('For %s, there is %d entry:', 'For %s, there are %d entries:', mysql_num_rows($erg)), '<em>'.$f_name.'</em>', mysql_num_rows($erg));
	}


	else {
		printf(ngettext('There is %d entry:', 'There are %d entries:', mysql_num_rows($erg)), mysql_num_rows($erg));
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

if (empty($_GET['b']) && empty($_GET['g']) && !empty($_GET['f'])) {
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
