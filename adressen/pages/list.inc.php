<?php
// Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');
require_once('../helper/Table.php');
require_once('../model/FamilyMember.php');
require_once('../model/Group.php');

echo '<h1>'._('list').'</h1>';
$from_with_get = 'mode=list';

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
		printf(
			_('Last names starting with %s:'),
			'<em>'.$_GET['b'].'</em>', mysql_num_rows($erg)
		);
		echo '<br />';
	}

	else if ($_SESSION['g'] != 0) {
		printf(
			_('Group %s:'),
			'<em>'.Group::get_name($_SESSION['g']).'</em>', mysql_num_rows($erg)
		);
		echo '<br />';
	}

	else if ($_SESSION['f'] != 0) {
		printf(
			_('Member %s:'),
			'<em>'.FamilyMember::get_name($_SESSION['f']).'</em>', mysql_num_rows($erg)
		);
		echo '<br />';
	}

	printf(
		ngettext(
			'%d entry:',
			'%d entries:', mysql_num_rows($erg)
		),
		mysql_num_rows($erg)
	);

	echo '<br /><br />';

	$table = new Table($erg, $from_with_get);
	echo $table->html();

	// Collect email address from everybody to send off a mass email.
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
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
