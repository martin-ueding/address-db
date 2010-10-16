<?PHP
session_start();


$p_id = (int)($_GET['id']);


include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');

$erg = select_fmg_zu_person ($p_id);
while ($l = mysql_fetch_assoc($erg))
	$fmgs[] = $l['fmg_id'];

$erg = select_gruppen_zu_person ($p_id);
while ($l = mysql_fetch_assoc($erg))
	$gruppen[] = $l['g_id'];

$erg = select_person_alles($p_id);

if (mysql_num_rows($erg) != 1)
	header('location:../index.php');

$person_loop = mysql_fetch_assoc($erg);

$werziehtum = 'alle';

include('../inc/varclean.inc.php');
include('../inc/select.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Person bearbeiten</title>
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

<form action="person_bearbeiten5.php" method="post">

<table>
<tr><th colspan="2">Name:</th></tr>
<tr>
<td>Anrede:</td>
<td><?PHP show_select_anrede('anrede_r', $person_loop['anrede_r']); show_select_prafix('prafix_r', $person_loop['prafix_r']); ?></td>
</tr>
<tr>
<td>Vorname:</td>
<td><?PHP echo '<input type="text" name="vorname" value="'.$person_loop['vorname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>2. Vorname:</td>
<td><?PHP echo '<input type="text" name="mittelname" value="'.$person_loop['mittelname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Nachname:</td>
<td><?PHP echo '<input type="text" name="nachname" value="'.$person_loop['nachname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Suffix:</td>
<td><?PHP show_select_suffix('suffix_r', $person_loop['suffix_r']); ?></td>
</tr>
<tr>
<td>Geburtsname:</td>
<td><?PHP echo '<input type="text" name="geburtsname" value="'.$person_loop['geburtsname'].'" size="30" maxlength="100" />'; ?></td>
</tr>
<tr>
<td>Geburtsdatum:</td>
<td><?PHP
show_select_zahlen('geb_t', $person_loop['geb_t'], 1, 31, true);
show_select_zahlen('geb_m', $person_loop['geb_m'], 1, 12, true);
show_select_zahlen('geb_j', $person_loop['geb_j'], date("Y")-100, date("Y"), false);
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
		if (!empty($fmgs) && in_array($l['fmg_id'], $fmgs))
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
		if (!empty($gruppen) && in_array($l['g_id'], $gruppen))
			echo ' checked';
		 echo ' /> '.$l['gruppe']."\n";
		 echo '</div>';
		}
echo '</div>';
	echo '&nbsp;<br style="clear: left;" /><br /><input class="rand" type="text" name="neue_gruppe" size="30" maxlength="100" /> Neue Gruppe anlegen';
	?>
	
	
	<h2>Teil 2/3 &ndash; Adresse</h2>
	
	<?PHP
	if (adresse_mehrfach_benutzt($l['adresse_r'])) {
		echo '&nbsp;<br /><b>Adress-Änderungen gelten für:</b> <br /><br />';
		echo '<input type="radio" name="werziehtum" value="einer"';
		if ($werziehtum == 'einer' || $haushalt == 1)
			echo ' checked';
		echo ' /> Nur diese Person';

		if ($haushalt != 1) {
	
			echo '<br />';
		
			echo '<input type="radio" name="werziehtum" value="alle"';
			if ($werziehtum == 'alle' && $haushalt != 1)
				echo ' checked';
			echo ' /> Alle, die hier wohnen';
		}
	
		
		echo '<br /><br />';

	}


	echo '<select size="5" name="adresse_r">';
	$sql = 'SELECT * FROM ad_adressen, ad_plz, ad_orte, ad_laender WHERE plz_r=plz_id && ort_r=o_id && land_r=l_id ORDER BY plz, ortsname, strasse;';
	$erg = mysql_query($sql);

	while ($l = mysql_fetch_assoc($erg)) {
		echo '<option value="'.$l['ad_id'].'"';
		if (($person_loop['adresse_r'] == $l['ad_id']) || (empty($person_loop['adresse_r']) && $l['ad_id'] == 1))
			echo ' selected';

		echo '>'.$l['plz'].' '.$l['ortsname'].' - '.$l['strasse'].'</option>';
	} 
	echo '</select>';
	
echo '<br /><br />';

	echo '<br /><input type="checkbox" id="adresswahl" name="adresswahl" value="manuell"';
	if ($adresswahl == 'manuell')
		echo ' checked';

	echo ' onClick = "_switch(\'manuelle_eingabe\'); return true;"> Oder neue Adresse anlegen:';

	?>

	<div id="manuelle_eingabe" style="width: 600px; padding: 1px; border: 1px dotted gray; display: <?PHP if($adresswahl == 'manuell'){echo 'block';} else {echo 'none';}?>;">

	<table>
		
	<tr>
		<td>Strasse:</td>
		<td><?PHP echo '<input type="text" name="strasse" value="'.$person_loop['strasse'].'" size="30" maxlength="100" />'; ?></td>
	</tr>
	
	<tr>
		<td>PLZ, Ort, Land:</td>
		<td><?PHP show_select_plz('plz_r', $person_loop['plz_r']); show_select_ort('ort_r', $person_loop['ort_r']); show_select_land('land_r', $person_loop['land_r']); ?></td>
	</tr>
	
	<tr>
		<td></td>
		<td><?PHP echo '<input type="text" name="plz" value="'.$person_loop['plz'].'" size="5" maxlength="5" />';  echo '<input type="text" name="ort" value="'.$person_loop['ort'].'" size="25" maxlength="100" />'; echo '<input type="text" name="land" value="'.$person_loop['land'].'" size="30" maxlength="100" />'; ?></td>
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


	
	<br /><br />
		<h2>Teil 3/3 &ndash; Pers&ouml;nliche Kontaktdaten</h2>

	<form action="person_bearbeiten_speichern3.php" method="post">

	<table>
		<tr>
			<td>Email privat:</td>
			<td><?PHP echo '<input type="text" name="email_privat" value="'.$person_loop['email_privat'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Arbeit:</td>
			<td><?PHP echo '<input type="text" name="email_arbeit" value="'.$person_loop['email_arbeit'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Email Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="email_aux" value="'.$person_loop['email_aux'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 1:</td>
			<td>http://<?PHP echo '<input type="text" name="hp1" value="'.$person_loop['hp1'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Homepage 2:</td>
			<td>http://<?PHP echo '<input type="text" name="hp2" value="'.$person_loop['hp2'].'" size="30" maxlength="100" />'; ?></td>
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
			<td><?PHP echo '<input type="text" name="chat_aim" value="'.$person_loop['chat_aim'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat MSN:</td>
			<td><?PHP echo '<input type="text" name="chat_msn" value="'.$person_loop['chat_msn'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat ICQ:</td>
			<td><?PHP echo '#<input type="text" name="chat_icq" value="'.$person_loop['chat_icq'].'" size="9" maxlength="9" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Yahoo:</td>
			<td><?PHP echo '<input type="text" name="chat_yim" value="'.$person_loop['chat_yim'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Skype:</td>
			<td><?PHP echo '<input type="text" name="chat_skype" value="'.$person_loop['chat_skype'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr>
			<td>Chat Sonstiges:</td>
			<td><?PHP echo '<input type="text" name="chat_aux" value="'.$person_loop['chat_aux'].'" size="30" maxlength="100" />'; ?></td>
		</tr>
		<tr><td colspan="2">&nbsp; </td></tr>
		<tr>
			<td>Notizen:</td>
			<td><?PHP echo '<textarea name="pnotizen" rows="4" cols="30">'.$person_loop['pnotizen'].'</textarea>'; ?></td>
		</tr>
	</table>


	
	<br />

<br /><br />
	
<input class="rand" type="submit" name="knopf" value="Speichern" />
</form>


</body>
</html>
