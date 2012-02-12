<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('components/Filter.php');
require_once('model/Model.php');

/**
 * Access to groups.
 */
class Group extends Model {
	public static function get_name($id) {
		$sql = 'SELECT name FROM ad_groups WHERE id = '.$id.';';
		$erg = mysql_query($sql);
		echo mysql_error();
		if ($l = mysql_fetch_assoc($erg)) {
			return $l['name'];
		}
	}

	public static function get_all() {
		$sql = 'SELECT id, name FROM ad_groups ORDER BY name;';
		return Model::sql_to_array($sql);
	}

	public static function gruppe_ist_nicht_leer ($id) {
		$filter = new Filter($_SESSION['f'], 0);
		$filter->add_where('group_id = '.$id);
		$sql = 'SELECT * FROM ad_groups_persons '.$filter->join().' WHERE '.$filter->where().';';
		$erg = mysql_query($sql);
		if (mysql_error() != "") {
			echo $sql;
			echo '<br />';
			echo mysql_error();
		}
		return mysql_num_rows($erg) > 0;
	}
}
