-- This migrates the database from the 3.1.1 scheme to the new 3.2 scheme.

-- The previous scheme had no real pattern, German names and so on. The new
-- scheme is compliant with the CakePHP database conventions.

ALTER TABLE `addresses`.`ad_adressen` RENAME TO `addresses`.`ad_addresses`,
 CHANGE COLUMN `ad_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_vorwahlen` RENAME TO `addresses`.`ad_area_codes`,
 CHANGE COLUMN `v_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `vorwahl` `area_code` VARCHAR(20)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_fmg` RENAME TO `addresses`.`ad_members`,
 CHANGE COLUMN `fmg_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `fmg` `member` VARCHAR(50)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_laender` RENAME TO `addresses`.`ad_countries`,
 CHANGE COLUMN `l_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `land` `country` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_orte` RENAME TO `addresses`.`ad_cities`,
 CHANGE COLUMN `o_id` `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `ortsname` `city` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_gruppen` RENAME TO `addresses`.`ad_groups`,
 CHANGE COLUMN `g_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `gruppe` `group` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_per` RENAME TO `addresses`.`ad_persons`,
 CHANGE COLUMN `p_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `vorname` `first_name` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `mittelname` `middle_name` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `nachname` `last_name` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `anrede_r` `form_of_address_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `prafix_r` `prefix_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `suffix_r` `suffix_id` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `geburtsname` `birth_name` VARCHAR(100)  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `pnotizen` `notes` TEXT  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `adresse_r` `address_id` INT(5) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `last_edit` `modified` INT(16)  NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_plz` RENAME TO `addresses`.`ad_postral_codes`,
 CHANGE COLUMN `plz_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `plz` `postral_code` VARCHAR(15)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_prafixe` RENAME TO `addresses`.`ad_prefix`,
 CHANGE COLUMN `prafix_id` `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `prafix` `prefix` VARCHAR(30)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_suffixe` RENAME TO `addresses`.`ad_suffix`,
 CHANGE COLUMN `s_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_flinks` RENAME TO `addresses`.`ad_members_persons`,
 CHANGE COLUMN `fl_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `fmg_lr` `member_id` INT(5) UNSIGNED NOT NULL,
 CHANGE COLUMN `person_lr` `person_id` INT(5) UNSIGNED NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_glinks` RENAME TO `addresses`.`ad_groups_persons`,
 CHANGE COLUMN `gl_id` `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `person_lr` `person_id` INT(5) UNSIGNED NOT NULL,
 CHANGE COLUMN `gruppe_lr` `group_id` INT(5) UNSIGNED NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_anreden` RENAME TO `addresses`.`ad_forms_of_address`,
 CHANGE COLUMN `a_id` `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
 CHANGE COLUMN `anrede` `form_of_address` VARCHAR(30)  CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`id`);

ALTER TABLE `addresses`.`ad_addresses` CHANGE COLUMN `strasse` `street` VARCHAR(200)  CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
 CHANGE COLUMN `plz_r` `postral_code_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `ort_r` `city_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 1,
 CHANGE COLUMN `land_r` `country_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 1;

ALTER TABLE `addresses`.`ad_persons` CHANGE COLUMN `geb_t` `birth_day` SMALLINT(2) UNSIGNED DEFAULT NULL,
 CHANGE COLUMN `geb_m` `birth_month` SMALLINT(2) UNSIGNED DEFAULT NULL,
 CHANGE COLUMN `geb_j` `birth_year` INT(4) UNSIGNED DEFAULT NULL,
 DROP COLUMN `last_send`;
