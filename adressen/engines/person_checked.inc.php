<?PHP
$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.($id).';';
mysql_query($sql);
$msgs[] = 'Person wurde aktualisiert.';

// update the data for the person
$person_loop['last_check'] = time();

$mode= 'person_display';
?>
