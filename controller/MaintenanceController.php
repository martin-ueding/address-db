<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Missing.php');
require_once('component/Template.php');
require_once('controller/Controller.php');

class MaintenanceController extends Controller {
	public function integrity_check() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('database check'));

		$template = new Template(__CLASS__, __FUNCTION__);
		return $template->html();
	}

	public function no_association() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('no association'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter(0, $_SESSION['g']);
		$filter->add_where('ad_flinks.person_lr IS NULL');
		$filter->add_join('LEFT JOIN ad_flinks ON person_lr = p_id');

		$missing = new Missing($filter);
		$template->set('missing', $missing);
		return $template->html();
	}

	public function no_birthday() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('no birthday'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('(geb_t = 0 || geb_m = 0)');
		$filter->add_where('anrede_r != 4');

		$missing = new Missing($filter);
		$template->set('missing', $missing);
		return $template->html();
	}

	public function no_email() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('no email'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('email_privat IS NULL');
		$filter->add_where('email_arbeit IS NULL');
		$filter->add_where('email_aux IS NULL');

		$missing = new Missing($filter);
		$template->set('missing', $missing);
		return $template->html();
	}

	public function no_group() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('no group'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], 0);
		$filter->add_where('ad_glinks.person_lr IS NULL');
		$filter->add_join('LEFT JOIN ad_glinks ON ad_glinks.person_lr = gl_id');

		$missing = new Missing($filter);
		$template->set('missing', $missing);
		return $template->html();
	}

	public function no_title() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '._('no from of address'));

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('anrede_r = 1');

		$missing = new Missing($filter);
		$template->set('missing', $missing);
		return $template->html();
	}
}
?>
