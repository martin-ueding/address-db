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
		$MAX_PRO_SEITE = 3;
		$SCHRIFTGROESSE = 7;

		header("Content-Type: text/plain; charset=iso-8859-1");
		header('Content-Disposition: attachment; filename="adressen-'.time().'.tex"');

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

		echo '\documentclass[10pt]{book}'."\n";
		echo '\usepackage[paperwidth=8cm, paperheight=12cm, outer=3mm, inner=12mm, top=3mm, bottom=3mm, scale=1, twoside]{geometry}'."\n";
		//echo '\usepackage[iso-8859-1]{inputenc}'.bruch();
		echo '\setlength{\parindent}{0cm}';
		echo '\usepackage[latin1]{inputenc}';


		echo '\begin{document}'."\n";

		echo '\fontsize{'.$SCHRIFTGROESSE.'}{'.round($SCHRIFTGROESSE*1.4).'}'."\n";
		echo '\selectfont'."\n";

		$zaehler = 0;

		function bruch () {
			return "\n\n\\nopagebreak[4]";
		}

		$nachname_buchstabe = '';

		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {

			$umbruchbeiarray = array('C', 'E', 'G', 'I', 'K', 'M', 'O', 'Q', 'S', 'U', 'X');

			if (isset($l['nachname'][0]) && $l['nachname'][0] != $nachname_buchstabe) {
				$nachname_buchstabe = $l['nachname'][0];

				if (array_search($nachname_buchstabe, $umbruchbeiarray) == $nachname_buchstabe) {
					//		echo '\chapter*{'.$nachname_buchstabe.'}'."\n";
					echo '\cleardoublepage'."\n";
				}
			}


			if ($l['prafix'] != "-")
				$prafix = $l['prafix'];
			else
				$prafix = '';

			echo '\section*{'.$prafix.' '.$l['vorname'].' '.$l['nachname'].'}'."\n";

			if ($l['adresse_r'] != 1) {
				echo $l['strasse'].bruch().$l['ortsname'].' '.$l['plz'].bruch();
			}

			if (!empty($l['email_privat']))
				echo 'Email P: '.convertToLaTeX($l['email_privat']).bruch();

			if (!empty($l['email_arbeit']))
				echo 'Email A: '.convertToLaTeX($l['email_arbeit']).bruch();

			if (!empty($l['email_aux']))
				echo 'Email: '.convertToLaTeX($l['email_aux']).bruch();


			if (!empty($l['tel_privat']))
				echo 'Tel P: '.AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].bruch();

			if (!empty($l['tel_arbeit']))
				echo 'Tel A: '.AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].bruch();

			if (!empty($l['tel_mobil']))
				echo 'Handy: '.AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].bruch();

			if (!empty($l['tel_fax']))
				echo 'Fax: '.AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].bruch();

			if (!empty($l['tel_aux']))
				echo 'Tel: '.AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].bruch();

			if (!empty($l['ftel_privat']))
				echo 'Tel P: '.AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].bruch();

			if (!empty($l['ftel_arbeit']))
				echo 'Tel A: '.AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].bruch();

			if (!empty($l['ftel_mobil']))
				echo 'Handy: '.AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].bruch();

			if (!empty($l['ftel_fax']))
				echo 'Fax: '.AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].bruch();

			if (!empty($l['ftel_aux']))
				echo 'Tel: '.AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].bruch();


			if (!empty($l['hp1'])) {
				echo 'http://'.$l['hp1'].bruch();
			}

			if (!empty($l['hp2'])) {
				echo 'http://'.$l['hp2'].bruch();
			}

			if ($l['geb_j'] == 0)
				$l['geb_j'] = '';

			if (!empty($l['geb_t']))
				echo $l['geb_t'].'.'.$l['geb_m'].'.'.$l['geb_j'].bruch();

			if (!empty($l['pnotizen']))
				echo '\\begin{verbatim}'.$l['pnotizen'].'\\end{verbatim}'.bruch();


			//	$zaehler++;
			//	if ($zaehler % $MAX_PRO_SEITE == 0)
			//		echo '\newpage'.bruch();
			//	else
			//		echo '\vspace{1cm}';

		}


		echo '\end{document}';

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
