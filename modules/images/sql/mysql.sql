CREATE TABLE `images_images` (
  `id` mediumint(15) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(16) NOT NULL DEFAULT '',
  `field` varchar(64) NOT NULL DEFAULT '',
  `type` enum('jpg','png','gif','ascii-small','ascii-medium','ascii-large','unknown') NOT NULL DEFAULT 'unknown',
  `storage` enum('files','database') NOT NULL DEFAULT 'files',
  `md5` varchar(32) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `bytes` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `updates` int(11) NOT NULL DEFAULT '0',
  `errors` int(11) NOT NULL DEFAULT '0',
  `megabytes` float(26,12) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `checked` int(11) NOT NULL DEFAULT '0',
  `errored` int(11) NOT NULL DEFAULT '0',
  `emailed` int(11) NOT NULL DEFAULT '0',
  `data` LONGTEXT,
  PRIMARY KEY (`id`),
  KEY `SEARCH` (`hash`,`uid`,`field`,`md5`,`checked`,`url`,`emailed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `images_fields` (
  `id` mediumint(15) NOT NULL AUTO_INCREMENT,
  `hash` varchar(16) NOT NULL DEFAULT '',
  `field` varchar(64) NOT NULL DEFAULT '',
  `typal` enum('icons','logo','photo','avatar','unknown') NOT NULL DEFAULT 'unknown',
  `views` int(11) NOT NULL DEFAULT '0',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `images` int(11) NOT NULL DEFAULT '0',
  `errors` int(11) NOT NULL DEFAULT '0',
  `megabytes` float(26,12) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `errored` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `SEARCH` (`hash`,`field`,`typal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `images_errors` (
  `id` mediumint(15) NOT NULL AUTO_INCREMENT,
  `type` enum('system','module','user','unknown') NOT NULL DEFAULT 'unknown',
  `uid` int(11) NOT NULL DEFAULT '0',
  `imageid` mediumint(15) NOT NULL DEFAULT '0',
  `fieldid` mediumint(15) NOT NULL DEFAULT '0',
  `code` varchar(64) NOT NULL DEFAULT '',
  `when` int(11) NOT NULL DEFAULT '0',
  `message` varchar(255),
  `emailed` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `SEARCH` (`type`,`uid`,`imageid`,`fieldid`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;