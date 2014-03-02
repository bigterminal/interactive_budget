CREATE DATABASE IF NOT EXISTS `interactivebudget`;

CREATE TABLE IF NOT EXISTS `interactivebudget`.`budget_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `interactivebudget`.`budgets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_2012` FLOAT NOT NULL,
  `total_2013` FLOAT NOT NULL,
  `total_2014` FLOAT NOT NULL,
  `delta_p_2014_2012` FLOAT,
  `delta_v_2014_2012` FLOAT NOT NULL,
  `delta_p_2014_2013` FLOAT,
  `delta_v_2014_2013` FLOAT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `budget_categories`(`id`)
) ENGINE = INNODB;