<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Keeps a stack of interesting pages the user visited.
 *
 * It saves the complete GET array, so that it can send the user back to the
 * exact site.
 *
 * @package component
 */
class History {
	/**
	 * Items on the stack.
	 *
	 * @var integer
	 */
	private $max_length = 10;

	/**
	 * Creates a new, empty History.
	 */
	public function __construct() {
		$this->snapshots = array();
	}

	/**
	 * Saves the given GET parameters.
	 *
	 * @param mixed $get GET array.
	 */
	public function save($get) {
		$this->compress();

		array_push($this->snapshots, $get);
	}

	/**
	 * Retrieves the latest snapshot.
	 *
	 * If no snapshot is saved, an empty array is returned.
	 *
	 * @return array GET array.
	 */
	public function load() {
		$latest = array();

		if (count($this->snapshots) > 0) {
			$latest = array_pop($this->snapshots);
		}

		return $latest;
	}

	/**
	 * Sends the user back one step using the header() function.
	 *
	 * To send the user back, but not back to a Person that does no longer
	 * exist (like after deletion), use the parameter to exclude an id.
	 *
	 * @param integer $filter_id A Person id not to use.
	 */
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

	/**
	 * Deletes items until the stack has the size it should.
	 */
	private function compress() {
		while (count($this->snapshots) > $this->max_length) {
			array_shift($this->snapshots);
		}
	}
}
?>
