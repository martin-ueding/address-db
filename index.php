<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

$f = (int)$_GET['f'];
// since this is not the main directory for displaying, one is forwareded.


echo '<!doctype html>';
echo '<html>';
echo '<head>';
echo '<meta http-equiv="refresh" content="0; ';

if ($f == 0)
	echo 'adressen/index.php';
else
	echo 'adressen/index.php?f='.$f;

echo '">';
echo '<style type="text/css">
#welcome {
	font-family: ubuntu, verdana, sans-serif;
color: #555;
	font-size: 70px;
margin: 40px auto 0px auto;
width: 600px;
}
</style>';

echo '<title></title>';
echo '</head>';
echo '<body>';
echo '<div id="welcome">Adressdatenbank</div>';
echo '</body>';
echo '</html>';
?>
