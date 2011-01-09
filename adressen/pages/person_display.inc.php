<?PHP
$mugshot_path = '_mugshots/per'.$id.'.jpg';
if (file_exists($mugshot_path)) {
	$bilddaten = getimagesize('_mugshots/per'.$id.'.jpg');
	echo '<img id="pers_bild" src="_mugshots/per'.$id.'.jpg" '.$bilddaten[3].' />';
}

$emailadresse_vorhanden = false;

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
		echo ' &nbsp;&nbsp; ('.sternzeichen ($person_loop['geb_t'], $person_loop['geb_m']).')';
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
	echo '<br />';
	echo _('show map').': ';
	echo '<a href="http://nominatim.openstreetmap.org/search?q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank" title="Open Street Map">&raquo;OSM</a>';
	echo ' &nbsp; ';
	echo '<a href="http://maps.google.de/maps?f=q&hl=de&q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank">&raquo;Google</a>';
	echo ' &nbsp; ';
	echo '<a href="http://www.bing.com/maps/?q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank">&raquo;Bing</a>';
	if ($person_loop['land'] == 'Deutschland') {
		echo ' &nbsp; ';
		echo '<a href="http://www.mapquest.com/maps/map.adp?country=de&address='.str_replace(' ', '+', $person_loop['strasse']).'&city='.str_replace(' ', '+', $person_loop['ortsname']).'&zip='.$person_loop['plz'].'" target="_blank">&raquo;MapQuest</a>';
	}
	echo '</td>';
	echo '</tr>';
}
if (!empty($person_loop['ftel_privat'])) {		
	echo '<tr>';
	echo '<td class="links">'._('telephone private').':</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_privat_r']).'-'.$person_loop['ftel_privat'].' '.skplnk(select_vw_id($person_loop['fvw_privat_r']).$person_loop['ftel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_arbeit'])) {	
	echo '<tr>';
	echo '<td class="links">'._('telephone work').':</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_arbeit_r']).'-'.$person_loop['ftel_arbeit'].' '.skplnk(select_vw_id($person_loop['fvw_arbeit_r']).$person_loop['ftel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_mobil'])) {	
	echo '<tr>';
	echo '<td class="links">'._('telephone mobile').': <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.select_vw_id($person_loop['fvw_mobil_r']).'-'.$person_loop['ftel_mobil'].' '.skplnk(select_vw_id($person_loop['fvw_mobil_r']).$person_loop['ftel_mobil']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_fax'])) {		
	echo '<tr>';
	echo '<td class="links">'._('fax').':</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_fax_r']).'-'.$person_loop['ftel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_aux'])) {	
	echo '<tr>';
	echo '<td class="links">'._('telephone other').':</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_aux_r']).'-'.$person_loop['ftel_aux'].' '.skplnk(select_vw_id($person_loop['fvw_aux_r']).$person_loop['ftel_aux']).'</td>';
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
	echo '<td class="rechts">'.select_vw_id($person_loop['vw_privat_r']).'-'.$person_loop['tel_privat'].' '.skplnk(select_vw_id($person_loop['vw_privat_r']).$person_loop['tel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_arbeit'])) {	
	echo '<tr>';
	echo '<td class="links">'._('work').':</td>';
	echo '<td>'.select_vw_id($person_loop['vw_arbeit_r']).'-'.$person_loop['tel_arbeit'].' '.skplnk(select_vw_id($person_loop['vw_arbeit_r']).$person_loop['tel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_mobil'])) {	
	echo '<tr>';
	echo '<td class="links">'._('mobile').': <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.select_vw_id($person_loop['vw_mobil_r']).'-'.$person_loop['tel_mobil'].' '.skplnk(select_vw_id($person_loop['vw_mobil_r']).$person_loop['tel_mobil']).'</td>';
	echo '</tr>';
}
		
