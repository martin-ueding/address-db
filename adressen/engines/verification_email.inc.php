<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

if ($_GET['sicher'] == 'ja') {
	if ($person_loop['last_send'] > time()-24*3600) {
		$msgs[] = _('The last email was sent within the last 24 hours. No email was sent now because this looks like an error.');
	}
	else {
		// set the language to the target language
		putenv('LC_MESSAGES='.$_GET['send_lang']);
		setlocale(LC_MESSAGES, $_GET['send_lang']);

		

		$mailtext .= '<style type="text/css">';
		$file = file('gfx/main.css');
		foreach ($file as $zeile) 
			$mailtext .= $zeile;
		$mailtext .= '</style>';


		$mailtext .= _('Dear').' '.$person_loop['vorname'].' '.$person_loop['nachname'].',<br /><br />'._('please take a minute and control your data that we have saved in our address book. If everything is correct, please click on the link at the bottom of this email.').'<br /><br />'._('If you want to correct something, please feel free to reply to this mail and tell us the changes. Amendments are welcomed as well.').'<br /><br />'._('Thank you!').'<br /><br />';



		// start to buffer everything, so you can reuse person_display's stuff with echo ;-)
		ob_start();


		$mailtext .= "\n";
		echo '<div class="pers_titel">';
		echo '&nbsp;&nbsp;'._('name').':';
		echo '</div>';

		echo '<table class="display_person">';
		echo '<tr>';
		echo '<td class="links">'._('form of address').':</td>';
		echo '<td class="rechts">';
		if ($person_loop['anrede'] != "-")
			echo ' '._($person_loop['anrede']);
		if ($person_loop['prafix'] != "-")
			echo ' '.$person_loop['prafix'];
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td class="links">'._('name').':</td>';
		echo '<td>';
		echo '<b>'.$person_loop['vorname'].'</b>';
		if (!empty($person_loop['mittelname']))
			echo ' '.$person_loop['mittelname'];
		echo ' <b>'.$person_loop['nachname'].'</b>';
		if ($person_loop['suffix'] != "-")
			echo ' ('.$person_loop['suffix'].')';
		if (!empty($person_loop['geburtsname'])) {
			echo ', ';
			if (empty($person_loop['anrede']))
				echo _('born<!-- both gender form-->');
			else {
				if ($person_loop['anrede'] == _('Mr.'))
					echo _('born<!-- male form -->');
				else
					echo _('born<!-- female form -->');
			}
			echo ' '.$person_loop['geburtsname'];
		}
		echo '</td>';
		echo '</tr>';
		if (!empty($person_loop['geb_t'])) {	
			echo '<tr>';
			echo '<td class="links">'._('birthday').':</td>';
			echo '<td>'.$person_loop['geb_t'].'.'.$person_loop['geb_m'].'.';
			if ($person_loop['geb_j'] > 1500) {
				echo $person_loop['geb_j'].' &nbsp;&nbsp; ';
				printf(_('(today %d years old)'),alter($person_loop['geb_t'],$person_loop['geb_m'],$person_loop['geb_j']));
				echo ' &nbsp;&nbsp; ('.Queries::sternzeichen ($person_loop['geb_t'], $person_loop['geb_m']).')';
			}
			echo '</td>';
			echo '</tr>';
			}
		echo '</table>';

		echo '<div class="pers_titel">';
		echo '&nbsp;&nbsp;'._('address').':';
		echo '</div>';
		echo '<table class="display_person">';
		if ($person_loop['adresse_r'] != 1) {
			echo '<tr>';
			echo '<td class="links">'._('address').':</td>';
			echo '<td class="rechts">';
			echo $person_loop['strasse'];
			echo ', ';
			echo $person_loop['plz'].' '.$person_loop['ortsname'];
			echo ' ('.$person_loop['land'].')';
			echo '</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['ftel_privat'])) {		
			echo '<tr>';
			echo '<td class="links">'._('telephone private').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['fvw_privat_r']).'-'.$person_loop['ftel_privat'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['ftel_arbeit'])) {	
			echo '<tr>';
			echo '<td class="links">'._('telephone work').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['fvw_arbeit_r']).'-'.$person_loop['ftel_arbeit'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['ftel_mobil'])) {	
			echo '<tr>';
			echo '<td class="links">'._('telephone mobile').': <i>'.Queries::handybetreiber(Queries::select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
			echo '<td>'.Queries::select_vw_id($person_loop['fvw_mobil_r']).'-'.$person_loop['ftel_mobil'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['ftel_fax'])) {		
			echo '<tr>';
			echo '<td class="links">'._('fax').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['fvw_fax_r']).'-'.$person_loop['ftel_fax'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['ftel_aux'])) {	
			echo '<tr>';
			echo '<td class="links">'._('telephone other').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['fvw_aux_r']).'-'.$person_loop['ftel_aux'].'</td>';
			echo '</tr>';
		}
		echo '</table>';

		echo '<div class="pers_titel">';
		echo '&nbsp;&nbsp;'._('telephone').':';
		echo '</div>';
		echo '<table class="display_person">';
		if (!empty($person_loop['tel_privat'])) {		
			echo '<tr>';
			echo '<td class="links">'._('private').':</td>';
			echo '<td class="rechts">'.Queries::select_vw_id($person_loop['vw_privat_r']).'-'.$person_loop['tel_privat'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['tel_arbeit'])) {	
			echo '<tr>';
			echo '<td class="links">'._('work').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['vw_arbeit_r']).'-'.$person_loop['tel_arbeit'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['tel_mobil'])) {	
			echo '<tr>';
			echo '<td class="links">'._('mobile').': <i>'.Queries::handybetreiber(Queries::select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
			echo '<td>'.Queries::select_vw_id($person_loop['vw_mobil_r']).'-'.$person_loop['tel_mobil'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['tel_fax'])) {		
			echo '<tr>';
			echo '<td class="links">'._('fax').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['vw_fax_r']).'-'.$person_loop['tel_fax'].'</td>';
			echo '</tr>';
		}
		if (!empty($person_loop['tel_aux'])) {	
			echo '<tr>';
			echo '<td class="links">'._('other').':</td>';
			echo '<td>'.Queries::select_vw_id($person_loop['vw_aux_r']).'-'.$person_loop['tel_aux'].'</td>';
			echo '</tr>';
		}
		echo '</table>';
				

		echo '<div class="pers_titel">';
		echo '&nbsp;&nbsp;'._('internet').':';
		echo '</div>';
		echo '<table class="display_person">';
		if (!empty($person_loop['email_privat'])) {	
			echo '<tr>';
			echo '<td class="links">'._('email private').':</td>';
			echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
			echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_privat'].'>">'.$person_loop['email_privat'].'</a></td>';
			echo '</tr>';
			$emailadresse_vorhanden = true;
		}
		if (!empty($person_loop['email_arbeit'])) {	
			echo '<tr>';
			echo '<td class="links">'._('email work').':</td>';
			echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
			echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_arbeit'].'>">'.$person_loop['email_arbeit'].'</a></td>';
			echo '</tr>';
			$emailadresse_vorhanden = true;
		}
		if (!empty($person_loop['email_aux'])) {	
			echo '<tr>';
			echo '<td class="links">'._('email other').':</td>';
			echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
			echo '<td class="rechts"><a href="mailto:'.$person_loop['vorname'].' '.$person_loop['nachname'].' <'.$person_loop['email_aux'].'>">'.$person_loop['email_aux'].'</a></td>';
			echo '</tr>';
			$emailadresse_vorhanden = true;
		}
		if (!empty($person_loop['hp1'])) {	
			echo '<tr>';
			echo '<td class="links">'._('homepage 1').':</td>';
			echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
			echo '<td><a href="http://'.$person_loop['hp1'].'" target="_blank">'.$person_loop['hp1'].'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['hp2'])) {	
			echo '<tr>';
			echo '<td class="links">'._('homepage 2').':</td>';
			echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
			echo '<td><a href="http://'.$person_loop['hp2'].'" target="_blank">'.$person_loop['hp2'].'</a></td>';
			echo '</tr>';
		}
				

		if (!empty($person_loop['chat_aim'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat AIM').':</td>';
			echo '<td class="icon"><img src="gfx/10/aim10.png" width="10" height="10" /></td>';
			echo '<td><a href="AIM://'.$person_loop['chat_aim'].'">'.$person_loop['chat_aim'].'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['chat_msn'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat MSN').':</td>';
			echo '<td class="icon"><img src="gfx/10/msn10.png" width="10" height="10" /></td>';
			echo '<td><a href="MSN://'.$person_loop['chat_msn'].'">'.$person_loop['chat_msn'].'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['chat_icq'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat ICQ').':</td>';
			echo '<td class="icon"><img src="gfx/10/icq10.png" width="10" height="10" /></td>';
			echo '<td><a href="ICQ://'.$person_loop['chat_icq'].'">#'.$person_loop['chat_icq'].'</a> &nbsp; <a href="http://people.icq.com/'.$person_loop['chat_icq'].'" target="_blank">&raquo; '._('profile page').'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['chat_yim'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat Yahoo').':</td>';
			echo '<td class="icon"><img src="gfx/10/yim10.png" width="10" height="10" /></td>';
			echo '<td><a href="Yahoo://'.$person_loop['chat_yim'].'">'.$person_loop['chat_yim'].'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['chat_skype'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat Skype').':</td>';
			echo '<td class="icon"><img src="gfx/10/skype10.png" width="10" height="10" /></td>';
			echo '<td><a href="Callto://'.$person_loop['chat_skype'].'">'.$person_loop['chat_skype'].'</a></td>';
			echo '</tr>';
		}
		if (!empty($person_loop['chat_aux'])) {	
			echo '<tr>';
			echo '<td class="links">'._('chat Jabber/XMPP').':</td>';
			echo '<td class="icon">&nbsp;</td>';
			echo '<td>'.$person_loop['chat_aux'].'</td>';
			echo '</tr>';
		}
				
				
		echo '</table>';
		
		$mailtext .= ob_get_contents();
		ob_end_clean();

		$mailtext .= "\n";

		$mailtext .= _('Please click here, if all your data is up-to-date:').'<br /><br />'."\n".'<a href="'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($person_loop['last_check']).'&lang='.$_GET['send_lang'].'">'.$url_to_server.'adressen_helper/aktuell.php?id='.$id.'&code='.md5($person_loop['last_check']).'</a>';

		putenv('LC_MESSAGES='.$_SESSION['lang']);
		setlocale(LC_MESSAGES, $_SESSION['lang']);


		if (!empty($person_loop['email_privat']))
			$email_an = $person_loop['email_privat'];
		else if (!empty($person_loop['email_arbeit']))
			$email_an = $person_loop['email_arbeit'];
		else if (!empty($person_loop['email_aux']))
			$email_an = $person_loop['email_aux'];
		else
			die(_('This entry does not have an email address. This should be an impossible error since you should not even be able to get here then.'));



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
