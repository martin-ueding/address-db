<?PHP

include('_config.inc.php');

$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.((int)$_GET['id']).';';
mysql_query($sql);

header('location:index.php?mode=person_display&id='.((int)$_GET['id']));

?>
