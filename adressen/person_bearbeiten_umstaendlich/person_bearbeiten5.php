<?PHP
session_start();

include('../inc/varclean.inc.php');
include('../inc/login.inc.php');
include('../inc/abfragen.inc.php');

$sql = 'UPDATE ad_per SET';

/* Name und Geburtstag */

$sql .= ' anrede_r='.$_SESSION['anrede_r'];
$sql .= ', prafix_r='.$_SESSION['prafix_r'];
$sql .= ', vorname="'.$_SESSION['vorname'].'"';
$sql .= ', mittelname="'.$_SESSION['mittelname'].'"';
$sql .= ', nachname="'.$_SESSION['nachname'].'"';
$sql .= ', suffix_r='.$_SESSION['suffix_r'];
$sql .= ', geburtsname="'.$_SESSION['geburtsname'].'"';

$sql .= ', geb_t='.$_SESSION['geb_t'];
$sql .= ', geb_m='.$_SESSION['geb_m'];
$sql .= ', geb_j='.$_SESSION['geb_j'];




/* Adresse */

/* Wenn die Adresse nur f&uuml;r einen ge&auml;ndert wird */
if ($_SESSION['werziehtum'] == 'einer') {
	
	/* Wenn die Adresse manuell eingegeben wurde */
	if ($_SESSION['adresswahl'] == 'manuell') {
		$sql_ad = 'INSERT INTO ad_adressen SET';
		$sql_ad .= ' strasse="'.$_SESSION['strasse'].'"';
	
	
		/* PLZ */
		if (!empty($_SESSION['plz'])) {
			$erg = select_plzid_plz($_SESSION['plz']);
		
			if (mysql_num_rows($erg) == 0)
				$plz_id = insert_plz($_SESSION['plz']);
		
			else if ($l = mysql_fetch_assoc($erg))
				$plz_id = $l['plz_id'];
		
			$sql_ad .= ', plz_r='.$plz_id;
		}
		else
			$sql_ad .= ', plz_r='.$_SESSION['plz_r'];
	
	
		/* Ort */
		if (!empty($_SESSION['ort'])) {
			$erg = select_ortid_ort($_SESSION['ort']);
		
			if (mysql_num_rows($erg) == 0)
				$ort_id = insert_ort($_SESSION['ort']);
		
			else if ($l = mysql_fetch_assoc($erg))
				$ort_id = $l['o_id'];
		
			$sql_ad .= ', ort_r='.$ort_id;
		}
		else
			$sql_ad .=', ort_r='.$_SESSION['ort_r'];
	
	
	
		/* Land */
		if (!empty($_SESSION['land'])) {
			$erg = select_landid_land($_SESSION['land']);
		
			if (mysql_num_rows($erg) == 0)
				$land_id = insert_land($_SESSION['land']);
		
		
			else if ($l = mysql_fetch_assoc($erg))
				$land_id = $l['l_id'];
			
			$sql_ad .= ', land_r='.$land_id.'';
		}
		else
			$sql_ad .= ', land_r='.$_SESSION['land_r'];
	
	
		$sql_ad .= ', ftel_privat="'.$_SESSION['ftel_privat'].'"';
		$sql_ad .= ', ftel_arbeit="'.$_SESSION['ftel_arbeit'].'"';
		$sql_ad .= ', ftel_mobil="'.$_SESSION['ftel_mobil'].'"';
		$sql_ad .= ', ftel_fax="'.$_SESSION['ftel_fax'].'"';
		$sql_ad .= ', ftel_aux="'.$_SESSION['ftel_aux'].'"';
	
		$sql_ad .= ', fvw_privat_r='.get_vwid($_SESSION['fvw_privat_eingabe'], $_SESSION['fvw_privat_id']);
		$sql_ad .= ', fvw_arbeit_r='.get_vwid($_SESSION['fvw_arbeit_eingabe'], $_SESSION['fvw_arbeit_id']);
		$sql_ad .= ', fvw_mobil_r='.get_vwid($_SESSION['fvw_mobil_eingabe'], $_SESSION['fvw_mobil_id']);
		$sql_ad .= ', fvw_fax_r='.get_vwid($_SESSION['fvw_fax_eingabe'], $_SESSION['fvw_fax_id']);
		$sql_ad .= ', fvw_aux_r='.get_vwid($_SESSION['fvw_aux_eingabe'], $_SESSION['fvw_aux_id']);
		
	
		mysql_query($sql_ad);
		$sql .= ', adresse_r='.mysql_insert_id();
	}
	
	/* Wenn eine Adresse aus dem Select ausgesucht wordern ist */
	else {
		$sql .= ', adresse_r='.$_SESSION['adresse_r'];
	}
}

