<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Deletion of a Person.
 */
?>
<h1><?php echo _('delete an entry'); ?></h1>
<?php
printf(_('Do you really want to delete the entry %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');

function hightlight($string) {return '<em>'.$string.'</em>';}

if (isset($association_ids)) {
	if (count($association_ids) >= 2) {
		echo '<br />';
		echo '<br />';
		echo _('Warning:').' '.sprintf(
			_('This entry is connected to %s. Consider just removing your association with it.'),
			implode(', ', array_map("highlight", $association_names))
		);
	}
	else if (count($association_ids) == 1 && $association_ids[0] != $_SESSION['f']) {
		echo '<br />';
		echo '<br />';
		echo _('Warning:').' '.sprintf(_('This entry is connected to %s. Are you sure that you can delete this entry?'), '<em>'.$association_names[0].'</em>');
	}
}

echo '<br />';
echo '<br />';
echo '<a href="index.php?mode=Person::delete&id='.$id.'&sure=true&back='.(isset($_GET['back']) ? urlencode($_GET['back']) : '').'">'._('Sure, delete that!').'</a>';
echo '<br />';
echo '<br />';
echo '<a href="index.php?mode=Person::view&id='.$id.'">'._('No, cancel!').'</a>';
?>
