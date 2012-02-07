<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Template.php');

$p_id = (int)($_GET['id']);

$template = new Template('person_form');
$template->set('heading', _('edit entry'));

$erg = Queries::select_fmg_zu_person ($p_id);
while ($l = mysql_fetch_assoc($erg))
	$fmgs[] = $l['fmg_id'];

$erg = Queries::select_gruppen_zu_person ($p_id);
while ($l = mysql_fetch_assoc($erg))
	$gruppen[] = $l['g_id'];

$template->set('adresswahl', '');
$template->set('fmgs', $fmgs);
$template->set('form_target', 'person_edit2.php');
$template->set('gruppen', $gruppen);
$template->set('haushalt', $person_loop['adresse_r']);
$template->set('p_id', $p_id);
$template->set('person_loop', $person_loop);
$template->set('werziehtum', 'alle');

echo $template->html();
?>
