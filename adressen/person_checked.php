<?PHP

include('inc/login.inc.php');

$sql = 'UPDATE ad_per SET last_check='.time().' WHERE p_id='.((int)$_GET['id']).';';
mysql_query($sql);

header('location:personenanzeige.php?id='.((int)$_GET['id']));

?>