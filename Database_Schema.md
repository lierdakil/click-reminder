# ER Diagram #
![http://click-reminder.googlecode.com/svn/wiki/images/schema.png](http://click-reminder.googlecode.com/svn/wiki/images/schema.png)

# SQL Script #
```
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `click-reminder` DEFAULT CHARACTER SET utf8 
;
USE `click-reminder` ;

-- -----------------------------------------------------
-- Table `click-reminder`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `click-reminder`.`users` ;

CREATE  TABLE IF NOT EXISTS `click-reminder`.`users` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `password_md5` VARCHAR(32) NULL ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `click-reminder`.`items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `click-reminder`.`items` ;

CREATE  TABLE IF NOT EXISTS `click-reminder`.`items` (
  `item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` INT UNSIGNED NOT NULL ,
  `timestamp` DOUBLE UNSIGNED NOT NULL ,
  `sort_int` INT UNSIGNED NULL ,
  PRIMARY KEY (`item_id`) ,
  INDEX `user_id_INDEX` (`user_id` ASC) ,
  CONSTRAINT `fk_items_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `click-reminder`.`users` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `click-reminder`.`item_props`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `click-reminder`.`item_props` ;

CREATE  TABLE IF NOT EXISTS `click-reminder`.`item_props` (
  `prop_name` VARCHAR(45) NULL ,
  `prop_value` VARCHAR(45) NULL ,
  `item_id` INT UNSIGNED NOT NULL ,
  UNIQUE INDEX `main` (`item_id` ASC, `prop_name` ASC) ,
  INDEX `item_id_INDEX` (`item_id` ASC) ,
  INDEX `prop_name_INDEX` (`prop_name` ASC) ,
  CONSTRAINT `fk_item_props_items1`
    FOREIGN KEY (`item_id` )
    REFERENCES `click-reminder`.`items` (`item_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `click-reminder`.`sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `click-reminder`.`sessions` ;

CREATE  TABLE IF NOT EXISTS `click-reminder`.`sessions` (
  `session_id` VARCHAR(45) NOT NULL ,
  `user_id` INT UNSIGNED NOT NULL ,
  `last_activity` DATETIME NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `user_id_INDEX` (`user_id` ASC) ,
  CONSTRAINT `fk_sessions_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `click-reminder`.`users` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `click-reminder`.`log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `click-reminder`.`log` ;

CREATE  TABLE IF NOT EXISTS `click-reminder`.`log` (
  `log_id` INT UNSIGNED NOT NULL ,
  `user_id` INT UNSIGNED NULL ,
  `item_id` INT UNSIGNED NULL ,
  `log_date` DATETIME NOT NULL ,
  `log_message` TEXT NOT NULL ,
  PRIMARY KEY (`log_id`) ,
  INDEX `log_date_INDEX` (`log_date` ASC) ,
  INDEX `user_id_INDEX` (`user_id` ASC) ,
  INDEX `item_id_INDEX` (`item_id` ASC) ,
  CONSTRAINT `fk_log_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `click-reminder`.`users` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_log_items1`
    FOREIGN KEY (`item_id` )
    REFERENCES `click-reminder`.`items` (`item_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
```