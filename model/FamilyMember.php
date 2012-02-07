<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class FamilyMember {
	public static function get_name($id) {
		$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$id.';';
		$name_erg = mysql_query($name_sql);
		if ($name = mysql_fetch_assoc($name_erg)) {
			return $name['fmg'];
		}
	}
}
