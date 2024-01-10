CREATE TABLE `user` (
    `user_id` INT NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(250) NOT NULL ,
    `email` VARCHAR(250) NOT NULL ,
    `password` VARCHAR(250) NOT NULL ,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;
ALTER TABLE `user` ADD `role` INT(11) NOT NULL AFTER `password`; 
CREATE TABLE `blog` (
    `blog_id` INT(11) NOT NULL AUTO_INCREMENT ,
    `blog_title` VARCHAR(255) NOT NULL ,
    `blog_body` VARCHAR(255) NOT NULL ,
    `blog_image` VARCHAR(250) NOT NULL ,
    `category` INT(11) NOT NULL ,
    `author_id` INT(11 ) NOT NULL ,
    `publish_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`blog_id`)
) ENGINE = InnoDB;
ALTER TABLE `blog` CHANGE `blog_body` `blog_body` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL; 

CREATE TABLE `categories` (
    `cat_id` INT NOT NULL AUTO_INCREMENT ,
    `cat_name` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`cat_id`)
) ENGINE = InnoDB;