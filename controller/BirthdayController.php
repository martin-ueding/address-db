<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Template.php');
require_once('controller/Controller.php');

class BirthdayController extends Controller {
	public function all_birthdays() {
		$this->set_page_title(_('Address DB').': '._('all birthdays'));

		$template = new Template('all_birthdays');

		$template->set('from_with_get', 'mode=all_birthdays');

		$monate = array(_('January'), _('February'), _('March'), _('April'), _('May'), _('June'), _('July'), _('August'), _('September'), _('October'), _('November'), _('December'));
		$template->set('months', $monate);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('geb_t != 0');
		$filter->add_where('geb_m != 0');

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_m, geb_t, nachname;';
		$erg = mysql_query($sql);

		$birthdays = array();

		while ($l = mysql_fetch_assoc($erg)) {
			$birthdays[$l['geb_m']][] = $l;
		}

		$template->set('birthdays', $birthdays);

		return $template->html();
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
