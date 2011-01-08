<?PHP
if ($_GET['sicher'] != 'ja') {
	printf(_('Do you really want to send a verification mail to %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
	echo '<br /><br />';
	echo '<a href="index.php?mode=verification_email&id='.$id.'&sicher=ja">'._('sure').'</a>';
	echo '<br /><br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">'._('Do not send!').'</a>';
}
?>
