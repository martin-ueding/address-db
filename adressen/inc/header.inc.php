<div class="nav_item" onmouseover="flipMenu('mitglieder', 'block');" onmouseout="flipMenu('mitglieder', 'none');">Persönlicher Modus<br />
<ul id="mitglieder">
<?PHP
if ($_SESSION['f'] != 0)
	echo '<li><a href="index.php?f=0">:: Alle</a></li>';

if (($_SESSION['f'] != 0 && $_SESSION['f'] == 1) || $_SESSION['f'] == 0)
	echo '<li><a class="herby" href="index.php?f=1&main=liste" target="_parent">Herbert</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 2) || $_SESSION['f'] == 0)
	echo '<li><a class="bettina" href="index.php?f=2&main=liste" target="_parent">Bettina</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 3) || $_SESSION['f'] == 0)
	echo '<li><a class="martin" href="index.php?f=3&main=liste" target="_parent">Martin</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 4) || $_SESSION['f'] == 0)
	echo '<li><a class="lennart" href="index.php?f=4&main=liste" target="_parent">Lennart</a></li>';
?>
</ul>
</div>

<div class="nav_item" onmouseover="flipMenu('gruppen', 'block');" onmouseout="flipMenu('gruppen', 'none');">Gruppen<br />
<ul id="gruppen">
<?PHP
$erg = select_alle_gruppen();
/* .. */
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
<li><a href="anzeigen/alle_geburtstage.php">Geburtstagsliste</a></li>
<li><a href="anzeigen/nichtmehraktuell.php">Nicht mehr aktuell</a></li>
<li><a href="anzeigen/ohne_anrede.php">Ohne Anrede</a></li>
</ul>
</div>

<div class="clearheinz"></div>
