-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema shop_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema shop_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `shop_db` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema shop_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema shop_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `shop_db` DEFAULT CHARACTER SET utf8 ;
USE `shop_db` ;

-- -----------------------------------------------------
-- Table `shop_db`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  `price` INT(6) NOT NULL DEFAULT '0',
  `in_stock` INT(6) NOT NULL DEFAULT '0',
  `slug` VARCHAR(45) NOT NULL,
  `preview` VARCHAR(45) NOT NULL,
  `original` VARCHAR(45) NOT NULL,
  `create_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promo` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shop_db`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`product_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`product_category` (
  `id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_product_category_1_idx` (`product_id` ASC),
  CONSTRAINT `fk_product_category_1`
    FOREIGN KEY (`product_id`)
    REFERENCES `shop_db`.`products` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_product_category_2`
    FOREIGN KEY (`category_id`)
    REFERENCES `shop_db`.`categories` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

USE `shop_db` ;

-- -----------------------------------------------------
-- Table `shop_db`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `role` VARCHAR(10) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shop_db`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `total` INT(45) NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `processed` TINYINT(1) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orders_1_idx` (`user_id` ASC),
  CONSTRAINT `fk_orders_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `shop_db`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shop_db`.`products_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shop_db`.`products_orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `orders_id` INT(11) NOT NULL,
  `products_id` INT(11) NOT NULL,
  `qt` INT(11) NOT NULL,
  `total` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `orders_id` (`orders_id` ASC),
  INDEX `plants_id` (`products_id` ASC),
  CONSTRAINT `products_orders_ibfk_1`
    FOREIGN KEY (`orders_id`)
    REFERENCES `shop_db`.`orders` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `products_orders_ibfk_2`
    FOREIGN KEY (`products_id`)
    REFERENCES `shop_db`.`products` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
