<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Template.php');
require_once('helper/Callto.php');
require_once('helper/Cellphone.php');
require_once('helper/DateFormat.php');
require_once('helper/ZodiacSign.php');
require_once('model/Address.php');
require_once('model/AreaCode.php');
require_once('model/City.php');
require_once('model/Country.php');
require_once('model/Person.php');
require_once('model/PostralCode.php');

include('_config.inc.php');

class PersonController {
	public static function create1() {
		$template = new Template('person_form');

		$template->set('checked_fmgs', array($_SESSION['f']));
		$template->set('checked_groups', array($_SESSION['g']));
		$template->set('form_target', 'person_create2.php');
		$template->set('heading', _('create a new entry'));
		$template->set('person_loop', array());

		echo $template->html();
	}

	public static function create2() {
		// Speichern Gruppe 1
		$anrede_r = $_POST['anrede_r'];
		$prafix_r = $_POST['prafix_r'];
		$vorname = $_POST['vorname'];
		$mittelname = $_POST['mittelname'];
		$nachname = $_POST['nachname'];
		$suffix_r = $_POST['suffix_r'];
		$geburtsname = $_POST['geburtsname'];

		$geb_t = $_POST['geb_t'];
		$geb_m = $_POST['geb_m'];
		$geb_j = $_POST['geb_j'];

		$fmgs = $_POST['fmgs'];
		$gruppen = $_POST['gruppen'];
		$haushalt = 1;



		/* Wenn eine neue Gruppe eingetragen wurde, wird diese jetzt schon in die
		 * Datenbank aufgenommen und steht danach als Haken bereit.
		 */

		if (!empty($_POST['neue_gruppe'])) {
			$sql = 'INSERT INTO ad_gruppen SET gruppe="'.$_POST['neue_gruppe'].'"';
			mysql_query($sql);
			echo mysql_error();
			$gruppen[] = mysql_insert_id();
		}

		// Speichern Gruppe 2

		$adresse_r = $_POST['adresse_r'];
		$adresswahl = $_POST['adresswahl'];


		$ftel_privat = $_POST['ftel_privat'];
		$ftel_arbeit = $_POST['ftel_arbeit'];
		$ftel_mobil = $_POST['ftel_mobil'];
		$ftel_fax = $_POST['ftel_fax'];
		$ftel_aux = $_POST['ftel_aux'];

		$fvw_privat_eingabe = $_POST['fvw_privat_eingabe'];
		$fvw_privat_id = $_POST['fvw_privat_id'];
		$fvw_arbeit_eingabe = $_POST['fvw_arbeit_eingabe'];
		$fvw_arbeit_id = $_POST['fvw_arbeit_id'];
		$fvw_mobil_eingabe = $_POST['fvw_mobil_eingabe'];
		$fvw_mobil_id = $_POST['fvw_mobil_id'];
		$fvw_fax_eingabe = $_POST['fvw_fax_eingabe'];
		$fvw_fax_id = $_POST['fvw_fax_id'];
		$fvw_aux_eingabe = $_POST['fvw_aux_eingabe'];
		$fvw_aux_id = $_POST['fvw_aux_id'];


		$strasse = $_POST['strasse'];
		$plz = $_POST['plz'];
		$ort = $_POST['ort'];
		$land = $_POST['land'];

		$plz_r = $_POST['plz_r'];
		$ort_r = $_POST['ort_r'];
		$land_r = $_POST['land_r'];

		// Speichern Gruppe 3

		$tel_privat = $_POST['tel_privat'];
		$tel_arbeit = $_POST['tel_arbeit'];
		$tel_mobil = $_POST['tel_mobil'];
		$tel_fax = $_POST['tel_fax'];
		$tel_aux = $_POST['tel_aux'];

		$vw_privat_eingabe = $_POST['vw_privat_eingabe'];
		$vw_privat_id = $_POST['vw_privat_id'];
		$vw_arbeit_eingabe = $_POST['vw_arbeit_eingabe'];
		$vw_arbeit_id = $_POST['vw_arbeit_id'];
		$vw_mobil_eingabe = $_POST['vw_mobil_eingabe'];
		$vw_mobil_id = $_POST['vw_mobil_id'];
		$vw_fax_eingabe = $_POST['vw_fax_eingabe'];
		$vw_fax_id = $_POST['vw_fax_id'];
		$vw_aux_eingabe = $_POST['vw_aux_eingabe'];
		$vw_aux_id = $_POST['vw_aux_id'];


		$email_privat = $_POST['email_privat'];
		$email_arbeit = $_POST['email_arbeit'];
		$email_aux = $_POST['email_aux'];

		$hp1 = $_POST['hp1'];
		$hp2 = $_POST['hp2'];

		$chat_aim = $_POST['chat_aim'];
		$chat_msn = $_POST['chat_msn'];
		$chat_icq = $_POST['chat_icq'];
		$chat_yim = $_POST['chat_yim'];
		$chat_skype = $_POST['chat_skype'];
		$chat_aux = $_POST['chat_aux'];


		$pnotizen = $_POST['pnotizen'];



		$sql = 'INSERT INTO ad_per SET';

		/* Name und Geburtstag */

		$sql .= ' anrede_r='.$anrede_r;
		$sql .= ', prafix_r='.$prafix_r;
		$sql .= ', vorname="'.$vorname.'"';
		$sql .= ', mittelname="'.$mittelname.'"';
		$sql .= ', nachname="'.$nachname.'"';
		$sql .= ', suffix_r='.$suffix_r;
		$sql .= ', geburtsname="'.$geburtsname.'"';

		$sql .= ', geb_t='.$geb_t;
		$sql .= ', geb_m='.$geb_m;
		$sql .= ', geb_j='.$geb_j;




		/* Adresse */

		if ($adresswahl == 'manuell') {
			$sql_ad = 'INSERT INTO ad_adressen SET';
			$sql_ad .= ' strasse="'.$strasse.'"';


			/* PLZ */
			if (!empty($plz)) {
				$erg = PostralCode::select_plzid_plz($plz);

				if (mysql_num_rows($erg) == 0)
					$plz_id = PostralCode::insert_plz($plz);

				else if ($l = mysql_fetch_assoc($erg))
					$plz_id = $l['plz_id'];

				$sql_ad .= ', plz_r='.$plz_id;
			}
			else
				$sql_ad .= ', plz_r='.$plz_r;


			/* Ort */
			if (!empty($ort)) {
				$erg = City::select_ortid_ort($ort);

				if (mysql_num_rows($erg) == 0)
					$ort_id = City::insert_ort($ort);

				else if ($l = mysql_fetch_assoc($erg))
					$ort_id = $l['o_id'];

				$sql_ad .= ', ort_r='.$ort_id;
			}
			else
				$sql_ad .=', ort_r='.$ort_r;



			/* Land */
			if (!empty($land)) {
				$erg = Country::select_landid_land($land);

				if (mysql_num_rows($erg) == 0)
					$land_id = Country::insert_land($land);


				else if ($l = mysql_fetch_assoc($erg))
					$land_id = $l['l_id'];

				$sql_ad .= ', land_r='.$land_id.'';
			}
			else
				$sql_ad .= ', land_r='.$land_r;


			$sql_ad .= ', ftel_privat="'.$ftel_privat.'"';
			$sql_ad .= ', ftel_arbeit="'.$ftel_arbeit.'"';
			$sql_ad .= ', ftel_mobil="'.$ftel_mobil.'"';
			$sql_ad .= ', ftel_fax="'.$ftel_fax.'"';
			$sql_ad .= ', ftel_aux="'.$ftel_aux.'"';

			$sql_ad .= ', fvw_privat_r='.AreaCode::get_vwid($fvw_privat_eingabe, $fvw_privat_id);
			$sql_ad .= ', fvw_arbeit_r='.AreaCode::get_vwid($fvw_arbeit_eingabe, $fvw_arbeit_id);
			$sql_ad .= ', fvw_mobil_r='.AreaCode::get_vwid($fvw_mobil_eingabe, $fvw_mobil_id);
			$sql_ad .= ', fvw_fax_r='.AreaCode::get_vwid($fvw_fax_eingabe, $fvw_fax_id);
			$sql_ad .= ', fvw_aux_r='.AreaCode::get_vwid($fvw_aux_eingabe, $fvw_aux_id);


			mysql_query($sql_ad);
			echo mysql_error();
			$sql .= ', adresse_r='.mysql_insert_id();

		}
		else if ($adresse_r != 0) {
			$sql .= ', adresse_r='.$adresse_r;
		}


		/* Schritt 3 */

		$sql .= ', tel_privat="'.$tel_privat.'"';
		$sql .= ', tel_arbeit="'.$tel_arbeit.'"';
		$sql .= ', tel_mobil="'.$tel_mobil.'"';
		$sql .= ', tel_fax="'.$tel_fax.'"';
		$sql .= ', tel_aux="'.$tel_aux.'"';

		$sql .= ', vw_privat_r='.AreaCode::get_vwid($vw_privat_eingabe, $vw_privat_id);
		$sql .= ', vw_arbeit_r='.AreaCode::get_vwid($vw_arbeit_eingabe, $vw_arbeit_id);
		$sql .= ', vw_mobil_r='.AreaCode::get_vwid($vw_mobil_eingabe, $vw_mobil_id);
		$sql .= ', vw_fax_r='.AreaCode::get_vwid($vw_fax_eingabe, $vw_fax_id);
		$sql .= ', vw_aux_r='.AreaCode::get_vwid($vw_aux_eingabe, $vw_aux_id);


		if (!empty($email_privat)) $sql .= ', email_privat="'.$email_privat.'"';
		if (!empty($email_arbeit)) $sql .= ', email_arbeit="'.$email_arbeit.'"';
		if (!empty($email_aux)) $sql .= ', email_aux="'.$email_aux.'"';
		if (!empty($hp1)) $sql .= ', hp1="'.$hp1.'"';
		if (!empty($hp2)) $sql .= ', hp2="'.$hp2.'"';
		if (!empty($chat_aim)) $sql .= ', chat_aim="'.$chat_aim.'"';
		if (!empty($chat_msn)) $sql .= ', chat_msn="'.$chat_msn.'"';
		if (!empty($chat_icq)) $sql .= ', chat_icq="'.$chat_icq.'"';
		if (!empty($chat_yim)) $sql .= ', chat_yim="'.$chat_yim.'"';
		if (!empty($chat_skype)) $sql .= ', chat_skype="'.$chat_skype.'"';
		if (!empty($chat_aux)) $sql .= ', chat_aux="'.$chat_aux.'"';
		if (!empty($pnotizen)) $sql .= ', pnotizen="'.$pnotizen.'"';

		$sql .= ', last_edit='.time();

		$sql .= ';';

		mysql_query($sql);
		if (mysql_error() != '') {
			echo 'MySQL-Error: '.mysql_error();
			echo '<br /><br />SQL-Befehl: '.$sql;
		}

		$p_id = mysql_insert_id();



		/* FMG-Bez&uuml;ge */
		$sql = 'DELETE FROM ad_flinks WHERE person_lr='.$p_id.';';
		mysql_query($sql);

		if (!empty($fmgs)) {
			foreach ($fmgs as $wert) {
				$sql = 'INSERT INTO ad_flinks SET person_lr='.$p_id.', fmg_lr='.$wert.';';
				mysql_query($sql);
				echo mysql_error();
			}
		}


		/* Gruppen */
		$sql = 'DELETE FROM ad_glinks WHERE person_lr='.$p_id.';';
		mysql_query($sql);

		if (!empty($gruppen)) {
			foreach ($gruppen as $wert) {
				$sql = 'INSERT INTO ad_glinks SET person_lr='.$p_id.', gruppe_lr='.$wert.';';
				mysql_query($sql);
			}
		}

		header('location:index.php?mode=person_display&id='.$p_id);
	}

