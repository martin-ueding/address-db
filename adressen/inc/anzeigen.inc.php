<?PHP
function alter($tag, $monat, $jahr) { // j, n
	$alter = date("Y") - $jahr;
	if ($monat > date("n") || ($monat == date("n") && $tag > date("j")))
		$alter--;
	return $alter;
}

function skplnk($nummer) {
	if ($nummer[0] != "+")
		$nummer = "+49" . substr($nummer, 1, strlen($nummer)-1);
		
	return '<a href="Callto://'.$nummer.'"><img src="eicons/10/skype10.png" /></a>';
}

function intelligent_date ($stamp) {
	global $date_format;
	$diff = time() - $stamp;

	// if the date is in the past ...
	if ($diff >= 0) {
		if ($diff < 15)
			return 'soeben';
		else if ($diff < 60)
			return 'in der letzten Minute';
		else if ($diff < 7200)
			return 'vor '.round($diff/60).' Minuten';
		else if ($diff < 86400)
			return 'vor '.round($diff/3600).' Stunden';
		else if ($stamp == 0)
			return 'nie';
		else
			return 'am '.date($date_format, $stamp);
	}
	else {
		return 'in der Zukunft ...';
	}
}

function gib_person_aus($id) {
	$erg = select_person_alles($id);

	$l = mysql_fetch_assoc($erg);
	
	echo '<div id="dialog">';

	if (file_exists('bilder/per'.$id.'.jpg')) {
		echo '<img src="bilder/per'.$id.'.jpg" width="120" height="180" />';
	}
	
	echo '<table>';
		echo '<tr>';
		echo '<td>Vorname:</td>';
		echo '<td>';


		echo '<b>'.$l['vorname'].'</b>';
		
		if (!empty($l['mittelname']))
			echo ' '.$l['mittelname'];

		echo ' <b>'.$l['nachname'].'</b>';
		

		echo '</td>';
		echo '</tr>';

		if (!empty($l['geburtsname'])) {	
			echo '<tr>';
			echo '<td>Geburtsname:</td>';
			echo '<td>'.$l['geburtsname'].'</td>';
			echo '</tr>';
		}
		
		echo '<tr><td colspan="2"><hr /></td></tr>';

		if ($l['adresse_r'] != 1) {

			echo '<tr>';
			echo '<td>Adresse:</td>';
			echo '<td>';
	
			echo $l['strasse'];
			echo '<br />';
			echo $l['plz'].', '.$l['ortsname'];
			echo '<br />';
			echo $l['land'];

			echo '<br />';
			echo '<a href="http://www.mapquest.com/maps/map.adp?country=de&address='.str_replace(' ', '+', $l['strasse']).'&city='.str_replace(' ', '+', $l['ortsname']).'&zip='.$l['plz'].'" target="_blank">Karte</a>';
	
			echo '</td>';
			echo '</tr>';

		}

		
		echo '<tr><td colspan="2"><hr /></td></tr>';

		if (!empty($l['tel_privat'])) {		
			echo '<tr>';
			echo '<td>Telefon Privat:</td>';
			echo '<td>'.select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['tel_arbeit'])) {	
			echo '<tr>';
			echo '<td>Telefon Arbeit:</td>';
			echo '<td>'.select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['tel_mobil'])) {	
			echo '<tr>';
			echo '<td>Handy:</td>';
			echo '<td>'.select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].' '.handybetreiber(select_vw_id($l['vw_mobil_r'])).'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['tel_fax'])) {		
			echo '<tr>';
			echo '<td>Fax:</td>';
			echo '<td>'.select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['tel_aux'])) {	
			echo '<tr>';
			echo '<td>Telefon Sonstiges:</td>';
			echo '<td>'.select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].'</td>';
			echo '</tr>';
		}

		echo '<tr><td colspan="2"><hr /></td></tr>';

		if (!empty($l['ftel_privat'])) {		
			echo '<tr>';
			echo '<td>Familen Telefon Privat:</td>';
			echo '<td>'.select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['ftel_arbeit'])) {	
			echo '<tr>';
			echo '<td>Familen Telefon Arbeit:</td>';
			echo '<td>'.select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['ftel_mobil'])) {	
			echo '<tr>';
			echo '<td>Familen Handy:</td>';
			echo '<td>'.select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['ftel_fax'])) {		
			echo '<tr>';
			echo '<td>Familen Fax:</td>';
			echo '<td>'.select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].'</td>';
			echo '</tr>';
		}
		
		if (!empty($l['ftel_aux'])) {	
			echo '<tr>';
			echo '<td>Familen Telefon Sonstiges:</td>';
			echo '<td>'.select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].'</td>';
			echo '</tr>';
		}

		
		echo '<tr><td colspan="2"><hr /></td></tr>';


		if (!empty($l['email_privat'])) {	
			echo '<tr>';
			echo '<td>Email Privat:</td>';
			echo '<td><a href="mailto:'.$l['email_privat'].'">'.$l['email_privat'].'</a></td>';
			echo '</tr>';
		}

		if (!empty($l['email_arbeit'])) {	
			echo '<tr>';
			echo '<td>Email Arbeit:</td>';
			echo '<td><a href="mailto:'.$l['email_arbeit'].'">'.$l['email_arbeit'].'</a></td>';
			echo '</tr>';
		}

		if (!empty($l['email_aux'])) {	
			echo '<tr>';
			echo '<td>Email Sonstiges:</td>';
			echo '<td><a href="mailto:'.$l['email_aux'].'">'.$l['email_aux'].'</a></td>';
			echo '</tr>';
		}

		if (!empty($l['hp1'])) {	
			echo '<tr>';
			echo '<td>Homepage 1:</td>';
			echo '<td><a href="http://'.$l['hp1'].'" target="_blank">'.$l['hp1'].'</a></td>';
			echo '</tr>';
		}

		if (!empty($l['hp2'])) {	
			echo '<tr>';
			echo '<td>Homepage 2:</td>';
			echo '<td><a href="http://'.$l['hp2'].'" target="_blank">'.$l['hp2'].'</a></td>';
			echo '</tr>';
		}
		
		echo '<tr><td colspan="2"><hr /></td></tr>';

		if (!empty($l['geb_t'])) {	
			echo '<tr>';
			echo '<td>Geburtstag:</td>';
			echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.'.$l['geb_j'].' ('.alter($l['geb_t'],$l['geb_m'],$l['geb_j']).')</td>';
			echo '</tr>';
		}
		
		echo '<tr><td colspan="2"><hr /></td></tr>';

		if (!empty($l['chat_aim'])) {	
			echo '<tr>';
			echo '<td>Chat AIM:</td>';
			echo '<td>'.$l['chat_aim'].'</td>';
			echo '</tr>';
		}

		if (!empty($l['chat_msn'])) {	
			echo '<tr>';
			echo '<td>Chat MSN:</td>';
			echo '<td>'.$l['chat_msn'].'</td>';
			echo '</tr>';
		}

		if (!empty($l['chat_icq'])) {	
			echo '<tr>';
			echo '<td>Chat ICQ:</td>';
			echo '<td>#'.$l['chat_icq'].'</td>';
			echo '</tr>';
		}

		if (!empty($l['chat_yim'])) {	
			echo '<tr>';
			echo '<td>Chat Yahoo:</td>';
			echo '<td>'.$l['chat_yim'].'</td>';
			echo '</tr>';
		}

		if (!empty($l['chat_skype'])) {	
			echo '<tr>';
			echo '<td>Chat Skype:</td>';
			echo '<td>'.$l['chat_skype'].'</td>';
			echo '</tr>';
		}

		if (!empty($l['chat_aux'])) {	
			echo '<tr>';
			echo '<td>Chat Aux:</td>';
			echo '<td>'.$l['chat_aux'].'</td>';
			echo '</tr>';
		}
		
		echo '<tr><td colspan="2"><hr /></td></tr>';

		if (!empty($l['pnotizen'])) {	
			echo '<tr>';
			echo '<td>Notizen:</td>';
			echo '<td>'.$l['pnotizen'].'</td>';
			echo '</tr>';
		}

//		Gruppen

		$erg = select_gruppen_zu_person($id);

		if (mysql_num_rows($erg) > 0) {
			echo '<tr>';
			echo '<td>Gruppen:</td>';
			echo '<td>';

			while ($l = mysql_fetch_assoc($erg)) {
				echo $l['gruppe'].'<br />';
				
			}
			echo '</td>';
			echo '</tr>';
		}

		$erg = select_fmg_zu_person($id);

		if (mysql_num_rows($erg) > 0) {
			echo '<tr>';
			echo '<td>FMG:</td>';
			echo '<td>';

			while ($l = mysql_fetch_assoc($erg)) {
				echo $l['fmg'].'<br />';
				
			}
			echo '</td>';
			echo '</tr>';
		}
					
		echo '</table>';
}
?>
