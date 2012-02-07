<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

echo '<h1>'._('delete an entry').'</h1>';
if (!empty($id)) {
	printf(_('Do you really want to delete the entry %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');

	// check for multiple associations
	$ass_sql = 'SELECT * FROM ad_flinks LEFT JOIN ad_fmg ON fmg_id=fmg_lr WHERE person_lr='.(int)$id.' ORDER BY fmg;';
	$ass_erg = mysql_query($ass_sql);
	while ($ass_l = mysql_fetch_assoc($ass_erg)) {
		$association_ids[] = $ass_l['fmg_id'];
		$association_names[] = $ass_l['fmg'];
	}
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
	echo '<a href="index.php?mode=person_delete2&id='.$id.'&back='.urlencode($_GET['back']).'">'._('Sure, delete that!').'</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">'._('No, cancel!').'</a>';
}
else {
	echo _('There is no ID specified.');
}

?>