/* Wenn die Adresse f&uuml;r alle ge&auml;ndert wird */
else if ($_SESSION['werziehtum'] == 'alle') {
	
	/* Wenn die Adresse manuell eingegeben wurde */
	if ($_SESSION['adresswahl'] == 'manuell') {
		/* Wenn der zuvor ausgesuchte Haushalt 1 war, dann wir ein neuer anlegelgt. */
		if ($_SESSION['haushalt'] == 1) {
			$sql_ad = 'INSERT INTO ad_adressen SET';
			$sql_ad .= ' strasse="'.$_SESSION['strasse'].'"';
		
		
			/* PLZ */
			if (!empty($_SESSION['plz'])) {
				$erg = select_plzid_plz($_SESSION['plz']);
			
				if (mysql_num_rows($erg) == 0)
					$plz_id = insert_plz($_SESSION['plz']);
			
				else if ($l = mysql_fetch_assoc($erg))
					$plz_id = $l['plz_id'];
			
				$sql_ad .= ', plz_r='.$plz_id;
			}
			else
				$sql_ad .= ', plz_r='.$_SESSION['plz_r'];
		
		
			/* Ort */
			if (!empty($_SESSION['ort'])) {
				$erg = select_ortid_ort($_SESSION['ort']);
			
				if (mysql_num_rows($erg) == 0)
					$ort_id = insert_ort($_SESSION['ort']);
			
				else if ($l = mysql_fetch_assoc($erg))
					$ort_id = $l['o_id'];
			
				$sql_ad .= ', ort_r='.$ort_id;
			}
			else
				$sql_ad .=', ort_r='.$_SESSION['ort_r'];
		
		
		
			/* Land */
			if (!empty($_SESSION['land'])) {
				$erg = select_landid_land($_SESSION['land']);
			
				if (mysql_num_rows($erg) == 0)
					$land_id = insert_land($_SESSION['land']);
			
			
				else if ($l = mysql_fetch_assoc($erg))
					$land_id = $l['l_id'];
				
				$sql_ad .= ', land_r='.$land_id.'';
			}
			else
				$sql_ad .= ', land_r='.$_SESSION['land_r'];
		
		
			$sql_ad .= ', ftel_privat="'.$_SESSION['ftel_privat'].'"';
			$sql_ad .= ', ftel_arbeit="'.$_SESSION['ftel_arbeit'].'"';
			$sql_ad .= ', ftel_mobil="'.$_SESSION['ftel_mobil'].'"';
			$sql_ad .= ', ftel_fax="'.$_SESSION['ftel_fax'].'"';
			$sql_ad .= ', ftel_aux="'.$_SESSION['ftel_aux'].'"';
		
			$sql_ad .= ', fvw_privat_r='.get_vwid($_SESSION['fvw_privat_eingabe'], $_SESSION['fvw_privat_id']);
			$sql_ad .= ', fvw_arbeit_r='.get_vwid($_SESSION['fvw_arbeit_eingabe'], $_SESSION['fvw_arbeit_id']);
			$sql_ad .= ', fvw_mobil_r='.get_vwid($_SESSION['fvw_mobil_eingabe'], $_SESSION['fvw_mobil_id']);
			$sql_ad .= ', fvw_fax_r='.get_vwid($_SESSION['fvw_fax_eingabe'], $_SESSION['fvw_fax_id']);
			$sql_ad .= ', fvw_aux_r='.get_vwid($_SESSION['fvw_aux_eingabe'], $_SESSION['fvw_aux_id']);
			
		
			mysql_query($sql_ad);

			$sql_ad = 'UPDATE ad_per SET adresse_r='.mysql_insert_id().' WHERE adresse_r='.$_SESSION['haushalt'].';';
			mysql_query($sql_ad);
			echo mysql_error();
		}

		
		else {
			$sql_ad = 'UPDATE ad_adressen SET strasse="'.$_SESSION['strasse'].'"';
	
		
			/* PLZ */
			if (!empty($_SESSION['plz'])) {
				$erg = select_plzid_plz($_SESSION['plz']);
			
				if (mysql_num_rows($erg) == 0)
					$plz_id = insert_plz($_SESSION['plz']);
			
				else if ($l = mysql_fetch_assoc($erg))
					$plz_id = $l['plz_id'];
			
				$sql_ad .= ', plz_r='.$plz_id;
			}
			else
				$sql_ad .= ', plz_r='.$_SESSION['plz_r'];
		
		
			/* Ort */
			if (!empty($_SESSION['ort'])) {
				$erg = select_ortid_ort($_SESSION['ort']);
			
				if (mysql_num_rows($erg) == 0)
					$ort_id = insert_ort($_SESSION['ort']);
			
				else if ($l = mysql_fetch_assoc($erg))
					$ort_id = $l['o_id'];
			
				$sql_ad .= ', ort_r='.$ort_id;
			}
			else
				$sql_ad .=', ort_r='.$_SESSION['ort_r'];
		
		
		
			/* Land */
			if (!empty($_SESSION['land'])) {
				$erg = select_landid_land($_SESSION['land']);
			
				if (mysql_num_rows($erg) == 0)
					$land_id = insert_land($_SESSION['land']);
			
			
				else if ($l = mysql_fetch_assoc($erg))
					$land_id = $l['l_id'];
				
				$sql_ad .= ', land_r='.$land_id.'';
			}
			else
				$sql_ad .= ', land_r='.$_SESSION['land_r'];
		
		
			$sql_ad .= ', ftel_privat="'.$_SESSION['ftel_privat'].'"';
			$sql_ad .= ', ftel_arbeit="'.$_SESSION['ftel_arbeit'].'"';
			$sql_ad .= ', ftel_mobil="'.$_SESSION['ftel_mobil'].'"';
			$sql_ad .= ', ftel_fax="'.$_SESSION['ftel_fax'].'"';
			$sql_ad .= ', ftel_aux="'.$_SESSION['ftel_aux'].'"';
		
			$sql_ad .= ', fvw_privat_r='.get_vwid($_SESSION['fvw_privat_eingabe'], $_SESSION['fvw_privat_id']);
			$sql_ad .= ', fvw_arbeit_r='.get_vwid($_SESSION['fvw_arbeit_eingabe'], $_SESSION['fvw_arbeit_id']);
			$sql_ad .= ', fvw_mobil_r='.get_vwid($_SESSION['fvw_mobil_eingabe'], $_SESSION['fvw_mobil_id']);
			$sql_ad .= ', fvw_fax_r='.get_vwid($_SESSION['fvw_fax_eingabe'], $_SESSION['fvw_fax_id']);
			$sql_ad .= ', fvw_aux_r='.get_vwid($_SESSION['fvw_aux_eingabe'], $_SESSION['fvw_aux_id']);
			
			$sql_ad .= ' WHERE ad_id='.$_SESSION['adresse_r'].';';
		
			mysql_query($sql_ad);
		}
	}
	
	/* Wenn eine Adresse aus dem Select ausgesucht wordern ist */
	else {
		$sql_ad = 'UPDATE ad_per SET adresse_r='.$_SESSION['adresse_r'].' WHERE adresse_r='.$_SESSION['haushalt'].';';
		mysql_query($sql_ad);
		echo mysql_error();
	}
}


