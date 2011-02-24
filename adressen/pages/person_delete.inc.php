<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

echo '<h1>'._('delete an entry').'</h1>';
if (!empty($id)) {
	printf(_('Do you really want to delete the entry %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_delete2&id='.$id.'&back='.urlencode($_GET['back']).'">'._('Sure, delete that!').'</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">'._('No, cancel!').'</a>';
}
echo _('There is no ID specified.');

?>
