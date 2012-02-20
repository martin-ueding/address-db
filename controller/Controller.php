<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Base class for specific Controller.
 *
 * This provides a couple convinience function for the child Controller. A
 * child controller should have public actions that return HTML code.
 */
class Controller {
	/**
	 * @var string
	 */
	private $page_title;

	/**
	 * The mode the page is currently on.
	 *
	 * @var string
	 */
	private $current_mode;

	private $layout;

	/**
	 * New controller.
	 */
	public function __construct() {
		$this->set_page_title(_('Address DB'));
		$this->layout = 'default';
	}

	/**
	 * @param string $title Page title.
	 */
	protected function set_page_title($title) {
		$this->page_title = $title;
	}

	/**
	 * @return string Page title.
	 */
	public function get_page_Title() {
		return $this->page_title;
	}

	/**
	 * @return string Current mode.
	 */
	public function get_current_mode() {
		return $this->current_mode;
	}

	/**
	 * @param string $mode Current mode.
	 */
	public function set_current_mode($mode) {
		$this->current_mode = $mode;
	}

	/**
	 * @return string Selected layout.
	 */
	public function get_layout() {
		return $this->layout;
	}

	/**
	 * @param string $layout Selected layout.
	 */
	protected function set_layout($layout) {
		$this->layout = $layout;
	}

	/**
	 * Finds a controller to a given mode.
	 *
	 * @param string $mode Mode to check.
	 * @return array Information about the controller action.
	 */
	public static function get_controller($mode) {
		preg_match('/([A-Za-z]+)::([A-Za-z0-9-_]+)/', $mode, $matches);

		$result = array();

		if (count($matches) > 2) {
			$mode_controller = $matches[1].'Controller';
			$result = array(
				'file' => 'controller/'.$mode_controller.'.php',
				'controller' => $mode_controller,
				'function' => $matches[2],
			);
		}

		return $result;
	}

	/**
	 * Saves the current $_GET into the session wide history component.
	 *
	 * @global History $_SESSION['history']
	 * @global array $_GET
	 */
	protected function history_save() {
		$_SESSION['history']->save($_GET);
	}
}
