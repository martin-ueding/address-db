<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('controller/Controller.php');
require_once('model/Person.php');
require_once('model/AreaCode.php');

class ExportController extends Controller {
	public function vcard() {
		$id = $_GET['id'];

		$erg = Person::select_person_alles($id);

		$l = mysql_fetch_assoc($erg);

		header("Content-Type: text/x-vcard; charset=iso-8859-1");
		header('Content-Disposition: attachment; filename="'.$l['vorname'].$l['nachname'].'.vcf"');

		if ($l['prafix'] != "-")
			echo $prafix = $l['prafix'];
		else
			$prafix = '';

		echo 'BEGIN:VCARD'."\n";
		echo 'VERSION:3.0'."\n";
		echo 'N;CHARSET=iso-8859-1:'.$l['nachname'].';'.$l['vorname'].';'.$l['mittelname'].';'.$prafix.';'."\n";
		echo 'FN;CHARSET=iso-8859-1:'.$prafix.' '.$l['vorname'].' '.$l['mittelname'].' '.$l['nachname']."\n";

		if (!empty($l['geburtsname']))
			echo 'X-MAIDENNAME;CHARSET=iso-8859-1:'.$l['geburtsname']."\n";

		if (!empty($l['email_privat']))
			echo 'EMAIL;type=INTERNET;type=HOME;type=pref:'.$l['email_privat']."\n";

		if (!empty($l['email_arbeit']))
			echo 'EMAIL;type=INTERNET;type=WORK:'.$l['email_arbeit']."\n";

		if (!empty($l['email_aux']))
			echo 'EMAIL;type=INTERNET;type=HOME:'.$l['email_aux']."\n";


		if (!empty($l['tel_privat']))
			echo 'TEL;type=HOME;type=pref:'.AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat']."\n";

		if (!empty($l['tel_arbeit']))
			echo 'TEL;type=WORK:'.AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit']."\n";

		if (!empty($l['tel_mobil']))
			echo 'TEL;type=CELL:'.AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil']."\n";

		if (!empty($l['tel_fax']))
			echo 'TEL;type=HOME;type=FAX:'.AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax']."\n";

		if (!empty($l['tel_aux']))
			echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux']."\n";

		if (!empty($l['ftel_privat']))
			echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat']."\n";

		if (!empty($l['ftel_arbeit']))
			echo 'TEL;type=WORK:'.AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit']."\n";

		if (!empty($l['ftel_mobil']))
			echo 'TEL;type=CELL:'.AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil']."\n";

		if (!empty($l['ftel_fax']))
			echo 'TEL;type=HOME;type=FAX:'.AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax']."\n";

		if (!empty($l['ftel_aux']))
			echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux']."\n";

		if ($l['adresse_r'] != 1) {
			echo 'item1.ADR;type=HOME;type=pref;CHARSET=iso-8859-1:;;'.$l['strasse'].';'.$l['ortsname'].';;'.$l['plz'].';'.$l['land']."\n";
			echo 'item1.X-ABADR:de'."\n";
		}



		if (!empty($l['hp1'])) {
			echo 'item2.URL;type=pref:http://'.$l['hp1']."\n";
			echo 'item2.X-ABLabel:_$!<HomePage>!$_'."\n";
		}

		if (!empty($l['hp2'])) {
			echo 'item2.URL;type=pref:http://'.$l['hp2']."\n";
			echo 'item2.X-ABLabel:_$!<HomePage>!$_'."\n";
		}

		if (!empty($l['geb_t']))
			echo 'BDAY;value=date:'.$l['geb_j'].'-'.$l['geb_m'].'-'.$l['geb_t']."\n";

		if (!empty($l['chat_aim']))
			echo 'X-AIM;type=HOME;type=pref:'.$l['chat_aim']."\n";

		if (!empty($l['chat_msn']))
			echo 'X-MSN;type=HOME;type=pref:'.$l['chat_msn']."\n";

		if (!empty($l['chat_icq']))
			echo 'X-ICQ;type=HOME;type=pref:'.$l['chat_icq']."\n";

		if (!empty($l['chat_yim']))
			echo 'X-YAHOO;type=HOME;type=pref:'.$l['chat_yim']."\n";

		if (!empty($l['chat_skype']))
			echo 'X-JABBER;type=HOME;type=pref:'.$l['chat_skype']."\n";

		if (!empty($l['chat_aux']))
			echo 'X-JABBER;type=HOME;type=pref:'.$l['chat_aux']."\n";


		echo 'END:VCARD'."\n";

		die();
	}

