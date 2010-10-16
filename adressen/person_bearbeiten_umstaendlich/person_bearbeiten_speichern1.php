<?PHP
session_start();

//include('../inc/varclean.inc.php');
include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');
include('../inc/select.inc.php');

/* Die Variablen vom Schritt 1 (Name und Bezug) werden jetzt in die Session
 * gespeichert, damit sie f&uuml;r den weiteren Vorgang immer verf&uuml;gbar
 * sind.
 */

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


/* Jetzt kommt man auf die n&auml;chste Seite */

header('location:person_bearbeiten2.php');
?>