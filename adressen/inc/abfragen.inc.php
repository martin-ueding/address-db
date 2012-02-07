<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

/**
 * Class with several database queries.
 *
 * @author Martin Ueding <dev@martin-ueding.de>
 */
class Queries {

	/**
	 * Finds the cell phone carrier to an area code.
	 *
	 * @param string $vw area code
	 * @return string carrier name
	 */
	public static function handybetreiber($vw) {
		switch ($vw) {
		case '+49-160': case '+49-170': case '+49-171': case '+49-175':
		case '+49-151':
			return '(T-Mobile)';
		case '+49-162': case '+49-172': case '+49-173': case '+49-174':
		case '+49-152':
			return '(Vodafone)';
		case '+49-163': case '+49-177': case '+49-178': case '+49-155':
		case '+49-157':
			return '(E-Plus)';
		case '+49-176': case '+49-179': case '+49-159':
			return '(O2)';
		}
	}

	/**
	 * Finds the zodiac sign to a given date.
	 *
	 * @param int $tag day
	 * @param int $monat month
	 * @return string zodiac sign
	 */
	public static function sternzeichen($tag, $monat) {
		$tagimmonat = date('z', mktime(0, 0, 0, $monat, $tag, 2001));

		if (0 <= $tagimmonat && $tagimmonat <
			date('z', mktime(0, 0, 0, 1, 21, 2001)))
			return _('Capricorn');

		if (date('z', mktime(0, 0, 0, 1, 21, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 2, 20, 2001)))
			return _('Aquarius');

		if (date('z', mktime(0, 0, 0, 2, 20, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 3, 20, 2001)))
			return _('Pisces');

		if (date('z', mktime(0, 0, 0, 3, 20, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 4, 21, 2001)))
			return _('Aries');

		if (date('z', mktime(0, 0, 0, 4, 21, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 5, 21, 2001)))
			return _('Taurus');

		if (date('z', mktime(0, 0, 0, 5, 21, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 6, 22, 2001)))
			return _('Gemini');

		if (date('z', mktime(0, 0, 0, 6, 22, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 7, 23, 2001)))
			return _('Cancer');

		if (date('z', mktime(0, 0, 0, 7, 23, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 8, 24, 2001)))
			return _('Leo');

		if (date('z', mktime(0, 0, 0, 8, 24, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 9, 24, 2001)))
			return _('Virgo');

		if (date('z', mktime(0, 0, 0, 9, 24, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 10, 24, 2001)))
			return _('Libra');

		if (date('z', mktime(0, 0, 0, 10, 24, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 11, 23, 2001)))
			return _('Scorpio');

		if (date('z', mktime(0, 0, 0, 11, 23, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 12, 22, 2001)))
			return _('Sagittarius');

		if (date('z', mktime(0, 0, 0, 12, 22, 2001)) <= $tagimmonat && 
			$tagimmonat < date('z', mktime(0, 0, 0, 12, 31, 2001)))
			return _('Capricorn');
	}


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
		// XXX use JOIN
		$sql = 'SELECT * '.
			'FROM ad_per, ad_adressen, ad_orte, ad_plz, ad_laender, '.
				'ad_anreden, ad_prafixe, ad_suffixe '.
			'WHERE p_id='.$id.' && adresse_r=ad_id && ort_r=o_id && '.
				'plz_r=plz_id && land_r=l_id && anrede_r=a_id && '.
				'prafix_r=prafix_id && suffix_r=s_id;';
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

	public static function select_alle_gruppen () {
		$sql = 'SELECT * FROM ad_gruppen ORDER BY gruppe;';
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

	public static function adresse_mehrfach_benutzt ($id) {
		$sql = 'SELECT * FROM ad_per WHERE adresse_r='.$id.';';
		$erg = mysql_query($sql);
		return mysql_num_rows($erg) > 1;
	}


	public static function delete_familie_id ($id) {
		$sql = 'DELETE FROM ad_fam WHERE f_id='.$id.';';
		mysql_query($sql);
	}

	public static function delete_person_id ($id) {
		$sql = 'DELETE FROM ad_per WHERE p_id='.$id.';';
		mysql_query($sql);
		$mugshot_path = '_mugshots/per'.$id.'.jpg';
		if (file_exists($mugshot_path)) {
			unlink($mugshot_path);
		}
	}
}

?>
