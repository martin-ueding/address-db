<?php
/* Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de> */

require_once('../helper/Filter.php');
require_once('../helper/Navigation.php');
require_once('../helper/Request.php');

$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
		$aktuell_name = $l['fmg'];
}
if (!isset($aktuell_name))
	$aktuell_name = _('all');
?>
<div id="nav_mode">
	<ul>
		<?php
		echo '<li><b>'._('mode').'</b></li>';

		// find all get parameters which are not the mode or the fmg and put them into a string
		$request = new Request();
		$request->set('mode', $mode);
		$request->set('f', 0);

		echo '<li><a href="?'.$request->join().'" '.($_SESSION['f'] == 0 ? 'class="active"' : '').'>'._('all').'</a></li>';
		echo Navigation::spacer();

		$sql = 'SELECT * FROM ad_fmg';
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			$request = new Request();
			$request->set('mode', $mode);
			$request->set('f', $l['fmg_id']);

			echo '<li><a href="index.php?'.$request->join().'" '.($_SESSION['f'] == $l['fmg_id'] ? 'class="active"' : '').'>'.$l['fmg'].'</a></li>';
			if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
				$aktuell_name = $l['fmg'];
		}
		?>

	</ul>
</div>


<div id="nav_groups">
	<ul>
		<?php
		echo '<li><b>'._('groups').'</b></li>';

		$request = new Request();
		$request->set('mode', $mode);
		$request->set('g', 0);

		echo '<li><a href="?'.$request->join().'" '.($_SESSION['g'] == 0 ? 'class="active"' : '').'>'._('all').'</a></li>';
		echo Navigation::spacer();

		$erg = Queries::select_alle_gruppen();
		while ($l = mysql_fetch_assoc($erg)) {
			if (Queries::gruppe_ist_nicht_leer($l['g_id'])) {
				$request = new Request();
				$request->set('mode', $mode);
				$request->set('g', $l['g_id']);

				echo '<li><a href="index.php?'.$request->join().'" '.($_SESSION['g'] == $l['g_id'] ? 'class="active"' : '').'>'.$l['gruppe'].'</a></li>';
			}
		}
		?>

	</ul>
</div>

<div id="nav_actions">
<ul>
<?php
echo '<li><b>'._('views').'</b></li>';
echo Navigation::nav_action_link('list', $mode, _('show entries'));
echo Navigation::nav_action_link('main', $mode, _('birthday view'));
echo Navigation::nav_action_link('all_birthdays', $mode, _('birthday list'));
echo Navigation::spacer();
echo '<li><b>'._('create').'</b></li>';
echo Navigation::nav_action_link('person_create1', $mode, _('create new entry'));
echo Navigation::spacer();
echo '<li><b>'._('maintenance').'</b></li>';
echo '<li><a href="export/kitchen.php">'._('export LaTeX sheets').'</a></li>';
echo Navigation::spacer();
echo Navigation::nav_action_link('no_title', $mode, _('no form of address'));
echo Navigation::nav_action_link('no_association', $mode, _('no association'));
echo Navigation::nav_action_link('no_group', $mode, _('no group'));
echo Navigation::nav_action_link('no_email', $mode, _('no email address'));
echo Navigation::nav_action_link('no_birthday', $mode, _('no birthday'));
echo Navigation::nav_action_link('integrity_check', $mode, _('database check'));
?>
</ul>
</div>

<!--
<div id="nav_lang">
	<ul>
		<?php
		$get_for_lang_change = '';
		foreach ($_GET as $key => $wert) {
			if ($key != 'mode' && $key != 'lang') {
				$get_for_lang_change .= '&'.$key.'='.$wert;
			}
		}
		foreach ($available_languages as $a_lang) {
			echo '<li><a class="fmg_key" href="index.php?mode='.$mode.'&lang='.$a_lang[0].$get_for_lang_change.'">'.$a_lang[1].'</a></li>';
		}
		?>
</ul>
</div>
-->



<?php
$buchstaben = range('A', 'Z');
echo '<div id="kartei">';
foreach ($buchstaben as $b) {
	$filter = new Filter($_SESSION['f'], $_SESSION['g']);
	$filter->add_where('nachname like "'.$b.'%"');

	$sql = 'SELECT p_id FROM ad_per '.$filter->join().' WHERE '.$filter->where().';';

	$erg = mysql_query($sql);
	if (mysql_num_rows($erg) > 0) {
		echo '<a href="index.php?mode=list&b='.$b.'">';
		echo $b;
		echo '</a>';
	}
	else {
		echo '<span>'.$b.'</span>';
	}
}
echo '</div>';
?>

<div id="search">
<form action="index.php" method="get"><input type="text" id="suche" name="suche" maxlength="100" /><input type="hidden" name="mode" value="search" /></form>
</div>
