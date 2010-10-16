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


/* Jetzt kommt man auf die n&auml;chste oder vorherige Seite */
if ($_POST['knopf'][0] == 'Z')
	header('location:person_anlegen2.php');
else
	header('location:person_anlegen4.php');
?>


?>