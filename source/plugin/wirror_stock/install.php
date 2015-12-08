<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_stock_zx;
CREATE TABLE IF NOT EXISTS `cdb_wirror_stock_zx` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` bigint(11) unsigned NOT NULL,
  `username`  varchar(20)  NOT NULL,
  `stockcode` char(12) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;

$sql01 = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_stock;
CREATE TABLE IF NOT EXISTS `cdb_wirror_stock` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` bigint(11) unsigned NOT NULL,
  `username`  varchar(20)  NOT NULL,
  `stockzj` bigint(11) unsigned NOT NULL,
  `sumexp` bigint(11) unsigned NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;

$sql02 = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_buystock;
CREATE TABLE IF NOT EXISTS `cdb_wirror_buystock` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` bigint(11) unsigned NOT NULL,
  `username`  varchar(20)  NOT NULL,
  `stockcount` int(11)  NOT NULL,
  `stockcode` char(12) NOT NULL,
  `stockname` varchar(30) NOT NULL,
  `stockcbj` DECIMAL(10,2) UNSIGNED NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;

$sql03 = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_stocklog;
CREATE TABLE IF NOT EXISTS `cdb_wirror_stocklog` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` bigint(11) unsigned NOT NULL,
  `username`  varchar(20)  NOT NULL,
  `tradename`  varchar(30)  NOT NULL,
  `stockcode` char(12) NOT NULL,
  `tradecount` int(11)  NOT NULL,
  `tradeamount` DECIMAL(10,2) UNSIGNED NOT NULL,
  `tradeprice` DECIMAL(10,2) UNSIGNED NOT NULL,
  `amountze` DECIMAL(10,2) UNSIGNED NOT NULL,
  `fsze` DECIMAL(10,2) UNSIGNED NOT NULL,
  `jyj` DECIMAL(10,2) UNSIGNED NOT NULL,
  `yhs` DECIMAL(10,2) UNSIGNED NOT NULL,
  `ghf` DECIMAL(10,2) UNSIGNED NOT NULL,
  `jygf` DECIMAL(10,2) UNSIGNED NOT NULL,
  `tradetype` char(2) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;


$sql04 = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_lookstock;
CREATE TABLE IF NOT EXISTS `cdb_wirror_lookstock` (
  `uid` bigint(11) unsigned NOT NULL,
  `count` int(11)  NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM;
EOF;

$sql05 = <<<EOF
DROP TABLE IF EXISTS cdb_wirror_stockph;
CREATE TABLE IF NOT EXISTS `cdb_wirror_stockph` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` bigint(11) unsigned NOT NULL,
  `username`  varchar(20)  NOT NULL,
  `sslstr`  DECIMAL(10,2) UNSIGNED NOT NULL,
  `cw`  DECIMAL(10,2) UNSIGNED NOT NULL,
  `zssl`  DECIMAL(10,2) UNSIGNED NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL, 
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;

runquery($sql);
runquery($sql01);
runquery($sql02);
runquery($sql03);
runquery($sql04);
runquery($sql05);
$finish = TRUE;
?>