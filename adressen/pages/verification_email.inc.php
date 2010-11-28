<?PHP
if ($_GET['sicher'] != 'ja') {
	echo 'M&ouml;chten Sie wirklich eine &Uuml;berpr&uuml;fungsmail an <em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em> senden?<br /><br />';
	echo '<a href="index.php?mode=verification_email&id='.$id.'&sicher=ja">Sicher</a>';
	echo '<br /><br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">NICHT SENDEN!</a>';
}
?>
