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
		<title>Person anlegen 3/4</title>

<link rel="STYLESHEET" type="text/css" href="../css/main.css">
	</head>
	<body class="maske">

	<table id="schritte">
<tr>
<td class="normal">1/4</td>
<td class="normal">2/4</td>
<td class="aktiv">3/4</td>
<td class="normal">4/4</td>
</tr>
</table>


	<h2>Schritt 3/4 - Pers&ouml;nliche Kontaktdaten</h2>

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


	
	<br />
	<input class="rand" type="submit" name="knopf" value="Zur&uuml;ck" />
	<input class="rand" type="submit" name="knopf" value="Weiter" />
		
	</form>

	</body>
</html>