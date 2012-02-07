<?php
// Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');

echo '<h1>'._('all birthdays').'</h1>';
$from_with_get = 'mode=all_birthdays';
$monate = array(_('January'), _('February'), _('March'), _('April'), _('May'), _('June'), _('July'), _('August'), _('September'), _('October'), _('November'), _('December'));

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('geb_t != 0');
$filter->add_where('geb_m != 0');

$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_m, geb_t, nachname;';
$erg = mysql_query($sql);

$aktuell = 1;


$birthdays = array();

while ($l = mysql_fetch_assoc($erg)) {
	$birthdays[$l['geb_m']][] = $l;
}

$showed_anything = false;

foreach ($birthdays as $month => $list) {
	if (count($list) == 0) {
		continue;
	}

	$showed_anything = true;

	echo '<div class="geb_monat_kasten">';
	echo '<b>'.$monate[$month-1].'</b>';
	echo '<br /><br />';

	foreach ($list as $person) {
		$tag = $person['geb_t'] < 10 ? '0'.$person['geb_t'] : $person['geb_t'];

		echo '<a href="?mode=person_display&id='.$person['p_id'].'&back='.urlencode($from_with_get).'">'.$tag.'. ';

		$has_birthday = $person['geb_t'] == date("j") && $aktuell == date("n");
		if ($has_birthday) {
			echo '<em>';
		}
		echo $person['vorname'].' '.$person['nachname'];
		if ($has_birthday) {
			echo '</em>';
		}

		echo '</a>';

		echo '<br />';
	}

	echo '</div>';
}

if (!$showed_anything) {
	echo _("Sorry, nobody's birthday is known.");
}

?>
