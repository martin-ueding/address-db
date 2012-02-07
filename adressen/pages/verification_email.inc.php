<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

if ($_GET['sicher'] != 'ja') {
	printf(_('Do you really want to send a verification mail to %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
	echo '<br /><br />';
	echo '<form action="index.php" method="GET">';
	echo '<input type="hidden" name="mode" value="verification_email" />';
	echo '<input type="hidden" name="id" value="'.$id.'" />';
	echo '<input type="hidden" name="sicher" value="ja" />';
	echo _('Language to send the email in:');
	echo '<br />';
	echo '<select name="send_lang" size="1">';
	foreach ($available_languages as $a_lang) {
		echo '<option value="'.$a_lang[0].'"'.($a_lang[0] == $_SESSION['lang'] ? ' selected' : '').'>'.$a_lang[1].'</option>';
	}
	echo '</select>';
	echo '<br /><br />';
	echo '<input type="submit" value="'._('send').'" />';
	echo '<br /><br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">'._('Do not send!').'</a>';
}
?>
