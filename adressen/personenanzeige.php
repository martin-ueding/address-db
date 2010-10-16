<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Listenanzeige</title>
<link rel="STYLESHEET" type="text/css" href="css/main.css">
</head>
	<body class="linksluft">


	<?PHP
	$id = $_GET["id"];
	include('inc/includes.inc.php');
	$erg = select_person_alles($id);
	$l = mysql_fetch_assoc($erg);
	if (file_exists('bilder/per'.$id.'.jpg')) {
		$bilddaten = getimagesize('bilder/per'.$id.'.jpg');
		echo '<img id="pers_bild" src="bilder/per'.$id.'.jpg" '.$bilddaten[3].' />';
	}
	
	$emailadresse_vorhanden = false;
	
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Name:';
	echo '</div>';
	
	echo '<table id="name">';
	echo '<tr>';
	echo '<td class="links">Anrede:</td>';
	echo '<td class="rechts">';
	if ($l['anrede'] != "-")
		echo ' '.$l['anrede'];
	if ($l['prafix'] != "-")
		echo ' '.$l['prafix'];
	echo '</td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<td class="links">Name:</td>';
	echo '<td>';
	echo '<b>'.$l['vorname'].'</b>';
	if (!empty($l['mittelname']))
		echo ' '.$l['mittelname'];
	echo ' <b>'.$l['nachname'].'</b>';
	if ($l['suffix'] != "-")
		echo ' ('.$l['suffix'].')';
	if (!empty($l['geburtsname'])) 
		{echo ', geborene(r) '.$l['geburtsname'];}
	echo '</td>';
	echo '</tr>';
	if (!empty($l['geb_t'])) {	
		echo '<tr>';
		echo '<td class="links">Geburtstag:</td>';
		echo '<td>'.$l['geb_t'].'.'.$l['geb_m'].'.';
		if ($l['geb_j'] > 1500) 
			echo $l['geb_j'].' &nbsp;&nbsp; (heute '.alter($l['geb_t'],$l['geb_m'],$l['geb_j']).' Jahre alt)&nbsp;&nbsp; ('.sternzeichen ($l['geb_t'], $l['geb_m']).')';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Adresse:';
	echo '</div>';
	echo '<table id="adresse">';
	if ($l['adresse_r'] != 1) {
		echo '<tr>';
		echo '<td class="links">Adresse:</td>';
		echo '<td class="rechts">';
		echo $l['strasse'];
		echo ', ';
		echo $l['plz'].' '.$l['ortsname'];
		echo ' ('.$l['land'].')';
		echo '<br />';
		echo 'Online-Karte zeigen: ';
		echo '<a href="http://maps.google.de/maps?f=q&hl=de&q='.urlencode($l['strasse'].', '.$l['ortsname'].', '.$l['plz'].', '.$l['land']).'" target="_blank">&raquo;GoogleMaps</a>';
		if ($l['land'] == 'Deutschland') {
			echo ' &nbsp; ';
			echo '<a href="http://www.mapquest.com/maps/map.adp?country=de&address='.str_replace(' ', '+', $l['strasse']).'&city='.str_replace(' ', '+', $l['ortsname']).'&zip='.$l['plz'].'" target="_blank">&raquo;MapQuest</a>';
		}
		echo '</td>';
		echo '</tr>';
	}
	if (!empty($l['ftel_privat'])) {		
		echo '<tr>';
		echo '<td class="links">Telefon Privat:</td>';
		echo '<td>'.select_vw_id($l['fvw_privat_r']).'-'.$l['ftel_privat'].' '.skplnk(select_vw_id($l['fvw_privat_r']).$l['ftel_privat']).'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['ftel_arbeit'])) {	
		echo '<tr>';
		echo '<td class="links">Telefon Arbeit:</td>';
		echo '<td>'.select_vw_id($l['fvw_arbeit_r']).'-'.$l['ftel_arbeit'].' '.skplnk(select_vw_id($l['fvw_arbeit_r']).$l['ftel_arbeit']).'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['ftel_mobil'])) {	
		echo '<tr>';
		echo '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($l['vw_mobil_r'])).'</i></td>';
		echo '<td>'.select_vw_id($l['fvw_mobil_r']).'-'.$l['ftel_mobil'].' '.skplnk(select_vw_id($l['fvw_mobil_r']).$l['ftel_mobil']).'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['ftel_fax'])) {		
		echo '<tr>';
		echo '<td class="links">Fax:</td>';
		echo '<td>'.select_vw_id($l['fvw_fax_r']).'-'.$l['ftel_fax'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['ftel_aux'])) {	
		echo '<tr>';
		echo '<td class="links">Telefon Sonstiges:</td>';
		echo '<td>'.select_vw_id($l['fvw_aux_r']).'-'.$l['ftel_aux'].' '.skplnk(select_vw_id($l['fvw_aux_r']).$l['ftel_aux']).'</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Telefon:';
	echo '</div>';
	echo '<table id="telefon">';
	if (!empty($l['tel_privat'])) {		
		echo '<tr>';
		echo '<td class="links">Privat:</td>';
		echo '<td class="rechts">'.select_vw_id($l['vw_privat_r']).'-'.$l['tel_privat'].' '.skplnk(select_vw_id($l['vw_privat_r']).$l['tel_privat']).'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['tel_arbeit'])) {	
		echo '<tr>';
		echo '<td class="links">Arbeit:</td>';
		echo '<td>'.select_vw_id($l['vw_arbeit_r']).'-'.$l['tel_arbeit'].' '.skplnk(select_vw_id($l['vw_arbeit_r']).$l['tel_arbeit']).'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['tel_mobil'])) {	
		echo '<tr>';
		echo '<td class="links">Handy: <i>'.handybetreiber(select_vw_id($l['vw_mobil_r'])).'</i></td>';
		echo '<td>'.select_vw_id($l['vw_mobil_r']).'-'.$l['tel_mobil'].' '.skplnk(select_vw_id($l['vw_mobil_r']).$l['tel_mobil']).'</td>';
		echo '</tr>';
	}
			
	if (!empty($l['tel_fax'])) {		
		echo '<tr>';
		echo '<td class="links">Fax:</td>';
		echo '<td>'.select_vw_id($l['vw_fax_r']).'-'.$l['tel_fax'].'</td>';
		echo '</tr>';
	}
	
	if (!empty($l['tel_aux'])) {	
		echo '<tr>';
		echo '<td class="links">Sonstiges:</td>';
		echo '<td>'.select_vw_id($l['vw_aux_r']).'-'.$l['tel_aux'].' '.skplnk(select_vw_id($l['vw_aux_r']).$l['tel_aux']).'</td>';
		echo '</tr>';
	}
	echo '</table>';
			
	
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Internet:';
	echo '</div>';
	echo '<table id="online">';
	if (!empty($l['email_privat'])) {	
		echo '<tr>';
		echo '<td class="links">Email Privat:</td>';
		echo '<td class="icon"><img src="eicons/10/email10.png" width="10" height="10" /></td>';
		echo '<td class="rechts"><a href="mailto:'.$l['email_privat'].'">'.$l['email_privat'].'</a></td>';
		echo '</tr>';
		$emailadresse_vorhanden = true;
	}
	if (!empty($l['email_arbeit'])) {	
		echo '<tr>';
		echo '<td class="links">Email Arbeit:</td>';
		echo '<td class="icon"><img src="eicons/10/email10.png" width="10" height="10" /></td>';
		echo '<td><a href="mailto:'.$l['email_arbeit'].'">'.$l['email_arbeit'].'</a></td>';
		echo '</tr>';
		$emailadresse_vorhanden = true;
	}
	if (!empty($l['email_aux'])) {	
		echo '<tr>';
		echo '<td class="links">Email Sonstiges:</td>';
		echo '<td class="icon"><img src="eicons/10/email10.png" width="10" height="10" /></td>';
		echo '<td><a href="mailto:'.$l['email_aux'].'">'.$l['email_aux'].'</a></td>';
		echo '</tr>';
		$emailadresse_vorhanden = true;
	}
	if (!empty($l['hp1'])) {	
		echo '<tr>';
		echo '<td class="links">Homepage 1:</td>';
		echo '<td class="icon"><img src="eicons/10/www10.png" width="10" height="10" /></td>';
		echo '<td><a href="http://'.$l['hp1'].'" target="_blank">'.$l['hp1'].'</a></td>';
		echo '</tr>';
	}
	if (!empty($l['hp2'])) {	
		echo '<tr>';
		echo '<td class="links">Homepage 2:</td>';
		echo '<td class="icon"><img src="eicons/10/www10.png" width="10" height="10" /></td>';
		echo '<td><a href="http://'.$l['hp2'].'" target="_blank">'.$l['hp2'].'</a></td>';
		echo '</tr>';
	}
			
	
	if (!empty($l['chat_aim'])) {	
		echo '<tr>';
		echo '<td class="links">Chat AIM:</td>';
		echo '<td class="icon"><img src="eicons/10/aim10.png" width="10" height="10" /></td>';
		echo '<td><a href="AIM://'.$l['chat_aim'].'">'.$l['chat_aim'].'</a></td>';
		echo '</tr>';
	}
	if (!empty($l['chat_msn'])) {	
		echo '<tr>';
		echo '<td class="links">Chat MSN:</td>';
		echo '<td class="icon"><img src="eicons/10/msn10.png" width="10" height="10" /></td>';
		echo '<td><a href="MSN://'.$l['chat_msn'].'">'.$l['chat_msn'].'</a></td>';
		echo '</tr>';
	}
	if (!empty($l['chat_icq'])) {	
		echo '<tr>';
		echo '<td class="links">Chat ICQ:</td>';
		echo '<td class="icon"><img src="eicons/10/icq10.png" width="10" height="10" /></td>';
		echo '<td><a href="ICQ://'.$l['chat_icq'].'">#'.$l['chat_icq'].'</a> &nbsp; <a href="http://people.icq.com/'.$l['chat_icq'].'" target="_blank">&raquo; Profil</a></td>';
		echo '</tr>';
	}
	if (!empty($l['chat_yim'])) {	
		echo '<tr>';
		echo '<td class="links">Chat Yahoo:</td>';
		echo '<td class="icon"><img src="eicons/10/yim10.png" width="10" height="10" /></td>';
		echo '<td><a href="Yahoo://'.$l['chat_yim'].'">'.$l['chat_yim'].'</a></td>';
		echo '</tr>';
	}
	if (!empty($l['chat_skype'])) {	
		echo '<tr>';
		echo '<td class="links">Chat Skype:</td>';
		echo '<td class="icon"><img src="eicons/10/skype10f.png" width="10" height="10" /></td>';
		echo '<td><a href="Callto://'.$l['chat_skype'].'">'.$l['chat_skype'].'</a></td>';
		echo '</tr>';
	}
	if (!empty($l['chat_aux'])) {	
		echo '<tr>';
		echo '<td class="links">Chat Aux:</td>';
		echo '<td class="icon">&nbsp;</td>';
		echo '<td>'.$l['chat_aux'].'</td>';
		echo '</tr>';
	}
			
			
	echo '</table>';
	
	if (!empty($l['pnotizen'])) {
		echo '<div class="pers_titel">';
		echo '&nbsp;&nbsp;Notizen:';
		echo '</div>';
		echo '<table id="notizen">';
		echo '<tr>';
		echo '<td>'.nl2br($l['pnotizen']).'</td>';
		echo '</tr>';
		echo '</table>';
	}
	
	$check = $l['last_check'];
			
	
	//		Gruppen
	echo '<div class="pers_titel">';
	echo '&nbsp;&nbsp;Meta:';
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
	
	echo '<tr>';
	echo '<td class="links">Aktualität:</td>';
	echo '<td>';
	
	$anzahl_level = 6;
	$veraltet_nach = 365;
	
	$letzter_check_vor = round((time()-$check)/3600/24);
	
	$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
	
	echo '<div style="padding: 5px;">';
	
	if ($check == 0)
		$aktuell_level = 0;
	else {
		$aktuell_level = round($anzahl_level*($veraltet_nach-$letzter_check_vor)/$veraltet_nach);
	}
	
	for ($i = $anzahl_level-1; $i >= 0 ; $i--) {
		echo '<img src="eicons/balken_'.($i < $aktuell_level ? 'aktiv' : 'inaktiv').'.png" title="Zuletzt am '.date("d.m.y", $check).' (vor '.$letzter_check_vor.' Tagen) überprüft." />';
	}
		
	echo '<div>';
		
	
	echo '<br />Wurden die Daten überprüft und sind aktuell? <a href="person_checked.php?id='.$id.'">Ja!</a>';
	
	if ($letzter_check_vor > 7 && $emailadresse_vorhanden)
		echo '<br /><a href="ueberpruefungsmail.php?id='.$id.'">&raquo; Überprüfungsemail direkt senden</a>';
	echo '</td>';
	echo '</tr>';
				
	echo '</table>';
	
	echo '<a href="person_bearbeiten/person_bearbeiten1.php?id='.$_GET['id'].'" title="Diese Person bearbeiten"><img src="eicons/person_bearbeiten.png" width="64" height="64" alt="Diese Person bearbeiten" border="0" /></a>';
	echo '<a href="person_loeschen.php?id='.$_GET['id'].'" title="Diese Person l&ouml;schen"><img src="eicons/person_loeschen.png" width="64" height="64" alt="Diese Person l&ouml;schen" border="0" /></a>';
	echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
	echo '<a href="bild_hochladen.php?id='.$_GET['id'].'" title="Bild hochladen"><img src="eicons/foto_upload.png" width="64" height="64" alt="Bild hochladen" border="0" /></a>';
	if (file_exists('bilder/per'.$_GET['id'].'.jpg'))
		echo '<a href="bild_loeschen.php?id='.$_GET['id'].'" title="Bild l&ouml;schen"><img src="eicons/foto_loeschen.png" width="64" height="64" alt="Bild l&ouml;schen" border="0" /></a>';
	echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';

	echo '<a href="vcard.php?id='.$_GET['id'].'" title="VCard"><img src="eicons/vcard.png" width="64" height="64" alt="VCard" border="0" /></a>';
		
	?>

	</body>
</html>
