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
		<title>Person anlegen 2/4</title>

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
	
<table id="schritte">
<tr>
<td class="normal">1/4</td>
<td class="aktiv">2/4</td>
<td class="normal">3/4</td>
<td class="normal">4/4</td>
</tr>
</table>


<form action="person_bearbeiten_speichern2.php" method="post">

<?PHP
	if (adresse_mehrfach_benutzt($_SESSION['adresse_r'])) {
		echo '&nbsp;<br /><b>Adress-Änderungen gelten für:</b> <br /><br />';
		echo '<input type="radio" name="werziehtum" value="einer"';
		if ($_SESSION['werziehtum'] == 'einer' || $_SESSION['haushalt'] == 1)
			echo ' checked';
		echo ' /> Nur diese Person';

		if ($_SESSION['haushalt'] != 1) {
	
			echo '<br />';
		
			echo '<input type="radio" name="werziehtum" value="alle"';
			if ($_SESSION['werziehtum'] == 'alle' && $_SESSION['haushalt'] != 1)
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


	
	<br /><br />
	<input class="rand" type="submit" name="knopf" value="Zur&uuml;ck" />
	<input class="rand" type="submit" name="knopf" value="Weiter" />
		
	</form>
	
	</body>
</html>