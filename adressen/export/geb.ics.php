<?PHP

//header('Content-Type: text/calendar; charset=iso-8859-1');

include('inc/includes.inc.php');

$f = (int)$_GET['f'];


echo 'BEGIN:VCALENDAR'."\n";
echo 'VERSION:2.0'."\n";
echo 'X-WR-CALNAME:Geburtstage'."\n";
echo 'PRODID:Adress Datebank'."\n";
echo 'X-WR-TIMEZONE:Europe/Berlin'."\n";
echo 'CALSCALE:GREGORIAN'."\n";
echo 'METHOD:PUBLISH'."\n"."\n";

$sql = 'SELECT * FROM ad_per, ad_flinks WHERE geb_t != 0 && geb_m != 0 && person_lr=p_id && fmg_lr='.$f.';';
$erg = mysql_query($sql);
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
	

	echo 'SUMMARY:'.$l['vorname'].' '.$l['nachname'].'s Geburtstag'."\n";
	echo 'UID:'.$l['p_id']."\n";
	echo 'RRULE:FREQ=YEARLY'."\n";
	echo 'DURATION:P1D'."\n";
	echo 'END:VEVENT'."\n"."\n";	
}

echo 'END:VCALENDAR'."\n";

?>