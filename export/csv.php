<?php
# Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

include('../_config.inc.php');
include('../inc/abfragen.inc.php');
include("../inc/anzeigen.inc.php");
include("../inc/select.inc.php");
include("../inc/varclean.inc.php");

if (empty($_GET['f']))
	die();


$sql = 'SELECT * '.
	'FROM ad_per, ad_flinks, ad_adressen, ad_orte, ad_plz, ad_laender, ad_anreden, ad_prafixe, ad_suffixe '.
	'WHERE person_lr=p_id && fmg_lr='.$_GET['f'].' && adresse_r=ad_id && ort_r=o_id && plz_r=plz_id && land_r=l_id && anrede_r=a_id && prafix_r=prafix_id && suffix_r=s_id '.
	'ORDER BY nachname, vorname;';



?>
