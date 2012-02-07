<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

include('_config.inc.php');
include('inc/abfragen.inc.php');

// Speichern Gruppe 1
$anrede_r = $_POST['anrede_r'];
$prafix_r = $_POST['prafix_r'];
$vorname = $_POST['vorname'];
$mittelname = $_POST['mittelname'];
$nachname = $_POST['nachname'];
$suffix_r = $_POST['suffix_r'];
$geburtsname = $_POST['geburtsname'];

$geb_t = $_POST['geb_t'];
$geb_m = $_POST['geb_m'];
$geb_j = $_POST['geb_j'];

$fmgs = $_POST['fmgs'];
$gruppen = $_POST['gruppen'];
$haushalt = 1;



/* Wenn eine neue Gruppe eingetragen wurde, wird diese jetzt schon in die
 * Datenbank aufgenommen und steht danach als Haken bereit.
 */
 
if (!empty($_POST['neue_gruppe'])) {
	$sql = 'INSERT INTO ad_gruppen SET gruppe="'.$_POST['neue_gruppe'].'"';
	mysql_query($sql);
	echo mysql_error();
	$gruppen[] = mysql_insert_id();
}

// Speichern Gruppe 2

$adresse_r = $_POST['adresse_r'];
$adresswahl = $_POST['adresswahl'];


$ftel_privat = $_POST['ftel_privat'];
$ftel_arbeit = $_POST['ftel_arbeit'];
$ftel_mobil = $_POST['ftel_mobil'];
$ftel_fax = $_POST['ftel_fax'];
$ftel_aux = $_POST['ftel_aux'];

$fvw_privat_eingabe = $_POST['fvw_privat_eingabe'];
$fvw_privat_id = $_POST['fvw_privat_id'];
$fvw_arbeit_eingabe = $_POST['fvw_arbeit_eingabe'];
$fvw_arbeit_id = $_POST['fvw_arbeit_id'];
$fvw_mobil_eingabe = $_POST['fvw_mobil_eingabe'];
$fvw_mobil_id = $_POST['fvw_mobil_id'];
$fvw_fax_eingabe = $_POST['fvw_fax_eingabe'];
$fvw_fax_id = $_POST['fvw_fax_id'];
$fvw_aux_eingabe = $_POST['fvw_aux_eingabe'];
$fvw_aux_id = $_POST['fvw_aux_id'];


$strasse = $_POST['strasse'];
$plz = $_POST['plz'];
$ort = $_POST['ort'];
$land = $_POST['land'];

$plz_r = $_POST['plz_r'];
$ort_r = $_POST['ort_r'];
$land_r = $_POST['land_r'];

// Speichern Gruppe 3

$tel_privat = $_POST['tel_privat'];
$tel_arbeit = $_POST['tel_arbeit'];
$tel_mobil = $_POST['tel_mobil'];
$tel_fax = $_POST['tel_fax'];
$tel_aux = $_POST['tel_aux'];

$vw_privat_eingabe = $_POST['vw_privat_eingabe'];
$vw_privat_id = $_POST['vw_privat_id'];
$vw_arbeit_eingabe = $_POST['vw_arbeit_eingabe'];
$vw_arbeit_id = $_POST['vw_arbeit_id'];
$vw_mobil_eingabe = $_POST['vw_mobil_eingabe'];
$vw_mobil_id = $_POST['vw_mobil_id'];
$vw_fax_eingabe = $_POST['vw_fax_eingabe'];
$vw_fax_id = $_POST['vw_fax_id'];
$vw_aux_eingabe = $_POST['vw_aux_eingabe'];
$vw_aux_id = $_POST['vw_aux_id'];


$email_privat = $_POST['email_privat'];
$email_arbeit = $_POST['email_arbeit'];
$email_aux = $_POST['email_aux'];

$hp1 = $_POST['hp1'];
$hp2 = $_POST['hp2'];

$chat_aim = $_POST['chat_aim'];
$chat_msn = $_POST['chat_msn'];
$chat_icq = $_POST['chat_icq'];
$chat_yim = $_POST['chat_yim'];
$chat_skype = $_POST['chat_skype'];
$chat_aux = $_POST['chat_aux'];


$pnotizen = $_POST['pnotizen'];



$sql = 'INSERT INTO ad_per SET';

/* Name und Geburtstag */

$sql .= ' anrede_r='.$anrede_r;
$sql .= ', prafix_r='.$prafix_r;
$sql .= ', vorname="'.$vorname.'"';
$sql .= ', mittelname="'.$mittelname.'"';
$sql .= ', nachname="'.$nachname.'"';
$sql .= ', suffix_r='.$suffix_r;
$sql .= ', geburtsname="'.$geburtsname.'"';

$sql .= ', geb_t='.$geb_t;
$sql .= ', geb_m='.$geb_m;
$sql .= ', geb_j='.$geb_j;




/* Adresse */

