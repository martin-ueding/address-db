<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Request.php');
require_once('component/Template.php');
require_once('controller/Controller.php');
require_once('model/Group.php');

class HeaderController extends Controller {
	public function view() {
		$template = new Template('header');

		$sql = 'SELECT * FROM ad_fmg';
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
				$aktuell_name = $l['fmg'];
		}
		if (!isset($aktuell_name))
			$aktuell_name = _('all');

		$request = new Request();
		if (preg_match('/^Person::/', $this->get_current_mode())) {
			$request->set('mode', 'List::index');
		}
		else {
			$request->set('mode', $this->get_current_mode());
		}
		$request->set('f', 0);

		$template->set('mode_all_request', $request->join());
		$template->set('mode_all_class', $_SESSION['f'] == 0 ? 'active' : '');

		$sql = 'SELECT * FROM ad_fmg';
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			$request = new Request();
			if (preg_match('/^Person::/', $this->get_current_mode())) {
				$request->set('mode', 'List::index');
			}
			else {
				$request->set('mode', $this->get_current_mode());
			}
			$request->set('f', $l['fmg_id']);

			$mode_links[] = array(
				'request' => $request->join(),
				'class' => $_SESSION['f'] == $l['fmg_id'] ? 'active' : '',
				'title' => $l['fmg'],
			);
		}

		$template->set('mode_links', $mode_links);

		$request = new Request();
		if (preg_match('/^Person::/', $this->get_current_mode())) {
			$request->set('mode', 'List::index');
		}
		else {
			$request->set('mode', $this->get_current_mode());
		}
		$request->set('g', 0);

		$template->set('group_all_request', $request->join());
		$template->set('group_all_class', $_SESSION['g'] == 0 ? 'active' : '');

		$erg = Group::select_alle_gruppen();
		while ($l = mysql_fetch_assoc($erg)) {
			if (Group::gruppe_ist_nicht_leer($l['g_id'])) {
				$request = new Request();
				if (preg_match('/^Person::/', $this->get_current_mode())) {
					$request->set('mode', 'List::index');
				}
				else {
					$request->set('mode', $this->get_current_mode());
				}
				$request->set('g', $l['g_id']);

				$group_links[] = array(
					'request' => $request->join(),
					'class' => $_SESSION['g'] == $l['g_id'] ? 'active' : '',
					'title' => $l['gruppe'],
				);
			}
		}
		# FIXME Isset here and in template.
		$template->set('group_links', $group_links);

		$buchstaben = range('A', 'Z');
		$show_letters = array();
		foreach ($buchstaben as $b) {
			$filter = new Filter($_SESSION['f'], $_SESSION['g']);
			$filter->add_where('nachname like "'.$b.'%"');

			$sql = 'SELECT p_id FROM ad_per '.$filter->join().' WHERE '
				.$filter->where().';';

			$erg = mysql_query($sql);
			if (mysql_num_rows($erg) > 0) {
				$show_letters[] = $b;
			}
			else {
			}
		}
		$template->set('show_letters', $show_letters);
		$template->set('current_mode', $this->get_current_mode());

		return $template->html();
	}
}
