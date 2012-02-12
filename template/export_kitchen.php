<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Export for kitchen sheets.
 *
 * Produces a LaTeX output.
 */

require_once('helper/Latex.php');

$SCHRIFTGROESSE = 9;
header("Content-Type: text/plain; charset=iso-8859-1");
header('Content-Disposition: attachment; filename="adressen-'.time().'.tex"');

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
			$content .= $l['strasse'].Latex::bruch().$l['ortsname'].' '.$l['plz'].Latex::bruch();
		}
	}

	// TODO i18n
	if (!empty($l['tel_privat']))
		$content .= 'Tel Privat: '.AreaCode::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].Latex::bruch();

	if (!empty($l['tel_arbeit']))
		$content .= 'Tel Arbeit: '.AreaCode::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].Latex::bruch();

	if (!empty($l['tel_mobil']))
		$content .= 'Handy: '.AreaCode::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].Latex::bruch();

	if (!empty($l['tel_fax']))
		$content .= 'Fax: '.AreaCode::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].Latex::bruch();

	if (!empty($l['tel_aux']))
		$content .= 'Tel: '.AreaCode::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].Latex::bruch();

	if (isset($last) && $last['adresse_r'] != $l['adresse_r']) {
		if (!empty($l['ftel_privat']))
			$content .= 'Tel Privat: '.AreaCode::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].Latex::bruch();

		if (!empty($l['ftel_arbeit']))
			$content .= 'Tel Arbeit: '.AreaCode::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].Latex::bruch();

		if (!empty($l['ftel_mobil']))
			$content .= 'Handy: '.AreaCode::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].Latex::bruch();

		if (!empty($l['ftel_fax']))
			$content .= 'Fax: '.AreaCode::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].Latex::bruch();

		if (!empty($l['ftel_aux']))
			$content .= 'Tel: '.AreaCode::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].Latex::bruch();
	}


	if (strlen($content) > 0) {
		echo $name;
		echo $content;

		if (!empty($l['pnotizen'])) {
			echo '\\begin{verbatim}'.wordwrap($l['pnotizen'], 33, "\n", true).'\\end{verbatim}'.Latex::bruch();
		}

	}

	$last = $l;
}

echo '\end{multicols}';

echo '\end{document}';
?>
