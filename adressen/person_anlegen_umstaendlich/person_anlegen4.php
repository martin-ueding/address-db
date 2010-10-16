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
		<title>Person anlegen 4/4</title>

<link rel="STYLESHEET" type="text/css" href="../css/main.css">
</head>
	<body class="maske">

<table id="schritte">
<tr>
<td class="normal">1/4</td>
<td class="normal">2/4</td>
<td class="normal">3/4</td>
<td class="aktiv">4/4</td>
</tr>
</table>

	<h2>Schritt 4/4 - Kontrolle</h2>

<table>
<tr><th colspan="2">1. Name und Bez&uuml;ge</th></tr>
<?PHP

	echo '<tr>';
	echo '<td>Name:</td>';
	echo '<td>';

	if ($_SESSION['anrede_r'] != 1)
		echo select_string_anrede($_SESSION['anrede_r']).' ';
	if ($_SESSION['prafix_r'] != 1)
		echo select_string_prafix($_SESSION['prafix_r']).' ';

	echo $_SESSION['vorname'];
	
	if (!empty($_SESSION['mittelname']))
		echo ' '.$_SESSION['mittelname'];

	echo ' '.$_SESSION['nachname'];
	
	if ($_SESSION['suffix_r'] != 1)
		echo ' '.select_string_suffix($_SESSION['suffix_r']);

	echo '</td>';
	echo '</tr>';


	if (!empty($_SESSION['geburtsname'])) {	
		echo '<tr>';
		echo '<td>Geburtsname:</td>';
		echo '<td>'.$_SESSION['geburtsname'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['geb_t'])) {	
		echo '<tr>';
		echo '<td>Geburtstag:</td>';
		echo '<td>'.$_SESSION['geb_t'].'.'.$_SESSION['geb_m'].'.'.$_SESSION['geb_j'].'</td>';
		echo '</tr>';
	}

	echo '</table>';
	echo '<a href="person_anlegen1.php">&laquo; Diese Daten bearbeiten</a><br>&nbsp;';

	if ($_SESSION['adresswahl'] == 'manuell') {
		echo '<table>';
		echo '<tr><th colspan="2">2. Adresse</th></tr>';

		if (!empty($_SESSION['strasse'])) {	
			echo '<tr>';
			echo '<td>Strasse:</td>';
			echo '<td>'.$_SESSION['strasse'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['plz']) or !empty($_SESSION['ort'])) {
			echo '<tr>';
			echo '<td>PLZ, Ort:</td>';
			echo '<td>'.$_SESSION['plz'].', '.$_SESSION['ort'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['land'])) {	
			echo '<tr>';
			echo '<td>Land:</td>';
			echo '<td>'.$_SESSION['land'].'</td>';
			echo '</tr>';
		}

		echo '<tr><td colspan="2">&nbsp;</td></tr>';
	
		if (!empty($_SESSION['ftel_privat'])) {		
			echo '<tr>';
			echo '<td>Familientelefon Privat:</td>';
			echo '<td>';
			if (!empty($_SESSION['fvw_privat_eingabe'])) {
				$fvw_privat = $_SESSION['fvw_privat_eingabe'];
			}
			else {
				$fvw_privat = select_vw_id($_SESSION['fvw_privat_id']);
			}
	
			echo $fvw_privat.'-'.$_SESSION['ftel_privat'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['ftel_arbeit'])) {	
			echo '<tr>';
			echo '<td>Familientelefon Arbeit:</td>';
			echo '<td>';
			if (!empty($_SESSION['fvw_arbeit_eingabe'])) {
				$fvw_arbeit = $_SESSION['fvw_arbeit_eingabe'];
			}
			else {
				$fvw_arbeit = select_vw_id($_SESSION['fvw_arbeit_id']);
			}
	
			echo $fvw_arbeit.'-'.$_SESSION['ftel_arbeit'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['ftel_mobil'])) {	
			echo '<tr>';
			echo '<td>Familien-Handy:</td>';
			echo '<td>';
			if (!empty($_SESSION['fvw_mobil_eingabe'])) {
				$fvw_mobil = $_SESSION['fvw_mobil_eingabe'];
			}
			else {
				$fvw_mobil = select_vw_id($_SESSION['fvw_mobil_id']);
			}
	
			echo $fvw_mobil.'-'.$_SESSION['ftel_mobil'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['ftel_fax'])) {		
			echo '<tr>';
			echo '<td>Familien-Fax:</td>';
			echo '<td>';
			if (!empty($_SESSION['fvw_fax_eingabe'])) {
				$fvw_fax = $_SESSION['fvw_fax_eingabe'];
			}
			else {
				$fvw_fax = select_vw_id($_SESSION['fvw_fax_id']);
			}
	
			echo $fvw_fax.'-'.$_SESSION['ftel_fax'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($_SESSION['ftel_aux'])) {	
			echo '<tr>';
			echo '<td>Familientelefon Sonstiges:</td>';
			echo '<td>';
			if (!empty($_SESSION['fvw_aux_eingabe'])) {
				$fvw_aux = $_SESSION['fvw_aux_eingabe'];
			}
			else {
				$fvw_aux = select_vw_id($_SESSION['fvw_aux_id']);
			}
	
			echo $fvw_aux.'-'.$_SESSION['ftel_aux'].'</td>';
			echo '</tr>';
		}
	}
	else if (!empty($_SESSION['adresse_r'])) {
		$sql = 'SELECT * FROM ad_adressen, ad_plz, ad_orte, ad_laender WHERE plz_r=plz_id && ort_r=o_id && land_r=l_id && ad_id='.$_SESSION['adresse_r'].' ORDER BY plz, ortsname, strasse;';
		$erg = mysql_query($sql);

		$l = mysql_fetch_assoc($erg);
		echo $l['plz'].' '.$l['ortsname'].' - '.$l['strasse'];
	}

	echo '<table>';

	echo '</table>';
	echo '<a href="person_anlegen2.php">&laquo; Diese Daten bearbeiten</a><br>&nbsp;';

	echo '<table>';
	echo '<tr><th colspan="2">3. Pers&ouml;nliche Kontaktdaten</th></tr>';

	if (!empty($_SESSION['tel_privat'])) {		
		echo '<tr>';
		echo '<td>Telefon Privat:</td>';
		echo '<td>';
		if (!empty($_SESSION['vw_privat_eingabe'])) {
			$vw_privat = $_SESSION['vw_privat_eingabe'];
		}
		else {
			$vw_privat = select_vw_id($_SESSION['vw_privat_id']);
		}

		echo $vw_privat.'-'.$_SESSION['tel_privat'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($_SESSION['tel_arbeit'])) {	
		echo '<tr>';
		echo '<td>Telefon Arbeit:</td>';
		echo '<td>';
		if (!empty($_SESSION['vw_arbeit_eingabe'])) {
			$vw_arbeit = $_SESSION['vw_arbeit_eingabe'];
		}
		else {
			$vw_arbeit = select_vw_id($_SESSION['vw_arbeit_id']);
		}

		echo $vw_arbeit.'-'.$_SESSION['tel_arbeit'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($_SESSION['tel_mobil'])) {	
		echo '<tr>';
		echo '<td>Handy:</td>';
		echo '<td>';
		if (!empty($_SESSION['vw_mobil_eingabe'])) {
			$vw_mobil = $_SESSION['vw_mobil_eingabe'];
		}
		else {
			$vw_mobil = select_vw_id($_SESSION['vw_mobil_id']);
		}

		echo $vw_mobil.'-'.$_SESSION['tel_mobil'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($_SESSION['tel_fax'])) {		
		echo '<tr>';
		echo '<td>Fax:</td>';
		echo '<td>';
		if (!empty($_SESSION['vw_fax_eingabe'])) {
			$vw_fax = $_SESSION['vw_fax_eingabe'];
		}
		else {
			$vw_fax = select_vw_id($_SESSION['vw_fax_id']);
		}

		echo $vw_fax.'-'.$_SESSION['tel_fax'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($_SESSION['tel_aux'])) {	
		echo '<tr>';
		echo '<td>Telefon Sonstiges:</td>';
		echo '<td>';
		if (!empty($_SESSION['vw_aux_eingabe'])) {
			$vw_aux = $_SESSION['vw_aux_eingabe'];
		}
		else {
			$vw_aux = select_vw_id($_SESSION['vw_aux_id']);
		}

		echo $vw_aux.'-'.$_SESSION['tel_aux'].'</td>';
		echo '</tr>';
	}

	


	if (!empty($_SESSION['email_privat'])) {	
		echo '<tr>';
		echo '<td>Email Privat:</td>';
		echo '<td>'.$_SESSION['email_privat'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['email_arbeit'])) {	
		echo '<tr>';
		echo '<td>Email Arbeit:</td>';
		echo '<td>'.$_SESSION['email_arbeit'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['email_aux'])) {	
		echo '<tr>';
		echo '<td>Email Sonstiges:</td>';
		echo '<td>'.$_SESSION['email_aux'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['hp1'])) {	
		echo '<tr>';
		echo '<td>Homepage 1:</td>';
		echo '<td>http://'.$_SESSION['hp1'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['hp2'])) {	
		echo '<tr>';
		echo '<td>Homepage 2:</td>';
		echo '<td>http://'.$_SESSION['hp2'].'</td>';
		echo '</tr>';
	}

	

	if (!empty($_SESSION['chat_aim'])) {	
		echo '<tr>';
		echo '<td>Chat AIM:</td>';
		echo '<td>'.$_SESSION['chat_aim'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['chat_msn'])) {	
		echo '<tr>';
		echo '<td>Chat MSN:</td>';
		echo '<td>'.$_SESSION['chat_msn'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['chat_icq'])) {	
		echo '<tr>';
		echo '<td>Chat ICQ:</td>';
		echo '<td>#'.$_SESSION['chat_icq'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['chat_yim'])) {	
		echo '<tr>';
		echo '<td>Chat Yahoo:</td>';
		echo '<td>'.$_SESSION['chat_yim'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['chat_skype'])) {	
		echo '<tr>';
		echo '<td>Chat Skype:</td>';
		echo '<td>'.$_SESSION['chat_skype'].'</td>';
		echo '</tr>';
	}

	if (!empty($_SESSION['chat_aux'])) {	
		echo '<tr>';
		echo '<td>Chat Aux:</td>';
		echo '<td>'.$_SESSION['chat_aux'].'</td>';
		echo '</tr>';
	}

			echo '<tr><td colspan="2">&nbsp;</td></tr>';
	
	
	


	if (!empty($_SESSION['pnotizen'])) {	
		echo '<tr>';
		echo '<td>Notizen:</td>';
		echo '<td>'.$_SESSION['pnotizen'].'</td>';
		echo '</tr>';
	}
	

	

	
	?>

	
			
	</table>


		
	<a href="person_anlegen3.php">&laquo; Diese Daten bearbeiten</a>

	<br /><br />

	<form action="person_anlegen5.php"><input class="rand" type="submit" value="Speichern" /></form>


	</body>
</html>