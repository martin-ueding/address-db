<?PHP
if (isset($_GET['f'])) {
	session_start();
	$_SESSION['f'] = (int)$_GET['f'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link rel="STYLESHEET" type="text/css" href="css/main.css">
		<title>PHP Family Address Database</title>

		<script type="text/javascript">
		function flipMenu(what, how) {
		   document.getElementById(what).style.display = how;
		}	   
		</script>
	</head>


	<body>
	<?PHP
	include('inc/login.inc.php');
	include('inc/abfragen.inc.php');
	include('inc/header.inc.php');

	include('main.php');
	?>

	</body>
</html>

