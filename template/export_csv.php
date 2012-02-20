<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Export into a CSV file.
 */

$csv = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
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

header("Content-Type: text/plain; charset=utf-8");
header('Content-Disposition: attachment; filename="adressen-'.time().'.csv"');

echo stream_get_contents($csv);

fclose($csv);
?>
