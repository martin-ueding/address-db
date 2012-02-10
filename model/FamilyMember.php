<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to family members.
 *
 * @package model
 */
class FamilyMember {
	public static function get_name($id) {
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$id.';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			return $name['fmg'];
		}
	}

	public static function select_alle_fmg () {
		$sql = 'SELECT * FROM ad_fmg ORDER BY fmg;';
		$erg = mysql_query($sql);
		return $erg;
	}
}
