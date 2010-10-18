<?PHP

/* Das hier ist die Funktionsdatei mit allen Abfragen, die es in der Adressverwaltung gibt. */

$debug = true;

if (empty($dbh)) {
	echo '<br /><b>Warnung:</b> abfragen.inc.php braucht die Datenbank.';
}

function handybetreiber ($vw) {
	switch ($vw) {
		case "0160": case "0170": case "0171": case "0175": case "0151":
			return "(T-Mobile)";
		case "0162": case "0172": case "0173": case "0174": case "0152":
			return "(Vodafone)";
		case "0163": case "0177": case "0178": case "0155": case "0157":
			return "(E-Plus)";
		case "0176": case "0179": case "0159":
			return "(O2)";
	}
}

function sternzeichen ($tag, $monat) {
	$tagimmonat = date("z", mktime(0, 0, 0, $monat, $tag, 2001));
	
	if (0 <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 1, 21, 2001)))
		return "Steinbock";
	
	if (date("z", mktime(0, 0, 0, 1, 21, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 2, 20, 2001)))
		return "Wassermann";
	
	if (date("z", mktime(0, 0, 0, 2, 20, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 3, 21, 2001)))
		return "Fische";
	
	if (date("z", mktime(0, 0, 0, 4, 21, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 5, 21, 2001)))
		return "Stier";
	
	if (date("z", mktime(0, 0, 0, 5, 21, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 6, 22, 2001)))
		return "Zwillinge";
	
	if (date("z", mktime(0, 0, 0, 6, 22, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 7, 23, 2001)))
		return "Krebs";
	
	if (date("z", mktime(0, 0, 0, 7, 23, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 8, 24, 2001)))
		return "L&ouml;";
	
	if (date("z", mktime(0, 0, 0, 8, 24, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 9, 24, 2001)))
		return "Jungfrau";
	
	if (date("z", mktime(0, 0, 0, 9, 24, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 10, 24, 2001)))
		return "Waage";
	
	if (date("z", mktime(0, 0, 0, 10, 24, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 11, 23, 2001)))
		return "Skorpion";
	
	if (date("z", mktime(0, 0, 0, 11, 23, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 12, 22, 2001)))
		return "Sch&uuml;tze";
		
	if (date("z", mktime(0, 0, 0, 12, 22, 2001)) <= $tagimmonat && $tagimmonat < date("z", mktime(0, 0, 0, 12, 31, 2001)))
		return "Steinboch";
}


/* SELECT-GRUPPE
 *
 * Diese Funktionen liefern immer eine Relation mit den Daten zur&uuml;ck.
 */


