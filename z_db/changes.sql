-- 28.04.14
ALTER TABLE `comment` ADD `com_pid` INT NOT NULL AFTER `com_id` ,
ADD INDEX ( `com_pid` );

ALTER TABLE `likes` CHANGE `l_key_obj` `l_key_obj` BIGINT NOT NULL;
ALTER TABLE `comment` CHANGE `com_pid` `com_pid` BIGINT NOT NULL;