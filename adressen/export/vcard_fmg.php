<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

include('../_config.inc.php');
include('../inc/abfragen.inc.php');
include("../inc/anzeigen.inc.php");
include("../inc/select.inc.php");
include("../inc/varclean.inc.php");



header("Content-Type: text/x-vcard; charset=iso-8859-1");
header('Content-Disposition: attachment; filename="adressen-'.time().'.vcf"');


if (empty($_GET['f']))
	die();


$sql = 'SELECT * FROM ad_per, ad_flinks, ad_adressen, ad_orte, ad_plz, ad_laender, ad_anreden, ad_prafixe, ad_suffixe WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' && adresse_r=ad_id && ort_r=o_id && plz_r=plz_id && land_r=l_id && anrede_r=a_id && prafix_r=prafix_id && suffix_r=s_id ORDER BY nachname, vorname;';


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
		echo 'TEL;type=HOME;type=pref:'.Queries::select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat']."\n";
	
	if (!empty($l['tel_arbeit']))
		echo 'TEL;type=WORK:'.Queries::select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit']."\n";
	
	if (!empty($l['tel_mobil']))
		echo 'TEL;type=CELL:'.Queries::select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil']."\n";
	
	if (!empty($l['tel_fax']))
		echo 'TEL;type=HOME;type=FAX:'.Queries::select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax']."\n";
	
	if (!empty($l['tel_aux']))
		echo 'TEL;type=HOME:'.Queries::select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux']."\n";
	
	if (!empty($l['ftel_privat']))
		echo 'TEL;type=HOME:'.Queries::select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat']."\n";
	
	if (!empty($l['ftel_arbeit']))
		echo 'TEL;type=WORK:'.Queries::select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit']."\n";
	
	if (!empty($l['ftel_mobil']))
		echo 'TEL;type=CELL:'.Queries::select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil']."\n";
	
	if (!empty($l['ftel_fax']))
		echo 'TEL;type=HOME;type=FAX:'.Queries::select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax']."\n";
	
	if (!empty($l['ftel_aux']))
		echo 'TEL;type=HOME:'.Queries::select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux']."\n";
	
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

?>
