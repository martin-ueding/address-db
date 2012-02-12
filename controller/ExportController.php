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
		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_address();
		$erg = $filter->get_erg();

		$data = array();

		while ($l = mysql_fetch_assoc($erg)) {
			$data[] = array(
				"Person" => array(
					"id" => $l['p_id'],
					"first_name" => $l['vorname'],
					"middle_name" => $l['mittelname'],
					"last_name" => $l['nachname'],
					"form_of_address" => $l['anrede'],
					"prefix" => $l['prafix'],
					"suffix" => $l['suffix'],
					"birth_name" => $l['geburtsname'],
					"notes" => $l['pnotizen'],
					"birthday" => sprintf("%04d-%02d-%02d", $l['geb_j'], $l['geb_t'], $l['geb_m']),
					"modified" => date("r", $l['last_edit']),
					"last_check" => date("r", $l['last_check']),
				),
				"Address" => array(
					"id" => $l['adresse_r'],
					"street" => $l["strasse"],
					"city" => $l["ortsname"],
					"postral_code" => $l["plz"],
					"country" => $l["land"],
					"Phone" => array(
						array(
							"area_code" => AreaCode::select_vw_id($l['fvw_privat_r']),
							"type" => "private",
							"number" => $l['ftel_privat'],
						),
						array(
							"area_code" => AreaCode::select_vw_id($l['fvw_arbeit_r']),
							"type" => "work",
							"number" => $l['ftel_arbeit'],
						),
						array(
							"area_code" => AreaCode::select_vw_id($l['fvw_mobil_r']),
							"type" => "mobile",
							"number" => $l['ftel_mobil'],
						),
						array(
							"area_code" => AreaCode::select_vw_id($l['fvw_fax_r']),
							"type" => "fax",
							"number" => $l['ftel_fax'],
						),
						array(
							"area_code" => AreaCode::select_vw_id($l['fvw_aux_r']),
							"type" => "aux",
							"number" => $l['ftel_aux'],
						),
					),
				),
				"Phone" => array(
					array(
						"area_code" => AreaCode::select_vw_id($l['vw_privat_r']),
						"type" => "private",
						"number" => $l['tel_privat'],
					),
					array(
						"area_code" => AreaCode::select_vw_id($l['vw_arbeit_r']),
						"type" => "work",
						"number" => $l['tel_arbeit'],
					),
					array(
						"area_code" => AreaCode::select_vw_id($l['vw_mobil_r']),
						"type" => "mobile",
						"number" => $l['tel_mobil'],
					),
					array(
						"area_code" => AreaCode::select_vw_id($l['vw_fax_r']),
						"type" => "fax",
						"number" => $l['tel_fax'],
					),
					array(
						"area_code" => AreaCode::select_vw_id($l['vw_aux_r']),
						"type" => "aux",
						"number" => $l['tel_aux'],
					),
				),
				"Email" => array(
					array(
						"email" => $l['email_privat'],
						"type" => "private",
					),
					array(
						"email" => $l['email_arbeit'],
						"type" => "work",
					),
					array(
						"email" => $l['email_aux'],
						"type" => "aux",
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
						"service" => "AIM",
					),
					array(
						"alias" => $l['chat_msn'],
						"service" => "MSN",
					),
					array(
						"alias" => $l['chat_icq'],
						"service" => "ICQ",
					),
					array(
						"alias" => $l['chat_yim'],
						"service" => "Yahoo!",
					),
					array(
						"alias" => $l['chat_skype'],
						"service" => "Skype",
					),
					array(
						"alias" => $l['chat_aux'],
						"service" => "Jabber",
					),
				),
			);

		}

		//echo json_encode($data);
		echo '<code><pre>';
		print_r($data);
		echo '</code></pre>';
		die();
	}
}
?>
