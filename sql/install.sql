CREATE TABLE IF NOT EXISTS `DB_PREFIXscheduledpublication` (
`id_scheduledpublication` int(10) unsigned NOT NULL AUTO_INCREMENT,
`object` varchar(255) NOT NULL,
`id_object` int(11) NOT NULL,
`due_date` DATETIME NOT NULL,
`status` int(1) NOT NULL DEFAULT 1,
`date_add` DATETIME DEFAULT now(),
`date_upd` DATETIME NOT NULL,
PRIMARY KEY (`id_scheduledpublication`)
) ENGINE = MYSQL_ENGINE DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci
