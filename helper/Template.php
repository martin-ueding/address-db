<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Template {
	public function __construct($templatename) {
		$this->templatename = $templatename;
		$this->data = array();
	}

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	public function html() {
		extract($this->data);
		include($this->templatefile());
	}

	private function templatefile() {
		return '../view/'.$this->templatename.'.php';
	}
}
