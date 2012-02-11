<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to postral codes.
 */
class PostralCode {
	public static function select_plzid_plz ($plz) {
		$sql = 'SELECT plz_id FROM ad_plz WHERE plz='. $plz.';';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_plz () {
		$sql = 'SELECT * FROM ad_plz ORDER BY plz;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function insert_plz ($plz) {
		$sql = 'INSERT INTO ad_plz SET plz='.$plz.';';
		mysql_query($sql);
		return mysql_insert_id();
	}
}
?>
