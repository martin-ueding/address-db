<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

echo '<h1>'._('entries without a group').'</h1>';
$from_with_get = 'mode=no_group';

$titel = $_GET["titel"];

$sql = 'SELECT * FROM ad_per LEFT JOIN ad_glinks ON person_lr=gl_id WHERE person_lr IS NULL ORDER BY nachname, vorname;';

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
