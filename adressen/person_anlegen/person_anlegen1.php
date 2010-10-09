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
<title>Person anlegen</title>
<link rel="STYLESHEET" type="text/css" href="../css/main.css">
<script type="text/javascript">
function _switch(object) 
	{
	if(document.getElementById(object).style.display == "none")
		{
		document.getElementById(object).style.display = "block";
		}
	else
		{
		document.getElementById(object).style.display = "none";
		}
	}
</script>
</head>
<body class="maske">

<h2>Teil 1/3 &ndash; Name und Bez&uuml;ge</h2>

<form action="person_anlegen5.php" method="post">

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

<h2>Teil 2/3 &ndash; Adresse</h2>

<?PHP

	echo '<select size="5" name="adresse_r">';
	$sql = 'SELECT * FROM ad_adressen, ad_plz, ad_orte, ad_laender WHERE plz_r=plz_id && ort_r=o_id && land_r=l_id ORDER BY plz, ortsname, strasse;';
	$erg = mysql_query($sql);

	while ($l = mysql_fetch_assoc($erg)) {
		echo '<option value="'.$l['ad_id'].'"';
		if (($_SESSION['adresse_r'] == $l['ad_id']) || (empty($_SESSION['adresse_r']) && $l['ad_id'] == 1))
			echo ' selected';

		echo '>'.$l['plz'].' '.$l['ortsname'].' - '.$l['strasse'].'</option>';
	} 
	echo '</select>';
	
echo '<br /><br />';

	echo '<br /><input type="checkbox" id="adresswahl" name="adresswahl" value="manuell"';
	if ($_SESSION['adresswahl'] == 'manuell')
		echo ' checked';

	echo ' onClick = "_switch(\'manuelle_eingabe\'); return true;"> Oder neue Adresse anlegen:';

	?>

	<div id="manuelle_eingabe" style="width: 600px; padding: 1px; border: 1px dotted gray; display: <?PHP if($_SESSION['adresswahl'] == 'manuell'){echo 'block';} else {echo 'none';}?>;">

	<table>
		
	<tr>
		<td>Strasse:</td>
		<td><?PHP echo '<input type="text" name="strasse" value="'.$_SESSION['strasse'].'" size="30" maxlength="100" />'; ?></td>
	</tr>
	
	<tr>
		<td>PLZ, Ort, Land:</td>
		<td><?PHP show_select_plz('plz_r', $_SESSION['plz_r']); show_select_ort('ort_r', $_SESSION['ort_r']); show_select_land('land_r', $_SESSION['land_r']); ?></td>
	</tr>
	
	<tr>
		<td></td>
		<td><?PHP echo '<input type="text" name="plz" value="'.$_SESSION['plz'].'" size="5" maxlength="5" />';  echo '<input type="text" name="ort" value="'.$_SESSION['ort'].'" size="25" maxlength="100" />'; echo '<input type="text" name="land" value="'.$_SESSION['land'].'" size="30" maxlength="100" />'; ?></td>
	</tr>
				
	</table>

	<br /><br />

	Allgemeine Telefone:

	<table>
		<tr>
			<td>Privat:</td>
			<td><?PHP show_telefon_eingabe('privat', true) ?></td>
		</tr>
		<tr>
			<td>Arbeit:</td>
			<td><?PHP show_telefon_eingabe('arbeit', true) ?></td>
		</tr>
		<tr>
			<td>Mobil:</td>
			<td><?PHP show_telefon_eingabe('mobil', true) ?></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><?PHP show_telefon_eingabe('fax', true) ?></td>
		</tr>
		<tr>
			<td>Aux:</td>
			<td><?PHP show_telefon_eingabe('aux', true) ?></td>
		</tr>
	</table>
		
	</div>
	<h2>Teil 3/3 &ndash; Pers&ouml;nliche Kontaktdaten</h2>

	<form action="person_anlegen_speichern3.php" method="post">

	<table>
		<tr>
			<td>Email privat:</td>
			<td><?PHP echo '<input type="text" name="email_privat" value="'.$_SESSION['email_privat'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Arbeit:</td>
			<td><?PHP echo '<input type="text" name="email_arbeit" value="'.$_SESSION['email_arbeit'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="email_aux" value="'.$_SESSION['email_aux'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 1:</td>
			<td>http://<?PHP echo '<input type="text" name="hp1" value="'.$_SESSION['hp1'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 2:</td>
			<td>http://<?PHP echo '<input type="text" name="hp2" value="'.$_SESSION['hp2'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Privat:</td>
			<td><?PHP show_telefon_eingabe('privat', false) ?></td>
		</tr>
		<tr>
			<td>Arbeit:</td>
			<td><?PHP show_telefon_eingabe('arbeit', false) ?></td>
		</tr>
		<tr>
			<td>Mobil:</td>
			<td><?PHP show_telefon_eingabe('mobil', false) ?></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><?PHP show_telefon_eingabe('fax', false) ?></td>
		</tr>
		<tr>
			<td>Aux:</td>
			<td><?PHP show_telefon_eingabe('aux', false) ?></td>
		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Chat AIM:</td>
			<td><?PHP echo '<input type="text" name="chat_aim" value="'.$_SESSION['chat_aim'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat MSN:</td>
			<td><?PHP echo '<input type="text" name="chat_msn" value="'.$_SESSION['chat_msn'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat ICQ:</td>
			<td><?PHP echo '#<input type="text" name="chat_icq" value="'.$_SESSION['chat_icq'].'" size="9" maxlength="9" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Yahoo:</td>
			<td><?PHP echo '<input type="text" name="chat_yim" value="'.$_SESSION['chat_yim'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Skype:</td>
			<td><?PHP echo '<input type="text" name="chat_skype" value="'.$_SESSION['chat_skype'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="chat_aux" value="'.$_SESSION['chat_aux'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp; </td></tr>
		<tr>
			<td>Notizen:</td>
			<td><?PHP echo '<textarea name="pnotizen" rows="4" cols="30">'.$_SESSION['pnotizen'].'</textarea>'; ?></td>
		</tr>
	</table>

<br /><br />
	
<input class="rand" type="submit" name="knopf" value="Speichern" /><br>&nbsp;
</form>


</body>
</html>