	public static function edit1() {
		$p_id = (int)($_GET['id']);

		$template = new Template('person_form');
		$template->set('heading', _('edit entry'));

		$erg = Person::select_fmg_zu_person($p_id);
		while ($l = mysql_fetch_assoc($erg))
			$checked_fmgs[] = $l['fmg_id'];

		$erg = Person::select_gruppen_zu_person($p_id);
		while ($l = mysql_fetch_assoc($erg))
			$checked_groups[] = $l['g_id'];

		$template->set('adresswahl', '');
		$template->set('checked_fmgs', $checked_fmgs);
		$template->set('checked_groups', $checked_groups);
		$template->set('form_target', 'person_edit2.php');
		$template->set('haushalt', $person_loop['adresse_r']);
		$template->set('p_id', $p_id);
		$template->set('person_loop', $person_loop);
		$template->set('werziehtum', 'alle');

		echo $template->html();
	}

	public static function edit2() {
		$p_id = (int)($_POST['p_id']);

		if ($p_id == 0) {
			die("Keine Person ID angegeben!");
		}

		$anrede_r = $_POST['anrede_r'];
		$prafix_r = $_POST['prafix_r'];
		$vorname = $_POST['vorname'];
		$mittelname = $_POST['mittelname'];
		$nachname = $_POST['nachname'];
		$suffix_r = $_POST['suffix_r'];
		$geburtsname = $_POST['geburtsname'];

		$geb_t = $_POST['geb_t'];
		$geb_m = $_POST['geb_m'];
		$geb_j = $_POST['geb_j'];

		$fmgs = $_POST['fmgs'];
		$gruppen = $_POST['gruppen'];

		$adresse_r = $_POST['adresse_r'];
		$haushalt = $_POST['haushalt'];
		$adresswahl = $_POST['adresswahl'];
		$werziehtum = $_POST['werziehtum'];
		if (empty($werziehtum))
			$werziehtum = 'alle';


		$ftel_privat = $_POST['ftel_privat'];
		$ftel_arbeit = $_POST['ftel_arbeit'];
		$ftel_mobil = $_POST['ftel_mobil'];
		$ftel_fax = $_POST['ftel_fax'];
		$ftel_aux = $_POST['ftel_aux'];

		$fvw_privat_eingabe = $_POST['fvw_privat_eingabe'];
		$fvw_privat_id = $_POST['fvw_privat_id'];
		$fvw_arbeit_eingabe = $_POST['fvw_arbeit_eingabe'];
		$fvw_arbeit_id = $_POST['fvw_arbeit_id'];
		$fvw_mobil_eingabe = $_POST['fvw_mobil_eingabe'];
		$fvw_mobil_id = $_POST['fvw_mobil_id'];
		$fvw_fax_eingabe = $_POST['fvw_fax_eingabe'];
		$fvw_fax_id = $_POST['fvw_fax_id'];
		$fvw_aux_eingabe = $_POST['fvw_aux_eingabe'];
		$fvw_aux_id = $_POST['fvw_aux_id'];


		$strasse = $_POST['strasse'];
		$plz = $_POST['plz'];
		$ort = $_POST['ort'];
		$land = $_POST['land'];

		$plz_r = $_POST['plz_r'];
		$ort_r = $_POST['ort_r'];
		$land_r = $_POST['land_r'];

		$tel_privat = $_POST['tel_privat'];
		$tel_arbeit = $_POST['tel_arbeit'];
		$tel_mobil = $_POST['tel_mobil'];
		$tel_fax = $_POST['tel_fax'];
		$tel_aux = $_POST['tel_aux'];

		$vw_privat_eingabe = $_POST['vw_privat_eingabe'];
		$vw_privat_id = $_POST['vw_privat_id'];
		$vw_arbeit_eingabe = $_POST['vw_arbeit_eingabe'];
		$vw_arbeit_id = $_POST['vw_arbeit_id'];
		$vw_mobil_eingabe = $_POST['vw_mobil_eingabe'];
		$vw_mobil_id = $_POST['vw_mobil_id'];
		$vw_fax_eingabe = $_POST['vw_fax_eingabe'];
		$vw_fax_id = $_POST['vw_fax_id'];
		$vw_aux_eingabe = $_POST['vw_aux_eingabe'];
		$vw_aux_id = $_POST['vw_aux_id'];


		$email_privat = $_POST['email_privat'];
		$email_arbeit = $_POST['email_arbeit'];
		$email_aux = $_POST['email_aux'];

		$hp1 = $_POST['hp1'];
		$hp2 = $_POST['hp2'];

		$chat_aim = $_POST['chat_aim'];
		$chat_msn = $_POST['chat_msn'];
		$chat_icq = $_POST['chat_icq'];
		$chat_yim = $_POST['chat_yim'];
		$chat_skype = $_POST['chat_skype'];
		$chat_aux = $_POST['chat_aux'];


		$pnotizen = $_POST['pnotizen'];


		/* Wenn eine neue Gruppe eingetragen wurde, wird diese jetzt schon in die
		 * Datenbank aufgenommen und steht danach als Haken bereit.
		 */

		if (!empty($_POST['neue_gruppe'])) {
			$sql = 'INSERT INTO ad_gruppen SET gruppe="'.$_POST['neue_gruppe'].'"';
			mysql_query($sql);
			$gruppen[] = mysql_insert_id();
		}

		$sql = 'UPDATE ad_per SET';

		/* Name und Geburtstag */

		$sql .= ' anrede_r='.$anrede_r;
		$sql .= ', prafix_r='.$prafix_r;
		$sql .= ', vorname="'.$vorname.'"';
		$sql .= ', mittelname="'.$mittelname.'"';
		$sql .= ', nachname="'.$nachname.'"';
		$sql .= ', suffix_r='.$suffix_r;
		$sql .= ', geburtsname="'.$geburtsname.'"';

		$sql .= ', geb_t='.$geb_t;
		$sql .= ', geb_m='.$geb_m;
		$sql .= ', geb_j='.$geb_j;




		/* Adresse */

		/* Wenn die Adresse nur f&uuml;r einen ge&auml;ndert wird */
		if ($werziehtum == 'einer') {

			/* Wenn die Adresse manuell eingegeben wurde */
			if ($adresswahl == 'manuell') {
				$sql_ad = 'INSERT INTO ad_adressen SET';
				$sql_ad .= ' strasse="'.$strasse.'"';


				/* PLZ */
				if (!empty($plz)) {
					$erg = PostralCode::select_plzid_plz($plz);

					if (mysql_num_rows($erg) == 0)
						$plz_id = PostralCode::insert_plz($plz);

					else if ($l = mysql_fetch_assoc($erg))
						$plz_id = $l['plz_id'];

					$sql_ad .= ', plz_r='.$plz_id;
				}
				else
					$sql_ad .= ', plz_r='.$plz_r;


				/* Ort */
				if (!empty($ort)) {
					$erg = City::select_ortid_ort($ort);

					if (mysql_num_rows($erg) == 0)
						$ort_id = City::insert_ort($ort);

					else if ($l = mysql_fetch_assoc($erg))
						$ort_id = $l['o_id'];

					$sql_ad .= ', ort_r='.$ort_id;
				}
				else
					$sql_ad .=', ort_r='.$ort_r;



				/* Land */
				if (!empty($land)) {
					$erg = Country::select_landid_land($land);

					if (mysql_num_rows($erg) == 0)
						$land_id = Country::insert_land($land);


					else if ($l = mysql_fetch_assoc($erg))
						$land_id = $l['l_id'];

					$sql_ad .= ', land_r='.$land_id.'';
				}
				else
					$sql_ad .= ', land_r='.$land_r;


				$sql_ad .= ', ftel_privat="'.$ftel_privat.'"';
				$sql_ad .= ', ftel_arbeit="'.$ftel_arbeit.'"';
				$sql_ad .= ', ftel_mobil="'.$ftel_mobil.'"';
				$sql_ad .= ', ftel_fax="'.$ftel_fax.'"';
				$sql_ad .= ', ftel_aux="'.$ftel_aux.'"';

				$sql_ad .= ', fvw_privat_r='.AreaCode::get_vwid($fvw_privat_eingabe, $fvw_privat_id);
				$sql_ad .= ', fvw_arbeit_r='.AreaCode::get_vwid($fvw_arbeit_eingabe, $fvw_arbeit_id);
				$sql_ad .= ', fvw_mobil_r='.AreaCode::get_vwid($fvw_mobil_eingabe, $fvw_mobil_id);
				$sql_ad .= ', fvw_fax_r='.AreaCode::get_vwid($fvw_fax_eingabe, $fvw_fax_id);
				$sql_ad .= ', fvw_aux_r='.AreaCode::get_vwid($fvw_aux_eingabe, $fvw_aux_id);


				mysql_query($sql_ad);
				$sql .= ', adresse_r='.mysql_insert_id();
			}

			/* Wenn eine Adresse aus dem Select ausgesucht wordern ist */
			else if ($adresse_r != 0){
				$sql .= ', adresse_r='.$adresse_r;
			}
		}

		/* Wenn die Adresse f&uuml;r alle ge&auml;ndert wird */
		else if ($werziehtum == 'alle') {

			/* Wenn die Adresse manuell eingegeben wurde */
			if ($adresswahl == 'manuell') {
				/* Wenn der zuvor ausgesuchte Haushalt 1 war, dann wir ein neuer anlegelgt. */
				if ($haushalt == 1) {
					$sql_ad = 'INSERT INTO ad_adressen SET';
					$sql_ad .= ' strasse="'.$strasse.'"';


					/* PLZ */
					if (!empty($plz)) {
						$erg = PostralCode::select_plzid_plz($plz);

						if (mysql_num_rows($erg) == 0)
							$plz_id = PostralCode::insert_plz($plz);

						else if ($l = mysql_fetch_assoc($erg))
							$plz_id = $l['plz_id'];

						$sql_ad .= ', plz_r='.$plz_id;
					}
					else
						$sql_ad .= ', plz_r='.$plz_r;


					/* Ort */
					if (!empty($ort)) {
						$erg = City::select_ortid_ort($ort);

						if (mysql_num_rows($erg) == 0)
							$ort_id = City::insert_ort($ort);

						else if ($l = mysql_fetch_assoc($erg))
							$ort_id = $l['o_id'];

						$sql_ad .= ', ort_r='.$ort_id;
					}
					else
						$sql_ad .=', ort_r='.$ort_r;



					/* Land */
					if (!empty($land)) {
						$erg = Country::select_landid_land($land);

						if (mysql_num_rows($erg) == 0)
							$land_id = Country::insert_land($land);


						else if ($l = mysql_fetch_assoc($erg))
							$land_id = $l['l_id'];

						$sql_ad .= ', land_r='.$land_id.'';
					}
					else
						$sql_ad .= ', land_r='.$land_r;


					$sql_ad .= ', ftel_privat="'.$ftel_privat.'"';
					$sql_ad .= ', ftel_arbeit="'.$ftel_arbeit.'"';
					$sql_ad .= ', ftel_mobil="'.$ftel_mobil.'"';
					$sql_ad .= ', ftel_fax="'.$ftel_fax.'"';
					$sql_ad .= ', ftel_aux="'.$ftel_aux.'"';

					$sql_ad .= ', fvw_privat_r='.AreaCode::get_vwid($fvw_privat_eingabe, $fvw_privat_id);
					$sql_ad .= ', fvw_arbeit_r='.AreaCode::get_vwid($fvw_arbeit_eingabe, $fvw_arbeit_id);
					$sql_ad .= ', fvw_mobil_r='.AreaCode::get_vwid($fvw_mobil_eingabe, $fvw_mobil_id);
					$sql_ad .= ', fvw_fax_r='.AreaCode::get_vwid($fvw_fax_eingabe, $fvw_fax_id);
					$sql_ad .= ', fvw_aux_r='.AreaCode::get_vwid($fvw_aux_eingabe, $fvw_aux_id);


					mysql_query($sql_ad);

					$sql_ad = 'UPDATE ad_per SET adresse_r='.mysql_insert_id().' WHERE adresse_r='.$haushalt.';';
					mysql_query($sql_ad);
					echo mysql_error();
				}


				else {
					$sql_ad = 'UPDATE ad_adressen SET strasse="'.$strasse.'"';


					/* PLZ */
					if (!empty($plz)) {
						$erg = PostralCode::select_plzid_plz($plz);

						if (mysql_num_rows($erg) == 0)
							$plz_id = PostralCode::insert_plz($plz);

						else if ($l = mysql_fetch_assoc($erg))
							$plz_id = $l['plz_id'];

						$sql_ad .= ', plz_r='.$plz_id;
					}
					else
						$sql_ad .= ', plz_r='.$plz_r;


					/* Ort */
					if (!empty($ort)) {
						$erg = City::select_ortid_ort($ort);

						if (mysql_num_rows($erg) == 0)
							$ort_id = City::insert_ort($ort);

						else if ($l = mysql_fetch_assoc($erg))
							$ort_id = $l['o_id'];

						$sql_ad .= ', ort_r='.$ort_id;
					}
					else
						$sql_ad .=', ort_r='.$ort_r;



					/* Land */
					if (!empty($land)) {
						$erg = Country::select_landid_land($land);

						if (mysql_num_rows($erg) == 0)
							$land_id = Country::insert_land($land);


						else if ($l = mysql_fetch_assoc($erg))
							$land_id = $l['l_id'];

						$sql_ad .= ', land_r='.$land_id.'';
					}
					else
						$sql_ad .= ', land_r='.$land_r;


					$sql_ad .= ', ftel_privat="'.$ftel_privat.'"';
					$sql_ad .= ', ftel_arbeit="'.$ftel_arbeit.'"';
					$sql_ad .= ', ftel_mobil="'.$ftel_mobil.'"';
					$sql_ad .= ', ftel_fax="'.$ftel_fax.'"';
					$sql_ad .= ', ftel_aux="'.$ftel_aux.'"';

					$sql_ad .= ', fvw_privat_r='.AreaCode::get_vwid($fvw_privat_eingabe, $fvw_privat_id);
					$sql_ad .= ', fvw_arbeit_r='.AreaCode::get_vwid($fvw_arbeit_eingabe, $fvw_arbeit_id);
					$sql_ad .= ', fvw_mobil_r='.AreaCode::get_vwid($fvw_mobil_eingabe, $fvw_mobil_id);
					$sql_ad .= ', fvw_fax_r='.AreaCode::get_vwid($fvw_fax_eingabe, $fvw_fax_id);
					$sql_ad .= ', fvw_aux_r='.AreaCode::get_vwid($fvw_aux_eingabe, $fvw_aux_id);

					$sql_ad .= ' WHERE ad_id='.$adresse_r.';';

					mysql_query($sql_ad);
				}
			}

			/* Wenn eine Adresse aus dem Select ausgesucht wordern ist */
			else if ($adresse_r > 0) {
				if (Address::adresse_mehrfach_benutzt($adresse_r)) {
					$sql_ad = 'UPDATE ad_per SET adresse_r='.$adresse_r.' WHERE adresse_r='.$haushalt.';';
					mysql_query($sql_ad);
					if (mysql_error() != "") {
						echo $sql_ad;
						echo '<br />';
						echo mysql_error();
					}
				}
			}
		}


		/* Schritt 3 */

		$sql .= ', tel_privat="'.$tel_privat.'"';
		$sql .= ', tel_arbeit="'.$tel_arbeit.'"';
		$sql .= ', tel_mobil="'.$tel_mobil.'"';
		$sql .= ', tel_fax="'.$tel_fax.'"';
		$sql .= ', tel_aux="'.$tel_aux.'"';

		$sql .= ', vw_privat_r='.AreaCode::get_vwid($vw_privat_eingabe, $vw_privat_id);
		$sql .= ', vw_arbeit_r='.AreaCode::get_vwid($vw_arbeit_eingabe, $vw_arbeit_id);
		$sql .= ', vw_mobil_r='.AreaCode::get_vwid($vw_mobil_eingabe, $vw_mobil_id);
		$sql .= ', vw_fax_r='.AreaCode::get_vwid($vw_fax_eingabe, $vw_fax_id);
		$sql .= ', vw_aux_r='.AreaCode::get_vwid($vw_aux_eingabe, $vw_aux_id);


		$sql .= ', email_privat="'.$email_privat.'"';
		$sql .= ', email_arbeit="'.$email_arbeit.'"';
		$sql .= ', email_aux="'.$email_aux.'"';
		$sql .= ', hp1="'.$hp1.'"';
		$sql .= ', hp2="'.$hp2.'"';
		$sql .= ', chat_aim="'.$chat_aim.'"';
		$sql .= ', chat_msn="'.$chat_msn.'"';
		$sql .= ', chat_icq="'.$chat_icq.'"';
		$sql .= ', chat_yim="'.$chat_yim.'"';
		$sql .= ', chat_skype="'.$chat_skype.'"';
		$sql .= ', chat_aux="'.$chat_aux.'"';
		$sql .= ', pnotizen="'.$pnotizen.'"';

		$sql .= ', last_edit='.time();

		$sql .= ' WHERE p_id='.$p_id.';';

		mysql_query($sql);
		if (mysql_error() != '') {
			echo 'MySQL-Error: '.mysql_error();
			echo '<br /><br />SQL-Befehl:'.$sql;
		}


		/* FMG-Bez&uuml;ge */
		$sql = 'DELETE FROM ad_flinks WHERE person_lr='.$p_id.';';
		mysql_query($sql);

		if (!empty($fmgs)) {
			foreach ($fmgs as $wert) {
				$sql = 'INSERT INTO ad_flinks SET person_lr='.$p_id.', fmg_lr='.$wert.';';
				mysql_query($sql);
				echo mysql_error();
			}
		}


		/* Gruppen */
		$sql = 'DELETE FROM ad_glinks WHERE person_lr='.$p_id.';';
		mysql_query($sql);

		if (!empty($gruppen)) {
			foreach ($gruppen as $wert) {
				$sql = 'INSERT INTO ad_glinks SET person_lr='.$p_id.', gruppe_lr='.$wert.';';
				mysql_query($sql);
			}
		}

		header('location:index.php?mode=person_display&id='.$p_id);
	}

