<h1>Daten&uuml;berpr&uuml;fung</h1>

<?PHP
$remove_unneeded = $_GET['remove_unneeded'] == 'true';
$deleted_items = 0;
$unneeded_items = 0;

// check mugshots
$dir = dir('_mugshots');
$pattern = 'per([0-9]+).jpg'; 
while ($file = $dir -> read()) {
	if (ereg($pattern, $file, $capture)) {
		$mugshot_ids[] = $capture[1];
	}
}

if (count($mugshot_ids) > 0) {
	// read all the IDs from the DB
	$sql = 'SELECT p_id FROM ad_per';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$p_ids[] = $l['p_id'];
	}

	// compare the found mugshots with the people in the DB
	$diff = array_diff($mugshot_ids, $p_ids);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>Bilder ohne Bezug</h2>';

		foreach ($diff as $bild_id) {
			echo '<img src="_mugshots/per'.$bild_id.'.jpg" height="180" /> ';

			if ($remove_unneeded) {
				if (@unlink('_mugshots/per'.$bild_id.'.jpg')) {
					$deleted_items++;
				}
				else {
					echo '<br />Fehler beim L&ouml;schen!';
				}
			}
		}

	}
}

// check addresses
$sql = 'SELECT ad_id FROM ad_adressen';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_addresses[] = $l['ad_id'];
}

if (count($stored_addresses) > 0) {
	$sql = 'SELECT adresse_r FROM ad_per';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_addresses[] = $l['adresse_r'];
	}

	$diff = array_diff($stored_addresses, $used_addresses);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>unbenutzte Adressen</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}

			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_adressen WHERE ad_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check postral codes
$sql = 'SELECT plz_id FROM ad_plz';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_plz[] = $l['plz_id'];
}

if (count($stored_plz) > 0) {
	$sql = 'SELECT plz_r FROM ad_adressen';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_plz[] = $l['plz_r'];
	}

	$diff = array_diff($stored_plz, $used_plz);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>unbenutzte Postleitzahlen</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_plz WHERE plz_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check cities
$sql = 'SELECT o_id FROM ad_orte';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_cities[] = $l['o_id'];
}

if (count($stored_cities) > 0) {
	$sql = 'SELECT ort_r FROM ad_adressen';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_cities[] = $l['ort_r'];
	}

	$diff = array_diff($stored_cities, $used_cities);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>unbenutzte Orte</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_orte WHERE o_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check countries
$sql = 'SELECT l_id FROM ad_laender';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_countries[] = $l['l_id'];
}

if (count($stored_countries) > 0) {
	$sql = 'SELECT land_r FROM ad_adressen';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_countries[] = $l['land_r'];
	}

	$diff = array_diff($stored_countries, $used_countries);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>unbenutzte L&auml;nder</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_laender WHERE l_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check telephone area codes
$sql = 'SELECT v_id FROM ad_vorwahlen';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_acodes[] = $l['v_id'];
}

if (count($stored_acodes) > 0) {
	$used_acodes = array(0);

	// select all address related area codes
	$sql = 'SELECT fvw_privat_r, fvw_arbeit_r, fvw_mobil_r, fvw_fax_r, fvw_aux_r FROM ad_adressen';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_array($erg)) {
		$used_acodes = array_merge($used_acodes, $l);
	}
	// select all person related area codes
	$sql = 'SELECT vw_privat_r, vw_arbeit_r, vw_mobil_r, vw_fax_r, vw_aux_r FROM ad_per';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_array($erg)) {
		$used_acodes = array_merge($used_acodes, $l);
	}

	$diff = array_diff($stored_acodes, $used_acodes);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>unbenutzte Vorwahlen</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_vorwahlen WHERE v_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check group links
$sql = 'SELECT person_lr FROM ad_glinks';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_grouplinks[] = $l['person_lr'];
}

if (count($stored_grouplinks) > 0) {
	$sql = 'SELECT p_id FROM ad_per';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_grouplinks[] = $l['p_id'];
	}

	$diff = array_diff($stored_grouplinks, $used_grouplinks);
	sort($diff);
	$diff = array_unique($diff);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>ung&uuml;ltige Gruppenzuordnungen (glinks)</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_glinks WHERE person_lr='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check groups
$sql = 'SELECT g_id FROM ad_gruppen';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_groups[] = $l['g_id'];
}

if (count($stored_groups) > 0) {
	$sql = 'SELECT gruppe_lr FROM ad_glinks';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_groups[] = $l['gruppe_lr'];
	}

	$diff = array_diff($stored_groups, $used_groups);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>leere Gruppen</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_gruppen WHERE g_id='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

// check family links
$sql = 'SELECT person_lr FROM ad_flinks';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	$stored_flinks[] = $l['person_lr'];
}

if (count($stored_flinks) > 0) {
	$sql = 'SELECT p_id FROM ad_per';
	$erg = mysql_query($sql);
	while ($l = mysql_fetch_assoc($erg)) {
		$used_flinks[] = $l['p_id'];
	}

	$diff = array_diff($stored_flinks, $used_flinks);
	sort($diff);
	$diff = array_unique($diff);

	if (count($diff) > 0) {
		$unneeded_items += count($diff);
		echo '<h2>ung&uuml;ltige Familienmitgliedzuordnungen (flinks)</h2>';

		$first = true;
		foreach ($diff as $item) {
			if ($first) {
				$first = false;
			}
			else {
				echo ', ';
			}
			echo $item;

			if ($remove_unneeded) {
				$remove_sql = 'DELETE FROM ad_flinks WHERE person_lr='.$item.';';
				mysql_query($remove_sql);
				$deleted_items++;
			}
		}
	}
}

if ($remove_unneeded) {
	echo '<br /><br />Es wurden '.$deleted_items.' Eintr&auml;ge gel&ouml;scht.';
}

if ($unneeded_items > 0) {
	echo '<br /><br /><a href="index.php?mode=integrity_check&remove_unneeded=true">'.$unneeded_items.'unben&ouml;tigte Eintr&auml;ge l&ouml;schen</a>';
}
else {
	echo 'Es gibt keine unben&ouml;tigten oder ung&uuml;ltigen Eintr&auml;ge.';
}

?>