if ($adresswahl == 'manuell') {
	$sql_ad = 'INSERT INTO ad_adressen SET';
	$sql_ad .= ' strasse="'.$strasse.'"';


	/* PLZ */
	if (!empty($plz)) {
		$erg = Queries::select_plzid_plz($plz);
	
		if (mysql_num_rows($erg) == 0)
			$plz_id = Queries::insert_plz($plz);
	
		else if ($l = mysql_fetch_assoc($erg))
			$plz_id = $l['plz_id'];
	
		$sql_ad .= ', plz_r='.$plz_id;
	}
	else
		$sql_ad .= ', plz_r='.$plz_r;


	/* Ort */
	if (!empty($ort)) {
		$erg = Queries::select_ortid_ort($ort);
	
		if (mysql_num_rows($erg) == 0)
			$ort_id = Queries::insert_ort($ort);
	
		else if ($l = mysql_fetch_assoc($erg))
			$ort_id = $l['o_id'];
	
		$sql_ad .= ', ort_r='.$ort_id;
	}
	else
		$sql_ad .=', ort_r='.$ort_r;



	/* Land */
	if (!empty($land)) {
		$erg = Queries::select_landid_land($land);
	
		if (mysql_num_rows($erg) == 0)
			$land_id = Queries::insert_land($land);
	
	
		else if ($l = mysql_fetch_assoc($erg))
			$land_id = $l['l_id'];
		
		$sql_ad .= ', land_r='.$land_id.'';
	}
	else
		$sql_ad .= ', land_r='.$land_r;


	$sql_ad .= ', ftel_privat="'.$ftel_privat.'"';
	$sql_ad .= ', ftel_arbeit="'.$ftel_arbeit.'"';
	$sql_ad .= ', ftel_mobil="'.$ftel_mobil.'"';
	$sql_ad .= ', ftel_fax="'.$ftel_fax.'"';
	$sql_ad .= ', ftel_aux="'.$ftel_aux.'"';

	$sql_ad .= ', fvw_privat_r='.Queries::get_vwid($fvw_privat_eingabe, $fvw_privat_id);
	$sql_ad .= ', fvw_arbeit_r='.Queries::get_vwid($fvw_arbeit_eingabe, $fvw_arbeit_id);
	$sql_ad .= ', fvw_mobil_r='.Queries::get_vwid($fvw_mobil_eingabe, $fvw_mobil_id);
	$sql_ad .= ', fvw_fax_r='.Queries::get_vwid($fvw_fax_eingabe, $fvw_fax_id);
	$sql_ad .= ', fvw_aux_r='.Queries::get_vwid($fvw_aux_eingabe, $fvw_aux_id);
	

	mysql_query($sql_ad);
	echo mysql_error();
	$sql .= ', adresse_r='.mysql_insert_id();
	
}
else if ($adresse_r != 0) {
	$sql .= ', adresse_r='.$adresse_r;
}


/* Schritt 3 */

$sql .= ', tel_privat="'.$tel_privat.'"';
$sql .= ', tel_arbeit="'.$tel_arbeit.'"';
$sql .= ', tel_mobil="'.$tel_mobil.'"';
$sql .= ', tel_fax="'.$tel_fax.'"';
$sql .= ', tel_aux="'.$tel_aux.'"';

$sql .= ', vw_privat_r='.Queries::get_vwid($vw_privat_eingabe, $vw_privat_id);
$sql .= ', vw_arbeit_r='.Queries::get_vwid($vw_arbeit_eingabe, $vw_arbeit_id);
$sql .= ', vw_mobil_r='.Queries::get_vwid($vw_mobil_eingabe, $vw_mobil_id);
$sql .= ', vw_fax_r='.Queries::get_vwid($vw_fax_eingabe, $vw_fax_id);
$sql .= ', vw_aux_r='.Queries::get_vwid($vw_aux_eingabe, $vw_aux_id);


if (!empty($email_privat)) $sql .= ', email_privat="'.$email_privat.'"';
if (!empty($email_arbeit)) $sql .= ', email_arbeit="'.$email_arbeit.'"';
if (!empty($email_aux)) $sql .= ', email_aux="'.$email_aux.'"';
if (!empty($hp1)) $sql .= ', hp1="'.$hp1.'"';
if (!empty($hp2)) $sql .= ', hp2="'.$hp2.'"';
if (!empty($chat_aim)) $sql .= ', chat_aim="'.$chat_aim.'"';
if (!empty($chat_msn)) $sql .= ', chat_msn="'.$chat_msn.'"';
if (!empty($chat_icq)) $sql .= ', chat_icq="'.$chat_icq.'"';
if (!empty($chat_yim)) $sql .= ', chat_yim="'.$chat_yim.'"';
if (!empty($chat_skype)) $sql .= ', chat_skype="'.$chat_skype.'"';
if (!empty($chat_aux)) $sql .= ', chat_aux="'.$chat_aux.'"';
if (!empty($pnotizen)) $sql .= ', pnotizen="'.$pnotizen.'"';

$sql .= ', last_edit='.time();

$sql .= ';';

mysql_query($sql);
if (mysql_error() != '') {
	echo 'MySQL-Error: '.mysql_error();
	echo '<br /><br />SQL-Befehl: '.$sql;
}

$p_id = mysql_insert_id();



/* FMG-Bez&uuml;ge */
$sql = 'DELETE FROM ad_flinks WHERE person_lr='.$p_id.';';
mysql_query($sql);

if (!empty($fmgs)) {
	foreach ($fmgs as $wert) {
		$sql = 'INSERT INTO ad_flinks SET person_lr='.$p_id.', fmg_lr='.$wert.';';
		mysql_query($sql);
		echo mysql_error();
	}
}


/* Gruppen */
$sql = 'DELETE FROM ad_glinks WHERE person_lr='.$p_id.';';
mysql_query($sql);

if (!empty($gruppen)) {
	foreach ($gruppen as $wert) {
		$sql = 'INSERT INTO ad_glinks SET person_lr='.$p_id.', gruppe_lr='.$wert.';';
		mysql_query($sql);
	}
}

header('location:index.php?mode=person_display&id='.$p_id);
?>
