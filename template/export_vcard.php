<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Exports a single VCard.
 */

header("Content-Type: text/x-vcard; charset=utf-8");
header('Content-Disposition: attachment; filename="'.$l['vorname'].$l['nachname'].'.vcf"');

if ($l['prafix'] != "-")
	echo $prafix = $l['prafix'];
else
	$prafix = '';

echo 'BEGIN:VCARD'."\n";
echo 'VERSION:3.0'."\n";
echo 'N;CHARSET=utf-8:'.$l['nachname'].';'.$l['vorname'].';'.$l['mittelname'].';'.$prafix.';'."\n";
echo 'FN;CHARSET=utf-8:'.$prafix.' '.$l['vorname'].' '.$l['mittelname'].' '.$l['nachname']."\n";

if (!empty($l['geburtsname']))
	echo 'X-MAIDENNAME;CHARSET=utf-8:'.$l['geburtsname']."\n";

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
	echo 'item1.ADR;type=HOME;type=pref;CHARSET=utf-8:;;'.$l['strasse'].';'.$l['ortsname'].';;'.$l['plz'].';'.$l['land']."\n";
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
?>
