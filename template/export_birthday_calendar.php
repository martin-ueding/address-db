<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Export into a ICS calendar with birthdays.
 */

header("Content-Type: text/calendar; charset=iso-8859-1");
header('Content-Disposition: attachment; filename="adressen-'.time().'.ics"');

echo 'BEGIN:VCALENDAR'."\n";
echo 'VERSION:2.0'."\n";
echo 'X-WR-CALNAME:'._('Birthdays')."\n";
echo 'PRODID:'._('Address Database')."\n";
echo 'X-WR-TIMEZONE:Europe/Berlin'."\n";
echo 'CALSCALE:GREGORIAN'."\n";
echo 'METHOD:PUBLISH'."\n"."\n";

while ($l = mysql_fetch_assoc($erg)) {
	if ($l['geb_j'] == 0)
		$l['geb_j'] = 2000;

	echo 'BEGIN:VEVENT'."\n";
	echo 'DTSTART;VALUE=DATE:'.$l['geb_j'];
	if ($l['geb_m'] < 10)
		echo '0';
	echo $l['geb_m'];
	if ($l['geb_t'] < 10)
		echo '0';
	echo $l['geb_t']."\n";


	echo 'SUMMARY:';
	$name = trim($l['vorname'].' '.$l['nachname']);
	if ($name[strlen($name)-1] == 'x' || $name[strlen($name)-1] == 's') {
		$name .= '\'';
	}
	else {
		$name .= 's';
	}
	echo $name.' '._('Birthday')."\n";
	echo 'UID:'.$l['p_id']."\n";
	echo 'RRULE:FREQ=YEARLY'."\n";
	echo 'DURATION:P1D'."\n";
	echo 'END:VEVENT'."\n"."\n";
}

echo 'END:VCALENDAR'."\n";
?>
