<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');

/**
 * Class with several database queries.
 *
 * @author Martin Ueding <dev@martin-ueding.de>
 */
class Queries {
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
		$filter->add_join('LEFT JOIN ad_adressen ON adresse_r = ad_id');
		$filter->add_join('LEFT JOIN ad_anreden ON anrede_r = a_id');
		$filter->add_join('LEFT JOIN ad_laender ON land_r = l_id');
		$filter->add_join('LEFT JOIN ad_orte ON ort_r = o_id');
		$filter->add_join('LEFT JOIN ad_plz ON plz_r = plz_id');
		$filter->add_join('LEFT JOIN ad_prafixe ON prafix_r = prafix_id');
		$filter->add_join('LEFT JOIN ad_suffixe ON suffix_r = s_id');
		$filter->add_where('p_id = '.$id);

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().';';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_plzid_plz ($plz) {
		$sql = 'SELECT plz_id FROM ad_plz WHERE plz='. $plz.';';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_ortid_ort ($ort) {
		$sql = 'SELECT o_id FROM ad_orte WHERE ortsname="'.$ort.'";';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_landid_land ($land) {
		$sql = 'SELECT l_id FROM ad_laender WHERE land="'.$land.'";';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_anreden () {
		$sql = 'SELECT * FROM ad_anreden ORDER BY anrede;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_prafixe () {
		$sql = 'SELECT * FROM ad_prafixe ORDER BY prafix;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_suffixe () {
		$sql = 'SELECT * FROM ad_suffixe ORDER BY suffix;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_plz () {
		$sql = 'SELECT * FROM ad_plz ORDER BY plz;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_orte () {
		$sql = 'SELECT * FROM ad_orte ORDER BY ortsname;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_laender () {
		$sql = 'SELECT * FROM ad_laender ORDER BY land;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_alle_vorwahlen () {
		$sql = 'SELECT * FROM ad_vorwahlen ORDER BY vorwahl;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function select_string_anrede ($id) {
		$sql = 'SELECT anrede FROM ad_anreden WHERE a_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['anrede'];
		}

		else
			return '-';
	}

	public static function select_string_prafix ($id) {
		$sql = 'SELECT prafix FROM ad_prafixe WHERE prafix_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['prafix'];
		}

		else
			return '-';
	}

	/**
	 * Gives the suffix string to an id.
	 *
	 * @param int $id suffix id
	 * @return string suffix
	 * */
	public static function select_string_suffix ($id) {
		$sql = 'SELECT suffix FROM ad_suffixe WHERE s_id='.$id.';';
		$erg = mysql_query($sql);

		if (mysql_num_rows($erg) == 1) {
			$l = mysql_fetch_assoc($erg);
			return $l['suffix'];
		}

		else {
			return '-';
		}
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

	public static function select_alle_fmg () {
		$sql = 'SELECT * FROM ad_fmg ORDER BY fmg;';
		$erg = mysql_query($sql);
		return $erg;
	}

	public static function get_vwid ($text, $id) {
		if (empty($text))
			return $id;
		else {
			$erg = Queries::select_vw_vw($text);
			if (mysql_num_rows($erg) == 0) {
				return Queries::insert_vw($text);
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

	public static function insert_plz ($plz) {
		$sql = 'INSERT INTO ad_plz SET plz='.$plz.';';
		mysql_query($sql);
		return mysql_insert_id();
	}

	public static function insert_ort ($ort) {
		$sql = 'INSERT INTO ad_orte SET ortsname="'.$ort.'";';
		mysql_query($sql);
		return mysql_insert_id();
	}

	public static function insert_land ($land) {
		$sql = 'INSERT INTO ad_laender SET land="'.$land.'";';
		mysql_query($sql);
		return mysql_insert_id();
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

	public static function adresse_mehrfach_benutzt ($id) {
		$sql = 'SELECT * FROM ad_per WHERE adresse_r='.$id.';';
		$erg = mysql_query($sql);
		return mysql_num_rows($erg) > 1;
	}


	public static function delete_familie_id ($id) {
		$sql = 'DELETE FROM ad_fam WHERE f_id='.$id.';';
		mysql_query($sql);
	}

}

?>
