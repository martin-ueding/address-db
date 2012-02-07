<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

include('../_config.inc.php');
include('../inc/abfragen.inc.php');
include("../inc/anzeigen.inc.php");
include("../inc/select.inc.php");
include("../inc/varclean.inc.php");

if (empty($_GET['f']))
	die();


$sql = 'SELECT * '.
	'FROM ad_per, ad_flinks, ad_adressen, ad_orte, ad_plz, ad_laender, ad_anreden, ad_prafixe, ad_suffixe '.
	'WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' && adresse_r=ad_id && ort_r=o_id && plz_r=plz_id && land_r=l_id && anrede_r=a_id && prafix_r=prafix_id && suffix_r=s_id '.
	'ORDER BY nachname, vorname;';


$filename = "adressen-".time().".csv";
$h = fopen($filename, "w");
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {

	$data[] = $l['vorname'];
	$data[] = $l['nachname'];
	$data[] = $l['email_privat'];
	$data[] = $l['email_arbeit'];
	$data[] = Queries::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'];
	$data[] = Queries::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'];
	$data[] = Queries::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'];
	$data[] = Queries::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'];
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
	$data[] = Queries::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'];
	$data[] = Queries::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'];
	$data[] = Queries::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'];
	$data[] = Queries::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'];
	$data[] = Queries::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'];
	$data[] = Queries::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'];
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

	fputcsv($h, $data);

	unset($data);
}
fclose($h);

header('location:'.$filename);

?>
