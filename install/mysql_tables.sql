CREATE TABLE `ad_adressen` (
  `ad_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `ftel_privat` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `ftel_arbeit` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `ftel_mobil` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `ftel_fax` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `ftel_aux` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `fvw_privat_r` int(5) unsigned NOT NULL DEFAULT '1',
  `fvw_arbeit_r` int(5) unsigned NOT NULL DEFAULT '1',
  `fvw_mobil_r` int(5) unsigned NOT NULL DEFAULT '1',
  `fvw_fax_r` int(5) unsigned NOT NULL DEFAULT '1',
  `fvw_aux_r` int(5) unsigned NOT NULL DEFAULT '1',
  `strasse` varchar(200) COLLATE latin1_german1_ci DEFAULT NULL,
  `plz_r` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `ort_r` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `land_r` mediumint(8) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_anreden` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `anrede` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_flinks` (
  `fl_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `fmg_lr` int(5) unsigned NOT NULL,
  `person_lr` int(5) unsigned NOT NULL,
  PRIMARY KEY (`fl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2015 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_fmg` (
  `fmg_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `fmg` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`fmg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_glinks` (
  `gl_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `person_lr` int(5) unsigned NOT NULL,
  `gruppe_lr` int(5) unsigned NOT NULL,
  PRIMARY KEY (`gl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1246 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_gruppen` (
  `g_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `gruppe` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_hu` (
  `hu_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `hu_kennzeichen` varchar(15) COLLATE latin1_german1_ci NOT NULL DEFAULT 'BN-XX XXXX',
  `hu_name` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  `hu_monat` int(2) unsigned NOT NULL DEFAULT '1',
  `hu_jahr` int(4) unsigned NOT NULL DEFAULT '2000',
  PRIMARY KEY (`hu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_laender` (
  `l_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `land` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_orte` (
  `o_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ortsname` varchar(100) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`o_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_per` (
  `p_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `vorname` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `mittelname` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `nachname` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `anrede_r` smallint(5) unsigned NOT NULL DEFAULT '1',
  `prafix_r` smallint(5) unsigned NOT NULL DEFAULT '1',
  `suffix_r` smallint(5) unsigned NOT NULL DEFAULT '1',
  `tel_privat` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `tel_arbeit` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `tel_mobil` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `tel_fax` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `tel_aux` varchar(50) COLLATE latin1_german1_ci DEFAULT NULL,
  `vw_privat_r` int(5) unsigned NOT NULL DEFAULT '1',
  `vw_arbeit_r` int(5) unsigned NOT NULL DEFAULT '1',
  `vw_mobil_r` int(5) unsigned NOT NULL DEFAULT '1',
  `vw_fax_r` int(5) unsigned NOT NULL DEFAULT '1',
  `vw_aux_r` int(5) unsigned NOT NULL DEFAULT '1',
  `email_privat` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `email_arbeit` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `email_aux` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `hp1` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `hp2` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `geb_t` smallint(2) unsigned DEFAULT NULL,
  `geb_m` smallint(2) unsigned DEFAULT NULL,
  `geb_j` int(4) unsigned DEFAULT NULL,
  `chat_aim` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `chat_msn` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `chat_icq` varchar(9) COLLATE latin1_german1_ci DEFAULT NULL,
  `chat_yim` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `chat_skype` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `chat_aux` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  `geburtsname` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `pnotizen` text COLLATE latin1_german1_ci,
  `adresse_r` int(5) unsigned NOT NULL DEFAULT '1',
  `last_check` int(16) unsigned NOT NULL DEFAULT '0',
  `last_send` int(16) NOT NULL DEFAULT '0',
  `last_edit` int(16) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM AUTO_INCREMENT=583 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_plz` (
  `plz_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `plz` varchar(15) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`plz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_prafixe` (
  `prafix_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prafix` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`prafix_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_suffixe` (
  `s_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `suffix` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `ad_vorwahlen` (
  `v_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `vorwahl` varchar(20) COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
