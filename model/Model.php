<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Model {
	/**
	 * Performs the MySQL query, retrieves the results and returns a single
	 * nested array.
	 *
	 * @param string $sql SQL query.
	 * @return array Results array.
	 */
	public static function sql_to_array($sql) {
		$result = array();

		$erg = mysql_query($sql);
		echo mysql_error();
		while ($l = mysql_fetch_assoc($erg)) {
			$result[] = $l;
		}

		return $result;
	}
}
