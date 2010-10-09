<?PHP
include('inc/login.inc.php');

$sql = 'CREATE TABLE `ad_fam` ('
        . ' `f_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `nachname` VARCHAR(100) NULL, '
        . ' `ftel_privat` VARCHAR(50) NULL, '
        . ' `ftel_arbeit` VARCHAR(50) NULL, '
        . ' `ftel_mobil` VARCHAR(50) NULL, '
        . ' `ftel_fax` VARCHAR(50) NULL, '
        . ' `ftel_aux` VARCHAR(50) NULL, '
        . ' `strasse` VARCHAR(200) NULL, '
        . ' `plz_r` MEDIUMINT UNSIGNED NULL, '
        . ' `ort_r` MEDIUMINT UNSIGNED NULL, '
        . ' `land_r` MEDIUMINT UNSIGNED NULL, '
        . ' `autor_r` INT(5) UNSIGNED NOT NULL, '
        . ' `erstellt` INT(15) UNSIGNED NOT NULL, '
        . ' `aktualisiert` INT(15) UNSIGNED NOT NULL, '
        . ' `fnotizen` TEXT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();


$sql = 'CREATE TABLE `ad_per` ('
        . ' `p_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `vorname` VARCHAR(100) NOT NULL, '
        . ' `mittelname` VARCHAR(100) NULL, '
        . ' `anrede_r` SMALLINT UNSIGNED NULL, '
        . ' `prafix_r` SMALLINT UNSIGNED NULL, '
        . ' `suffix_r` SMALLINT UNSIGNED NULL, '
        . ' `tel_privat` VARCHAR(50) NULL, '
        . ' `tel_arbeit` VARCHAR(50) NULL, '
        . ' `tel_mobil` VARCHAR(50) NULL, '
        . ' `tel_fax` VARCHAR(50) NULL, '
        . ' `tel_aux` VARCHAR(50) NULL, '
        . ' `email_privat` VARCHAR(150) NULL, '
        . ' `email_arbeit` VARCHAR(150) NULL, '
        . ' `email_aux` VARCHAR(150) NULL, '
        . ' `hp1` VARCHAR(250) NULL, '
        . ' `hp2` VARCHAR(250) NULL, '
        . ' `geb_t` SMALLINT(2) UNSIGNED NULL, '
        . ' `geb_m` SMALLINT(2) UNSIGNED NULL, '
        . ' `geb_j` INT(4) UNSIGNED NULL, '
        . ' `chat_aim` VARCHAR(150) NULL, '
        . ' `chat_msn` VARCHAR(150) NULL, '
        . ' `chat_icq` VARCHAR(9) NULL, '
        . ' `chat_yim` VARCHAR(150) NULL, '
        . ' `chat_skype` VARCHAR(150) NULL, '
        . ' `chat_aux` VARCHAR(150) NULL, '
        . ' `geburtsname` VARCHAR(100) NULL, '
        . ' `pnotizen` TEXT NULL, '
        . ' `familie_r` INT(5) UNSIGNED NOT NULL, '
        . ' `perstellt` INT(15) UNSIGNED NOT NULL, '
        . ' `paktualisiert` INT(15) UNSIGNED NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();


$sql = 'CREATE TABLE `ad_plz` ('
        . ' `plz_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `plz` INT(5) UNSIGNED NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();


$sql = 'CREATE TABLE `ad_orte` ('
        . ' `o_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `ortsname` VARCHAR(100) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_laender` ('
        . ' `l_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `land` VARCHAR(100) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_anreden` ('
        . ' `a_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `anrede` VARCHAR(30) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_prafixe` ('
        . ' `prafix_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `prafix` VARCHAR(30) NOT NULL'
        . ' )'

        . ' ENGINE = myisam;';


mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_gruppen` ('
        . ' `g_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `gruppe` VARCHAR(100) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_vorwahlen` ('
        . ' `v_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `vorwahl` VARCHAR(20) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'ALTER TABLE `ad_fam` ADD `fvw_privat_r` INT(5) UNSIGNED NOT NULL AFTER `ftel_aux`, ADD `fvw_arbeit_r` INT(5) UNSIGNED NOT NULL AFTER `fvw_privat_r`, ADD `fvw_mobil_r` INT(5) UNSIGNED NOT NULL AFTER `fvw_arbeit_r`, ADD `fvw_fax_r` INT(5) UNSIGNED NOT NULL AFTER `fvw_mobil_r`, ADD `fvw_aux_r` INT(5) UNSIGNED NOT NULL AFTER `fvw_fax_r`;';

mysql_query($sql);
echo mysql_error();

$sql = 'ALTER TABLE `ad_fam` CHANGE `fvw_privat_r` `fvw_privat_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\', CHANGE `fvw_arbeit_r` `fvw_arbeit_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\', CHANGE `fvw_mobil_r` `fvw_mobil_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\', CHANGE `fvw_fax_r` `fvw_fax_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\', CHANGE `fvw_aux_r` `fvw_aux_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\', CHANGE `autor_r` `autor_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\'';

mysql_query($sql);
echo mysql_error();

$sql = 'ALTER TABLE `ad_per` ADD `vw_privat_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\' AFTER `tel_aux`, ADD `vw_arbeit_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\' AFTER `vw_privat_r`, ADD `vw_mobil_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\' AFTER `vw_arbeit_r`, ADD `vw_fax_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\' AFTER `vw_mobil_r`, ADD `vw_aux_r` INT(5) UNSIGNED NOT NULL DEFAULT \'1\' AFTER `vw_fax_r`;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_glinks` ('
        . ' `gl_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `person_lr` INT(5) UNSIGNED NOT NULL, '
        . ' `gruppe_lr` INT(5) UNSIGNED NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_flinks` ('
        . ' `fl_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `fmg_lr` INT(5) UNSIGNED NOT NULL, '
        . ' `person_lr` INT(5) UNSIGNED NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';

mysql_query($sql);
echo mysql_error();

$sql = 'CREATE TABLE `ad_fmg` ('
        . ' `fmg_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `fmg` VARCHAR(50) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';


mysql_query($sql);
echo mysql_error();

?>