<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

if (session_id() == "")
	session_start();

if (!empty($_GET['lang'])) {
	$_SESSION['lang_session'] = $_GET['lang'];
	$lang = $_GET['lang'];
}
else if (empty($_SESSION['lang_session'])) {
	$_SESSION['lang_session'] = 'de_DE';
	$lang = 'de_DE';
}
else {
	$lang = $_SESSION['lang_session'];
}
if (function_exists('bindtextdomain')) {
	putenv('LC_MESSAGES='.$lang);
	setlocale(LC_MESSAGES, $lang);
	bindtextdomain("phpfamilyaddressdb", "../locale/");
	bind_textdomain_codeset("phpfamilyaddressdb", "iso-8859-1");
	textdomain("phpfamilyaddressdb");

	$available_languages = array(
		array('de_DE', _('German')),
		array('en', _('English')),
		array('nl', _('Dutch')),
		array('tr', _('Turkish'))
	);
}
else {
	function _($s) {
		return $s;
	}
}

?>
