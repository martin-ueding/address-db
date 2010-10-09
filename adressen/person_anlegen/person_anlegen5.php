<?PHP
session_start();

//include('../inc/varclean.inc.php');
include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');


// Speichern Gruppe 1
$_SESSION['anrede_r'] = $_POST['anrede_r'];
$_SESSION['prafix_r'] = $_POST['prafix_r'];
$_SESSION['vorname'] = $_POST['vorname'];
$_SESSION['mittelname'] = $_POST['mittelname'];
$_SESSION['nachname'] = $_POST['nachname'];
$_SESSION['suffix_r'] = $_POST['suffix_r'];
$_SESSION['geburtsname'] = $_POST['geburtsname'];

$_SESSION['geb_t'] = $_POST['geb_t'];
$_SESSION['geb_m'] = $_POST['geb_m'];
$_SESSION['geb_j'] = $_POST['geb_j'];

$_SESSION['fmgs'] = $_POST['fmgs'];
$_SESSION['gruppen'] = $_POST['gruppen'];




/* Wenn eine neue Gruppe eingetragen wurde, wird diese jetzt schon in die
 * Datenbank aufgenommen und steht danach als Haken bereit.
 */
 
if (!empty($_POST['neue_gruppe'])) {
	$sql = 'INSERT INTO ad_gruppen SET gruppe="'.$_POST['neue_gruppe'].'"';
	mysql_query($sql);
	$_SESSION['gruppen'][] = mysql_insert_id();
}

// Speichern Gruppe 2

$_SESSION['adresse_r'] = $_POST['adresse_r'];
$_SESSION['adresswahl'] = $_POST['adresswahl'];


$_SESSION['ftel_privat'] = $_POST['ftel_privat'];
$_SESSION['ftel_arbeit'] = $_POST['ftel_arbeit'];
$_SESSION['ftel_mobil'] = $_POST['ftel_mobil'];
$_SESSION['ftel_fax'] = $_POST['ftel_fax'];
$_SESSION['ftel_aux'] = $_POST['ftel_aux'];

$_SESSION['fvw_privat_eingabe'] = $_POST['fvw_privat_eingabe'];
$_SESSION['fvw_privat_id'] = $_POST['fvw_privat_id'];
$_SESSION['fvw_arbeit_eingabe'] = $_POST['fvw_arbeit_eingabe'];
$_SESSION['fvw_arbeit_id'] = $_POST['fvw_arbeit_id'];
$_SESSION['fvw_mobil_eingabe'] = $_POST['fvw_mobil_eingabe'];
$_SESSION['fvw_mobil_id'] = $_POST['fvw_mobil_id'];
$_SESSION['fvw_fax_eingabe'] = $_POST['fvw_fax_eingabe'];
$_SESSION['fvw_fax_id'] = $_POST['fvw_fax_id'];
$_SESSION['fvw_aux_eingabe'] = $_POST['fvw_aux_eingabe'];
$_SESSION['fvw_aux_id'] = $_POST['fvw_aux_id'];


$_SESSION['strasse'] = $_POST['strasse'];
$_SESSION['plz'] = $_POST['plz'];
$_SESSION['ort'] = $_POST['ort'];
$_SESSION['land'] = $_POST['land'];

$_SESSION['plz_r'] = $_POST['plz_r'];
$_SESSION['ort_r'] = $_POST['ort_r'];
$_SESSION['land_r'] = $_POST['land_r'];

// Speichern Gruppe 3

$_SESSION['tel_privat'] = $_POST['tel_privat'];
$_SESSION['tel_arbeit'] = $_POST['tel_arbeit'];
$_SESSION['tel_mobil'] = $_POST['tel_mobil'];
$_SESSION['tel_fax'] = $_POST['tel_fax'];
$_SESSION['tel_aux'] = $_POST['tel_aux'];

$_SESSION['vw_privat_eingabe'] = $_POST['vw_privat_eingabe'];
$_SESSION['vw_privat_id'] = $_POST['vw_privat_id'];
$_SESSION['vw_arbeit_eingabe'] = $_POST['vw_arbeit_eingabe'];
$_SESSION['vw_arbeit_id'] = $_POST['vw_arbeit_id'];
$_SESSION['vw_mobil_eingabe'] = $_POST['vw_mobil_eingabe'];
$_SESSION['vw_mobil_id'] = $_POST['vw_mobil_id'];
$_SESSION['vw_fax_eingabe'] = $_POST['vw_fax_eingabe'];
$_SESSION['vw_fax_id'] = $_POST['vw_fax_id'];
$_SESSION['vw_aux_eingabe'] = $_POST['vw_aux_eingabe'];
$_SESSION['vw_aux_id'] = $_POST['vw_aux_id'];


