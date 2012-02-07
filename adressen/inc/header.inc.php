<?PHP
/* Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de> */

require_once('../helpers/NavHelper.php');

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
		<?PHP
		echo '<li><b>'._('mode').'</b></li>';

		// find all get parameters which are not the mode or the fmg and put them into a string
		$get_for_fmg_change = '';
		foreach ($_GET as $key => $wert) {
			if ($key != 'mode' && $key != 'f') {
				$get_for_fmg_change .= '&'.$key.'='.$wert;
			}
		}

		echo '<li><a href="?mode='.$mode.'&f=0'.$get_for_fmg_change.'" '.($_SESSION['f'] == 0 ? 'class="active"' : '').'>'._('all').'</a></li>';
		echo NavHelper::spacer();

		$sql = 'SELECT * FROM ad_fmg';
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			echo '<li><a href="index.php?mode='.$mode.'&f='.$l['fmg_id'].$get_for_fmg_change.'" '.($_SESSION['f'] == $l['fmg_id'] ? 'class="active"' : '').'>'.$l['fmg'].'</a></li>';
			if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
				$aktuell_name = $l['fmg'];
		}
		?>

	</ul>
</div>


<div id="nav_groups">
	<ul>
		<?PHP
		echo '<li><b>'._('groups').'</b></li>';

		$get_for_group_change = '';
		foreach ($_GET as $key => $wert) {
			if ($key != 'mode' && $key != 'g') {
				$get_for_group_change .= '&'.$key.'='.$wert;
			}
		}
		echo '<li><a href="?mode='.$mode.'&g=0'.$get_for_group_change.'" '.($_SESSION['g'] == 0 ? 'class="active"' : '').'>'._('all').'</a></li>';
		echo NavHelper::spacer();

		$erg = Queries::select_alle_gruppen();
		while ($l = mysql_fetch_assoc($erg)) {
			if (Queries::gruppe_ist_nicht_leer($l['g_id'])) {
				echo '<li><a href="index.php?mode='.$mode.'&g='.$l['g_id'].'" '.($_SESSION['g'] == $l['g_id'] ? 'class="active"' : '').'>'.$l['gruppe'].'</a></li>';
			}
		}
		?>

	</ul>
</div>

<div id="nav_actions">
<ul>
<?php
echo '<li><b>'._('action').'</b></li>';

echo NavHelper::nav_action_link('main', $mode, _('birthday view'));
echo NavHelper::nav_action_link('list', $mode, _('show entries'));
echo NavHelper::nav_action_link('person_create1', $mode, _('create new entry'));
echo NavHelper::nav_action_link('all_birthdays', $mode, _('birthday list'));
echo NavHelper::spacer();
echo '<li><a href="export/kitchen.php">'._('export LaTeX sheets').'</a></li>';
echo NavHelper::spacer();
echo NavHelper::nav_action_link('no_title', $mode, _('no form of address'));
echo NavHelper::nav_action_link('no_association', $mode, _('no association'));
echo NavHelper::nav_action_link('no_group', $mode, _('no group'));
echo NavHelper::nav_action_link('no_email', $mode, _('no email address'));
echo NavHelper::nav_action_link('no_birthday', $mode, _('no birthday'));
echo NavHelper::nav_action_link('integrity_check', $mode, _('database check'));
?>
</ul>
</div>

<!--
<div id="nav_lang">
	<ul>
		<?PHP
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



<?PHP
$buchstaben = range('A', 'Z');
echo '<div id="kartei">';
foreach ($buchstaben as $b) {
	if (isset($_SESSION['f']) && $_SESSION['f'] != 0)
		$sql = 'SELECT p_id FROM ad_per, ad_flinks WHERE nachname like "'.$b.'%" && person_lr=p_id && fmg_lr='.$_SESSION['f'].';';
	else
		$sql = 'SELECT p_id FROM ad_per WHERE nachname like "'.$b.'%";';
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

<!--
<div>
<form action="index.php" method="get"><input type="text" id="suche" name="suche" maxlength="100" /><input type="hidden" name="mode" value="search" /></form>
</div>

<div class="clearheinz"></div>
-->
