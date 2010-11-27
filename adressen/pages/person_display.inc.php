<?PHP
$mugshot_path = '_mugshots/per'.$id.'.jpg';
if (file_exists($mugshot_path)) {
	$bilddaten = getimagesize('_mugshots/per'.$id.'.jpg');
	echo '<img id="pers_bild" src="_mugshots/per'.$id.'.jpg" '.$bilddaten[3].' />';
}

$emailadresse_vorhanden = false;

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Name:';
echo '</div>';

echo '<table id="name">';
echo '<tr>';
echo '<td class="links">Anrede:</td>';
echo '<td class="rechts">';
if ($person_loop['anrede'] != "-")
	echo ' '.$person_loop['anrede'];
if ($person_loop['prafix'] != "-")
	echo ' '.$person_loop['prafix'];
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td class="links">Name:</td>';
echo '<td>';
echo '<b>'.$person_loop['vorname'].'</b>';
if (!empty($person_loop['mittelname']))
	echo ' '.$person_loop['mittelname'];
echo ' <b>'.$person_loop['nachname'].'</b>';
if ($person_loop['suffix'] != "-")
	echo ' ('.$person_loop['suffix'].')';
if (!empty($person_loop['geburtsname'])) {
	echo ', geborene'.(empty($person_loop['anrede']) ? '(r)' : ($person_loop['anrede'] == "Herr" ? 'r' : '')).' '.$person_loop['geburtsname'];
}
echo '</td>';
echo '</tr>';
if (!empty($person_loop['geb_t'])) {	
	echo '<tr>';
	echo '<td class="links">Geburtstag:</td>';
	echo '<td>'.$person_loop['geb_t'].'.'.$person_loop['geb_m'].'.';
	if ($person_loop['geb_j'] > 1500) 
		echo $person_loop['geb_j'].' &nbsp;&nbsp; (heute '.alter($person_loop['geb_t'],$person_loop['geb_m'],$person_loop['geb_j']).' Jahre alt)&nbsp;&nbsp; ('.sternzeichen ($person_loop['geb_t'], $person_loop['geb_m']).')';
	echo '</td>';
	echo '</tr>';
	}
echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Adresse:';
echo '</div>';
echo '<table id="adresse">';
if ($person_loop['adresse_r'] != 1) {
	echo '<tr>';
	echo '<td class="links">Adresse:</td>';
	echo '<td class="rechts">';
	echo $person_loop['strasse'];
	echo ', ';
	echo $person_loop['plz'].' '.$person_loop['ortsname'];
	echo ' ('.$person_loop['land'].')';
	echo '<br />';
	echo 'Online-Karte zeigen: ';
	echo '<a href="http://maps.google.de/maps?f=q&hl=de&q='.urlencode($person_loop['strasse'].', '.$person_loop['ortsname'].', '.$person_loop['plz'].', '.$person_loop['land']).'" target="_blank">&raquo;GoogleMaps</a>';
	if ($person_loop['land'] == 'Deutschland') {
		echo ' &nbsp; ';
		echo '<a href="http://www.mapquest.com/maps/map.adp?country=de&address='.str_replace(' ', '+', $person_loop['strasse']).'&city='.str_replace(' ', '+', $person_loop['ortsname']).'&zip='.$person_loop['plz'].'" target="_blank">&raquo;MapQuest</a>';
	}
	echo '</td>';
	echo '</tr>';
}
if (!empty($person_loop['ftel_privat'])) {		
	echo '<tr>';
	echo '<td class="links">Telefon Privat:</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_privat_r']).'-'.$person_loop['ftel_privat'].' '.skplnk(select_vw_id($person_loop['fvw_privat_r']).$person_loop['ftel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_arbeit'])) {	
	echo '<tr>';
	echo '<td class="links">Telefon Arbeit:</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_arbeit_r']).'-'.$person_loop['ftel_arbeit'].' '.skplnk(select_vw_id($person_loop['fvw_arbeit_r']).$person_loop['ftel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_mobil'])) {	
	echo '<tr>';
	echo '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.select_vw_id($person_loop['fvw_mobil_r']).'-'.$person_loop['ftel_mobil'].' '.skplnk(select_vw_id($person_loop['fvw_mobil_r']).$person_loop['ftel_mobil']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_fax'])) {		
	echo '<tr>';
	echo '<td class="links">Fax:</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_fax_r']).'-'.$person_loop['ftel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['ftel_aux'])) {	
	echo '<tr>';
	echo '<td class="links">Telefon Sonstiges:</td>';
	echo '<td>'.select_vw_id($person_loop['fvw_aux_r']).'-'.$person_loop['ftel_aux'].' '.skplnk(select_vw_id($person_loop['fvw_aux_r']).$person_loop['ftel_aux']).'</td>';
	echo '</tr>';
}
echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Telefon:';
echo '</div>';
echo '<table id="telefon">';
if (!empty($person_loop['tel_privat'])) {		
	echo '<tr>';
	echo '<td class="links">Privat:</td>';
	echo '<td class="rechts">'.select_vw_id($person_loop['vw_privat_r']).'-'.$person_loop['tel_privat'].' '.skplnk(select_vw_id($person_loop['vw_privat_r']).$person_loop['tel_privat']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_arbeit'])) {	
	echo '<tr>';
	echo '<td class="links">Arbeit:</td>';
	echo '<td>'.select_vw_id($person_loop['vw_arbeit_r']).'-'.$person_loop['tel_arbeit'].' '.skplnk(select_vw_id($person_loop['vw_arbeit_r']).$person_loop['tel_arbeit']).'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_mobil'])) {	
	echo '<tr>';
	echo '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($person_loop['vw_mobil_r'])).'</i></td>';
	echo '<td>'.select_vw_id($person_loop['vw_mobil_r']).'-'.$person_loop['tel_mobil'].' '.skplnk(select_vw_id($person_loop['vw_mobil_r']).$person_loop['tel_mobil']).'</td>';
	echo '</tr>';
}
		
