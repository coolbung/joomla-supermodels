DROP TABLE IF EXISTS `#__jticketing_events`;

CREATE TABLE `#__jticketing_events` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(25) NOT NULL,
	`state` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
)
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
