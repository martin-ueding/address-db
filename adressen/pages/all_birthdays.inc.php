<?PHP	
echo '<h1>'._('all birthdays').'</h1>';
$from_with_get = 'mode=all_birthdays';
$monate = array(_('January'), _('February'), _('March'), _('April'), _('May'), _('June'), _('July'), _('August'), _('September'), _('October'), _('November'), _('December'));
	
if ($_SESSION['f'] != 0)
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE geb_t!=0 && geb_m!=0 && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY geb_m, geb_t, nachname;';
else
	$sql = 'SELECT * FROM ad_per WHERE geb_t!=0 && geb_m!=0 ORDER BY geb_m, geb_t, nachname;';

$erg = mysql_query($sql);

$aktuell = 1;

echo '<div class="geb_monat_kasten">';
echo '<b>'._('January').'</b><br /><br />';

while ($l = mysql_fetch_assoc($erg)) {
	if ($l['geb_m'] != $aktuell) {
		$aktuell = $l['geb_m'];
		echo '</div>';
		echo '<div class="geb_monat_kasten">';
		echo '<b>'.$monate[$aktuell-1].'</b><br /><br />';
	}
	$tag = $l['geb_t'] < 10 ? '0'.$l['geb_t'] : $l['geb_t'];
	echo '<a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$tag.'. ';
	if ($l['geb_t'] == date("j") && $aktuell == date("n"))
		echo '<em>'.$l['vorname'].' '.$l['nachname'].'</em>';
	else
	echo $l['vorname'].' '.$l['nachname'];
	
	echo '</a><br />';
}
	
echo '</div>';
	
$sql = 'SELECT * FROM ad_per WHERE (geb_t=0 or geb_m=0) && anrede_r!=4 ORDER BY nachname, vorname;';
	
$erg = mysql_query($sql);
	
	
echo '<br clear="all" /><br /><br />';
echo '<h3>'._('without a birthday').' ('.mysql_num_rows($erg).'):</h3>';

echo _('show list?').' <input type="checkbox" id="adresswahl" name="adresswahl" value="manuell" onClick = "_switch(\'luecken\'); return true;">';
	
echo '<div id="luecken" style="display: none;">';

while ($l = mysql_fetch_assoc($erg)) {
	echo '<a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].' '.$l['nachname'].'</a><br />';
}
echo '</div>';
echo '</div>';


?>
