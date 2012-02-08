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
require_once('controller/Controller.php');

include('_config.inc.php');

class PersonController extends Controller {
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

	public static function view() {
		$template = new Template('person_view');

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}

		if (!isset($id)) {
			return _('No ID given.');
		}

		$erg = Person::select_person_alles($id);
		$person_loop = mysql_fetch_assoc($erg);

		$template->set('id', $id);
		$template->set('person_loop', $person_loop);

		return $template->html();
	}
}
?>
