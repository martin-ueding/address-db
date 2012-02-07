<?PHP
// Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');

// Geburtstagstabelle
echo '<table id="geburtstag">';
echo '<tr>';
echo '<td colspan="4"><b>'._('birthdays').'</b></td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="3">&nbsp;<br />'._('this month').':</td>';
echo '</tr>';
// Daten laufender Monat holen und Anzeigearray erstellen
$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('geb_m='.date("n"));

$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_t';
$erg = mysql_query($sql);
echo mysql_error();
$i = 0;
while ($l = mysql_fetch_assoc($erg)) {
	# TODO Use CSS for zebra.
	if($i % 2){ echo '<tr class="zeihell">';}
	else { echo '<tr class="zeidunkel">'; }
	echo '<td><a href="?mode=person_display&id='.$l['p_id'].'">';
	if ($l['geb_t'] == date("j"))
		echo '<em>'.$l['vorname'].' '.$l['nachname'].'</em>';
	else if ($l['geb_t'] < date("j"))
		echo '<span class="graytext">'.$l['vorname'].' '.$l['nachname'].'</span>';
	else
		echo $l['vorname'].' '.$l['nachname'];
	
	echo '</a> </td>';
	echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>';
	if ($l['geb_j'] > 1500)
		echo '<td> ('.(date("Y")-$l['geb_j']).') </td>';
	else
		echo '<td>&nbsp;</td>';
	echo '</tr>';
	$i++;
}
/* .Ende Geburtstage laufender Monat. */
echo '<tr>';
echo '<td colspan="3">&nbsp;<br />'._('next month').':</td>';
echo '</tr>';
/* .. */
/* .Daten kommender Monat holen und Anzeigearray erstellen. */
if (isset($_SESSION['f']) && $_SESSION['f'] != 0)
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE geb_m='.((date("n")%12)+1).' && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY geb_t';
else
	$sql = 'SELECT * FROM ad_per WHERE geb_m='.((date("n")%12)+1).' ORDER BY geb_t';
$erg = mysql_query($sql);
echo mysql_error();
	
$i = 0;
while ($l = mysql_fetch_assoc($erg)) {
	if($i % 2) {
		echo '<tr class="zeihell">';
	}
	else {
		echo '<tr class="zeidunkel">';
	}
	echo '<td><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].' '.$l['nachname'].'</a> </td>';
	echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>';
	
	echo '<td>';
	if ($l['geb_j'] > 1500) {
		echo '(';
		if (date("n") == 12)
			echo (date("Y")-$l['geb_j']) +1;
		else
			echo (date("Y")-$l['geb_j']);
		echo ')';
	}
	else
		echo '&nbsp;';
	
	echo '</td>';
	echo '</tr>';
	$i++;
}
echo '</table>';

?>
