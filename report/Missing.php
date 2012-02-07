<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Table.php');

class Missing {
	public function __construct($filter, $from_with_get) {
		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';
		$erg = mysql_query($sql);

		$this->table = new Table($erg, $from_with_get);
	}

	public function html() {
		return $this->table->html();
	}
}

?>
