<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');

/**
 * Access to persons.
 */
class Person {
	/**
	 * Gives a relation to a person.
	 *
	 * @param int $id entry id
	 * @return mixed query result
	 * */
	public static function select_person_id ($id) {
		$sql = 'SELECT * FROM ad_per WHERE p_id='.$id.';';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_person_alles ($id) {
		$filter = new Filter();
		$filter->add_address();
		$filter->add_where('p_id = '.$id);

		$erg = $filter->get_erg();
		return $erg;
	}

	public static function delete_person_id ($id) {
		$sql = 'DELETE FROM ad_per WHERE p_id='.$id.';';
		mysql_query($sql);
		$mugshot_path = '_mugshots/per'.$id.'.jpg';
		if (file_exists($mugshot_path)) {
			unlink($mugshot_path);
		}
	}

	public static function verbindung_besteht ($person, $gruppe) {
		$sql = 'SELECT * FROM ad_glinks '.
			'WHERE person_lr='.$person.' && gruppe_lr='.$gruppe.';';
		$erg = mysql_query($sql);

		return mysql_num_rows($erg) != 0;
	}

	public static function verbindung_besteht_fmg ($person, $fmg) {
		$sql = 'SELECT * FROM ad_flinks '.
			'WHERE person_lr='.$person.' && fmg_lr='.$fmg.';';
		$erg = mysql_query($sql);

		return mysql_num_rows($erg) != 0;
	}

	public static function select_gruppen_zu_person ($id) {
		$sql = 'SELECT * FROM ad_gruppen, ad_glinks '.
			'WHERE g_id=gruppe_lr && person_lr='.$id.'  '.
			'ORDER BY gruppe;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_fmg_zu_person ($id) {
		$sql = 'SELECT * FROM ad_fmg, ad_flinks '.
			'WHERE fmg_id=fmg_lr && person_lr='.$id.'  '.
			'ORDER BY fmg;';
		$erg = mysql_query($sql);
		return $erg;
	}
}
?>
