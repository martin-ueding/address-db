<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('component/Missing.php');

class MaintenanceController {
	public static function integrity_check() {
		echo '<h1>'._('integrity check').'</h1>';

		$remove_unneeded = isset($_GET['remove_unneeded']);
		$deleted_items = 0;
		$unneeded_items = 0;

		// check mugshots
		$dir = dir('_mugshots');
		$pattern = '/per([0-9]+).jpg/';
		while ($file = $dir -> read()) {
			if (preg_match($pattern, $file, $capture)) {
				$mugshot_ids[] = $capture[1];
			}
		}

		if (isset($mugshot_ids)) {
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
				echo '<h2>'._('pictures with no associated entry').'</h2>';

				foreach ($diff as $bild_id) {
					echo '<img src="_mugshots/per'.$bild_id.'.jpg" height="180" /> ';

					if ($remove_unneeded) {
						if (@unlink('_mugshots/per'.$bild_id.'.jpg')) {
							$deleted_items++;
						}
						else {
							echo '<br />'.sprintf(_('Error during deletion of image %s!'), 'per'.$bild_id.'.jpg');
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
				echo '<h2>'._('unused addresses').'</h2>';

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
				echo '<h2>'._('unused postral codes').'</h2>';

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
				echo '<h2>'._('unused cities').'</h2>';

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
				echo '<h2>'._('unused countries').'</h2>';

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
				echo '<h2>'._('unused area codes').'</h2>';

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
				echo '<h2>'._('invalid group links').' (glinks)</h2>';

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
				echo '<h2>'._('empty groups').'</h2>';

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
				echo '<h2>'._('invalid family member links').' (flinks)</h2>';

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
			echo '<br /><br />'.sprintf(_('%d entries were deleted.'), $deleted_items);
		}
		else {
			if ($unneeded_items > 0) {
				if ($unneeded_items > $deleted_items) {
					echo '<br /><br /><a href="index.php?mode=integrity_check&remove_unneeded=true">'.sprintf(_('delete %d unneeded entries'), $unneeded_items).'</a>';
				}
			}
			else {
				echo _('There are no invalid or unneeded entries.');
			}
		}
	}

	public static function no_association() {
		echo '<h1>'._('entries without an association').'</h1>';
		$from_with_get = 'mode=no_association';

		$filter = new Filter(0, $_SESSION['g']);
		$filter->add_where('ad_flinks.person_lr IS NULL');
		$filter->add_join('LEFT JOIN ad_flinks ON person_lr = p_id');

		$missing = new Missing($filter, $from_with_get);
		echo $missing->html();
	}

	public static function no_birthday() {
		echo '<h1>'._('without a birthday').'</h1>';
		$from_with_get = 'mode=no_birthday';

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('(geb_t = 0 || geb_m = 0)');
		$filter->add_where('anrede_r != 4');


		$missing = new Missing($filter, $from_with_get);
		echo $missing->html();
	}

	public static function no_email() {
		echo '<h1>'._('entries without an email address').'</h1>';
		$from_with_get = 'mode=no_email';

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('email_privat IS NULL');
		$filter->add_where('email_arbeit IS NULL');
		$filter->add_where('email_aux IS NULL');

		$missing = new Missing($filter, $from_with_get);
		echo $missing->html();
	}

	public static function no_group() {
		echo '<h1>'._('entries without a group').'</h1>';
		$from_with_get = 'mode=no_group';

		$filter = new Filter($_SESSION['f'], 0);
		$filter->add_where('ad_glinks.person_lr IS NULL');
		$filter->add_join('LEFT JOIN ad_glinks ON ad_glinks.person_lr = gl_id');

		$missing = new Missing($filter, $from_with_get);
		echo $missing->html();
	}

	public static function no_title() {
		echo '<h1>'._('entries without a form of address').'</h1>';
		$from_with_get = 'mode=no_title';

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);
		$filter->add_where('anrede_r = 1');

		$missing = new Missing($filter, $from_with_get);
		echo $missing->html();
	}
}
?>
