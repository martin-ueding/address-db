<?php
// original script from
// http://www.wer-weiss-was.de/theme163/article2952225.html
// changes Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

include('_config.inc.php');

$tables = mysql_query("SHOW TABLES FROM ".$db);
while ($cells = mysql_fetch_array($tables)) {
	$table = $cells[0];
	echo "DROP TABLE IF EXISTS `$table`;\n";
	$res = mysql_query("SHOW CREATE TABLE `$table`");
	if ($res) {
		$create = mysql_fetch_array($res);
		$create[1] .= ";";
		$line = str_replace("\n", "", $create[1]);
		echo $line;
		$data = mysql_query("SELECT * FROM `$table`");
		$num = mysql_num_fields($data);
		while ($row = mysql_fetch_array($data)) {
			$line = "INSERT INTO `$table` VALUES(";
			for ($i=1;$i<=$num;$i++) {
				$line .= "'".mysql_real_escape_string($row[$i-1])."', ";
			}
			$line = substr($line,0,-2);
			echo $line.");\n";
		}
	}
}
?>
