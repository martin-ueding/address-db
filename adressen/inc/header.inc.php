<script type="text/javascript">
function flipMenu(what, how) {
   document.getElementById(what).style.display = how;
}	   
</script>

<div class="nav_item" onmouseover="flipMenu('mitglieder', 'block');" onmouseout="flipMenu('mitglieder', 'none');">Persönlicher Modus<br />
<ul id="mitglieder">
<?PHP
if ($_SESSION['f'] != 0)
	echo '<li><a href="index.php?f=0">:: Alle</a></li>';
$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	echo '<li><a class="fmg_key" href="index.php?f='.$l['fmg_id'].'">'.$l['fmg'].'</a></li>';
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
		echo '<li><a href="liste.php?g='.$l['g_id'].'&titel='.$l['gruppe'].'">'.$l['gruppe'].'</a></li>';
	}
}
?>
</ul>
</div>


<div class="nav_item" onmouseover="flipMenu('spezial', 'block');" onmouseout="flipMenu('spezial', 'none');">Spezial<br />
<ul id="spezial">
<li><a href="alle_geburtstage.php">Geburtstagsliste</a></li>
<li><a href="ohne_anrede.php">Ohne Anrede</a></li>
</ul>
</div>

<div class="nav_item" onmouseover="flipMenu('kartei', 'block');" onmouseout="flipMenu('kartei', 'none');">A-Z<br />
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
		echo '<a href="liste.php?b='.$b.'">';
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
<form action="suche.php" method="post" target="main">
<div id="suchfeld"><input type="search" id="suche" name="suche" maxlength="100" />

<input type="image" id="sub_mit" src="eicons/lupe.png" align="middle" title="Suche starten" /></div>
</form>
<?PHP
echo '</div>';
echo '</div>';
?>

<div class="clearheinz"></div>
