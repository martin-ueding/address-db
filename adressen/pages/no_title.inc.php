<?PHP
echo 'Personen ohne Anrede:<br /><br />';

$titel = $_GET["titel"];

if ($_SESSION['f'] != 0)
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE anrede_r=1 && person_lr=p_id && fmg_lr='.$_SESSION['f'].'';
else
	$sql = 'SELECT * FROM ad_per WHERE anrede_r=1';
$erg = mysql_query($sql);
$i = 0;
while ($l = mysql_fetch_assoc($erg)) {
	$daten[] = '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'"><td><a href="?mode=person_display&id='.$l['p_id'].'">&raquo;</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['nachname'].'</a></td></tr>';
}

/* Daten anzeigen */

if (count($daten) > 0) {	
	echo '<table id="liste">';

	foreach($daten as $zeile)
		echo $zeile;	
	
	echo '</table>';
}

else
	echo 'Nichts gefunden';

?>