$_SESSION['email_privat'] = $_POST['email_privat'];
$_SESSION['email_arbeit'] = $_POST['email_arbeit'];
$_SESSION['email_aux'] = $_POST['email_aux'];

$_SESSION['hp1'] = $_POST['hp1'];
$_SESSION['hp2'] = $_POST['hp2'];

$_SESSION['chat_aim'] = $_POST['chat_aim'];
$_SESSION['chat_msn'] = $_POST['chat_msn'];
$_SESSION['chat_icq'] = $_POST['chat_icq'];
$_SESSION['chat_yim'] = $_POST['chat_yim'];
$_SESSION['chat_skype'] = $_POST['chat_skype'];
$_SESSION['chat_aux'] = $_POST['chat_aux'];


$_SESSION['pnotizen'] = $_POST['pnotizen'];



$sql = 'INSERT INTO ad_per SET';

/* Name und Geburtstag */

$sql .= ' anrede_r='.$_SESSION['anrede_r'];
$sql .= ', prafix_r='.$_SESSION['prafix_r'];
$sql .= ', vorname="'.$_SESSION['vorname'].'"';
$sql .= ', mittelname="'.$_SESSION['mittelname'].'"';
$sql .= ', nachname="'.$_SESSION['nachname'].'"';
$sql .= ', suffix_r='.$_SESSION['suffix_r'];
$sql .= ', geburtsname="'.$_SESSION['geburtsname'].'"';

$sql .= ', geb_t='.$_SESSION['geb_t'];
$sql .= ', geb_m='.$_SESSION['geb_m'];
$sql .= ', geb_j='.$_SESSION['geb_j'];




/* Adresse */

if ($_SESSION['adresswahl'] == 'manuell') {
	$sql_ad = 'INSERT INTO ad_adressen SET';
	$sql_ad .= ' strasse="'.$_SESSION['strasse'].'"';


	/* PLZ */
	if (!empty($_SESSION['plz'])) {
		$erg = select_plzid_plz($_SESSION['plz']);
	
		if (mysql_num_rows($erg) == 0)
			$plz_id = insert_plz($_SESSION['plz']);
	
		else if ($l = mysql_fetch_assoc($erg))
			$plz_id = $l['plz_id'];
	
		$sql_ad .= ', plz_r='.$plz_id;
	}
	else
		$sql_ad .= ', plz_r='.$_SESSION['plz_r'];


	/* Ort */
	if (!empty($_SESSION['ort'])) {
		$erg = select_ortid_ort($_SESSION['ort']);
	
		if (mysql_num_rows($erg) == 0)
			$ort_id = insert_ort($_SESSION['ort']);
	
		else if ($l = mysql_fetch_assoc($erg))
			$ort_id = $l['o_id'];
	
		$sql_ad .= ', ort_r='.$ort_id;
	}
	else
		$sql_ad .=', ort_r='.$_SESSION['ort_r'];



	/* Land */
	if (!empty($_SESSION['land'])) {
		$erg = select_landid_land($_SESSION['land']);
	
		if (mysql_num_rows($erg) == 0)
			$land_id = insert_land($_SESSION['land']);
	
	
		else if ($l = mysql_fetch_assoc($erg))
			$land_id = $l['l_id'];
		
		$sql_ad .= ', land_r='.$land_id.'';
	}
	else
		$sql_ad .= ', land_r='.$_SESSION['land_r'];


	$sql_ad .= ', ftel_privat="'.$_SESSION['ftel_privat'].'"';
	$sql_ad .= ', ftel_arbeit="'.$_SESSION['ftel_arbeit'].'"';
	$sql_ad .= ', ftel_mobil="'.$_SESSION['ftel_mobil'].'"';
	$sql_ad .= ', ftel_fax="'.$_SESSION['ftel_fax'].'"';
	$sql_ad .= ', ftel_aux="'.$_SESSION['ftel_aux'].'"';

	$sql_ad .= ', fvw_privat_r='.get_vwid($_SESSION['fvw_privat_eingabe'], $_SESSION['fvw_privat_id']);
	$sql_ad .= ', fvw_arbeit_r='.get_vwid($_SESSION['fvw_arbeit_eingabe'], $_SESSION['fvw_arbeit_id']);
	$sql_ad .= ', fvw_mobil_r='.get_vwid($_SESSION['fvw_mobil_eingabe'], $_SESSION['fvw_mobil_id']);
	$sql_ad .= ', fvw_fax_r='.get_vwid($_SESSION['fvw_fax_eingabe'], $_SESSION['fvw_fax_id']);
	$sql_ad .= ', fvw_aux_r='.get_vwid($_SESSION['fvw_aux_eingabe'], $_SESSION['fvw_aux_id']);
	

	mysql_query($sql_ad);
	$sql .= ', adresse_r='.mysql_insert_id();
	
}
else {
	$sql .= ', adresse_r='.$_SESSION['adresse_r'];
}


