<?PHP
$path_config = 'adressen/_config.inc.php';

if (!file_exists($path_config)) {
	echo _('You need to create a config file');
}

?>