/* Schritt 3 */

$sql .= ', tel_privat="'.$_SESSION['tel_privat'].'"';
$sql .= ', tel_arbeit="'.$_SESSION['tel_arbeit'].'"';
$sql .= ', tel_mobil="'.$_SESSION['tel_mobil'].'"';
$sql .= ', tel_fax="'.$_SESSION['tel_fax'].'"';
$sql .= ', tel_aux="'.$_SESSION['tel_aux'].'"';

$sql .= ', vw_privat_r='.get_vwid($_SESSION['vw_privat_eingabe'], $_SESSION['vw_privat_id']);
$sql .= ', vw_arbeit_r='.get_vwid($_SESSION['vw_arbeit_eingabe'], $_SESSION['vw_arbeit_id']);
$sql .= ', vw_mobil_r='.get_vwid($_SESSION['vw_mobil_eingabe'], $_SESSION['vw_mobil_id']);
$sql .= ', vw_fax_r='.get_vwid($_SESSION['vw_fax_eingabe'], $_SESSION['vw_fax_id']);
$sql .= ', vw_aux_r='.get_vwid($_SESSION['vw_aux_eingabe'], $_SESSION['vw_aux_id']);


$sql .= ', email_privat="'.$_SESSION['email_privat'].'"';
$sql .= ', email_arbeit="'.$_SESSION['email_arbeit'].'"';
$sql .= ', email_aux="'.$_SESSION['email_aux'].'"';
$sql .= ', hp1="'.$_SESSION['hp1'].'"';
$sql .= ', hp2="'.$_SESSION['hp2'].'"';
$sql .= ', chat_aim="'.$_SESSION['chat_aim'].'"';
$sql .= ', chat_msn="'.$_SESSION['chat_msn'].'"';
$sql .= ', chat_icq="'.$_SESSION['chat_icq'].'"';
$sql .= ', chat_yim="'.$_SESSION['chat_yim'].'"';
$sql .= ', chat_skype="'.$_SESSION['chat_skype'].'"';
$sql .= ', chat_aux="'.$_SESSION['chat_aux'].'"';
$sql .= ', pnotizen="'.$_SESSION['pnotizen'].'"';

