<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Models the GET attributes for a future request.
 *
 * @package component
 */
class Request {
	/**
	 * Generates a new request based on the current _GET array.
	 *
	 * @global array $_GET
	 * @param boolean $use_current Set to false if want an empty request.
	 */
	public function __construct($use_current = true) {
		if ($use_current) {
			$this->parameters = $_GET;
		}
		else {
			$this->parameters = array();
		}
	}

	/**
	 * Sets a parameter.
	 *
	 * @param string $key Key to set.
	 * @param string $value Mathing value.
	 */
	public function set($key, $value) {
		$this->parameters[$key] = $value;
	}

	/**
	 * Returns the parameters in key=value&key=value&... form.
	 *
	 * @return Parameters ready for a GET request.
	 */
	public function join() {
		$pairs = array();

		foreach ($this->parameters as $key => $value) {
			$pairs[] = $key.'='.$value;
		}
		sort($pairs);

		return implode('&', $pairs);
	}
}
