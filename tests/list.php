<?php
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

$dir = dir('.');
while ($file = $dir->read()) {
	if (preg_match('/.*_test\.php$/', $file)) {
		$tests[] = $file;
	}
}

sort($tests);

foreach ($tests as $test) {
	echo '<a href="'.$test.'" target="main">'.$test.'</a><br />';
}
