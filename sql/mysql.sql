# SQL Dump for wgfaker module
# PhpMyAdmin Version: 4.0.4
# https://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Thu Feb 03, 2022 to 16:41:14
# Server version: 5.5.5-10.4.10-MariaDB
# PHP Version: 7.4.0

#
# Structure table for `wgfaker_table` 6
#

CREATE TABLE `wgfaker_table` (
  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` INT(10) NOT NULL DEFAULT '0',
  `module` VARCHAR(255) NOT NULL DEFAULT '',
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `skip` INT(1) NOT NULL DEFAULT '0',
  `datecreated` INT(11) NOT NULL DEFAULT '0',
  `submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#
# Structure table for `wgfaker_field` 7
#

CREATE TABLE `wgfaker_field` (
  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` INT(10) NOT NULL DEFAULT '0',
  `tableid` INT(10) NOT NULL DEFAULT '0',
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `type` VARCHAR(255) NOT NULL DEFAULT '',
  `datatypeid` INT(10) NOT NULL DEFAULT '0',
  `datecreated` INT(11) NOT NULL DEFAULT '0',
  `submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#
# Structure table for `wgfaker_datatype` 5
#

CREATE TABLE `wgfaker_datatype` (
  `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '',
  `values` TEXT NOT NULL ,
  `weight` INT(10) NOT NULL DEFAULT '0',
  `datecreated` INT(11) NOT NULL DEFAULT '0',
  `submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

