<?PHP
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

// Insert MySQL Data here
$server = 'localhost';
$user = 'root';
$passwd = '';
$db = 'addressdb';

// URL to Server with tailing slash
$url_to_server = 'http://example.com/addressdb/';

$admin_name = '';
$admin_email = 'example@example.com';

$date_format = 'd.m.Y';
$time_format = 'd.m.Y H:i:s';

$path_to_phpmailer = '../PHPMailer_v2.0.4/class.phpmailer.php';

// Do not change anything below this line please ---

$dbh = mysql_connect($server, $user, $passwd);

if ($dbh)
	mysql_select_db($db, $dbh);
?>
