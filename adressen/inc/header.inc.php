<div class="nav_item" onclick="_switch('spezial');">Men&uuml;<br />
<ul id="spezial">
<li><a href="?mode=main">Startseite</a></li>
<li><a href="?mode=list&f=<?PHP echo $_SESSION['f']; ?>">Zeige meine Personen</a></li>
<li><a href="?mode=person_create1">Neue Person anlegen</a></li>
<li><a href="?mode=all_birthdays">Geburtstagsliste</a></li>
<li><a href="?mode=no_title">Ohne Anrede</a></li>
<li><a href="index.php?mode=integrity_check">Daten&uuml;berpr&uuml;fung</a></li>
</ul>
</div>
<?PHP
$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	if ($l['fmg_id'] == $_SESSION['f'])
		$aktuell_name = $l['fmg'];
}
if ($aktuell_name == "")
	$aktuell_name = 'Alle';
?>

<div class="nav_item" onclick="_switch('mitglieder');">Modus: <?PHP echo $aktuell_name; ?><br />
<ul id="mitglieder">
<?PHP
// find all get parameters which are not the mode or the fmg and put them into a string
$get_for_fmg_change = '';
foreach ($_GET as $key => $wert) {
	if ($key != 'mode' && $key != 'f') {
		$get_for_fmg_change .= '&'.$key.'='.$wert;
	}
}
if ($_SESSION['f'] != 0)
	echo '<li><a href="?mode=list&f=0'.$get_for_fmg_change.'">:: Alle</a></li>';
$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	echo '<li><a class="fmg_key" href="?mode='.$mode.'&f='.$l['fmg_id'].$get_for_fmg_change.'">'.$l['fmg'].'</a></li>';
	if ($l['fmg_id'] == $_SESSION['f'])
		$aktuell_name = $l['fmg'];
}
?>
</ul>
</div>

<div class="nav_item" onclick="_switch('gruppen');">Gruppen<br />
<ul id="gruppen">
<?PHP
$erg = select_alle_gruppen();
while ($l = mysql_fetch_assoc($erg)) {
	if (gruppe_ist_nicht_leer($l['g_id'])) {
		echo '<li><a href="?mode=list&g='.$l['g_id'].'&titel='.urlencode($l['gruppe']).'">'.$l['gruppe'].'</a></li>';
	}
}
?>
</ul>
</div>



<?PHP
$buchstaben = range('A', 'Z');
echo '<div id="kartei">';
foreach ($buchstaben as $b) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT p_id FROM ad_per, ad_flinks WHERE nachname like "'.$b.'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].';';
	else
		$sql = 'SELECT p_id FROM ad_per WHERE nachname like "'.$b.'%";';
	$erg = mysql_query($sql);
	if (mysql_num_rows($erg) > 0) {
		echo '<a href="?mode=list&b='.$b.'">';
		echo $b;
		echo '</a>';
	}
	else {
		echo '<span>'.$b.'</span>';
	}
}
echo '</div>';

echo '<div class="nav_item">';
?>
<form action="index.php" method="get"><input type="search" id="suche" name="suche" maxlength="100" /><input type="image" value="suchen" id="suche_button" src="gfx/lupe.png" /><input type="hidden" name="mode" value="search" /></form>
<?PHP
echo '</div>';
?>

<div class="clearheinz"></div>
