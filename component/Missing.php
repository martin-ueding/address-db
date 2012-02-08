<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('helper/Table.php');

class Missing {
	public function __construct($filter) {
		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';
		$erg = mysql_query($sql);

		$this->table = new Table($erg);
	}

	public function html() {
		return $this->table->html();
	}
}

?>
