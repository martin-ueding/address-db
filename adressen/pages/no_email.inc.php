<?PHP
$from_with_get = 'mode=no_email';
echo _('entries without an email address').':<br /><br />';

$titel = $_GET["titel"];

if ($_SESSION['f'] != 0)
	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_flinks ON person_lr=p_id WHERE (email_privat is null && email_arbeit is null && email_aux is null) && fmg_lr='.$_SESSION['f'].' ORDER BY nachname, vorname;';
else
	$sql = 'SELECT * FROM ad_per WHERE (email_privat is null && email_arbeit is null && email_aux is null) ORDER BY nachname, vorname;';
$erg = mysql_query($sql);
$i = 0;
while ($l = mysql_fetch_assoc($erg)) {
	$daten[] = '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'"><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">&raquo;</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['nachname'].'</a></td></tr>';
}

/* Daten anzeigen */

if (count($daten) > 0) {	
	echo '<table id="liste">';

	foreach($daten as $zeile)
		echo $zeile;	
	
	echo '</table>';
}

else
	echo _('nothing found');

?>