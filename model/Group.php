<?php
# Copyright (c) 2012 Martin Ueding <dev@martin-ueding.de>

class Group {
	public static function get_name($id) {
		$sql = 'SELECT gruppe FROM ad_gruppen WHERE g_id = '.$id.';';
		$erg = mysql_query($sql);
		if ($l = mysql_fetch_assoc($erg)) {
			return $l['gruppe'];
		}
	}
}
