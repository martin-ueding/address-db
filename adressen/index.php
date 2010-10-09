<?PHP
if (isset($_GET['f'])) {
	session_start();
	$_SESSION['f'] = (int)$_GET['f'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
<title>php Address Database</title>
</head>

<!-- frames -->
<frameset  rows="60,*">
    <frame name="kopf" src="kopf.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" noresize="noresize" />
    <frameset  cols="225,*">
        <frame name="navigation" src="navigation.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" noresize="noresize" />
        <?PHP
        if ($_GET['f'] != 0 && $_GET['main'] == 'liste')
       		echo '<frame name="main" src="liste.php?f='.$_GET['f'].'" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" noresize="noresize" />';
        else
        	echo '<frame name="main" src="main.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" noresize="noresize" />';
        ?>
    </frameset>
</frameset>

<body>
</body>
</html>

