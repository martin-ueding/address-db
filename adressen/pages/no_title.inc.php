<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

require_once('../helpers/Filter.php');

echo '<h1>'._('entries without a form of address').'</h1>';
$from_with_get = 'mode=no_title';

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('anrede_r = 1');

$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';

$erg = mysql_query($sql);
$i = 0;
while ($l = mysql_fetch_assoc($erg)) {
	$daten[] = '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'"><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">&raquo;</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['nachname'].'</a></td></tr>';
}

/* Daten anzeigen */

if (isset($daten) && count($daten) > 0) {
	echo '<table id="liste">';

	foreach($daten as $zeile)
		echo $zeile;	
	
	echo '</table>';
}

else
	echo _('nothing found');

?>
