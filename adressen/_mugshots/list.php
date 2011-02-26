<?PHP
$dir = dir('.');
while ($zeile = $dir->read()) {
	if (strpos(strtolower($zeile), '.jpg')) {
		echo $zeile."\n";
	}
}
?>
