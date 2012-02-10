<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to countries.
 *
 * @package model
 */
class Country {
	public static function select_landid_land ($land) {
		$sql = 'SELECT l_id FROM ad_laender WHERE land="'.$land.'";';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_laender () {
		$sql = 'SELECT * FROM ad_laender ORDER BY land;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function insert_land ($land) {
		$sql = 'INSERT INTO ad_laender SET land="'.$land.'";';
		mysql_query($sql);
		return mysql_insert_id();
	}
}
?>
