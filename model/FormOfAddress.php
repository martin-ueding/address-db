<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to forms of address.
 */
class FormOfAddress {
	public static function select_string_anrede ($id) {
		$sql = 'SELECT anrede FROM ad_anreden WHERE a_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['anrede'];
		}

		else
			return '-';
	}

	public static function select_alle_anreden () {
		$sql = 'SELECT * FROM ad_anreden ORDER BY anrede;';
		$erg = mysql_query($sql);
		return $erg;
	}
}
?>
