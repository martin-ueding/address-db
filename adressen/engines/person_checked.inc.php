<?PHP
$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.($id).';';
mysql_query($sql);
$msgs[] = 'Person wurde aktualisiert.';

$mode= 'person_display';
?>
