<?PHP	
echo '<h1>'._('without a birthday').'</h1>';
	
$sql = 'SELECT * FROM ad_per WHERE (geb_t=0 or geb_m=0) && anrede_r!=4 ORDER BY nachname, vorname;';
	
$erg = mysql_query($sql);
	
echo '<div id="luecken">';

while ($l = mysql_fetch_assoc($erg)) {
	echo '<a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].' '.$l['nachname'].'</a><br />';
}
echo '</div>';
echo '</div>';


?>
