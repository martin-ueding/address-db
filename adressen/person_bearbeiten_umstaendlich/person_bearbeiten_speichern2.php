<?PHP
session_start();

include('../inc/varclean.inc.php');
include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');
include('../inc/select.inc.php');

/* Die Variablen vom Schritt 1 (Name und Bezug) werden jetzt in die Session
 * gespeichert, damit sie f&uuml;r den weiteren Vorgang immer verf&uuml;gbar
 * sind.
 */

$_SESSION['adresse_r'] = $_POST['adresse_r'];
$_SESSION['adresswahl'] = $_POST['adresswahl'];
$_SESSION['werziehtum'] = $_POST['werziehtum'];
if (empty($_SESSION['werziehtum']))
	$_SESSION['werziehtum'] = 'alle';


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



/* Jetzt kommt man auf die n&auml;chste oder vorherige Seite */
if ($_POST['knopf'][0] == 'Z')
	header('location:person_bearbeiten1.php');
else
	header('location:person_bearbeiten3.php');
?>


?>