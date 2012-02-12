<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Template.php');
require_once('controller/Controller.php');
require_once('model/Person.php');
require_once('model/AreaCode.php');

/**
 * Various exports.
 */
class ExportController extends Controller {
	/**
	 * Exports the currently selected person as a single VCard.
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_GET['id']
	 */
	public function vcard() {
		$template = new Template(__CLASS__, __FUNCTION__);

		$id = $_GET['id'];

		$erg = Person::select_person_alles($id);

		$l = mysql_fetch_assoc($erg);

		$template->set('l', $l);

		echo $template->html();

		die();
	}

	/**
	 * Exports the currently selected group as a combined VCard.
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function vcard_multiple() {
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_join('LEFT JOIN ad_adressen ON adresse_r = ad_id');
		$filter->add_join('LEFT JOIN ad_anreden ON anrede_r = a_id');
		$filter->add_join('LEFT JOIN ad_laender ON land_r = l_id');
		$filter->add_join('LEFT JOIN ad_orte ON ort_r = o_id');
		$filter->add_join('LEFT JOIN ad_plz ON plz_r = plz_id');
		$filter->add_join('LEFT JOIN ad_prafixe ON prafix_r = prafix_id');
		$filter->add_join('LEFT JOIN ad_suffixe ON suffix_r = s_id');

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';

		$erg = mysql_query($sql);

		$template = new Template(__CLASS__, __FUNCTION__);
		$template->set('erg', $erg);
		echo $template->html();

		die();
	}

	/**
	 * Exports the currently selected group as kitchen hangout.
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function kitchen() {
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_address();

		$template = new Template(__CLASS__, __FUNCTION__);
		$template->set('erg', $filter->get_erg());
		echo $template->html();

		die();
	}

	/**
	 * Exports the currently selected group as a CSV file.
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function csv() {

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_address();

		$template = new Template(__CLASS__, __FUNCTION__);
		$template->set('erg', $filter->get_erg());
		echo $template->html();

		die();
	}

	/**
	 * Exports the currently selected group as dayolanner sheets
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function dayplanner() {
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_address();

		$template = new Template(__CLASS__, __FUNCTION__);
		$template->set('erg', $filter->get_erg());
		echo $template->html();

		die();
	}

	/**
	 * Exports the currently selected group as an ICS birthday calender
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function birthday_calendar() {
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);

		$template = new Template(__CLASS__, __FUNCTION__);
		$template->set('erg', $filter->get_erg());
		echo $template->html();


		die();
	}

	/**
	 * Exports the data into a CakePHP named, JSON encoded array.
	 */
	public function json() {
		echo '<code><pre>';
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_address();
		$erg = $filter->get_erg();

		$data = array();

		while ($l = mysql_fetch_assoc($erg)) {
			$current = array(
				"Person" => array(
					//"id" => $l['p_id'],
					"first_name" => $l['vorname'],
					"middle_name" => $l['mittelname'],
					"last_name" => $l['nachname'],
					"birth_name" => $l['geburtsname'],
					"notes" => $l['pnotizen'],
					"birthday" => sprintf("%04d-%02d-%02d", $l['geb_j'], $l['geb_t'], $l['geb_m']),
					"modified" => date("r", $l['last_edit']),
					"last_check" => date("r", $l['last_check']),
				),
				"Salutation" => array(
					"name" => $l['anrede'],
				),
				"Suffix" => array(
					"name" => $l['suffix'],
				),
				"Prefix" => array(
					"name" => $l['prafix'],
				),
				"Address" => array(
					//"id" => $l['adresse_r'],
					"street" => $l["strasse"],
					"city" => $l["ortsname"],
					"postral_code" => $l["plz"],
					"country" => $l["land"],
					"Phone" => array(
						array(
							"AreaCode" => array(
								"code" => AreaCode::select_vw_id($l['fvw_privat_r']),
							),
							"Type" => array(
								"name" => "private",
							),
							"number" => $l['ftel_privat'],
						),
						array(
							"AreaCode" => array(
								"code" => AreaCode::select_vw_id($l['fvw_arbeit_r']),
							),
							"Type" => array(
								"name" => "work",
							),
							"number" => $l['ftel_arbeit'],
						),
						array(
							"AreaCode" => array(
								"code" => AreaCode::select_vw_id($l['fvw_mobil_r']),
							),
							"Type" => array(
								"name" => "mobile",
							),
							"number" => $l['ftel_mobil'],
						),
						array(
							"AreaCode" => array(
								"code" => AreaCode::select_vw_id($l['fvw_fax_r']),
							),
							"Type" => array(
								"name" => "fax",
							),
							"number" => $l['ftel_fax'],
						),
						array(
							"AreaCode" => array(
								"code" => AreaCode::select_vw_id($l['fvw_aux_r']),
							),
							"Type" => array(
								"name" => "aux",
							),
							"number" => $l['ftel_aux'],
						),
					),
				),
				"Phone" => array(
					array(
						"AreaCode" => array(
							"code" => AreaCode::select_vw_id($l['vw_privat_r']),
						),
						"Type" => array(
							"name" => "private",
						),
						"number" => $l['tel_privat'],
					),
					array(
						"AreaCode" => array(
							"code" => AreaCode::select_vw_id($l['vw_arbeit_r']),
						),
						"Type" => array(
							"name" => "work",
						),
						"number" => $l['tel_arbeit'],
					),
					array(
						"AreaCode" => array(
							"code" => AreaCode::select_vw_id($l['vw_mobil_r']),
						),
						"Type" => array(
							"name" => "mobile",
						),
						"number" => $l['tel_mobil'],
					),
					array(
						"AreaCode" => array(
							"code" => AreaCode::select_vw_id($l['vw_fax_r']),
						),
						"Type" => array(
							"name" => "fax",
						),
						"number" => $l['tel_fax'],
					),
					array(
						"AreaCode" => array(
							"code" => AreaCode::select_vw_id($l['vw_aux_r']),
						),
						"Type" => array(
							"name" => "aux",
						),
						"number" => $l['tel_aux'],
					),
				),
				"Email" => array(
					array(
						"email" => $l['email_privat'],
						"Type" => array(
							"name" => "private",
						),
					),
					array(
						"email" => $l['email_arbeit'],
						"Type" => array(
							"name" => "work",
						),
					),
					array(
						"email" => $l['email_aux'],
						"Type" => array(
							"name" => "aux",
						),
					)
				),
				"Homepage" => array(
					array(
						"url" => $l['hp1'],
					),
					array(
						"url" => $l['hp2'],
					),
				),
				"Messenger" => array(
					array(
						"alias" => $l['chat_aim'],
						"MessengerService" => array(
							"name" => "AIM",
						),
					),
					array(
						"alias" => $l['chat_msn'],
						"MessengerService" => array(
							"name" => "MSN",
						),
					),
					array(
						"alias" => $l['chat_icq'],
						"MessengerService" => array(
							"name" => "ICQ",
						),
					),
					array(
						"alias" => $l['chat_yim'],
						"MessengerService" => array(
							"name" => "Yahoo!",
						),
					),
					array(
						"alias" => $l['chat_skype'],
						"MessengerService" => array(
							"name" => "Skype",
						),
					),
					array(
						"alias" => $l['chat_aux'],
						"MessengerService" => array(
							"name" => "Jabber",
						),
					),
				),
			);


			$erg2 = Person::select_gruppen_zu_person($l['p_id']);
			if (mysql_num_rows($erg2) > 0) {
				while ($l2 = mysql_fetch_assoc($erg2)) {
					$current["Group"][] = array(
						"name" => $l2['gruppe'],
					);

				}
			}
			$erg2 = Person::select_fmg_zu_person($l['p_id']);
			if (mysql_num_rows($erg2) > 0) {
				while ($l2 = mysql_fetch_assoc($erg2)) {
					$current["Member"][] = array(
						"name" => $l2['fmg'],
					);
				}
			}

			$data[] = $current;
		}

		//echo json_encode($data);
		print_r($data);
		echo '</code></pre>';
		die();
	}
}
?>
