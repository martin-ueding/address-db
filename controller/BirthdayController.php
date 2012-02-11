<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Template.php');
require_once('controller/Controller.php');

/**
 * Controller for birthdays.
 */
class BirthdayController extends Controller {
	public function index() {
		$this->history_save();

		$this->set_page_title(_('Address DB').': '._('all birthdays'));

		$template = new Template(__CLASS__, __FUNCTION__);

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

	public function upcoming_birthdays() {
		$this->history_save();

		$this->set_page_title(_('Address DB').': '._('current birthdays'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('geb_m='.date("n"));

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_t';
		$erg = mysql_query($sql);
		$this_persons = array();
		while ($l = mysql_fetch_assoc($erg)) {
			$this_persons[] = array(
				'age' => $l['geb_j'] > 1500 ? '('.(date("Y")-$l['geb_j']).')' : '&nbsp',
				'day' => $l['geb_t'],
				'first_name' => $l['vorname'],
				'had_birthday' => $l['geb_t'] < date("j"),
				'has_birthday' => $l['geb_t'] == date("j"),
				'last_name' => $l['nachname'],
				'link' => 'mode=Person::view&id='.$l['p_id'],
				'month' => $l['geb_m'],
				'year' => $l['geb_j'],
			);
		}
		$template->set('this_persons', $this_persons);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('geb_m='.((date("n")%12)+1));

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY geb_t';

		$erg = mysql_query($sql);
		$next_persons = array();

		while ($l = mysql_fetch_assoc($erg)) {
			$p = array(
				'day' => $l['geb_t'],
				'first_name' => $l['vorname'],
				'had_birthday' => $l['geb_t'] < date("j"),
				'has_birthday' => $l['geb_t'] == date("j"),
				'last_name' => $l['nachname'],
				'link' => 'mode=Person::view&id='.$l['p_id'],
				'month' => $l['geb_m'],
				'year' => $l['geb_j'],
			);

			if ($l['geb_j'] > 1500) {
				if (date("n") == 12)
					$p['age'] = (date("Y")-$l['geb_j']) +1;
				else
					$p['age'] = (date("Y")-$l['geb_j']);

				$p['age'] = '('.$p['age'].')';
			}
			else
				$p['age'] = '&nbsp;';

			$next_persons[] = $p;
		}

		$template->set('next_persons', $next_persons);

		return $template->html();
	}
}
