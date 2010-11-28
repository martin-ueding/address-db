<?PHP
$f = (int)$_GET['f'];
// since this is not the main directory for displaying, one is forwareded.
if ($f == 0)
	header('location:adressen/index.php');
else
	header('location:adressen/index.php=f='.$f);
?>
