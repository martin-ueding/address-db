<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class History {
	private $max_length = 5;

	public function __construct() {
		$this->snapshots = array();
	}

	public function save($get) {
		$this->compress();

		array_push($this->snapshots, $get);
	}

	public function load() {
		return array_pop($this->snapshots);
	}

	public function load_get() {
		$pairs = array();

		foreach ($this->load() as $key => $value) {
			$pairs[] = $key.'='.$value;
		}

		sort($pairs);

		return implode('&', $pairs);
	}

	private function compress() {
		while (count($this->snapshots) > $this->max_length) {
			array_shift($this->snapshots);
		}
	}
}
?>
