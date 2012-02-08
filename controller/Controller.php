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

	public static function get_controller($mode) {
		preg_match('/([A-Za-z]+)::([A-Za-z0-9-_]+)/', $mode, $matches);

		if (count($matches) > 2) {

			$mode_controller = $matches[1].'Controller';
			$mode_function = $matches[2];

			$controllerfile = 'controller/'.$mode_controller.'.php';
			if (file_exists($controllerfile)) {
				require_once($controllerfile);
				return new $mode_controller();
			}
		}
	}

	public static function call($mode) {
		preg_match('/([A-Za-z]+)::([A-Za-z0-9-_]+)/', $mode, $matches);
		if (count($matches) > 2) {
			$mode_controller = $matches[1].'Controller';
			$mode_function = $matches[2];

			$controllerfile = 'controller/'.$mode_controller.'.php';
			if (file_exists($controllerfile)) {
				require_once($controllerfile);
				$content_controller = new $mode_controller();
			}
			return $content_controller->$mode_function();
		}
	}

	protected function history_save() {
		$_SESSION['history']->save($_GET);
	}
}
