<?PHP
$suche = mysql_real_escape_string($_GET['suche']);
$from_with_get = 'mode=search&suche='.$suche;

$treffer = false;

function display_name_list ($sql, $title) {
	global $from_with_get;
	global $treffer;
	$erg = mysql_query($sql);
	if (mysql_error() != "") {
		echo '<br />'.$sql;
		echo '<br />'.mysql_error();
	}
	if (mysql_num_rows($erg) > 0) {
		$treffer = true;
		echo $title;
		echo '<div class="slidedown">';
		echo '<table id="liste" cellpadding="0" cellspacing="0">';
		$i = 0;
		while ($l = mysql_fetch_assoc($erg)) {
			echo '<tr class="'.($i++ % 2 == 0 ? 'hell' : 'dunkel').'">';
			echo '<td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">&raquo;</a></td><td align="right"><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['vorname'].'</a></td><td><a href="?mode=person_display&id='.$l['p_id'].'&back='.urlencode($from_with_get).'">'.$l['nachname'].'</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</div><br />';
	}
}

if (empty($suche)) {
	echo 'Es wurde kein Suchbegriff eingebenen';
}
else {
	echo 'Suche nach dem Begriff <em>[ '.$suche.' ]</em> &hellip; <br /><br />';

	$sql = 'SELECT * FROM ad_per WHERE CONCAT_WS(" ", vorname, nachname) like "%'.$suche.'%" || CONCAT_WS(" ", vorname, mittelname, nachname) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil eines Namens:');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_orte ON ort_r=o_id LEFT JOIN ad_plz ON plz_r=plz_id LEFT JOIN ad_laender ON land_r=l_id WHERE CONCAT_WS(", ", strasse, plz, ortsname, land) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Adresse:');


	// telephone numbers associated with address
	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_privat_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_privat) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Haustelefonnummer (privat):');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_arbeit_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_arbeit) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Haustelefonnummer (arbeit):');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_mobil_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_mobil) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Haustelefonnummer (mobil):');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_fax_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_fax) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Hausfaxnummer:');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_aux_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_aux) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Haustelefonnummer (aux):');


	// telephone numbers associated with person
	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_privat_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_privat) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer pers&ouml;nlichen Telefonnummer (privat):');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_arbeit_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_arbeit) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer pers&ouml;nlichen Telefonnummer (arbeit):');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_mobil_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_mobil) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer pers&ouml;nlichen Handynummer:');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_fax_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_fax) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer pers&ouml;nlichen Faxnummer:');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_aux_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_aux) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer pers&ouml;nlichen Telefonnummer (aux):');


	$sql = 'SELECT * FROM ad_per WHERE email_privat like "%'.$suche.'%" || email_arbeit like "%'.$suche.'%" || email_aux like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Emailadresse:');

	$sql = 'SELECT * FROM ad_per WHERE hp1 like "%'.$suche.'%" || hp2 like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Internetadresse:');

	$sql = 'SELECT * FROM ad_per WHERE chat_aim like "%'.$suche.'%" || chat_msn like "%'.$suche.'%" || chat_icq like "%'.$suche.'%" || chat_yim like "%'.$suche.'%" || chat_skype like "%'.$suche.'%" || chat_aux like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil eines Chat-Nicknames:');

	$sql = 'SELECT * FROM ad_per WHERE pnotizen like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; als Teil einer Notiz:');

	if (!$treffer) {
		echo 'Keine Treffer';
	}

	if (ereg('0([1-9]+)-([0-9]+)', $suche, $matches)) {
		echo 'Meinten Sie anstelle von '.$matches[0].' vielleicht <a href="index.php?mode=search&suche='.urlencode('+49-'.$matches[1].'-'.$matches[2]).'">+49-'.$matches[1].'-'.$matches[2].'</a>?';
	}
}
