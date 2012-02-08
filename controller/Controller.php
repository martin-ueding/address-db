<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Controller {
	private $page_title;
	private $current_mode;

	public function __construct() {
		$this->set_page_title(_('Address DB'));
	}

	protected function set_page_title($title) {
		$this->page_title = $title;
	}

	public function get_page_Title() {
		return $this->page_title;
	}

	public function get_current_mode() {
		return $this->current_mode;
	}

	public function set_current_mode($mode) {
		$this->current_mode = $mode;
	}
}
