<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

$dir = dir('.');
while ($zeile = $dir->read()) {
	if (strpos(strtolower($zeile), '.jpg')) {
		echo $zeile."\n";
	}
}
?>
