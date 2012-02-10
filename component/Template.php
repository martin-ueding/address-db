<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Renders a template.
 *
 * @package component
 */
class Template {
	/**
	 * Constructs a new template with from the given name.
	 *
	 * @param string $templatename Name of the template.
	 */
	public function __construct($templatename) {
		$this->templatename = $templatename;
		$this->data = array();
	}

	/**
	 * Set variable for use in template.
	 *
	 * @param string $key Name of the variable in the template.
	 * @param string $value Value for the variable.
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	/**
	 * Generate HTML.
	 *
	 * @return string HTML.
	 */
	public function html() {
		extract($this->data);

		ob_start();
		include($this->templatefile());
		return ob_get_clean();
	}

	/**
	 * Path to the template file.
	 *
	 * @return string Relative path.
	 */
	private function templatefile() {
		return 'template/'.$this->templatename.'.php';
	}
}
