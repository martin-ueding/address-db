<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Template.php');
require_once('controller/Controller.php');
require_once('helper/Table.php');

class SearchController extends Controller {
	public function index() {
		$this->history_save();
		$this->set_page_title(_('Address DB').': '.sprintf(
			_('search for &bdquo;%s&ldquo;'), $_GET['suche']));

		$template = new Template(__CLASS__, __FUNCTION__);
		return $template->html();
	}
}
?>
