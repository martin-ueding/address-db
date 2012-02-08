<?php
# Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('helper/Table.php');
require_once('component/Filter.php');

echo '<h1>'._('search').'</h1>';

$suche = mysql_real_escape_string($_GET['suche']);
$from_with_get = 'mode=search&suche='.$suche;

$treffer = false;

function display_name_list($filter, $title) {
	$filter->add_join('LEFT JOIN ad_adressen ON adresse_r=ad_id', true);
	$filter->add_join('LEFT JOIN ad_orte ON ort_r=o_id');
	$filter->add_join('LEFT JOIN ad_plz ON plz_r=plz_id');
	$filter->add_join('LEFT JOIN ad_laender ON land_r=l_id');

	$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';
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
		$table = new Table($erg, $from_with_get);
		echo $table->html();
		echo '</div><br />';
	}
}

if (empty($suche)) {
	echo _('No search query was entered');
}
else {
	printf(_('Searching for the term %s').' &hellip;', '<em>[ '.$suche.' ]</em>');
	echo '<br /><br />';

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('(CONCAT_WS(" ", vorname, nachname) like "%'.$suche.'%" || CONCAT_WS(" ", vorname, mittelname, nachname) like "%'.$suche.'%")');
	display_name_list($filter, '&hellip; '._('as part of a name').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('CONCAT_WS(", ", strasse, plz, ortsname, land) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of an address').':');


	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON fvw_privat_r = v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, ftel_privat) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a house phone number (private)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON fvw_arbeit_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, ftel_arbeit) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a house phone number (work)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON fvw_mobil_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, ftel_mobil) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a house phone number (mobile)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON fvw_fax_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, ftel_fax) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a house fax number').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON fvw_aux_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, ftel_aux) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a house phone number (aux)').':');


	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON vw_privat_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, tel_privat) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a personal phone number (private)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON vw_arbeit_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, tel_arbeit) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a personal phone number (work)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON vw_mobil_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, tel_mobil) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a personal phone number (mobile)').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON vw_fax_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, tel_fax) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a personal fax number').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_join('LEFT JOIN ad_vorwahlen ON vw_aux_r=v_id');
	$filter->add_where('CONCAT_WS("-", vorwahl, tel_aux) like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a personal phone number (aux)').':');


	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('(email_privat like "%'.$suche.'%" || email_arbeit like "%'.$suche.'%" || email_aux like "%'.$suche.'%")');
	display_name_list($filter, '&hellip; '._('as part of an email address').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('(hp1 like "%'.$suche.'%" || hp2 like "%'.$suche.'%")');
	display_name_list($filter, '&hellip; '._('as part of a URL').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('(chat_aim like "%'.$suche.'%" || chat_msn like "%'.$suche.'%" || chat_icq like "%'.$suche.'%" || chat_yim like "%'.$suche.'%" || chat_skype like "%'.$suche.'%" || chat_aux like "%'.$suche.'%")');
	display_name_list($filter, '&hellip; '._('as part of a chat nickname').':');

	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('pnotizen like "%'.$suche.'%"');
	display_name_list($filter, '&hellip; '._('as part of a note').':');

	if (!$treffer) {
		echo _('no results').'<br /><br />';
	}

	if (preg_match('/0([1-9]+)-([0-9]+)/', $suche, $matches)) {
		printf(_('Did you mean %s instead of %s?'), '<a href="index.php?mode=search&suche='.urlencode('+49-'.$matches[1].'-'.$matches[2]).'">+49-'.$matches[1].'-'.$matches[2].'</a>', $matches[0]);
	}
}