if (!empty($person_loop['tel_fax'])) {		
	echo '<tr>';
	echo '<td class="links">Fax:</td>';
	echo '<td>'.select_vw_id($person_loop['vw_fax_r']).'-'.$person_loop['tel_fax'].'</td>';
	echo '</tr>';
}

if (!empty($person_loop['tel_aux'])) {	
	echo '<tr>';
	echo '<td class="links">Sonstiges:</td>';
	echo '<td>'.select_vw_id($person_loop['vw_aux_r']).'-'.$person_loop['tel_aux'].' '.skplnk(select_vw_id($person_loop['vw_aux_r']).$person_loop['tel_aux']).'</td>';
	echo '</tr>';
}
echo '</table>';
		

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Internet:';
echo '</div>';
echo '<table id="online">';
if (!empty($person_loop['email_privat'])) {	
	echo '<tr>';
	echo '<td class="links">Email Privat:</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td class="rechts"><a href="mailto:'.$person_loop['email_privat'].'">'.$person_loop['email_privat'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['email_arbeit'])) {	
	echo '<tr>';
	echo '<td class="links">Email Arbeit:</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td><a href="mailto:'.$person_loop['email_arbeit'].'">'.$person_loop['email_arbeit'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['email_aux'])) {	
	echo '<tr>';
	echo '<td class="links">Email Sonstiges:</td>';
	echo '<td class="icon"><img src="gfx/10/email10.png" width="10" height="10" /></td>';
	echo '<td><a href="mailto:'.$person_loop['email_aux'].'">'.$person_loop['email_aux'].'</a></td>';
	echo '</tr>';
	$emailadresse_vorhanden = true;
}
if (!empty($person_loop['hp1'])) {	
	echo '<tr>';
	echo '<td class="links">Homepage 1:</td>';
	echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
	echo '<td><a href="http://'.$person_loop['hp1'].'" target="_blank">'.$person_loop['hp1'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['hp2'])) {	
	echo '<tr>';
	echo '<td class="links">Homepage 2:</td>';
	echo '<td class="icon"><img src="gfx/10/www10.png" width="10" height="10" /></td>';
	echo '<td><a href="http://'.$person_loop['hp2'].'" target="_blank">'.$person_loop['hp2'].'</a></td>';
	echo '</tr>';
}
		

