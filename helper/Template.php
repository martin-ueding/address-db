<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Renders a template.
 */
class Template {
	/**
	 * Constructs a new template with from the given name.
	 */
	public function __construct($templatename) {
		$this->templatename = $templatename;
		$this->data = array();
	}

	/**
	 * Set variable for use in template.
	 */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	/**
	 * Generate HTML.
	 */
	public function html() {
		extract($this->data);

		ob_start();
		include($this->templatefile());
		return ob_get_clean();
	}

	/**
	 * Path to the template file.
	 */
	private function templatefile() {
		return '../view/'.$this->templatename.'.php';
	}
}
