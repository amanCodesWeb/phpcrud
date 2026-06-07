-- =====================================================
-- Database setup — Import this file to create the DB + table + sample data
-- =====================================================
-- Usage:
--   mysql -u root -p < sql/database.sql
--   Or import via phpMyAdmin

CREATE DATABASE IF NOT EXISTS `phpcrud_demo`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `phpcrud_demo`;

-- Table: crud — stores name and email with auto-increment ID
CREATE TABLE IF NOT EXISTS `crud` (
    `sno`   INT(11)      NOT NULL AUTO_INCREMENT,
    `name`  VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
INSERT INTO `crud` (`name`, `email`) VALUES
    ('John Doe',     'john@example.com'),
    ('Jane Smith',   'jane@example.com'),
    ('Alice Johnson','alice@example.com');
