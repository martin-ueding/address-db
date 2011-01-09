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
	echo _('No search query was entered');
}
else {
	printf(_('Searching for the term %s').' &hellip;', '<em>[ '.$suche.' ]</em>');
	echo '<br /><br />';

	$sql = 'SELECT * FROM ad_per WHERE CONCAT_WS(" ", vorname, nachname) like "%'.$suche.'%" || CONCAT_WS(" ", vorname, mittelname, nachname) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a name').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_orte ON ort_r=o_id LEFT JOIN ad_plz ON plz_r=plz_id LEFT JOIN ad_laender ON land_r=l_id WHERE CONCAT_WS(", ", strasse, plz, ortsname, land) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of an address').':');


	// telephone numbers associated with address
	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_privat_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_privat) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a house phone number (private)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_arbeit_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_arbeit) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a house phone number (work)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_mobil_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_mobil) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a house phone number (mobile)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_fax_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_fax) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a house fax number').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_adressen ON adresse_r=ad_id LEFT JOIN ad_vorwahlen ON fvw_aux_r=v_id WHERE CONCAT_WS("-", vorwahl, ftel_aux) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a house phone number (aux)').':');


	// telephone numbers associated with person
	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_privat_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_privat) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a personal phone number (private)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_arbeit_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_arbeit) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a personal phone number (work)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_mobil_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_mobil) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a personal phone number (mobile)').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_fax_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_fax) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a personal fax number').':');

	$sql = 'SELECT * FROM ad_per LEFT JOIN ad_vorwahlen ON vw_aux_r=v_id WHERE CONCAT_WS("-", vorwahl, tel_aux) like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a personal phone number (aux)').':');


	$sql = 'SELECT * FROM ad_per WHERE email_privat like "%'.$suche.'%" || email_arbeit like "%'.$suche.'%" || email_aux like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of an email address').':');

	$sql = 'SELECT * FROM ad_per WHERE hp1 like "%'.$suche.'%" || hp2 like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a URL').':');

	$sql = 'SELECT * FROM ad_per WHERE chat_aim like "%'.$suche.'%" || chat_msn like "%'.$suche.'%" || chat_icq like "%'.$suche.'%" || chat_yim like "%'.$suche.'%" || chat_skype like "%'.$suche.'%" || chat_aux like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a chat nickname').':');

	$sql = 'SELECT * FROM ad_per WHERE pnotizen like "%'.$suche.'%" ORDER BY nachname, vorname;';
	display_name_list($sql, '&hellip; '._('as part of a note').':');

	if (!$treffer) {
		echo _('no results').'<br /><br />';
	}

	if (ereg('0([1-9]+)-([0-9]+)', $suche, $matches)) {
		echo 'Meinten Sie anstelle von '.$matches[0].' vielleicht <a href="index.php?mode=search&suche='.urlencode('+49-'.$matches[1].'-'.$matches[2]).'">+49-'.$matches[1].'-'.$matches[2].'</a>?';
		printf(_('Did you mean %s instead of %s?'), '<a href="index.php?mode=search&suche='.urlencode('+49-'.$matches[1].'-'.$matches[2]).'">+49-'.$matches[1].'-'.$matches[2].'</a>', $matches[0]);
	}
}