/* Schritt 3 */

$sql .= ', tel_privat="'.$_SESSION['tel_privat'].'"';
$sql .= ', tel_arbeit="'.$_SESSION['tel_arbeit'].'"';
$sql .= ', tel_mobil="'.$_SESSION['tel_mobil'].'"';
$sql .= ', tel_fax="'.$_SESSION['tel_fax'].'"';
$sql .= ', tel_aux="'.$_SESSION['tel_aux'].'"';

$sql .= ', vw_privat_r='.get_vwid($_SESSION['vw_privat_eingabe'], $_SESSION['vw_privat_id']);
$sql .= ', vw_arbeit_r='.get_vwid($_SESSION['vw_arbeit_eingabe'], $_SESSION['vw_arbeit_id']);
$sql .= ', vw_mobil_r='.get_vwid($_SESSION['vw_mobil_eingabe'], $_SESSION['vw_mobil_id']);
$sql .= ', vw_fax_r='.get_vwid($_SESSION['vw_fax_eingabe'], $_SESSION['vw_fax_id']);
$sql .= ', vw_aux_r='.get_vwid($_SESSION['vw_aux_eingabe'], $_SESSION['vw_aux_id']);


if (!empty($_SESSION['email_privat'])) $sql .= ', email_privat="'.$_SESSION['email_privat'].'"';
if (!empty($_SESSION['email_arbeit'])) $sql .= ', email_arbeit="'.$_SESSION['email_arbeit'].'"';
if (!empty($_SESSION['email_aux'])) $sql .= ', email_aux="'.$_SESSION['email_aux'].'"';
if (!empty($_SESSION['hp1'])) $sql .= ', hp1="'.$_SESSION['hp1'].'"';
if (!empty($_SESSION['hp2'])) $sql .= ', hp2="'.$_SESSION['hp2'].'"';
if (!empty($_SESSION['chat_aim'])) $sql .= ', chat_aim="'.$_SESSION['chat_aim'].'"';
if (!empty($_SESSION['chat_msn'])) $sql .= ', chat_msn="'.$_SESSION['chat_msn'].'"';
if (!empty($_SESSION['chat_icq'])) $sql .= ', chat_icq="'.$_SESSION['chat_icq'].'"';
if (!empty($_SESSION['chat_yim'])) $sql .= ', chat_yim="'.$_SESSION['chat_yim'].'"';
if (!empty($_SESSION['chat_skype'])) $sql .= ', chat_skype="'.$_SESSION['chat_skype'].'"';
if (!empty($_SESSION['chat_aux'])) $sql .= ', chat_aux="'.$_SESSION['chat_aux'].'"';
if (!empty($_SESSION['pnotizen'])) $sql .= ', pnotizen="'.$_SESSION['pnotizen'].'"';

$sql .= ';';

mysql_query($sql);
if (mysql_error() != '') {
	echo 'MySQL-Error: '.mysql_error();
	echo '<br /><br />SQL-Befehl:'.$sql;
}

$p_id = mysql_insert_id();



/* FMG-Bez&uuml;ge */
$sql = 'DELETE FROM ad_flinks WHERE person_lr='.$p_id.';';
mysql_query($sql);

if (!empty($_SESSION['fmgs'])) {
	foreach ($_SESSION['fmgs'] as $wert) {
		$sql = 'INSERT INTO ad_flinks SET person_lr='.$p_id.', fmg_lr='.$wert.';';
		mysql_query($sql);
		echo mysql_error();
	}
}


/* Gruppen */
$sql = 'DELETE FROM ad_glinks WHERE person_lr='.$p_id.';';
mysql_query($sql);

if (!empty($_SESSION['gruppen'])) {
	foreach ($_SESSION['gruppen'] as $wert) {
		$sql = 'INSERT INTO ad_glinks SET person_lr='.$p_id.', gruppe_lr='.$wert.';';
		mysql_query($sql);
	}
}

session_destroy();

header('location:../personenanzeige.php?id='.$p_id);
?>