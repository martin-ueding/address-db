<?PHP
// Insert MySQL Data here
$server = 'localhost:8889';
$user = 'addressdb';
$passwd = '4tSMp7EVVDqLgbu';
$db = 'adressdb-redesign';

// URL to Server with tailing slash
$url_to_server = 'http://www.example.com/';

$admin_email = 'example@example.com';



// ---

$dbh = mysql_connect($server, $user, $passwd);

if ($dbh)
	mysql_select_db($db, $dbh);
?>
