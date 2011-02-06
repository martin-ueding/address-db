<div class="menu">

<ul>
<li><a href="index.php?mode=main"><?PHP echo _('menu'); ?><!--[if gte IE 7]><!--></a><!--<![endif]-->
<!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul>
	<li><a href="index.php?mode=list<?PHP if (isset($_SESSION['f'])) echo '&f='.$_SESSION['f']; ?>"><?PHP echo _('show my entries'); ?></a></li>
	<li><a href="index.php?mode=person_create1"><?PHP echo _('create new entry'); ?></a></li>
	<li><a href="index.php?mode=all_birthdays"><?PHP echo _('birthday list'); ?></a></li>
	<li><a href="export/kitchen.php"><?PHP echo _('export LaTeX sheets'); ?></a></li>

	<li><a class="drop" href=""><?PHP echo _('maintenance'); ?><!--[if gte IE 7]><!--></a><!--<![endif]-->
<!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul>
			<li><a href="index.php?mode=no_title"><?PHP echo _('no form of address'); ?></a></li>
			<li><a href="index.php?mode=no_email"><?PHP echo _('no email address'); ?></a></li>
			<li><a href="index.php?mode=no_birthday"><?PHP echo _('no birthday'); ?></a></li>
			<li><a href="index.php?mode=integrity_check"><?PHP echo _('database check'); ?></a></li>
		</ul>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>

<?PHP
$sql = 'SELECT * FROM ad_fmg';
$erg = mysql_query($sql);
while ($l = mysql_fetch_assoc($erg)) {
	if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
		$aktuell_name = $l['fmg'];
}
if (!isset($aktuell_name))
	$aktuell_name = _('all');
?>
<li><a href=""><?PHP echo _('mode'); ?>: <?PHP echo $aktuell_name; ?><!--[if gte IE 7]><!--></a><!--<![endif]-->
<!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul>
		<?PHP
		// find all get parameters which are not the mode or the fmg and put them into a string
		$get_for_fmg_change = '';
		foreach ($_GET as $key => $wert) {
			if ($key != 'mode' && $key != 'f') {
				$get_for_fmg_change .= '&'.$key.'='.$wert;
			}
		}
		if (isset($_SESSION['f']) && $_SESSION['f'] != 0)
			echo '<li><a href="?mode='.$mode.'&f=0'.$get_for_fmg_change.'">:: '._('all').'</a></li>';
		$sql = 'SELECT * FROM ad_fmg';
		$erg = mysql_query($sql);
		while ($l = mysql_fetch_assoc($erg)) {
			echo '<li><a class="fmg_key" href="index.php?mode='.$mode.'&f='.$l['fmg_id'].$get_for_fmg_change.'">'.$l['fmg'].'</a></li>';
			if (isset($_SESSION['f']) && $l['fmg_id'] == $_SESSION['f'])
				$aktuell_name = $l['fmg'];
		}
		?>

	</ul>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>


<li><a href=""><?PHP echo _('groups'); ?><!--[if gte IE 7]><!--></a><!--<![endif]-->
<!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul>
		<?PHP
		$erg = select_alle_gruppen();
		while ($l = mysql_fetch_assoc($erg)) {
			if (gruppe_ist_nicht_leer($l['g_id'])) {
				echo '<li><a href="index.php?mode=list&g='.$l['g_id'].'&titel='.urlencode($l['gruppe']).'">'.$l['gruppe'].'</a></li>';
			}
		}
		?>

	</ul>

<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href=""><?PHP echo _('languages'); ?><!--[if gte IE 7]><!--></a><!--<![endif]-->
<!--[if lte IE 6]><table><tr><td><![endif]-->
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
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>

</div>



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

<div>
<form action="index.php" method="get"><input type="text" id="suche" name="suche" maxlength="100" /><input type="hidden" name="mode" value="search" /></form>
</div>

<div class="clearheinz"></div>
