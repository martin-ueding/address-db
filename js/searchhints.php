<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');

session_start();

require_once('component/Login.php');

$q = $_POST['query'];

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('nachname like "'.$q.'%"');

$sql = 'SELECT nachname FROM ad_per '.$filter->join().' WHERE '.$filter->where().' GROUP BY nachname ORDER BY nachname LIMIT 15;';

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
