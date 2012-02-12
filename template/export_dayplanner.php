<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Export for dayplanner sheets.
 *
 * Produces a LaTeX output.
 */

$MAX_PRO_SEITE = 3;
$SCHRIFTGROESSE = 7;

header("Content-Type: text/plain; charset=iso-8859-1");
header('Content-Disposition: attachment; filename="adressen-'.time().'.tex"');

echo '\documentclass[10pt]{book}'."\n";
echo '\usepackage[paperwidth=8cm, paperheight=12cm, outer=3mm, inner=12mm, top=3mm, bottom=3mm, scale=1, twoside]{geometry}'."\n";
echo '\setlength{\parindent}{0cm}';
echo '\usepackage[latin1]{inputenc}';


echo '\begin{document}'."\n";

echo '\fontsize{'.$SCHRIFTGROESSE.'}{'.round($SCHRIFTGROESSE*1.4).'}'."\n";
echo '\selectfont'."\n";

$zaehler = 0;

$nachname_buchstabe = '';

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
?>
