<?php
/**
 * @package template
 */

echo '<h1>'._('all birthdays').'</h1>';
$showed_anything = false;

foreach ($birthdays as $month => $list) {
	if (count($list) == 0) {
		continue;
	}

	$showed_anything = true;

	echo '<div class="geb_monat_kasten">';
	echo '<b>'.$months[$month-1].'</b>';
	echo '<br /><br />';

	foreach ($list as $person) {
		$tag = $person['geb_t'] < 10 ? '0'.$person['geb_t'] : $person['geb_t'];

		echo '<a href="?mode=Person::view&id='.$person['p_id'].'">'.$tag.'. ';

		$has_birthday = $person['geb_t'] == date("j") && $month == date("n");
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
