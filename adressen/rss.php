<?PHP
include('inc/login.inc.php');


echo '<?xml version="1.0" encoding="ISO-8859-1" ?>' . "\n";
echo '<rss version="0.91">' . "\n";
echo '<channel>' . "\n";
echo '<title>Geburtstage</title>' . "\n";
echo '<link>http://www.bonnmedia.de/adressen/</link>' . "\n";
echo '<description>Aktuelle Geburtstage</description>' . "\n";
echo '<language>de-de</language>' . "\n";
echo '<copyright>BonnMedia.de</copyright>' . "\n";
echo '<image>' . "\n";
echo '<title>Geburtstage</title>' . "\n";
echo '<url>http://www.bonnmedia.de/adressen/icons/rss.png</url>' . "\n";
echo '<link>http://www.bonnmedia.de/adressen/</link>' . "\n";
echo '</image>' . "\n";

$sql = 'SELECT * FROM ad_per WHERE geb_m='.date("n").' ORDER BY geb_t';
	$erg = mysql_query($sql);
	echo mysql_error();

	while ($l = mysql_fetch_assoc($erg)) {
		
		echo '<item>' . "\n";
		echo '<title>' . $l['vorname'].' '.$l['nachname'] . '</title>' . "\n";
//		echo '<description><![CDATA[' . $l['besch'];
//		echo '<br />Datum: ' . $l['geb_t'].'.'.$l['geb_m'].'.'.date('Y');
//		echo '<br />]]></description>' . "\n";
		echo '<link>personenanzeige.php?id='.$l['p_id'].'</link>' . "\n";
	
		echo '<pubDate>' . date("r", mktime(0, 0, 0, $l['geb_m'], $l['geb_t'], date('Y'))) . ' CET</pubDate>';
		echo '</item>' . "\n";
	}

	echo '<br />N&auml;chsten Monat:<br />';

	$sql = 'SELECT * FROM ad_per WHERE geb_m='.((date("n")+1)%12).' ORDER BY geb_t';
	$erg = mysql_query($sql);
	echo mysql_error();

	$jahr = (date("n") == 11) ? 0 : (date("n")+1);

	while ($l = mysql_fetch_assoc($erg)) {
		echo '<item>' . "\n";
		echo '<title>' . $l['vorname'].' '.$l['nachname'] . '</title>' . "\n";
//		echo '<description><![CDATA[' . $l['besch'];
//		echo '<br />Datum: ' . $l['geb_t'].'.'.$l['geb_m'].'.'.$jahr;
//		echo '<br />]]></description>' . "\n";
		echo '<link>personenanzeige.php?id='.$l['p_id'].'</link>' . "\n";
	
		echo '<pubDate>' . date("r", mktime(0, 0, 0, $l['geb_m'], $l['geb_t'], $jahr)) . ' CET</pubDate>';
		echo '</item>' . "\n";
	}



echo '</channel>' . "\n";
echo '</rss>' . "\n";

?>

