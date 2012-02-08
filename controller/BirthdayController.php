<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');

class BirthdayController {
	public static function all_birthdays() {
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
	}

	public static function upcoming_birthdays() {
		echo '<table id="geburtstag">';
		echo '<tr>';
		echo '<td colspan="4"><b>'._('birthdays').'</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="3">&nbsp;<br />'._('this month').':</td>';
		echo '</tr>';

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('geb_m='.date("n"));

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_t';
		$erg = mysql_query($sql);
		echo mysql_error();
		while ($l = mysql_fetch_assoc($erg)) {
			echo '<tr class="data">';
			echo '<td><a href="?mode=person_display&id='.$l['p_id'].'">';
			if ($l['geb_t'] == date("j"))
				echo '<em>'.$l['vorname'].' '.$l['nachname'].'</em>';
			else if ($l['geb_t'] < date("j"))
				echo '<span class="graytext">'.$l['vorname'].' '.$l['nachname'].'</span>';
			else
				echo $l['vorname'].' '.$l['nachname'];

			echo '</a> </td>';
			echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>';
			if ($l['geb_j'] > 1500)
				echo '<td> ('.(date("Y")-$l['geb_j']).') </td>';
			else
				echo '<td>&nbsp;</td>';
			echo '</tr>';
		}

		echo '<tr>';
		echo '<td colspan="3">&nbsp;<br />'._('next month').':</td>';
		echo '</tr>';

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('geb_m='.((date("n")%12)+1));

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_t';

		$erg = mysql_query($sql);
		echo mysql_error();

		while ($l = mysql_fetch_assoc($erg)) {
			echo '<tr class="data">';
			echo '<td><a href="?mode=person_display&id='.$l['p_id'].'">'.$l['vorname'].' '.$l['nachname'].'</a> </td>';
			echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.</td>';

			echo '<td>';
			if ($l['geb_j'] > 1500) {
				echo '(';
				if (date("n") == 12)
					echo (date("Y")-$l['geb_j']) +1;
				else
					echo (date("Y")-$l['geb_j']);
				echo ')';
			}
			else
				echo '&nbsp;';

			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
}