	public static function checked() {
$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.($id).';';
mysql_query($sql);
$msgs[] = _('The entry was updated.');

// update the data for the person
$person_loop['last_check'] = time();

$mode= 'person_display';
	}

	public static function delete1() {
echo '<h1>'._('delete an entry').'</h1>';
if (!empty($id)) {
	printf(_('Do you really want to delete the entry %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');

	// check for multiple associations
	$ass_sql = 'SELECT * FROM ad_flinks LEFT JOIN ad_fmg ON fmg_id=fmg_lr WHERE person_lr='.(int)$id.' ORDER BY fmg;';
	$ass_erg = mysql_query($ass_sql);
	while ($ass_l = mysql_fetch_assoc($ass_erg)) {
		$association_ids[] = $ass_l['fmg_id'];
		$association_names[] = $ass_l['fmg'];
	}
	if (isset($association_ids)) {
		if (count($association_ids) >= 2) {
			echo '<br />';
			echo '<br />';
			echo _('Warning:').' '.sprintf(_('This entry is connected to %s. Consider just removing your association with it.'), implode(', ', $association_names));
		}
		else if (count($association_ids) == 1 && $association_ids[0] != $_SESSION['f']) {
			echo '<br />';
			echo '<br />';
			echo _('Warning:').' '.sprintf(_('This entry is connected to %s. Are you sure that you can delete this entry?'), $association_names[0]);
		}
	}

	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_delete2&id='.$id.'&back='.urlencode($_GET['back']).'">'._('Sure, delete that!').'</a>';
	echo '<br />';
	echo '<br />';
	echo '<a href="index.php?mode=person_display&id='.$id.'">'._('No, cancel!').'</a>';
}
else {
	echo _('There is no ID specified.');
}
	}

	public static function delete2() {
if (!empty($id)) {
	Person::delete_person_id($id);

	if (!empty($person_loop['vorname']) || !empty($person_loop['nachname'])) {
		$msgs[] = sprintf(_('The entry %s was deleted.'),
				'<em>'.$person_loop['vorname'].' '.
				$person_loop['nachname'].'</em>');
	}

	$_GET['mode'] = 'main';
	$back = $_GET['back'];
	$items = explode('&', $back);
	foreach ($items as $item) {
		$keyvalue = explode('=', $item);
		$_GET[$keyvalue[0]] = $keyvalue[1];
	}

	$mode = $_GET['mode'];
	if (empty($mode)) {
		$mode = 'main';
	}

	unset($items);
}
else {
	$msgs[] = _('Missing an ID.');
}
	}

	public static function display() {
echo '<h1>'._('display entry').'</h1>';

if (isset($id)) {

$mugshot_path = '_mugshots/per'.$id.'.jpg';
if (file_exists($mugshot_path)) {
	$bilddaten = getimagesize('_mugshots/per'.$id.'.jpg');
	echo '<img id="pers_bild" src="_mugshots/per'.$id.'.jpg" '.$bilddaten[3].' />';
}

$emailadresse_vorhanden = false;

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('name').':';
echo '</div>';

echo '<table class="display_person">';
echo '<tr>';
echo '<td class="links">'._('form of address').':</td>';
echo '<td class="rechts">';
if ($person_loop['anrede'] != "-")
	echo ' '._($person_loop['anrede']);
if ($person_loop['prafix'] != "-")
	echo ' '.$person_loop['prafix'];
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td class="links">'._('name').':</td>';
echo '<td>';
echo '<b>'.$person_loop['vorname'].'</b>';
if (!empty($person_loop['mittelname']))
	echo ' '.$person_loop['mittelname'];
echo ' <b>'.$person_loop['nachname'].'</b>';
if ($person_loop['suffix'] != "-")
	echo ' ('.$person_loop['suffix'].')';
if (!empty($person_loop['geburtsname'])) {
	echo ', ';
	if (empty($person_loop['anrede']))
		echo _('born<!-- both gender form-->');
	else {
		if ($person_loop['anrede'] == _('Mr.'))
			echo _('born<!-- male form -->');
		else
			echo _('born<!-- female form -->');
	}
	echo ' '.$person_loop['geburtsname'];
}
echo '</td>';
echo '</tr>';
if (!empty($person_loop['geb_t'])) {
	echo '<tr>';
	echo '<td class="links">'._('birthday').':</td>';
	echo '<td>'.$person_loop['geb_t'].'.'.$person_loop['geb_m'].'.';
	if ($person_loop['geb_j'] > 1500) {
		echo $person_loop['geb_j'].' &nbsp;&nbsp; ';
		printf(_('(today %d years old)'), DateFormat::alter($person_loop['geb_t'],$person_loop['geb_m'],$person_loop['geb_j']));
		echo ' &nbsp;&nbsp; ('.ZodiacSign::sternzeichen ($person_loop['geb_t'], $person_loop['geb_m']).')';
	}
	echo '</td>';
	echo '</tr>';
	}
echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('address').':';
echo '</div>';
echo '<table class="display_person">';
if ($person_loop['adresse_r'] != 1) {
	echo '<tr>';
	echo '<td class="links">'._('address').':</td>';
	echo '<td class="rechts">';
	echo $person_loop['strasse'];
	echo ', ';
	echo $person_loop['plz'].' '.$person_loop['ortsname'];
	echo ' ('.$person_loop['land'].')';
	echo '<br />';
	echo _('show map').': ';
	echo '<a href="http://nominatim.openstreetmap.org/search?q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank" title="Open Street Map">&raquo;OSM</a>';
	echo ' &nbsp; ';
	echo '<a href="http://maps.google.com/maps?f=q&hl=de&q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank">&raquo;Google</a>';
	echo ' &nbsp; ';
	echo '<a href="http://www.bing.com/maps/?q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank">&raquo;Bing</a>';
	if ($person_loop['land'] == 'Deutschland') {
		echo ' &nbsp; ';
		echo '<a href="http://www.mapquest.com/maps/map.adp?country=de&address='.str_replace(' ', '+', $person_loop['strasse']).'&city='.str_replace(' ', '+', $person_loop['ortsname']).'&zip='.$person_loop['plz'].'" target="_blank">&raquo;MapQuest</a>';
	}
	echo '</td>';
	echo '</tr>';
}
if (!empty($person_loop['ftel_privat'])) {
	echo '<tr>';
	echo '<td class="links">'._('telephone private').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['fvw_privat_r']).'-'.$person_loop['ftel_privat'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['fvw_privat_r']).$person_loop['ftel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_arbeit'])) {
	echo '<tr>';
	echo '<td class="links">'._('telephone work').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['fvw_arbeit_r']).'-'.$person_loop['ftel_arbeit'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['fvw_arbeit_r']).$person_loop['ftel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_mobil'])) {
	echo '<tr>';
	echo '<td class="links">'._('telephone mobile').': <i>'.Cellphone::handybetreiber(AreaCode::select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['fvw_mobil_r']).'-'.$person_loop['ftel_mobil'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['fvw_mobil_r']).$person_loop['ftel_mobil']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_fax'])) {
	echo '<tr>';
	echo '<td class="links">'._('fax').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['fvw_fax_r']).'-'.$person_loop['ftel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_aux'])) {
	echo '<tr>';
	echo '<td class="links">'._('telephone other').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['fvw_aux_r']).'-'.$person_loop['ftel_aux'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['fvw_aux_r']).$person_loop['ftel_aux']).'</td>';
	echo '</tr>';
}
echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('telephone').':';
echo '</div>';
echo '<table class="display_person">';
if (!empty($person_loop['tel_privat'])) {
	echo '<tr>';
	echo '<td class="links">'._('private').':</td>';
	echo '<td class="rechts">'.AreaCode::select_vw_id($person_loop['vw_privat_r']).'-'.$person_loop['tel_privat'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['vw_privat_r']).$person_loop['tel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_arbeit'])) {
	echo '<tr>';
	echo '<td class="links">'._('work').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['vw_arbeit_r']).'-'.$person_loop['tel_arbeit'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['vw_arbeit_r']).$person_loop['tel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_mobil'])) {
	echo '<tr>';
	echo '<td class="links">'._('mobile').': <i>'.Cellphone::handybetreiber(AreaCode::select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['vw_mobil_r']).'-'.$person_loop['tel_mobil'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['vw_mobil_r']).$person_loop['tel_mobil']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_fax'])) {
	echo '<tr>';
	echo '<td class="links">'._('fax').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['vw_fax_r']).'-'.$person_loop['tel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_aux'])) {
	echo '<tr>';
	echo '<td class="links">'._('other').':</td>';
	echo '<td>'.AreaCode::select_vw_id($person_loop['vw_aux_r']).'-'.$person_loop['tel_aux'].' '.Callto::skplnk(AreaCode::select_vw_id($person_loop['vw_aux_r']).$person_loop['tel_aux']).'</td>';
	echo '</tr>';
}
echo '</table>';


echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('internet').':';
echo '</div>';
echo '<table class="display_person">';
if (!empty($person_loop['email_privat'])) {
	echo '<tr>';
	echo '<td class="links">'._('email private').':</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_privat'].'>">'.$person_loop['email_privat'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['email_arbeit'])) {
	echo '<tr>';
	echo '<td class="links">'._('email work').':</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_arbeit'].'>">'.$person_loop['email_arbeit'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['email_aux'])) {
	echo '<tr>';
	echo '<td class="links">'._('email other').':</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_aux'].'>">'.$person_loop['email_aux'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['hp1'])) {
	echo '<tr>';
	echo '<td class="links">'._('homepage 1').':</td>';
	echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
	echo '<td><a href="http://'.$person_loop['hp1'].'" target="_blank">'.$person_loop['hp1'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['hp2'])) {
	echo '<tr>';
	echo '<td class="links">'._('homepage 2').':</td>';
	echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
	echo '<td><a href="http://'.$person_loop['hp2'].'" target="_blank">'.$person_loop['hp2'].'</a></td>';
	echo '</tr>';
}


if (!empty($person_loop['chat_aim'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat AIM').':</td>';
	echo '<td class="icon"><img src="gfx/10/aim10.png" width="10" height="10" /></td>';
	echo '<td><a href="AIM://'.$person_loop['chat_aim'].'">'.$person_loop['chat_aim'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_msn'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat MSN').':</td>';
	echo '<td class="icon"><img src="gfx/10/msn10.png" width="10" height="10" /></td>';
	echo '<td><a href="MSN://'.$person_loop['chat_msn'].'">'.$person_loop['chat_msn'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_icq'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat ICQ').':</td>';
	echo '<td class="icon"><img src="gfx/10/icq10.png" width="10" height="10" /></td>';
	echo '<td><a href="ICQ://'.$person_loop['chat_icq'].'">#'.$person_loop['chat_icq'].'</a> &nbsp; <a href="http://people.icq.com/'.$person_loop['chat_icq'].'" target="_blank">&raquo; '._('profile page').'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_yim'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat Yahoo').':</td>';
	echo '<td class="icon"><img src="gfx/10/yim10.png" width="10" height="10" /></td>';
	echo '<td><a href="Yahoo://'.$person_loop['chat_yim'].'">'.$person_loop['chat_yim'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_skype'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat Skype').':</td>';
	echo '<td class="icon"><img src="gfx/10/skype10.png" width="10" height="10" /></td>';
	echo '<td><a href="Callto://'.$person_loop['chat_skype'].'">'.$person_loop['chat_skype'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_aux'])) {
	echo '<tr>';
	echo '<td class="links">'._('chat Jabber/XMPP').':</td>';
	echo '<td class="icon">&nbsp;</td>';
	echo '<td>'.$person_loop['chat_aux'].'</td>';
	echo '</tr>';
}


echo '</table>';

if (!empty($person_loop['pnotizen'])) {
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;'._('notes').':';
	echo '</div>';
	echo '<table class="display_person">';
	echo '<tr>';
	echo '<td>'.nl2br($person_loop['pnotizen']).'</td>';
	echo '</tr>';
	echo '</table>';
}

//		Gruppen
echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('relations').':';
echo '</div>';
echo '<table class="display_person">';
$erg = Person::select_gruppen_zu_person($id);
if (mysql_num_rows($erg) > 0) {
	echo '<tr>';
	echo '<td class="links">'._('groups').':</td>';
	echo '<td class="rechts">';
	while ($l = mysql_fetch_assoc($erg)) {
		echo $l['gruppe'].' &nbsp; ';

	}
	echo '</td>';
	echo '</tr>';
}
$erg = Person::select_fmg_zu_person($id);
if (mysql_num_rows($erg) > 0) {
	echo '<tr>';
	echo '<td class="links">'._('associated with').':</td>';
	echo '<td>';
	while ($l = mysql_fetch_assoc($erg)) {
		echo $l['fmg'].' &nbsp; ';
	}
	echo '</td>';
	echo '</tr>';
}

echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('up-to-dateness').':';
echo '</div>';
echo '<table class="display_person">';


echo '<tr>';
echo '<td class="links">'._('up-to-dateness').':</td>';
echo '<td>';

$anzahl_level = 6;
$veraltet_nach = 365;

$letzter_check_vor = round((time()-$person_loop['last_check'])/3600/24);

$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);

echo '<div style="padding: 5px;">';

if ($person_loop['last_check'] == 0)
	$aktuell_level = 0;
else {
	$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
}

for ($i = $anzahl_level-1; $i >= 0 ; $i--) {
	echo '<img src="gfx/balken_'.($i < $aktuell_level ? 'aktiv' : 'inaktiv').'.png" title="';
	printf(_('last check %s (%d days ago)'), DateFormat::intelligent_date($person_loop['last_check']), $letzter_check_vor);
	echo '" />';
}

echo '<div>';

echo _('Was the data checked and is it up-to-date?').' <a href="index.php?mode=person_checked&id='.$id.'">'._('yes').'</a>';
echo '</td>';
echo '</tr>';

if ($emailadresse_vorhanden) {
	echo '<tr>';
	echo '<td class="links">'._('verification email').':</td>';
	echo '<td>';

	echo '<a href="index.php?mode=verification_email&id='.$id.'">&raquo; '._('send verification email').'</a>';
	if ($person_loop['last_send'] != 0) {
		echo ' (letzte vom '.date($date_format, $person_loop['last_send']).')';
	}
	if ($person_loop['last_check'] < $person_loop['last_send']) {

		echo '<br />'.sprintf(_('verification mail %s sent, confirmation pending'), DateFormat::intelligent_date($person_loop['last_send']));
	}
	echo '</td>';
	echo '</tr>';
}
echo '<tr>';
echo '<td class="links">'._('last edited').':</td>';
echo '<td>'.DateFormat::intelligent_date($person_loop['last_edit']).'</td>';
echo '</td>';

echo '</table>';

echo '<a href="?mode=person_edit1&id='.$id.'" title="'._('edit this entry').'"><img src="gfx/person_bearbeiten.png" width="64" height="64" alt="'._('edit this entry').'" border="0" /></a>';
echo '<a href="?mode=person_delete&id='.$id.(isset($_GET['back']) ? '&back='.urlencode($_GET['back']): '').'" title="'._('delete this entry').'"><img src="gfx/person_loeschen.png" width="64" height="64" alt="'._('delete this entry').'" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a href="?mode=pic_upload1&id='.$id.'" title="'._('upload picture').'"><img src="gfx/foto_upload.png" width="64" height="64" alt="'._('upload picture').'" border="0" /></a>';
if (file_exists($mugshot_path))
	echo '<a href="index.php?mode=pic_remove&id='.$id.'" title="'._('delete picture').'"><img src="gfx/foto_loeschen.png" width="64" height="64" alt="'._('delete picture').'" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a href="export/vcard.php?id='.$id.'" title="'._('download VCard').'"><img src="gfx/vcard.png" width="64" height="64" alt="'._('download VCard').'" border="0" /></a>';

}
else {
	echo _('No ID given.');
}
	}
}
?>
