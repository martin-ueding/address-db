<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

class Person {
	public static function delete_person_id ($id) {
		$sql = 'DELETE FROM ad_per WHERE p_id='.$id.';';
		mysql_query($sql);
		$mugshot_path = '_mugshots/per'.$id.'.jpg';
		if (file_exists($mugshot_path)) {
			unlink($mugshot_path);
		}
	}
}
