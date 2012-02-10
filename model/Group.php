<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Access to groups.
 *
 * @package model
 */
class Group {
	public static function get_name($id) {
		$sql = 'SELECT gruppe FROM ad_gruppen WHERE g_id = '.$id.';';
		$erg = mysql_query($sql);
		if ($l = mysql_fetch_assoc($erg)) {
			return $l['gruppe'];
		}
	}

	public static function select_alle_gruppen () {
		$sql = 'SELECT * FROM ad_gruppen ORDER BY gruppe;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function gruppe_ist_nicht_leer ($id) {
		if (isset($_SESSION['f']) && $_SESSION['f'] != 0)
			$sql = 'SELECT * FROM ad_flinks '.
			'LEFT JOIN ad_per ON p_id=ad_flinks.person_lr '.
			'LEFT JOIN ad_glinks ON ad_glinks.person_lr=p_id '.
			'LEFT JOIN ad_gruppen ON g_id=gruppe_lr '.
			'WHERE fmg_lr='.$_SESSION['f'].' && g_id='.$id.';';
		else
			$sql = 'SELECT * FROM ad_glinks '.
			'WHERE gruppe_lr='.$id.';';
		$erg = mysql_query($sql);
		if (mysql_error() != "") {
			echo $sql;
			echo '<br />';
			echo mysql_error();
		}
		return mysql_num_rows($erg) > 0;
	}
}
