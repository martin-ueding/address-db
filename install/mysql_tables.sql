-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: rdbms.strato.de
-- Erstellungszeit: 18. Oktober 2010 um 18:00
-- Server Version: 5.0.89
-- PHP-Version: 5.2.9

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_adressen`
-- 

DROP TABLE IF EXISTS `ad_adressen`;
CREATE TABLE IF NOT EXISTS `ad_adressen` (
  `ad_id` int(5) unsigned NOT NULL auto_increment,
  `ftel_privat` varchar(50) collate latin1_german1_ci default NULL,
  `ftel_arbeit` varchar(50) collate latin1_german1_ci default NULL,
  `ftel_mobil` varchar(50) collate latin1_german1_ci default NULL,
  `ftel_fax` varchar(50) collate latin1_german1_ci default NULL,
  `ftel_aux` varchar(50) collate latin1_german1_ci default NULL,
  `fvw_privat_r` int(5) unsigned NOT NULL default '1',
  `fvw_arbeit_r` int(5) unsigned NOT NULL default '1',
  `fvw_mobil_r` int(5) unsigned NOT NULL default '1',
  `fvw_fax_r` int(5) unsigned NOT NULL default '1',
  `fvw_aux_r` int(5) unsigned NOT NULL default '1',
  `strasse` varchar(200) collate latin1_german1_ci default NULL,
  `plz_r` mediumint(8) unsigned NOT NULL default '1',
  `ort_r` mediumint(8) unsigned NOT NULL default '1',
  `land_r` mediumint(8) unsigned NOT NULL default '1',
  PRIMARY KEY  (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=210 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_anreden`
-- 