if (!empty($person_loop['tel_fax'])) {		
	echo '<tr>';
	echo '<td class="links">'._('fax').':</td>';
	echo '<td>'.select_vw_id($person_loop['vw_fax_r']).'-'.$person_loop['tel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_aux'])) {	
	echo '<tr>';
	echo '<td class="links">'._('other').':</td>';
	echo '<td>'.select_vw_id($person_loop['vw_aux_r']).'-'.$person_loop['tel_aux'].' '.skplnk(select_vw_id($person_loop['vw_aux_r']).$person_loop['tel_aux']).'</td>';
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

if (!empty($person_loop['pnotizen'])) {
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;'._('notes').':';
	echo '</div>';
	echo '<table class="display_person">';
	echo '<tr>';
	echo '<td>'.nl2br($person_loop['pnotizen']).'</td>';
	echo '</tr>';
	echo '</table>';
}

//		Gruppen
echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('relations').':';
echo '</div>';
echo '<table class="display_person">';
$erg = select_gruppen_zu_person($id);
if (mysql_num_rows($erg) > 0) {
	echo '<tr>';
	echo '<td class="links">'._('groups').':</td>';
	echo '<td class="rechts">';
	while ($l = mysql_fetch_assoc($erg)) {
		echo $l['gruppe'].' &nbsp; ';
		
	}
	echo '</td>';
	echo '</tr>';
}
$erg = select_fmg_zu_person($id);
if (mysql_num_rows($erg) > 0) {
	echo '<tr>';
	echo '<td class="links">'._('associated with').':</td>';
	echo '<td>';
	while ($l = mysql_fetch_assoc($erg)) {
		echo $l['fmg'].' &nbsp; ';
	}
	echo '</td>';
	echo '</tr>';
}

echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;'._('up-to-dateness').':';
echo '</div>';
echo '<table class="display_person">';


echo '<tr>';
echo '<td class="links">'._('up-to-dateness').':</td>';
echo '<td>';

$anzahl_level = 6;
$veraltet_nach = 365;

$letzter_check_vor = round((time()-$person_loop['last_check'])/3600/24);

$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);

echo '<div style="padding: 5px;">';

if ($person_loop['last_check'] == 0)
	$aktuell_level = 0;
else {
	$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
}

for ($i = $anzahl_level-1; $i >= 0 ; $i--) {
	echo '<img src="gfx/balken_'.($i < $aktuell_level ? 'aktiv' : 'inaktiv').'.png" title="';
	printf(_('last check %s (%d days ago)'), intelligent_date($person_loop['last_check']), $letzter_check_vor);
	echo '" />';
}
	
echo '<div>';
	
echo _('Was the data checked and is it up-to-date?').' <a href="index.php?mode=person_checked&id='.$id.'">'._('yes').'</a>';
echo '</td>';
echo '</tr>';

if ($emailadresse_vorhanden) {
	echo '<tr>';
	echo '<td class="links">'._('verification email').':</td>';
	echo '<td>';

	echo '<a href="index.php?mode=verification_email&id='.$id.'">&raquo; '._('send verification email').'</a>';
	if ($person_loop['last_send'] != 0) {
		echo ' (letzte vom '.date($date_format, $person_loop['last_send']).')';
	}
	if ($person_loop['last_check'] < $person_loop['last_send']) {
		
		echo '<br />'.sprintf(_('verification mail %s sent, confirmation pending'), intelligent_date($person_loop['last_send']));
	}
	echo '</td>';
	echo '</tr>';
}
echo '<tr>';
echo '<td class="links">'._('last edited').':</td>';
echo '<td>'.intelligent_date($person_loop['last_edit']).'</td>';
echo '</td>';
			
echo '</table>';

echo '<a href="?mode=person_edit1&id='.$id.'" title="'._('edit this entry').'"><img src="gfx/person_bearbeiten.png" width="64" height="64" alt="'._('edit this entry').'" border="0" /></a>';
echo '<a href="?mode=person_delete&id='.$id.'&back='.urlencode($_GET['back']).'" title="'._('delete this entry').'"><img src="gfx/person_loeschen.png" width="64" height="64" alt="'._('delete this entry').'" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a href="?mode=pic_upload1&id='.$id.'" title="'._('upload picture').'"><img src="gfx/foto_upload.png" width="64" height="64" alt="'._('upload picture').'" border="0" /></a>';
if (file_exists($mugshot_path))
	echo '<a href="index.php?mode=pic_remove&id='.$id.'" title="'._('delete picture').'"><img src="gfx/foto_loeschen.png" width="64" height="64" alt="'._('delete picture').'" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a href="export/vcard.php?id='.$id.'" title="'._('download VCard').'"><img src="gfx/vcard.png" width="64" height="64" alt="'._('download VCard').'" border="0" /></a>';
	
?>
