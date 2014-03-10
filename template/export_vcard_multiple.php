<?php
# Copyright © 2012, 2014 Martin Ueding <dev@martin-ueding.de>

/**
 * Exports a list as a big VCard.
 */

header("Content-Type: text/x-vcard; charset=utf-8");
header('Content-Disposition: attachment; filename="adressen-'.time().'.vcf"');

while ($l = mysql_fetch_assoc($erg)) {
    if ($l['prafix'] != "-")
        $prafix = $l['prafix'];
    else
        $prafix = '';

    echo 'BEGIN:VCARD'."\n";
    echo 'VERSION:3.0'."\n";
    echo 'N;CHARSET=utf-8:'.$l['nachname'].';'.$l['vorname'].';'.$l['mittelname'].';'.$prafix.';'."\n";

    $fn_array = array();
    if (strlen($prafix) > 0)
        $fn_array[] = $prafix;
    if (strlen($l['vorname']) > 0)
        $fn_array[] = $l['vorname'];
    if (strlen($l['mittelname']) > 0)
        $fn_array[] = $l['mittelname'];
    if (strlen($l['nachname']) > 0)
        $fn_array[] = $l['nachname'];
    $fn = implode(' ', $fn_array);
    echo 'FN;CHARSET=utf-8:'.$fn."\n";

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
        echo 'ADR;type=HOME;type=pref;CHARSET=utf-8:;;'.$l['strasse'].';'.$l['ortsname'].';;'.$l['plz'].';'.$l['land']."\n";
    }

    if (!empty($l['pnotizen'])) {
        $cleaned = str_replace("\n", ' ', $l['pnotizen']);
        $cleaned = str_replace("\r", ' ', $cleaned);
        echo 'NOTE;CHARSET=utf-8:'.$cleaned."\n";
    }

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

    if (!empty($l['chat_skype']))
        echo 'X-SKYPE;type=HOME;type=pref:'.$l['chat_skype']."\n";

    if (!empty($l['chat_aux']))
        echo 'X-JABBER;type=HOME;type=pref:'.$l['chat_aux']."\n";

    $erg2 = Person::select_gruppen_zu_person($l['p_id']);
    $groups = array();
    while ($l2 = mysql_fetch_assoc($erg2)) {
        $groups[] = $l2['gruppe'];
    }

    if (count($groups) > 0) {
        echo 'CATEGORIES:'.implode(',', $groups)."\n";
    }

    echo 'END:VCARD'."\n";

    echo "\n\n\n";
}
?>
