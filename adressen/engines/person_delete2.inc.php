<?PHP
if (!empty($id)) {
	delete_person_id($id);

	$msgs[] = 'Die Person <em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em> wurde gel&ouml;scht.';

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
	$msgs[] = 'Keine Person mit der ID '.$id.' vorhanden.';
}

?>
