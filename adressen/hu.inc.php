<?PHP
// T&Uuml;V Anzeige
$sql = 'SELECT * FROM ad_hu ORDER BY hu_jahr, hu_monat';
$erg = mysql_query($sql);

$jahr = date("Y");
$monat = date("n");

echo '<table id="hu_tabelle">';
echo '<tr>';
echo '<th>Name</th>';
echo '<th>Kennzeichen</th>';
echo '<th>Monate verbleibend</th>';
echo '<th>N&auml;chster Termin</th>';
echo '</tr>';
while ($l = mysql_fetch_assoc($erg)) {
	if ($l['hu_jahr'] == $jahr)
		$differenz = $l['hu_monat']-$monat;
	else
		$differenz = ($l['hu_jahr'] - $jahr)*12 - $monat + $l['hu_monat'];
	
	echo '<tr style="';
	if ($differenz > 3)
		echo 'background-color: #008040;';
	else if ($differenz > 0)
		echo 'background-color: #C65000;';
	else
		echo 'background-color: #D0292C;';
	echo '">';
	echo '<td>'.$l['hu_name'].'</td>';
	echo '<td>'.$l['hu_kennzeichen'].'</td>';
	echo '<td>'.$differenz.'</td>';
	echo '<td>'.$l['hu_monat'].'.'.$l['hu_jahr'].'</td>';
	echo '</tr>';
}
echo '</table>';
?>
