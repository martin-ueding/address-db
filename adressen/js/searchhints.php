<?PHP
include('../_config.inc.php');
$q = $_POST['query'];

echo '<ul>';

$sql = 'SELECT * FROM ad_per WHERE nachname like "'.$q.'%" ORDER BY nachname LIMIT 5;';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	echo '<li><a href="index.php?mode=search&suche='.$l['nachname'].'">'.$l['nachname'].'</a></li>';
}

echo '</ul>';
?>
