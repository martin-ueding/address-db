<?PHP
// Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Template.php');

$p_id = (int)($_GET['id']);

$template = new Template('person_form');
$template->set('heading', _('edit entry'));

$erg = Queries::select_fmg_zu_person($p_id);
while ($l = mysql_fetch_assoc($erg))
	$checked_fmgs[] = $l['fmg_id'];

$erg = Queries::select_gruppen_zu_person($p_id);
while ($l = mysql_fetch_assoc($erg))
	$checked_groups[] = $l['g_id'];

$template->set('adresswahl', '');
$template->set('checked_fmgs', $checked_fmgs);
$template->set('checked_groups', $checked_groups);
$template->set('form_target', 'person_edit2.php');
$template->set('haushalt', $person_loop['adresse_r']);
$template->set('p_id', $p_id);
$template->set('person_loop', $person_loop);
$template->set('werziehtum', 'alle');

echo $template->html();
?>
