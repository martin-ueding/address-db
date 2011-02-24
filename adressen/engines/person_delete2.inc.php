<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

if (!empty($id)) {
	delete_person_id($id);

	if (!empty($person_loop['vorname']) || !empty($person_loop['nachname'])) {
		$msgs[] = sprintf(_('The entry %s was deleted.'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
	}

	$_GET['mode'] = 'main';
	$back = $_GET['back'];
	$items = explode('&', $back);
	foreach ($items as $item) {
		$keyvalue = explode('=', $item);
		$_GET[$keyvalue[0]] = $keyvalue[1];
	}

	$mode = $_GET['mode'];
	if (empty($mode)) {
		$mode = 'main';
	}

	unset($items);
}
else {
	$msgs[] = _('Missing an ID.');
}

?>
