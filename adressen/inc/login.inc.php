<?PHP
// Insert MySQL Data here
$server = 'localhost:8889';
$user = 'addressdb';
$passwd = '4tSMp7EVVDqLgbu';
$db = 'adressdb-redesign';

// URL to Server with tailing slash
$url_to_server = 'http://localhost:8888/Anwendungen/AdressDB-redesign/';

$admin_email = 'example@example.com';

$date_format = 'd.m.Y';
$time_format = 'd.m.Y H:i:s';

// ---

$dbh = mysql_connect($server, $user, $passwd);

if ($dbh)
	mysql_select_db($db, $dbh);
?>
