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

	public function go_back($filter_id = null) {
		$snapshot = $this->load();

		if ($filter_id != null) {
			while ($snapshot['id'] == $filter_id) {
				$snapshot = $this->load();
			}
		}

		$pairs = array();

		foreach ($snapshot as $key => $value) {
			$pairs[] = $key.'='.$value;
		}

		sort($pairs);

		header('location:?'.implode('&', $pairs));
	}

	private function compress() {
		while (count($this->snapshots) > $this->max_length) {
			array_shift($this->snapshots);
		}
	}
}
?>
