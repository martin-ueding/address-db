<?PHP
$id = $_GET["id"];
$erg = select_person_alles($id);
$l = mysql_fetch_assoc($erg);
$person_loop = $l;

if ($_GET['sicher'] == 'ja') {
	if ($l['last_send'] > time()-24*3600) {
		$msgs[] = 'Die letzte Email wurde innerhalb der letzten 24 Stunden versendet, dies ist sicher ein Irrtum. Es wurde keine Email versandt.';
	}
	else {
		$mailtext .= '<style type="text/css">';
			$file = file('css/main.css');
			foreach ($file as $zeile) 
				$mailtext .= $zeile;
		$mailtext .= '</style>';


		$mailtext .= 'Guten Tag '.$l['vorname'].' '.$l['nachname'].',<br /><br />bitte nehmen Sie sich einen Augenblick und &uuml;berpr&uuml;fen Sie die Daten, die im Adressbuch f&uuml;r Sie gespeichert sind. Sind alle Daten korrekt, klicken Sie bitte auf den Link unten in der Email.<br /><br />Wenn Sie etwas korrigieren m&ouml;chten, antworten Sie bitte einfach auf diese Email und schildern Sie Ihre &Auml;nderungen. Erg&auml;nzungen (Emailadresse, Geburtsdatum, weitere Telefonnummern oder Chat-Pseudonyme) sind ebenfalls willkommen.<br /><br />Vielen Dank!<br /><br />';



		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Name:';
		$mailtext .= '</div>';

		$mailtext .= '<table id="name">';
		$mailtext .= '<tr>';
		$mailtext .= '<td class="links">Anrede:</td>';
		$mailtext .= '<td class="rechts">';
		if ($l['anrede'] != "-")
			$mailtext .= ' '.$l['anrede'];
		if ($l['prafix'] != "-")
			$mailtext .= ' '.$l['prafix'];
		$mailtext .= '</td>';
		$mailtext .= '</tr>';

		$mailtext .= '<tr>';
		$mailtext .= '<td class="links">Name:</td>';
		$mailtext .= '<td>';
		$mailtext .= '<b>'.$l['vorname'].'</b>';
		if (!empty($l['mittelname']))
			$mailtext .= ' '.$l['mittelname'];
		$mailtext .= ' <b>'.$l['nachname'].'</b>';
		if ($l['suffix'] != "-")
			$mailtext .= ' ('.$l['suffix'].')';
		if (!empty($l['geburtsname'])) 
			$mailtext .= ', geborene(r) '.$l['geburtsname'];
		$mailtext .= '</td>';
		$mailtext .= '</tr>';
		if (!empty($l['geb_t'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Geburtstag:</td>';
			$mailtext .= '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.';
			if ($l['geb_j'] > 1500) 
				$mailtext .= $l['geb_j'].' &nbsp;&nbsp; (heute '.alter($l['geb_t'],$l['geb_m'],$l['geb_j']).' Jahre alt)';
			$mailtext .= '</td>';
			$mailtext .= '</tr>';
			}
		$mailtext .= '</table>';

		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Adresse:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="adresse">';

		if ($l['adresse_r'] != 1) {
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Adresse:</td>';
			$mailtext .= '<td class="rechts">';
			$mailtext .= $l['strasse'];
			$mailtext .= ', ';
			$mailtext .= $l['plz'].' '.$l['ortsname'];
			$mailtext .= ' ('.$l['land'].')';
			$mailtext .= '</td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($l['ftel_privat'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Privat:</td>';
			$mailtext .= '<td>'.select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['ftel_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Arbeit:</td>';
			$mailtext .= '<td>'.select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['ftel_mobil'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($l['vw_mobil_r'])).'</i></td>';
			$mailtext .= '<td>'.select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['ftel_fax'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Fax:</td>';
			$mailtext .= '<td>'.select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['ftel_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Sonstiges:</td>';
			$mailtext .= '<td>'.select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= '</table>';

		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Telefon:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="telefon">';

		$mailtext .= "\n";
		if (!empty($l['tel_privat'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Privat:</td>';
			$mailtext .= '<td class="rechts">'.select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['tel_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Arbeit:</td>';
			$mailtext .= '<td>'.select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['tel_mobil'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($l['vw_mobil_r'])).'</i></td>';
			$mailtext .= '<td>'.select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['tel_fax'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Fax:</td>';
			$mailtext .= '<td>'.select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($l['tel_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Sonstiges:</td>';
			$mailtext .= '<td>'.select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].'</td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= '</table>';

		$mailtext .= "\n";		

		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Internet:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="online">';
		if (!empty($l['email_privat'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Privat:</td>';
			$mailtext .= '<td class="rechts"><a href="mailto:'.$l['email_privat'].'">'.$l['email_privat'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($l['email_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Arbeit:</td>';
			$mailtext .= '<td><a href="mailto:'.$l['email_arbeit'].'">'.$l['email_arbeit'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($l['email_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Sonstiges:</td>';
			$mailtext .= '<td><a href="mailto:'.$l['email_aux'].'">'.$l['email_aux'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($l['hp1'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Homepage 1:</td>';
			$mailtext .= '<td><a href="http://'.$l['hp1'].'" target="_blank">'.$l['hp1'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($l['hp2'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Homepage 2:</td>';
			$mailtext .= '<td><a href="http://'.$l['hp2'].'" target="_blank">'.$l['hp2'].'</a></td>';
			$mailtext .= '</tr>';
		}


		if (!empty($l['chat_aim'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat AIM:</td>';
			$mailtext .= '<td>'.$l['chat_aim'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($l['chat_msn'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat MSN:</td>';
			$mailtext .= '<td>'.$l['chat_msn'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($l['chat_icq'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat ICQ:</td>';
			$mailtext .= '<td>#'.$l['chat_icq'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($l['chat_yim'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Yahoo:</td>';
			$mailtext .= '<td>'.$l['chat_yim'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($l['chat_skype'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Skype:</td>';
			$mailtext .= '<td>'.$l['chat_skype'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($l['chat_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Aux:</td>';
			$mailtext .= '<td>'.$l['chat_aux'].'</td>';
			$mailtext .= '</tr>';
		}

				
		$mailtext .= '</table>';

		$mailtext .= "\n";

		$mailtext .= 'Bitte klicken Sie hier, wenn die Daten aktuell sind:<br /><br />'."\n".'<a href="'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($l['last_check']).'">'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($l['last_check']).'</a>';

				
						
		if (!empty($l['email_privat']))
			$email_an = $l['email_privat'];
		else if (!empty($l['email_arbeit']))
			$email_an = $l['email_arbeit'];
		else
			die();



		// eMaildaten angeben
		$titel = 'Bitte überprüfen Sie Ihre Daten';


		// Header erzeugen
		$header = "From:$admin_email\n";
		$header .= "Reply-To:$admin_email\n";
		$header .= "return-path:$admin_email\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\n";

		// eMail senden
		mail ($email_an, $titel, $mailtext, $header);


		// enter the sending of the mail into the database
		$sql = 'UPDATE ad_per SET last_send='.time().' WHERE p_id='.$id.';';
		mysql_query($sql);

		$msgs[] = 'Die Überprüfungsmail wurde verschickt.';
	}
	// get back to person_display
	$mode = 'person_display';
}
?>
