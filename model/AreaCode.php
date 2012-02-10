<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to telephone area codes.
 *
 * @package model
 */
class AreaCode {
	public static function select_alle_vorwahlen () {
		$sql = 'SELECT * FROM ad_vorwahlen ORDER BY vorwahl;';
		$erg = mysql_query($sql);
		return $erg;
	}

	/**
	 * Finds an area code to a given id
	 *
	 * @param int $id area code id
	 * @return string area code
	 * */
	public static function select_vw_id ($id) {
		$sql = 'SELECT vorwahl FROM ad_vorwahlen WHERE v_id='.$id.';';
		$erg = mysql_query($sql);

		$l = mysql_fetch_assoc($erg);
		return $l['vorwahl'];
	}

	public static function select_vw_vw ($vw) {
		$sql = 'SELECT v_id FROM ad_vorwahlen WHERE vorwahl="'.$vw.'";';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function get_vwid ($text, $id) {
		if (empty($text))
			return $id;
		else {
			$erg = AreaCode::select_vw_vw($text);
			if (mysql_num_rows($erg) == 0) {
				return AreaCode::insert_vw($text);
			}
			else {
				$l = mysql_fetch_assoc($erg);
				return $l['v_id'];
			}
		}
	}

	public static function insert_vw ($vw) {
		$sql = 'INSERT INTO ad_vorwahlen SET vorwahl="'.$vw.'";';
		mysql_query($sql);
		return mysql_insert_id();
	}
}
