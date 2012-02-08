<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Prefix {
	public static function select_string_prafix ($id) {
		$sql = 'SELECT prafix FROM ad_prafixe WHERE prafix_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['prafix'];
		}

		else
			return '-';
	}

	public static function select_alle_prafixe () {
		$sql = 'SELECT * FROM ad_prafixe ORDER BY prafix;';
		$erg = mysql_query($sql);
		return $erg;
	}
}
?>
