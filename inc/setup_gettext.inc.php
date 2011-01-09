<?PHP
if (!empty($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
}
if (empty($_SESSION['lang'])) {
   $_SESSION['lang'] = 'de_DE';
}   
putenv('LC_MESSAGES='.$_SESSION['lang']);
setlocale(LC_MESSAGES, $_SESSION['lang']);
bindtextdomain("main", "../locale/");
bind_textdomain_codeset("main", "iso-8859-1");
textdomain("main");

$available_languages = array(
	array('de_DE', _('German')),
	array('en', _('English'))
);

?>
