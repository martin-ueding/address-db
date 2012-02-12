<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Request.php');
require_once('component/Template.php');
require_once('controller/Controller.php');
require_once('model/Group.php');
require_once('model/Member.php');

class HeaderController extends Controller {
	/**
	 * 
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function view() {
		$template = new Template('header');

		$aktuell_name = Member::get_name($_SESSION['f']);

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

		foreach (Member::get_all() as $member) {
			$request = new Request();
			if (preg_match('/^Person::/', $this->get_current_mode())) {
				$request->set('mode', 'List::index');
			}
			else {
				$request->set('mode', $this->get_current_mode());
			}
			$request->set('f', $member['id']);

			$mode_links[] = array(
				'request' => $request->join(),
				'class' => $_SESSION['f'] == $member['id'] ? 'active' : '',
				'title' => $member['name'],
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

		foreach (Group::get_all() as $group) {
			if (Group::gruppe_ist_nicht_leer($group['id'])) {
				$request = new Request();
				if (preg_match('/^Person::/', $this->get_current_mode())) {
					$request->set('mode', 'List::index');
				}
				else {
					$request->set('mode', $this->get_current_mode());
				}
				$request->set('g', $group['id']);

				$group_links[] = array(
					'request' => $request->join(),
					'class' => $_SESSION['g'] == $group['id'] ? 'active' : '',
					'title' => $group['name'],
				);
			}
		}
		# FIXME Isset here and in template.
		$template->set('group_links', $group_links);

		$buchstaben = range('A', 'Z');
		$show_letters = array();
		foreach ($buchstaben as $b) {
			$filter = new Filter($_SESSION['f'], $_SESSION['g']);
			$filter->add_where('last_name like "'.$b.'%"');

			$sql = 'SELECT id FROM ad_persons '.$filter->join().' WHERE '.$filter->where().';';

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
