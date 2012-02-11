<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Template.php');
require_once('controller/Controller.php');
require_once('model/Person.php');
require_once('model/AreaCode.php');

/**
 * Various exports.
 *
 * @package controller
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
		$template = new Template('export_vcard');

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

		$template = new Template('export_vcard_multiple');
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
		function convertToLaTeX ($s) {
			$s = str_replace('@', '(at)', $s);
			$s = str_replace('_', '\\_', $s);
			return $s;
		}


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

		$template = new Template('export_'.__FUNCTION__);
		$template->set('erg', $erg);
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
	 * Exports the currently selected group as dayolanner sheets
	 *
	 * The result is sent as a download file.
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function dayplanner() {
		function convertToLaTeX ($s) {
			$s = str_replace('@', '(at)', $s);
			$s = str_replace('_', '\\_', $s);
			return $s;
		}

		function bruch () {
			return "\n\n\\nopagebreak[4]";
		}

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
	 * Exports the currently selected group as an ICS birthday calender
	 *
	 * @global integer $_SESSION['f']
	 * @global integer $_SESSION['g']
	 */
	public function birthday_calendar() {
		echo 'BEGIN:VCALENDAR'."\n";
		echo 'VERSION:2.0'."\n";
		echo 'X-WR-CALNAME:'._('Birthdays')."\n";
		echo 'PRODID:'._('Address Database')."\n";
		echo 'X-WR-TIMEZONE:Europe/Berlin'."\n";
		echo 'CALSCALE:GREGORIAN'."\n";
		echo 'METHOD:PUBLISH'."\n"."\n";

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';

		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			if ($l['geb_j'] == 0)
				$l['geb_j'] = 2000;

			echo 'BEGIN:VEVENT'."\n";
			echo 'DTSTART;VALUE=DATE:'.$l['geb_j'];
			if ($l['geb_m'] < 10)
				echo '0';
			echo $l['geb_m'];
			if ($l['geb_t'] < 10)
				echo '0';
			echo $l['geb_t']."\n";


			echo 'SUMMARY:';
			$name = trim($l['vorname'].' '.$l['nachname']);
			if ($name[strlen($name)-1] == 'x' || $name[strlen($name)-1] == 's') {
				$name .= '\'';
			}
			else {
				$name .= 's';
			}
			echo $name.' '._('Birthday')."\n";
			echo 'UID:'.$l['p_id']."\n";
			echo 'RRULE:FREQ=YEARLY'."\n";
			echo 'DURATION:P1D'."\n";
			echo 'END:VEVENT'."\n"."\n";
		}

		echo 'END:VCALENDAR'."\n";

		die();
	}
}
?>
