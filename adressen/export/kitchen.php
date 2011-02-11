<?PHP

$SCHRIFTGROESSE = 9;

include('../_config.inc.php');
include('../inc/abfragen.inc.php');
include("../inc/anzeigen.inc.php");
include("../inc/select.inc.php");
include("../inc/varclean.inc.php");

header("Content-Type: text/plain; charset=iso-8859-1");
header('Content-Disposition: attachment; filename="adressen-'.time().'.tex"');

function convertToLaTeX ($s) {
	$s = str_replace('@', '(at)', $s);
	$s = str_replace('_', '\\_', $s);
	return $s;
}

$sql = 'SELECT * FROM ad_per, ad_adressen, ad_orte, ad_plz, ad_laender, ad_anreden, ad_prafixe, ad_suffixe WHERE adresse_r=ad_id && ort_r=o_id && plz_r=plz_id && land_r=l_id && anrede_r=a_id && prafix_r=prafix_id && suffix_r=s_id ORDER BY nachname, adresse_r, vorname;';

echo '\documentclass[10pt]{article}
\usepackage[left=7mm, right=7mm, top=7mm, bottom=7mm, scale=1, landscape]{geometry}
\geometry{a4paper}
\setlength{\parindent}{0cm}
\usepackage[latin1]{inputenc}
\usepackage{multicol}
';


echo '\begin{document} \sffamily'."\n";

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
		
	$name = '\section*{'.trim($prafix.' '.$l['vorname'].' '.$l['nachname']).'}'."\n";

	$content = '';

	if ($last['adresse_r'] != $l['adresse_r']) {
		if ($l['adresse_r'] != 1) {
			$content .= $l['strasse'].bruch().$l['ortsname'].' '.$l['plz'].bruch();
		}
	}
	
	// TODO i18n
	if (!empty($l['tel_privat']))
		$content .= 'Tel Privat: '.select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].bruch();
	
	if (!empty($l['tel_arbeit']))
		$content .= 'Tel Arbeit: '.select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].bruch();
	
	if (!empty($l['tel_mobil']))
		$content .= 'Handy: '.select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].bruch();
	
	if (!empty($l['tel_fax']))
		$content .= 'Fax: '.select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].bruch();
	
	if (!empty($l['tel_aux']))
		$content .= 'Tel: '.select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].bruch();
	
	if ($last['adresse_r'] != $l['adresse_r']) {
		if (!empty($l['ftel_privat']))
			$content .= 'Tel Privat: '.select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].bruch();
		
		if (!empty($l['ftel_arbeit']))
			$content .= 'Tel Arbeit: '.select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].bruch();
		
		if (!empty($l['ftel_mobil']))
			$content .= 'Handy: '.select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].bruch();
		
		if (!empty($l['ftel_fax']))
			$content .= 'Fax: '.select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].bruch();
		
		if (!empty($l['ftel_aux']))
			$content .= 'Tel: '.select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].bruch();
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

?>
