<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('model/Model.php');

/**
 * Access to members.
 */
class Member extends Model {
	public static function get_name($id) {
		$name_sql = 'SELECT name FROM ad_members WHERE id='.$id.';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			return $name['name'];
		}
	}

	/**
	 * @return array
	 */
	public static function get_all() {
		$sql = 'SELECT id, name FROM ad_members ORDER BY name;';
		return Model::sql_to_array($sql);
	}
}
