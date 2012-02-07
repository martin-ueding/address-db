<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

foreach ($_GET as $key => $wert) {
	$_GET[$key] = strip_tags($_GET[$key]);
	$_GET[$key] = addslashes($_GET[$key]);
	$_GET[$key] = htmlspecialchars($_GET[$key], ENT_QUOTES);
	$_GET[$key] = trim($_GET[$key]);
}

foreach ($_POST as $key => $wert) {
	$_POST[$key] = strip_tags($_POST[$key]);
	$_POST[$key] = addslashes($_POST[$key]);
	$_POST[$key] = htmlspecialchars($_POST[$key], ENT_QUOTES);
	$_POST[$key] = trim($_POST[$key]);
}

/*foreach ($_SESSION as $key => $wert) {
	$_SESSION[$key] = strip_tags($_SESSION[$key]);
	$_SESSION[$key] = addslashes($_SESSION[$key]);
	$_SESSION[$key] = htmlspecialchars($_SESSION[$key], ENT_QUOTES);
	$_SESSION[$key] = trim($_SESSION[$key]);
}*/

?>
