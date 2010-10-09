<?PHP session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Adress DB</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="STYLESHEET" type="text/css" href="css/main.css" media="all" />
</head>
<body>
<form action="suche.php" method="post" target="main">
<div id="suchfeld"><input type="search" id="suche" name="suche" maxlength="100" />

<input type="image" id="sub_mit" src="eicons/lupe.png" align="middle" title="Suche starten" /></div>
</form>

<?PHP
include("inc/includes.inc.php");
/* .. */
$buchstaben = range('A', 'Z');
/* .. */
echo '<div id="kartei">';
foreach ($buchstaben as $b)
	{
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT p_id FROM ad_per, ad_flinks WHERE nachname like "'.$b.'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].';';
	else
		$sql = 'SELECT p_id FROM ad_per WHERE nachname like "'.$b.'%";';
	$erg = mysql_query($sql);
	if (mysql_num_rows($erg) > 0)
		{
		echo '<a href="liste.php?b='.$b.'" target="main">';
		echo $b;
		echo '</a>';
		}
	else
		{echo '<span>'.$b.'</span>';}
	echo ' ';
	}
echo '</div>';
?>

</body>
</html>