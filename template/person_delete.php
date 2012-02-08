<h1><?php echo _('delete an entry'); ?></h1>
<?php
printf(_('Do you really want to delete the entry %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');

if (isset($association_ids)) {
	if (count($association_ids) >= 2) {
		echo '<br />';
		echo '<br />';
		echo _('Warning:').' '.sprintf(_('This entry is connected to %s. Consider just removing your association with it.'), implode(', ', $association_names));
	}
	else if (count($association_ids) == 1 && $association_ids[0] != $_SESSION['f']) {
		echo '<br />';
		echo '<br />';
		echo _('Warning:').' '.sprintf(_('This entry is connected to %s. Are you sure that you can delete this entry?'), $association_names[0]);
	}
}

echo '<br />';
echo '<br />';
echo '<a href="index.php?mode=Person::delete&id='.$id.'&sure=true&back='.urlencode($_GET['back']).'">'._('Sure, delete that!').'</a>';
echo '<br />';
echo '<br />';
echo '<a href="index.php?mode=Person::view&id='.$id.'">'._('No, cancel!').'</a>';
?>
