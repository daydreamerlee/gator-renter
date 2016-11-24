ALTER TABLE `apartments` 
ADD COLUMN `owner_user_id` INT(11) NOT NULL AFTER `flagged`,
ADD INDEX `fk_apartments_1_idx` (`owner_user_id` ASC);

ALTER TABLE `user_roles` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL ;

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` INT(11) NOT NULL,
  `from_user_id` INT(11) NOT NULL,
  `to_user_id` INT(11) NOT NULL,
  `apartment_id` INT(11) NOT NULL,
  `message` VARCHAR(1000) NOT NULL,
  `created` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_messages_1_idx` (`from_user_id` ASC),
  INDEX `fk_user_messages_2_idx` (`to_user_id` ASC),
  INDEX `fk_user_messages_3_idx` (`apartment_id` ASC),
  CONSTRAINT `fk_user_messages_1`
    FOREIGN KEY (`from_user_id`)
    REFERENCES `users` (`uid`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_messages_2`
    FOREIGN KEY (`to_user_id`)
    REFERENCES `users` (`uid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_messages_3`
    FOREIGN KEY (`apartment_id`)
    REFERENCES `apartments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `apartments` 
ADD CONSTRAINT `fk_apartments_1`
  FOREIGN KEY (`owner_user_id`)
  REFERENCES `users` (`uid`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


USE 
DROP procedure IF EXISTS `updateUserDetail`;

USE 
DROP procedure IF EXISTS `getUserDetail`;
