CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `title` varchar(250) DEFAULT '',
  `description` text,
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
