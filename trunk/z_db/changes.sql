-- 28.04.14

ALTER TABLE `comment` ADD `com_pid` INT NOT NULL AFTER `com_id` ,
ADD INDEX ( `com_pid` )

