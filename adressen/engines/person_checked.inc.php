<?php
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.($id).';';
mysql_query($sql);
$msgs[] = _('The entry was updated.');

// update the data for the person
$person_loop['last_check'] = time();

$mode= 'person_display';
?>
