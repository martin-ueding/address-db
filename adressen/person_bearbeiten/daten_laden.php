<?PHP
session_start();


$_SESSION['p_id'] = (int)($_GET['id']);


include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');

$erg = select_fmg_zu_person ($_SESSION['p_id']);
while ($l = mysql_fetch_assoc($erg))
	$_SESSION['fmgs'][] = $l['fmg_id'];

$erg = select_gruppen_zu_person ($_SESSION['p_id']);
while ($l = mysql_fetch_assoc($erg))
	$_SESSION['gruppen'][] = $l['g_id'];

$erg = select_person_alles($_SESSION['p_id']);

if (mysql_num_rows($erg) != 1)
	header('location:../index.php');

$l = mysql_fetch_assoc($erg);


$_SESSION['anrede_r'] = $l['anrede_r'];
$_SESSION['prafix_r'] = $l['prafix_r'];
$_SESSION['vorname'] = $l['vorname'];
$_SESSION['mittelname'] = $l['mittelname'];
$_SESSION['nachname'] = $l['nachname'];
$_SESSION['suffix_r'] = $l['suffix_r'];
$_SESSION['geburtsname'] = $l['geburtsname'];

$_SESSION['geb_t'] = $l['geb_t'];
$_SESSION['geb_m'] = $l['geb_m'];
$_SESSION['geb_j'] = $l['geb_j'];

$_SESSION['adresse_r'] = $l['adresse_r'];
$_SESSION['haushalt'] = $l['adresse_r']; // Wenn alle Adressen ge&auml;ndert werden, ist das das Original

$_SESSION['strasse'] = $l['strasse'];
//$_SESSION['plz'] = $l['plz'];
//$_SESSION['ort'] = $l['ort'];
//$_SESSION['land'] = $l['land'];

$_SESSION['plz_r'] = $l['plz_r'];
$_SESSION['ort_r'] = $l['ort_r'];
$_SESSION['land_r'] = $l['land_r'];


$_SESSION['ftel_privat'] = $l['ftel_privat'];
$_SESSION['ftel_arbeit'] = $l['ftel_arbeit'];
$_SESSION['ftel_mobil'] = $l['ftel_mobil'];
$_SESSION['ftel_fax'] = $l['ftel_fax'];
$_SESSION['ftel_aux'] = $l['ftel_aux'];

$_SESSION['fvw_privat_id'] = $l['fvw_privat_r'];
$_SESSION['fvw_arbeit_id'] = $l['fvw_arbeit_r'];
$_SESSION['fvw_mobil_id'] = $l['fvw_mobil_r'];
$_SESSION['fvw_fax_id'] = $l['fvw_fax_r'];
$_SESSION['fvw_aux_id'] = $l['fvw_aux_r'];

$_SESSION['tel_privat'] = $l['tel_privat'];
$_SESSION['tel_arbeit'] = $l['tel_arbeit'];
$_SESSION['tel_mobil'] = $l['tel_mobil'];
$_SESSION['tel_fax'] = $l['tel_fax'];
$_SESSION['tel_aux'] = $l['tel_aux'];

$_SESSION['vw_privat_id'] = $l['vw_privat_r'];
$_SESSION['vw_arbeit_id'] = $l['vw_arbeit_r'];
$_SESSION['vw_mobil_id'] = $l['vw_mobil_r'];
$_SESSION['vw_fax_id'] = $l['vw_fax_r'];
$_SESSION['vw_aux_id'] = $l['vw_aux_r'];


$_SESSION['email_privat'] = $l['email_privat'];
$_SESSION['email_arbeit'] = $l['email_arbeit'];
$_SESSION['email_aux'] = $l['email_aux'];

$_SESSION['hp1'] = $l['hp1'];
$_SESSION['hp2'] = $l['hp2'];

$_SESSION['chat_aim'] = $l['chat_aim'];
$_SESSION['chat_msn'] = $l['chat_msn'];
$_SESSION['chat_icq'] = $l['chat_icq'];
$_SESSION['chat_yim'] = $l['chat_yim'];
$_SESSION['chat_skype'] = $l['chat_skype'];
$_SESSION['chat_aux'] = $l['chat_aux'];

$_SESSION['pnotizen'] = $l['pnotizen'];


$_SESSION['werziehtum'] = 'alle';

header('location:person_bearbeiten1.php');
?>