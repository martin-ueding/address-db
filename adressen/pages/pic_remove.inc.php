<?PHP
if (!empty($id)) {
	printf(_('Do you really want to remove the picture for <em>%s</em>?'), $person_loop['vorname'].' '.$person_loop['nachname']);
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=pic_remove2&id='.$id.'">'._('Yes, delete picture!').'</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$_GET['id'].'">'._('Cancel').'</a>';
}

?>
