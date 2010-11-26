<?PHP
function alter($tag, $monat, $jahr) { // j, n
	$alter = date("Y") - $jahr;
	if ($monat > date("n") || ($monat == date("n") && $tag > date("j")))
		$alter--;
	return $alter;
}

function skplnk($nummer) {
	if ($nummer[0] != "+")
		$nummer = "+49" . substr($nummer, 1, strlen($nummer)-1);
		
	return '<a href="Callto://'.$nummer.'"><img src="eicons/10/skype10.png" /></a>';
}

function intelligent_date ($stamp) {
	global $date_format;
	$diff = time() - $stamp;

	// if the date is in the past ...
	if ($diff >= 0) {
		if ($diff < 15)
			return 'soeben';
		else if ($diff < 60)
			return 'in der letzten Minute';
		else if ($diff < 7200)
			return 'vor '.round($diff/60).' Minuten';
		else if ($diff < 86400)
			return 'vor '.round($diff/3600).' Stunden';
		else if ($stamp == 0)
			return 'nie';
		else
			return 'am '.date($date_format, $stamp);
	}
	else {
		return 'in der Zukunft ...';
	}
}
?>