// &Uuml;berarbeiten!!
function finde_personen_zu_familie ($id) {
	$sql = 'SELECT * FROM ad_per WHERE familie_r='.$id.' ORDER BY geb_j, geb_m;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_person_id ($id) {
	$sql = 'SELECT * FROM ad_per WHERE p_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_person_alles ($id) {
	$sql = 'SELECT * FROM ad_per, ad_adressen, ad_orte, ad_plz, ad_laender, ad_anreden, ad_prafixe, ad_suffixe WHERE p_id='.$id.' && adresse_r=ad_id && ort_r=o_id && plz_r=plz_id && land_r=l_id && anrede_r=a_id && prafix_r=prafix_id && suffix_r=s_id;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_plzid_plz ($plz) {
	$sql = 'SELECT plz_id FROM ad_plz WHERE plz='. $plz.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_ortid_ort ($ort) {
	$sql = 'SELECT o_id FROM ad_orte WHERE ortsname="'.$ort.'";';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_landid_land ($land) {
	$sql = 'SELECT l_id FROM ad_laender WHERE land="'.$land.'";';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_anreden () {
	$sql = 'SELECT * FROM ad_anreden ORDER BY anrede;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_prafixe () {
	$sql = 'SELECT * FROM ad_prafixe ORDER BY prafix;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_suffixe () {
	$sql = 'SELECT * FROM ad_suffixe ORDER BY suffix;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_plz () {
	$sql = 'SELECT * FROM ad_plz ORDER BY plz;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_orte () {
	$sql = 'SELECT * FROM ad_orte ORDER BY ortsname;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_laender () {
	$sql = 'SELECT * FROM ad_laender ORDER BY land;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_vorwahlen () {
	$sql = 'SELECT * FROM ad_vorwahlen ORDER BY vorwahl;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_string_anrede ($id) {
	$sql = 'SELECT anrede FROM ad_anreden WHERE a_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();

	if (mysql_num_rows($erg) == 1) {
		$l = mysql_fetch_assoc($erg);
		return $l['anrede'];
	}
	
	else
		return '-';
}

function select_string_prafix ($id) {
	$sql = 'SELECT prafix FROM ad_prafixe WHERE prafix_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();

	if (mysql_num_rows($erg) == 1) {
		$l = mysql_fetch_assoc($erg);
		return $l['prafix'];
	}
	
	else
		return '-';
}

function select_string_suffix ($id) {
	$sql = 'SELECT suffix FROM ad_suffixe WHERE s_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();

	if (mysql_num_rows($erg) == 1) {
		$l = mysql_fetch_assoc($erg);
		return $l['suffix'];
	}
	
	else
		return '-';
}

// &Uuml;berarbeiten!!
function finde_familien_id_zu_person ($id) {
	$sql = 'SELECT familie_r FROM ad_per WHERE p_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();

	$l = mysql_fetch_assoc($erg);
	return $l['familie_r'];
}

function select_vw_id ($id) {
	$sql = 'SELECT vorwahl FROM ad_vorwahlen WHERE v_id='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();

	$l = mysql_fetch_assoc($erg);
	return $l['vorwahl'];
}

function select_vw_vw ($vw) {
	$sql = 'SELECT v_id FROM ad_vorwahlen WHERE vorwahl="'.$vw.'";';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_gruppen_zu_person ($id) {
	$sql = 'SELECT * FROM ad_gruppen, ad_glinks WHERE g_id=gruppe_lr && person_lr='.$id.'  ORDER BY gruppe;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_fmg_zu_person ($id) {
	$sql = 'SELECT * FROM ad_fmg, ad_flinks WHERE fmg_id=fmg_lr && person_lr='.$id.'  ORDER BY fmg;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_gruppen () {
	$sql = 'SELECT * FROM ad_gruppen ORDER BY gruppe;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function select_alle_fmg () {
	$sql = 'SELECT * FROM ad_fmg ORDER BY fmg;';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return $erg;
}

function get_vwid ($text, $id) {
	if (empty($text))
		return $id;
	else {
		$erg = select_vw_vw($text);
		if (mysql_num_rows($erg) == 0) {
			return insert_vw($text);
		}
		else {
			$l = mysql_fetch_assoc($erg);
			return $l['v_id'];
		}
	}
}


/* INSERT-GRUPPE
 *
 * Diese Funktionen schreiben die Daten in die Datenbank und liefern die neue ID zur&uuml;ck.
 */

function insert_vw ($vw) {
	$sql = 'INSERT INTO ad_vorwahlen SET vorwahl="'.$vw.'";';
	mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return mysql_insert_id();
}

function insert_plz ($plz) {
	$sql = 'INSERT INTO ad_plz SET plz='.$plz.';';
	mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return mysql_insert_id();
}

function insert_ort ($ort) {
	$sql = 'INSERT INTO ad_orte SET ortsname="'.$ort.'";';
	mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return mysql_insert_id();
}

function insert_land ($land) {
	$sql = 'INSERT INTO ad_laender SET land="'.$land.'";';
	mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return mysql_insert_id();
}

function verbindung_besteht ($person, $gruppe) {
	$sql = 'SELECT * FROM ad_glinks WHERE person_lr='.$person.' && gruppe_lr='.$gruppe.';';
	$erg = mysql_query($sql);

	return mysql_num_rows($erg) != 0;
}

function verbindung_besteht_fmg ($person, $fmg) {
	$sql = 'SELECT * FROM ad_flinks WHERE person_lr='.$person.' && fmg_lr='.$fmg.';';
	$erg = mysql_query($sql);

	return mysql_num_rows($erg) != 0;
}

function gruppe_ist_nicht_leer ($id) {
	if ($_SESSION['f'] != 0)
		$sql = 'SELECT * FROM ad_flinks LEFT JOIN ad_per ON p_id=ad_flinks.person_lr LEFT JOIN ad_glinks ON ad_glinks.person_lr=p_id LEFT JOIN ad_gruppen ON g_id=gruppe_lr WHERE fmg_lr='.$_SESSION['f'].' && g_id='.$id.';';
	else
		$sql = 'SELECT * FROM ad_glinks WHERE gruppe_lr='.$id.';';
	$erg = mysql_query($sql);
	if (mysql_error() != "") {
		echo $sql;
		echo '<br />';
		echo mysql_error();
	}
	return mysql_num_rows($erg) > 0;

}

function adresse_mehrfach_benutzt ($id) {
	$sql = 'SELECT * FROM ad_per WHERE adresse_r='.$id.';';
	$erg = mysql_query($sql);
	if ($debug)
		echo mysql_error();
	return mysql_num_rows($erg) > 1;
}


/* UPDATE */

/* DELETE */

function delete_familie_id ($id) {
	$sql = 'DELETE FROM ad_fam WHERE f_id='.$id.';';
	mysql_query($sql);
}

function delete_person_id ($id) {
	$sql = 'DELETE FROM ad_per WHERE p_id='.$id.';';
	mysql_query($sql);
}


?>
