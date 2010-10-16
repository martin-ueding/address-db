<?PHP
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Adress DB</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="STYLESHEET" type="text/css" href="css/main.css" media="all" />
</head>
<body>
<div id="buttons">
<a href="index.php" target="_top" title="Zurück zur Startseite"><img src="eicons/home.png" width="32" height="32" alt="Zurück zur Startseite" border="0" /></a>
 &nbsp;&nbsp;&nbsp; 
<a href="person_anlegen/person_anlegen1.php" title="Neue Person anlegen" target="main"><img src="eicons/add_user.png" width="32" height="32" alt="Neue Person anlegen" border="0" /></a>
</div>


<div class="nav_kopf">&nbsp;&nbsp; Datum:</div>
<?PHP
include("kalender.inc.php");
include("inc/includes.inc.php");
?>

<div class="nav_kopf">&nbsp;&nbsp; Persönlicher Modus:</div>
<ul id="mitglieder">
<?PHP
if ($_SESSION['f'] != 0)
	echo '<li><a href="index.php?f=0" target="_parent">:: Alle</a></li>';

if (($_SESSION['f'] != 0 && $_SESSION['f'] == 1) || $_SESSION['f'] == 0)
	echo '<li><a class="herby" href="index.php?f=1&main=liste" target="_parent">Herbert</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 2) || $_SESSION['f'] == 0)
	echo '<li><a class="bettina" href="index.php?f=2&main=liste" target="_parent">Bettina</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 3) || $_SESSION['f'] == 0)
	echo '<li><a class="martin" href="index.php?f=3&main=liste" target="_parent">Martin</a></li>';
if (($_SESSION['f'] != 0 && $_SESSION['f'] == 4) || $_SESSION['f'] == 0)
	echo '<li><a class="lennart" href="index.php?f=4&main=liste" target="_parent">Lennart</a></li>';
?>
</ul>

<div class="nav_kopf">&nbsp;&nbsp; Gruppen:</div>
<ul id="gruppen">
<?PHP
$erg = select_alle_gruppen();
/* .. */
while ($l = mysql_fetch_assoc($erg)) 
	{
	if (gruppe_ist_nicht_leer($l['g_id']))
		{
		echo '<li><a href="liste.php?g='.$l['g_id'].'&titel='.$l['gruppe'].'" target="main">'.$l['gruppe'].'</a></li>';
		}
	}
?>
</ul>



<div class="nav_kopf">&nbsp;&nbsp; Spezial:</div>
<ul id="spezial">
<li><a href="anzeigen/alle_geburtstage.php" target="main">Geburtstagsliste</a></li>
<li><a href="anzeigen/nichtmehraktuell.php" target="main">Nicht mehr aktuell</a></li>
<li><a href="anzeigen/ohne_anrede.php" target="main">Ohne Anrede</a></li>
</ul>
	
</body>
</html>