if (!empty($person_loop['chat_aim'])) {	
	echo '<tr>';
	echo '<td class="links">Chat AIM:</td>';
	echo '<td class="icon"><img src="gfx/10/aim10.png" width="10" height="10" /></td>';
	echo '<td><a href="AIM://'.$person_loop['chat_aim'].'">'.$person_loop['chat_aim'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_msn'])) {	
	echo '<tr>';
	echo '<td class="links">Chat MSN:</td>';
	echo '<td class="icon"><img src="gfx/10/msn10.png" width="10" height="10" /></td>';
	echo '<td><a href="MSN://'.$person_loop['chat_msn'].'">'.$person_loop['chat_msn'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_icq'])) {	
	echo '<tr>';
	echo '<td class="links">Chat ICQ:</td>';
	echo '<td class="icon"><img src="gfx/10/icq10.png" width="10" height="10" /></td>';
	echo '<td><a href="ICQ://'.$person_loop['chat_icq'].'">#'.$person_loop['chat_icq'].'</a> &nbsp; <a href="http://people.icq.com/'.$person_loop['chat_icq'].'" target="_blank">&raquo; Profil</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_yim'])) {	
	echo '<tr>';
	echo '<td class="links">Chat Yahoo:</td>';
	echo '<td class="icon"><img src="gfx/10/yim10.png" width="10" height="10" /></td>';
	echo '<td><a href="Yahoo://'.$person_loop['chat_yim'].'">'.$person_loop['chat_yim'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_skype'])) {	
	echo '<tr>';
	echo '<td class="links">Chat Skype:</td>';
	echo '<td class="icon"><img src="gfx/10/skype10.png" width="10" height="10" /></td>';
	echo '<td><a href="Callto://'.$person_loop['chat_skype'].'">'.$person_loop['chat_skype'].'</a></td>';
	echo '</tr>';
}
if (!empty($person_loop['chat_aux'])) {	
	echo '<tr>';
	echo '<td class="links">Chat Aux:</td>';
	echo '<td class="icon">&nbsp;</td>';
	echo '<td>'.$person_loop['chat_aux'].'</td>';
	echo '</tr>';
}
		
		
echo '</table>';

if (!empty($person_loop['pnotizen'])) {
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Notizen:';
	echo '</div>';
	echo '<table id="notizen">';
	echo '<tr>';
	echo '<td>'.nl2br($person_loop['pnotizen']).'</td>';
	echo '</tr>';
	echo '</table>';
}

//		Gruppen
echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Bez&uuml;ge:';
echo '</div>';
echo '<table id="gruppen2">';
$erg = select_gruppen_zu_person($id);
if (mysql_num_rows($erg) > 0) {
	echo '<tr>';
	echo '<td class="links">Gruppen:</td>';
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
	echo '<td class="links">Gehört zu:</td>';
	echo '<td>';
	while ($l = mysql_fetch_assoc($erg)) {
		echo $l['fmg'].' &nbsp; ';
	}
	echo '</td>';
	echo '</tr>';
}

echo '</table>';

echo '<div class="pers_titel">';
echo '&nbsp;&nbsp;Aktualit&auml;t:';
echo '</div>';
echo '<table id="gruppen2">';


echo '<tr>';
echo '<td class="links">Aktualität:</td>';
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
	echo '<img src="gfx/balken_'.($i < $aktuell_level ? 'aktiv' : 'inaktiv').'.png" title="Zuletzt '.intelligent_date($person_loop['last_check']).' (vor '.$letzter_check_vor.' Tagen) überprüft." />';
}
	
echo '<div>';
	
echo 'Wurden die Daten überprüft und sind aktuell? <a href="index.php?mode=person_checked&id='.$id.'">Ja!</a>';
echo '</td>';
echo '</tr>';

if ($emailadresse_vorhanden) {
	echo '<tr>';
	echo '<td class="links">&Uuml;berpr&uuml;fungsmail:</td>';
	echo '<td>';

	echo '<a href="index.php?mode=verification_email&id='.$id.'">&raquo; Überprüfungsemail senden</a>';
	if ($person_loop['last_send'] != 0) {
		echo ' (letzte vom '.date($date_format, $person_loop['last_send']).')';
	}
	if ($person_loop['last_check'] < $person_loop['last_send']) {
		echo '<br />Mail '.intelligent_date($person_loop['last_send']),' gesendet, Überprüfung ausstehend';
	}
	echo '</td>';
	echo '</tr>';
}
echo '<tr>';
echo '<td class="links">Zuletzt editiert:</td>';
echo '<td>'.intelligent_date($person_loop['last_edit']).'</td>';
echo '</td>';
			
echo '</table>';

echo '<a href="?mode=person_edit1&id='.$id.'" title="Diese Person bearbeiten"><img src="gfx/person_bearbeiten.png" width="64" height="64" alt="Diese Person bearbeiten" border="0" /></a>';
echo '<a href="?mode=person_delete&id='.$id.'&back='.urlencode($_GET['back']).'" title="Diese Person l&ouml;schen"><img src="gfx/person_loeschen.png" width="64" height="64" alt="Diese Person l&ouml;schen" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
echo '<a href="?mode=pic_upload1&id='.$id.'" title="Bild hochladen"><img src="gfx/foto_upload.png" width="64" height="64" alt="Bild hochladen" border="0" /></a>';
if (file_exists('bilder/per'.$id.'.jpg'))
	echo '<a href="?mode=pic_remove&id='.$id.'" title="Bild l&ouml;schen"><img src="gfx/foto_loeschen.png" width="64" height="64" alt="Bild l&ouml;schen" border="0" /></a>';
echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';

echo '<a href="export/vcard.php?id='.$id.'" title="VCard"><img src="gfx/vcard.png" width="64" height="64" alt="VCard" border="0" /></a>';
	
?>
