<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Request {
	public function __construct($use_current = true) {
		if ($use_current) {
			$this->parameters = $_GET;
		}
		else {
			$this->parameters = array();
		}
	}

	public function set($key, $value) {
		$this->parameters[$key] = $value;
	}

	public function join() {
		$pairs = array();

		foreach ($this->parameters as $key => $value) {
			$pairs[] = $key.'='.$value;
		}
		sort($pairs);

		return implode('&', $pairs);
	}
}
