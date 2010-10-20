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

<div class="nav_item" onmouseover="flipMenu('mitglieder', 'block');" onmouseout="flipMenu('mitglieder', 'none');">Modus: <?PHP echo $aktuell_name; ?><br />
<ul id="mitglieder">
<?PHP
if ($_SESSION['f'] != 0)
	echo '<li><a href="?mode=list&f=0">:: Alle</a></li>';
$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	echo '<li><a class="fmg_key" href="?mode=list&f='.$l['fmg_id'].'">'.$l['fmg'].'</a></li>';
	if ($l['fmg_id'] == $_SESSION['f'])
		$aktuell_name = $l['fmg'];
}
?>
</ul>
</div>

<div class="nav_item" onmouseover="flipMenu('gruppen', 'block');" onmouseout="flipMenu('gruppen', 'none');">Gruppen<br />
<ul id="gruppen">
<?PHP
$erg = select_alle_gruppen();
while ($l = mysql_fetch_assoc($erg)) {
	if (gruppe_ist_nicht_leer($l['g_id'])) {
		echo '<li><a href="?mode=list&g='.$l['g_id'].'&titel='.$l['gruppe'].'">'.$l['gruppe'].'</a></li>';
	}
}
?>
</ul>
</div>


<div class="nav_item" onmouseover="flipMenu('spezial', 'block');" onmouseout="flipMenu('spezial', 'none');">Spezial<br />
<ul id="spezial">
<li><a href="?mode=person_create1">Neue Person anlegen</a></li>
<li><a href="?mode=main">Startseite</a></li>
<li><a href="?mode=all_birthdays">Geburtstagsliste</a></li>
<li><a href="?mode=no_title">Ohne Anrede</a></li>
</ul>
</div>

<div class="nav_item" onmouseover="flipMenu('kartei', 'block');" onmouseout="flipMenu('kartei', 'none');">Auswahl: A-Z<br />
<?PHP
$buchstaben = range('A', 'Z');
echo '<div id="kartei">';
foreach ($buchstaben as $b)
	{
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT p_id FROM ad_per, ad_flinks WHERE nachname like "'.$b.'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].';';
	else
		$sql = 'SELECT p_id FROM ad_per WHERE nachname like "'.$b.'%";';
	$erg = mysql_query($sql);
	if (mysql_num_rows($erg) > 0)
		{
		echo '<a href="?mode=list&b='.$b.'">';
		echo $b;
		echo '</a>';
		}
	else
		{echo '<span>'.$b.'</span>';}
	echo ' ';
	}
echo '</div>';
echo '</div>';

echo '<div class="nav_item" onmouseover="flipMenu(\'suchbox\', \'block\');" onmouseout="flipMenu(\'suchbox\', \'none\');">Suche<br />';
echo '<div id="suchbox">';
?>
<form action="?mode=search" method="post">
<div id="suchfeld"><input type="search" id="suche" name="suche" maxlength="100" />

<input type="image" id="sub_mit" src="eicons/lupe.png" align="middle" title="Suche starten" /></div>
</form>
<?PHP
echo '</div>';
echo '</div>';
?>

<div class="clearheinz"></div>
