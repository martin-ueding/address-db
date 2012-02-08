<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Suffix {
	/**
	 * Gives the suffix string to an id.
	 *
	 * @param int $id suffix id
	 * @return string suffix
	 * */
	public static function select_string_suffix ($id) {
		$sql = 'SELECT suffix FROM ad_suffixe WHERE s_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['suffix'];
		}

		else {
			return '-';
		}
	}

	public static function select_alle_suffixe () {
		$sql = 'SELECT * FROM ad_suffixe ORDER BY suffix;';
		$erg = mysql_query($sql);
		return $erg;
	}
}
