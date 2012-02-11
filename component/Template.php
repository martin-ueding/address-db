<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Renders a template.
 */
class Template {
	/**
	 * Constructs a new template with from the given name.
	 *
	 * If the second parameter is given, constructs a new template for the
	 * given controller action.
	 *
	 * @param string $templatename Name of the template (or controller).
	 * @param string $action Name of the function.
	 */
	public function __construct($templatename, $action = null) {
		if ($action == null) {
			$this->templatename = $templatename;
		}
		else {
			preg_match('/(.*)Controller/', $templatename, $matches);

			if (count($matches) == 0) {
				die(sprintf(
					_('Cannot find template for %s %s.'),
					$templatename,
					$action
				));
			}
			else {
				$this->templatename = strtolower($matches[1].'_'.$action);
			}
		}
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
