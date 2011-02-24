<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

include('../_config.inc.php');
$q = $_POST['query'];


$sql = 'SELECT nachname FROM ad_per WHERE nachname like "'.$q.'%" GROUP BY nachname ORDER BY nachname LIMIT 15;';
$erg = mysql_query($sql);
if (mysql_num_rows($erg) > 0) {
	echo '<ul>';
	while ($l = mysql_fetch_assoc($erg)) {
		echo '<a href="index.php?mode=search&suche='.$l['nachname'].'"><li>'.$l['nachname'].'</li></a>';
	}
	echo '</ul>';
}
else
	echo _('no suggestions available');

?>