DROP TABLE IF EXISTS `ad_anreden`;
CREATE TABLE IF NOT EXISTS `ad_anreden` (
  `a_id` int(10) unsigned NOT NULL auto_increment,
  `anrede` varchar(30) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_flinks`
-- 

DROP TABLE IF EXISTS `ad_flinks`;
CREATE TABLE IF NOT EXISTS `ad_flinks` (
  `fl_id` int(5) unsigned NOT NULL auto_increment,
  `fmg_lr` int(5) unsigned NOT NULL,
  `person_lr` int(5) unsigned NOT NULL,
  PRIMARY KEY  (`fl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1747 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1747 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_fmg`
-- 

DROP TABLE IF EXISTS `ad_fmg`;
CREATE TABLE IF NOT EXISTS `ad_fmg` (
  `fmg_id` int(5) unsigned NOT NULL auto_increment,
  `fmg` varchar(50) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`fmg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_glinks`
-- 

DROP TABLE IF EXISTS `ad_glinks`;
CREATE TABLE IF NOT EXISTS `ad_glinks` (
  `gl_id` int(5) unsigned NOT NULL auto_increment,
  `person_lr` int(5) unsigned NOT NULL,
  `gruppe_lr` int(5) unsigned NOT NULL,
  PRIMARY KEY  (`gl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1126 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=1126 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_gruppen`
-- 

DROP TABLE IF EXISTS `ad_gruppen`;
CREATE TABLE IF NOT EXISTS `ad_gruppen` (
  `g_id` int(5) unsigned NOT NULL auto_increment,
  `gruppe` varchar(100) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_hu`
-- 

DROP TABLE IF EXISTS `ad_hu`;
CREATE TABLE IF NOT EXISTS `ad_hu` (
  `hu_id` int(5) unsigned NOT NULL auto_increment,
  `hu_kennzeichen` varchar(15) collate latin1_german1_ci NOT NULL default 'BN-XX XXXX',
  `hu_name` varchar(100) collate latin1_german1_ci NOT NULL,
  `hu_monat` int(2) unsigned NOT NULL default '1',
  `hu_jahr` int(4) unsigned NOT NULL default '2000',
  PRIMARY KEY  (`hu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_laender`
-- 

DROP TABLE IF EXISTS `ad_laender`;
CREATE TABLE IF NOT EXISTS `ad_laender` (
  `l_id` int(5) unsigned NOT NULL auto_increment,
  `land` varchar(100) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`l_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_orte`
-- 

DROP TABLE IF EXISTS `ad_orte`;
CREATE TABLE IF NOT EXISTS `ad_orte` (
  `o_id` int(10) unsigned NOT NULL auto_increment,
  `ortsname` varchar(100) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`o_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_per`
-- 

DROP TABLE IF EXISTS `ad_per`;
CREATE TABLE IF NOT EXISTS `ad_per` (
  `p_id` int(5) unsigned NOT NULL auto_increment,
  `vorname` varchar(100) collate latin1_german1_ci default NULL,
  `mittelname` varchar(100) collate latin1_german1_ci default NULL,
  `nachname` varchar(100) collate latin1_german1_ci default NULL,
  `anrede_r` smallint(5) unsigned NOT NULL default '1',
  `prafix_r` smallint(5) unsigned NOT NULL default '1',
  `suffix_r` smallint(5) unsigned NOT NULL default '1',
  `tel_privat` varchar(50) collate latin1_german1_ci default NULL,
  `tel_arbeit` varchar(50) collate latin1_german1_ci default NULL,
  `tel_mobil` varchar(50) collate latin1_german1_ci default NULL,
  `tel_fax` varchar(50) collate latin1_german1_ci default NULL,
  `tel_aux` varchar(50) collate latin1_german1_ci default NULL,
  `vw_privat_r` int(5) unsigned NOT NULL default '1',
  `vw_arbeit_r` int(5) unsigned NOT NULL default '1',
  `vw_mobil_r` int(5) unsigned NOT NULL default '1',
  `vw_fax_r` int(5) unsigned NOT NULL default '1',
  `vw_aux_r` int(5) unsigned NOT NULL default '1',
  `email_privat` varchar(150) collate latin1_german1_ci default NULL,
  `email_arbeit` varchar(150) collate latin1_german1_ci default NULL,
  `email_aux` varchar(150) collate latin1_german1_ci default NULL,
  `hp1` varchar(250) collate latin1_german1_ci default NULL,
  `hp2` varchar(250) collate latin1_german1_ci default NULL,
  `geb_t` smallint(2) unsigned default NULL,
  `geb_m` smallint(2) unsigned default NULL,
  `geb_j` int(4) unsigned default NULL,
  `chat_aim` varchar(150) collate latin1_german1_ci default NULL,
  `chat_msn` varchar(150) collate latin1_german1_ci default NULL,
  `chat_icq` varchar(9) collate latin1_german1_ci default NULL,
  `chat_yim` varchar(150) collate latin1_german1_ci default NULL,
  `chat_skype` varchar(150) collate latin1_german1_ci default NULL,
  `chat_aux` varchar(150) collate latin1_german1_ci default NULL,
  `geburtsname` varchar(100) collate latin1_german1_ci default NULL,
  `pnotizen` text collate latin1_german1_ci,
  `adresse_r` int(5) unsigned NOT NULL default '1',
  `last_check` int(16) unsigned NOT NULL default '0',
  PRIMARY KEY  (`p_id`)
) ENGINE=MyISAM AUTO_INCREMENT=528 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=528 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_plz`
-- 

DROP TABLE IF EXISTS `ad_plz`;
CREATE TABLE IF NOT EXISTS `ad_plz` (
  `plz_id` int(5) unsigned NOT NULL auto_increment,
  `plz` varchar(15) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`plz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_prafixe`
-- 

DROP TABLE IF EXISTS `ad_prafixe`;
CREATE TABLE IF NOT EXISTS `ad_prafixe` (
  `prafix_id` int(10) unsigned NOT NULL auto_increment,
  `prafix` varchar(30) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`prafix_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_suffixe`
-- 

DROP TABLE IF EXISTS `ad_suffixe`;
CREATE TABLE IF NOT EXISTS `ad_suffixe` (
  `s_id` int(5) unsigned NOT NULL auto_increment,
  `suffix` varchar(30) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ad_vorwahlen`
-- 

DROP TABLE IF EXISTS `ad_vorwahlen`;
CREATE TABLE IF NOT EXISTS `ad_vorwahlen` (
  `v_id` int(5) unsigned NOT NULL auto_increment,
  `vorwahl` varchar(20) collate latin1_german1_ci NOT NULL,
  PRIMARY KEY  (`v_id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=90 ;

ALTER TABLE `ad_per` ADD `last_send` INT( 16 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `ad_per` ADD `last_edit` INT( 16 ) NOT NULL 
