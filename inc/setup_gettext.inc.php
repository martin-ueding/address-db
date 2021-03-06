<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

function gtxt_find_language() {
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

	return $lang;
}

function gtxt_set_locale($lang) {
	if (function_exists('bindtextdomain')) {
		$domain = 'address_db';

		putenv('LC_MESSAGES='.$lang);
		setlocale(LC_MESSAGES, $lang);
		bindtextdomain($domain, "locale/");
		bind_textdomain_codeset($domain, "utf-8");
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
}

gtxt_set_locale(gtxt_find_language());

?>
