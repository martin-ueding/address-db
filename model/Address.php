<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Address {
	public static function adresse_mehrfach_benutzt ($id) {
		$sql = 'SELECT * FROM ad_per WHERE adresse_r='.$id.';';
		$erg = mysql_query($sql);
		return mysql_num_rows($erg) > 1;
	}
}
?>