	public function vcard_multiple() {
		header("Content-Type: text/x-vcard; charset=iso-8859-1");
		header('Content-Disposition: attachment; filename="adressen-'.time().'.vcf"');


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
		while ($l = mysql_fetch_assoc($erg)) {
			if ($l['prafix'] != "-")
				$prafix = $l['prafix'];
			else
				$prafix = '';

			echo 'BEGIN:VCARD'."\n";
			echo 'VERSION:3.0'."\n";
			echo 'N;CHARSET=iso-8859-1:'.$l['nachname'].';'.$l['vorname'].';'.$l['mittelname'].';'.$prafix.';'."\n";
			echo 'FN;CHARSET=iso-8859-1:'.trim($prafix.' '.$l['vorname'].' '.$l['mittelname'].' '.$l['nachname'])."\n";

			if (!empty($l['geburtsname']))
				echo 'X-MAIDENNAME;CHARSET=iso-8859-1:'.$l['geburtsname']."\n";

			if (!empty($l['email_privat']))
				echo 'EMAIL;type=INTERNET;type=HOME;type=pref:'.$l['email_privat']."\n";

			if (!empty($l['email_arbeit']))
				echo 'EMAIL;type=INTERNET;type=WORK:'.$l['email_arbeit']."\n";

			if (!empty($l['email_aux']))
				echo 'EMAIL;type=INTERNET;type=HOME:'.$l['email_aux']."\n";


			if (!empty($l['tel_privat']))
				echo 'TEL;type=HOME;type=pref:'.AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat']."\n";

			if (!empty($l['tel_arbeit']))
				echo 'TEL;type=WORK:'.AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit']."\n";

			if (!empty($l['tel_mobil']))
				echo 'TEL;type=CELL:'.AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil']."\n";

			if (!empty($l['tel_fax']))
				echo 'TEL;type=HOME;type=FAX:'.AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax']."\n";

			if (!empty($l['tel_aux']))
				echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux']."\n";

			if (!empty($l['ftel_privat']))
				echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat']."\n";

			if (!empty($l['ftel_arbeit']))
				echo 'TEL;type=WORK:'.AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit']."\n";

			if (!empty($l['ftel_mobil']))
				echo 'TEL;type=CELL:'.AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil']."\n";

			if (!empty($l['ftel_fax']))
				echo 'TEL;type=HOME;type=FAX:'.AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax']."\n";

			if (!empty($l['ftel_aux']))
				echo 'TEL;type=HOME:'.AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux']."\n";

			if ($l['adresse_r'] != 1) {
				echo 'ADR;type=HOME;type=pref;CHARSET=iso-8859-1:;;'.$l['strasse'].';'.$l['ortsname'].';;'.$l['plz'].';'.$l['land']."\n";
			}




			//	if (!empty($l['pnotizen']))
			//		echo 'NOTE;CHARSET=iso-8859-1: '.$l['pnotizen']."\n";


			if (!empty($l['hp1'])) {
				echo 'URL;type=pref:http://'.$l['hp1']."\n";
			}

			if (!empty($l['hp2'])) {
				echo 'URL;type=pref:http://'.$l['hp2']."\n";
			}

			if (!empty($l['geb_t']))
				echo 'BDAY;value=date:'.$l['geb_j'].'-'.$l['geb_m'].'-'.$l['geb_t']."\n";

			if (!empty($l['chat_aim']))
				echo 'X-AIM;type=HOME;type=pref:'.$l['chat_aim']."\n";

			if (!empty($l['chat_msn']))
				echo 'X-MSN;type=HOME;type=pref:'.$l['chat_msn']."\n";

			if (!empty($l['chat_icq']))
				echo 'X-ICQ;type=HOME;type=pref:'.$l['chat_icq']."\n";

			if (!empty($l['chat_yim']))
				echo 'X-YAHOO;type=HOME;type=pref:'.$l['chat_yim']."\n";

			//	if (!empty($l['chat_skype']))
			//		echo 'X-JABBER;type=HOME;type=pref:'.$l['chat_skype']."\n";

			if (!empty($l['chat_aux']))
				echo 'X-JABBER;type=HOME;type=pref:'.$l['chat_aux']."\n";


			echo 'END:VCARD'."\n";

			echo "\n\n\n";
		}

		die();
	}

