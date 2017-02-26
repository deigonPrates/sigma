-- MySQL Script generated by MySQL Workbench
-- 02/25/17 18:21:10
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema emcac
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema emcac
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `emcac` DEFAULT CHARACTER SET utf8 ;
USE `emcac` ;

-- -----------------------------------------------------
-- Table `emcac`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL DEFAULT 'NADA CONSTA',
  `username` VARCHAR(100) NOT NULL,
  `password` CHAR(128) NOT NULL,
  `salt` CHAR(128) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 1,
  `registration` VARCHAR(45) NOT NULL,
  `birth` DATE NOT NULL,
  `sex` VARCHAR(12) NOT NULL,
  `phone` VARCHAR(16) NOT NULL DEFAULT 'NADA CONSTA',
  `address` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `users_role_id_idx` (`role_id` ASC),
  CONSTRAINT `users_role_id`
    FOREIGN KEY (`role_id`)
    REFERENCES `emcac`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`login_attempts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`login_attempts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `login_attempts_user_id_idx` (`user_id` ASC),
  CONSTRAINT `login_attempts_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `emcac`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`recoveries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`recoveries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `passwors_user_id_idx` (`user_id` ASC),
  CONSTRAINT `passwors_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `emcac`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`classes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`classes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `ano` YEAR NOT NULL,
  `teacher` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`classes_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`classes_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `classes_id` INT NOT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`, `classes_id`, `users_id`),
  INDEX `fk_classes_has_users_users1_idx` (`users_id` ASC),
  INDEX `fk_classes_has_users_classes1_idx` (`classes_id` ASC),
  CONSTRAINT `fk_classes_has_users_classes1`
    FOREIGN KEY (`classes_id`)
    REFERENCES `emcac`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_classes_has_users_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `emcac`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`activities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`activities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `subject` VARCHAR(45) NOT NULL,
  `value` FLOAT NOT NULL,
  `date` DATE NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 1,
  `classes_id` INT NOT NULL,
  PRIMARY KEY (`id`, `classes_id`),
  INDEX `fk_activities_classes1_idx` (`classes_id` ASC),
  CONSTRAINT `fk_activities_classes1`
    FOREIGN KEY (`classes_id`)
    REFERENCES `emcac`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`questions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `activities_id` INT NOT NULL,
  `number` INT NOT NULL,
  `query` VARCHAR(250) NOT NULL,
  `alternative_a` VARCHAR(250) NOT NULL,
  `alternative_b` VARCHAR(250) NOT NULL,
  `alternative_c` VARCHAR(250) NOT NULL,
  `alternative_d` VARCHAR(250) NOT NULL,
  `alternative_e` VARCHAR(250) NOT NULL,
  `answer` CHAR(1) NOT NULL,
  `value` FLOAT NOT NULL,
  PRIMARY KEY (`id`, `activities_id`),
  INDEX `fk_questions_activities1_idx` (`activities_id` ASC),
  CONSTRAINT `fk_questions_activities1`
    FOREIGN KEY (`activities_id`)
    REFERENCES `emcac`.`activities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emcac`.`answers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emcac`.`answers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `alternative` CHAR(1) NOT NULL,
  PRIMARY KEY (`id`, `question_id`, `user_id`),
  INDEX `answers_user_id_idx` (`user_id` ASC),
  INDEX `answers_question_id_idx` (`question_id` ASC),
  CONSTRAINT `answers_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `emcac`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `answers_question_id`
    FOREIGN KEY (`question_id`)
    REFERENCES `emcac`.`questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