$sql .= ' WHERE p_id='.$_SESSION['p_id'].';';

mysql_query($sql);
if (mysql_error() != '') {
	echo 'MySQL-Error: '.mysql_error();
	echo '<br /><br />SQL-Befehl:'.$sql;
}


/* FMG-Bez&uuml;ge */
$sql = 'DELETE FROM ad_flinks WHERE person_lr='.$_SESSION['p_id'].';';
mysql_query($sql);

if (!empty($_SESSION['fmgs'])) {
	foreach ($_SESSION['fmgs'] as $wert) {
		$sql = 'INSERT INTO ad_flinks SET person_lr='.$_SESSION['p_id'].', fmg_lr='.$wert.';';
		mysql_query($sql);
		echo mysql_error();
	}
}


/* Gruppen */
$sql = 'DELETE FROM ad_glinks WHERE person_lr='.$_SESSION['p_id'].';';
mysql_query($sql);

if (!empty($_SESSION['gruppen'])) {
	foreach ($_SESSION['gruppen'] as $wert) {
		$sql = 'INSERT INTO ad_glinks SET person_lr='.$_SESSION['p_id'].', gruppe_lr='.$wert.';';
		mysql_query($sql);
	}
}

session_destroy();

header('location:../personenanzeige.php?id='.$_SESSION['p_id']);


?>