	public function kitchen() {
		$SCHRIFTGROESSE = 9;
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

		echo '\documentclass[10pt]{article}
		\usepackage[left=7mm, right=7mm, top=7mm, bottom=7mm, scale=1, landscape]{geometry}
		\geometry{a4paper}
		\setlength{\parindent}{0cm}
		\usepackage[latin1]{inputenc}
		\usepackage{multicol}
		\renewcommand\sfdefault{phv}
		\renewcommand\familydefault{\sfdefault}
		';


		echo '\begin{document}'."\n";

		//echo '\fontsize{'.$SCHRIFTGROESSE.'}{'.round($SCHRIFTGROESSE*1.4).'}'."\n";
		//echo '\selectfont'."\n";


		function bruch () {
			return "\n\n\\nopagebreak[4]";
		}
		echo '\begin{multicols}{4}';


		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {

			if ($l['prafix'] != "-")
				$prafix = $l['prafix'];
			else
				$prafix = '';

			$display_name = trim($prafix.' '.$l['nachname'].', '.$l['vorname'], ' ,');
			$name = '\section*{'.$display_name.'}'."\n";

			$content = '';

			if (isset($last) && $last['adresse_r'] != $l['adresse_r']) {
				if ($l['adresse_r'] != 1) {
					$content .= $l['strasse'].bruch().$l['ortsname'].' '.$l['plz'].bruch();
				}
			}

			// TODO i18n
			if (!empty($l['tel_privat']))
				$content .= 'Tel Privat: '.AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].bruch();

			if (!empty($l['tel_arbeit']))
				$content .= 'Tel Arbeit: '.AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].bruch();

			if (!empty($l['tel_mobil']))
				$content .= 'Handy: '.AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].bruch();

			if (!empty($l['tel_fax']))
				$content .= 'Fax: '.AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].bruch();

			if (!empty($l['tel_aux']))
				$content .= 'Tel: '.AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].bruch();

			if (isset($last) && $last['adresse_r'] != $l['adresse_r']) {
				if (!empty($l['ftel_privat']))
					$content .= 'Tel Privat: '.AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].bruch();

				if (!empty($l['ftel_arbeit']))
					$content .= 'Tel Arbeit: '.AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].bruch();

				if (!empty($l['ftel_mobil']))
					$content .= 'Handy: '.AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].bruch();

				if (!empty($l['ftel_fax']))
					$content .= 'Fax: '.AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].bruch();

				if (!empty($l['ftel_aux']))
					$content .= 'Tel: '.AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].bruch();
			}


			if (strlen($content) > 0) {
				echo $name;
				echo $content;

				if (!empty($l['pnotizen'])) {
					echo '\\begin{verbatim}'.wordwrap($l['pnotizen'], 33, "\n", true).'\\end{verbatim}'.bruch();
				}

			}

			$last = $l;
		}

		echo '\end{multicols}';

		echo '\end{document}';

		die();
	}

	public function csv() {
		$csv = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

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
		while ($l = mysql_fetch_assoc($erg)) {

			$data[] = $l['vorname'];
			$data[] = $l['nachname'];
			$data[] = $l['email_privat'];
			$data[] = $l['email_arbeit'];
			$data[] = AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'];
			$data[] = AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'];
			$data[] = AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'];
			$data[] = AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'];
			$data[] = $l['strasse'];
			$data[] = $l['ortsname'];
			$data[] = $l['plz'];
			$data[] = $l['land'];
			$data[] = 'http://'.$l['hp1'];
			$data[] = 'http://'.$l['hp2'];
			$data[] = $l['geb_j'];
			$data[] = $l['geb_m'];
			$data[] = $l['geb_t'];


			$data[] = $l['prafix'];
			$data[] = $l['geburtsname'];
			$data[] = $l['email_aux'];
			$data[] = AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'];
			$data[] = AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'];
			$data[] = AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'];
			$data[] = AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'];
			$data[] = AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'];
			$data[] = AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'];
			$data[] = $l['chat_aim'];
			$data[] = $l['chat_msn'];
			$data[] = $l['chat_icq'];
			$data[] = $l['chat_yim'];
			$data[] = $l['chat_skype'];
			$data[] = $l['chat_aux'];

			$data[] = $l['pnotizen'];

			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i] == '-') {
					$data[$i] = "";
				}
			}

			fputcsv($csv, $data);



			unset($data);
		}

		rewind($csv);

		header("Content-Type: text/plain; charset=iso-8859-1");
		header('Content-Disposition: attachment; filename="adressen-'.time().'.csv"');

		echo stream_get_contents($csv);

		fclose($csv);

		die();
	}
}
?>
