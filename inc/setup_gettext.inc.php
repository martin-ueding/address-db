<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

if (session_id() == "")
	session_start();

if (!empty($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	$lang = $_GET['lang'];
}
else if (empty($_SESSION['lang'])) {
	$_SESSION['lang'] = 'de_DE';
	$lang = 'de_DE';
}
else {
	$lang = $_SESSION['lang'];
}

if (function_exists('bindtextdomain')) {
	$domain = 'address_db';

	putenv('LC_MESSAGES='.$lang);
	setlocale(LC_MESSAGES, $lang);
	bindtextdomain($domain, "../locale/");
	bind_textdomain_codeset($domain, "iso-8859-1");
	textdomain($domain);

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
