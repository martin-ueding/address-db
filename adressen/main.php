<?PHP session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Adress DB</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="STYLESHEET" type="text/css" href="css/main.css" media="all" />
</head>
<body class="linksluft">

<?PHP
include("inc/includes.inc.php");

// Geburtstagstabelle
echo '<table id="geburtstag">'."\n";
echo '<tr>'."\n";
echo '<td colspan="4"><b>Geburtstage</b></td>'."\n";
echo '</tr>'."\n";
echo '<tr>'."\n";
echo '<td colspan="3">&nbsp;<br />Dieser Monat:</td>'."\n";
echo '</tr>'."\n";
// Daten laufender Monat holen und Anzeigearray erstellen
if ($_SESSION['f'] != 0)
	$sql = 'SELECT * FROM ad_per, ad_flinks WHERE geb_m='.date("n").' && person_lr=p_id && fmg_lr='.$_SESSION['f'].' ORDER BY geb_t';
else
	$sql = 'SELECT * FROM ad_per WHERE geb_m='.date("n").' ORDER BY geb_t';
$erg = mysql_query($sql);
echo mysql_error();
$i = 0;
while ($l = mysql_fetch_assoc($erg)) 
	{
	if($i % 2){ echo '<tr class="zeihell">';}
	else { echo '<tr class="zeidunkel">'; }
	echo '<td><a href="personenanzeige.php?id='.$l['p_id'].'" target="main">';
	if ($l['geb_t'] == date("j"))
		echo '<em>'.$l['vorname'].' '.$l['nachname'].'</em>';
	else if ($l['geb_t'] < date("j"))
		echo '<span class="grau">'.$l['vorname'].' '.$l['nachname'].'</span>';
	else
		echo $l['vorname'].' '.$l['nachname'];
	
	echo '</a> </td>'."\n";
	echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>'."\n";
	if ($l['geb_j'] > 1500)
		echo '<td> ('.(date("Y")-$l['geb_j']).') </td>'."\n";
	else
		echo '<td>&nbsp;</td>';
	echo '</tr>'."\n";
	$i++;
	}
/* .Ende Geburtstage laufender Monat. */
echo '<tr>'."\n";
echo '<td colspan="3">&nbsp;<br />N�chster Monat:</td>'."\n";
echo '</tr>'."\n";
/* .. */
/* .Daten kommender Monat holen und Anzeigearray erstellen. */
if ($_SESSION['f'] != 0)
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
	echo '<td><a href="personenanzeige.php?id='.$l['p_id'].'" target="main">'.$l['vorname'].' '.$l['nachname'].'</a> </td>'."\n";
	echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>'."\n";
	
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
	
	echo '</td>'."\n";
	echo '</tr>'."\n";
	$i++;
}
echo '</table>'."\n";

echo '<div style="overflow: auto; height: 150px; width: 200px; border: 1px solid #444; padding: 5px;"><b>Zuletzt aktualisiert:</b><br />';
$sql = 'SELECT * FROM ad_per ORDER BY last_check DESC LIMIT 15;';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	echo '<a href="personenanzeige.php?id='.$l['p_id'].'" target="main">'.$l['vorname'].' '.$l['nachname'].'</a><br />';
}
echo '</div>';

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
	
	</body>
</html>