<?PHP
if ($_GET['sicher'] == 'ja') {
	if ($person_loop['last_send'] > time()-24*3600) {
		$msgs[] = _('The last email was sent within the last 24 hours. No email was sent now because this looks like an error.');
	}
	else {
		

		$mailtext .= '<style type="text/css">';
		$file = file('gfx/main.css');
		foreach ($file as $zeile) 
			$mailtext .= $zeile;
		$mailtext .= '</style>';


		$mailtext .= _('Dear').' '.$person_loop['vorname'].' '.$person_loop['nachname'].',<br /><br />'._('please take a minute and control your data that we have saved in our address book. If everything is correct, please click on the link at the bottom of this email.').'<br /><br />'._('If you want to correct something, please feel free to reply to this mail and tell us the changes. Amendments are welcomed as well.').'<br /><br />'._('Thank you!').'<br /><br />';



		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Name:';
		$mailtext .= '</div>';

		$mailtext .= '<table id="name">';
		$mailtext .= '<tr>';
		$mailtext .= '<td class="links">Anrede:</td>';
		$mailtext .= '<td class="rechts">';
		if ($person_loop['anrede'] != "-")
			$mailtext .= ' '.$person_loop['anrede'];
		if ($person_loop['prafix'] != "-")
			$mailtext .= ' '.$person_loop['prafix'];
		$mailtext .= '</td>';
		$mailtext .= '</tr>';

		$mailtext .= '<tr>';
		$mailtext .= '<td class="links">Name:</td>';
		$mailtext .= '<td>';
		$mailtext .= '<b>'.$person_loop['vorname'].'</b>';
		if (!empty($person_loop['mittelname']))
			$mailtext .= ' '.$person_loop['mittelname'];
		$mailtext .= ' <b>'.$person_loop['nachname'].'</b>';
		if ($person_loop['suffix'] != "-")
			$mailtext .= ' ('.$person_loop['suffix'].')';
		if (!empty($person_loop['geburtsname'])) 
			$mailtext .= ', geborene(r) '.$person_loop['geburtsname'];
		$mailtext .= '</td>';
		$mailtext .= '</tr>';
		if (!empty($person_loop['geb_t'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Geburtstag:</td>';
			$mailtext .= '<td>'.$person_loop['geb_t'].'.'.$person_loop['geb_m'].'.';
			if ($person_loop['geb_j'] > 1500) 
				$mailtext .= $person_loop['geb_j'].' &nbsp;&nbsp; (heute '.alter($person_loop['geb_t'],$person_loop['geb_m'],$person_loop['geb_j']).' Jahre alt)';
			$mailtext .= '</td>';
			$mailtext .= '</tr>';
			}
		$mailtext .= '</table>';

		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Adresse:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="adresse">';

		if ($person_loop['adresse_r'] != 1) {
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Adresse:</td>';
			$mailtext .= '<td class="rechts">';
			$mailtext .= $person_loop['strasse'];
			$mailtext .= ', ';
			$mailtext .= $person_loop['plz'].' '.$person_loop['ortsname'];
			$mailtext .= ' ('.$person_loop['land'].')';
			$mailtext .= '</td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($person_loop['ftel_privat'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Privat:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['fvw_privat_r']).'-'.$person_loop['ftel_privat'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['ftel_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Arbeit:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['fvw_arbeit_r']).'-'.$person_loop['ftel_arbeit'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['ftel_mobil'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['fvw_mobil_r']).'-'.$person_loop['ftel_mobil'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['ftel_fax'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Fax:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['fvw_fax_r']).'-'.$person_loop['ftel_fax'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['ftel_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Telefon Sonstiges:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['fvw_aux_r']).'-'.$person_loop['ftel_aux'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= '</table>';

		$mailtext .= "\n";
		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Telefon:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="telefon">';

		$mailtext .= "\n";
		if (!empty($person_loop['tel_privat'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Privat:</td>';
			$mailtext .= '<td class="rechts">'.select_vw_id($person_loop['vw_privat_r']).'-'.$person_loop['tel_privat'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['tel_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Arbeit:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['vw_arbeit_r']).'-'.$person_loop['tel_arbeit'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['tel_mobil'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['vw_mobil_r']).'-'.$person_loop['tel_mobil'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['tel_fax'])) {		
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Fax:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['vw_fax_r']).'-'.$person_loop['tel_fax'].'</td>';
			$mailtext .= '</tr>';
		}

		$mailtext .= "\n";
		if (!empty($person_loop['tel_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Sonstiges:</td>';
			$mailtext .= '<td>'.select_vw_id($person_loop['vw_aux_r']).'-'.$person_loop['tel_aux'].'</td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= '</table>';

		$mailtext .= "\n";		

		$mailtext .= '<div class="pers_titel">';
		$mailtext .= '&nbsp;&nbsp;Internet:';
		$mailtext .= '</div>';
		$mailtext .= '<table id="online">';
		if (!empty($person_loop['email_privat'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Privat:</td>';
			$mailtext .= '<td class="rechts"><a href="mailto:'.$person_loop['email_privat'].'">'.$person_loop['email_privat'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($person_loop['email_arbeit'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Arbeit:</td>';
			$mailtext .= '<td><a href="mailto:'.$person_loop['email_arbeit'].'">'.$person_loop['email_arbeit'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($person_loop['email_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Email Sonstiges:</td>';
			$mailtext .= '<td><a href="mailto:'.$person_loop['email_aux'].'">'.$person_loop['email_aux'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($person_loop['hp1'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Homepage 1:</td>';
			$mailtext .= '<td><a href="http://'.$person_loop['hp1'].'" target="_blank">'.$person_loop['hp1'].'</a></td>';
			$mailtext .= '</tr>';
		}
		$mailtext .= "\n";
		if (!empty($person_loop['hp2'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Homepage 2:</td>';
			$mailtext .= '<td><a href="http://'.$person_loop['hp2'].'" target="_blank">'.$person_loop['hp2'].'</a></td>';
			$mailtext .= '</tr>';
		}


		if (!empty($person_loop['chat_aim'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat AIM:</td>';
			$mailtext .= '<td>'.$person_loop['chat_aim'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($person_loop['chat_msn'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat MSN:</td>';
			$mailtext .= '<td>'.$person_loop['chat_msn'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($person_loop['chat_icq'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat ICQ:</td>';
			$mailtext .= '<td>#'.$person_loop['chat_icq'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($person_loop['chat_yim'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Yahoo:</td>';
			$mailtext .= '<td>'.$person_loop['chat_yim'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($person_loop['chat_skype'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Skype:</td>';
			$mailtext .= '<td>'.$person_loop['chat_skype'].'</td>';
			$mailtext .= '</tr>';
		}
		if (!empty($person_loop['chat_aux'])) {	
			$mailtext .= '<tr>';
			$mailtext .= '<td class="links">Chat Aux:</td>';
			$mailtext .= '<td>'.$person_loop['chat_aux'].'</td>';
			$mailtext .= '</tr>';
		}

				
		$mailtext .= '</table>';

		$mailtext .= "\n";

		$mailtext .= 'Bitte klicken Sie hier, wenn die Daten aktuell sind:<br /><br />'."\n".'<a href="'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($person_loop['last_check']).'">'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($person_loop['last_check']).'</a>';

		if (!empty($person_loop['email_privat']))
			$email_an = $person_loop['email_privat'];
		else if (!empty($person_loop['email_arbeit']))
			$email_an = $person_loop['email_arbeit'];
		else
			die();

		require($path_to_phpmailer);

		$mail = new PHPMailer();
		
		$mail->From = $admin_email;
		$mail->FromName = $admin_name;
		$mail->AddAddress($email_an, $person_loop['vorname'].' '.$person_loop['nachname']);
		
		$mail->WordWrap = 70;
		$mail->IsHTML(true);
		
		$mail->Subject = _('Please check your data');
		$mail->Body    = $mailtext;
		
		if($mail->Send()) {
			$msgs[] = _('The verification email was sent.');
		}
		else {
			$msgs[] = _('There was an error while sending the verification email:').'<br/>'.$mail->ErrorInfo;
		}



		// enter the sending of the mail into the database
		$sql = 'UPDATE ad_per SET last_send='.time().' WHERE p_id='.$id.';';
		mysql_query($sql);

		// since the data was edited, it has to be reloaded
		$person_loop['last_send'] = time();
	}
	// get back to person_display
	$mode = 'person_display';
}
?>
