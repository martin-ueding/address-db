<?PHP
session_start();

include('../inc/varclean.inc.php');
include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');
include('../inc/select.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Person anlegen 1/4</title>
<link rel="STYLESHEET" type="text/css" href="../css/main.css">	</head>
<body class="maske">
	
<table id="schritte">
<tr>
<td class="aktiv">1/4</td>
<td class="normal">2/4</td>
<td class="normal">3/4</td>
<td class="normal">4/4</td>
</tr>
</table>

<h2>Schritt 1/4 - Name und Bez&uuml;ge</h2>

<form action="person_anlegen_speichern1.php" method="post">

<table>
<tr><th colspan="2">Name:</th></tr>
<tr>
<td>Anrede:</td>
<td><?PHP show_select_anrede('anrede_r', $_SESSION['anrede_r']); show_select_prafix('prafix_r', $_SESSION['prafix_r']); ?></td>
</tr>
<tr>
<td>Vorname:</td>
<td><?PHP echo '<input type="text" name="vorname" value="'.$_SESSION['vorname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>2. Vorname:</td>
<td><?PHP echo '<input type="text" name="mittelname" value="'.$_SESSION['mittelname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Nachname:</td>
<td><?PHP echo '<input type="text" name="nachname" value="'.$_SESSION['nachname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Suffix:</td>
<td><?PHP show_select_suffix('suffix_r', $_SESSION['suffix_r']); ?></td>
</tr>
<tr>
<td>Geburtsname:</td>
<td><?PHP echo '<input type="text" name="geburtsname" value="'.$_SESSION['geburtsname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Geburtsdatum:</td>
<td><?PHP
show_select_zahlen('geb_t', $_SESSION['geb_t'], 1, 31, true);
show_select_zahlen('geb_m', $_SESSION['geb_m'], 1, 12, true);
show_select_zahlen('geb_j', $_SESSION['geb_j'], date("Y")-100, date("Y"), false);
?></td>
</tr>
</table>
<br><br>
<h3>Bez&uuml;ge:</h3>

<?PHP
	/* Beziehungen zu den Familienmitgliedern */
	$erg = select_alle_fmg();
echo '<div class="box_596">';
	echo 'Wer kennt diese Person?<br /><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="fmgs[]" value="'.$l['fmg_id'].'"';
		if (!empty($_SESSION['fmgs']) && in_array($l['fmg_id'], $_SESSION['fmgs']))
			echo ' checked';
		 echo ' /> '.$l['fmg']."\n";
		 echo '</div>';
		}
echo '</div>';
echo '<div class="box_596">';
	echo '<br /><br />';
	/* Gruppen */
	$erg = select_alle_gruppen();
	echo 'In welchen Gruppen ist die Person?<br><br />';
	while ($l = mysql_fetch_assoc($erg))
		{
		echo '<div class="input_block">';
		echo '<input type="checkbox" name="gruppen[]" value="'.$l['g_id'].'"';
		if (!empty($_SESSION['gruppen']) && in_array($l['g_id'], $_SESSION['gruppen']))
			echo ' checked';
		 echo ' /> '.$l['gruppe']."\n";
		 echo '</div>';
		}
echo '</div>';
	echo '&nbsp;<br style="clear: left;" /><br /><input class="rand" type="text" name="neue_gruppe" size="30" maxlength="100" /> Neue Gruppe anlegen';
	?>
<br /><br />
	
<input class="rand" type="submit" name="knopf" value="Weiter" /><br>&nbsp;
</form>


</body>
</html>