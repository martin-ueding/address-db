<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('helper/Table.php');

/**
 * Shows a report of Person that match the given Filter.
 */
class Missing {
	public function __construct($filter) {
		$erg = $filter->get_erg();
		$this->table = new Table($erg);
	}

	/**
	 * Renders HTML.
	 *
	 * @return string HTML.
	 */
	public function html() {
		return $this->table->html();
	}
}

?>
