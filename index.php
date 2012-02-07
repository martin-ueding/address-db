<?PHP
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

$f = (int)$_GET['f'];

if ($f == 0)
	$to = 'adressen/index.php';
else
	$to = 'adressen/index.php?f='.$f;

header('location:'.$to);
?>
