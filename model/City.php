<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to cities.
 */
class City {
	public static function select_ortid_ort ($ort) {
		$sql = 'SELECT o_id FROM ad_orte WHERE ortsname="'.$ort.'";';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_orte () {
		$sql = 'SELECT * FROM ad_orte ORDER BY ortsname;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function insert_ort ($ort) {
		$sql = 'INSERT INTO ad_orte SET ortsname="'.$ort.'";';
		mysql_query($sql);
		return mysql_insert_id();
	}
}
?>
