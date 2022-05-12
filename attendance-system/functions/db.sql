CREATE DATABASE `attendance_system`;
USE `attendance_system`;

CREATE TABLE `chip_records` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `employee` int(10) unsigned NOT NULL,
    `time` datetime NOT NULL DEFAULT current_timestamp(),
    `chip_type` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    KEY `employee_id` (`employee`) USING BTREE,
    KEY `chip_type_id` (`chip_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `chip_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `value` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO `chip_types` (`id`, `value`) VALUES
    (1, 'príchod do práce'),
    (2, 'odchod z práce'),
    (3, 'začiatok prestávky'),
    (4, 'koniec prestávky'),
    (5, 'začiatok obeda'),
    (6, 'koniec obeda');

CREATE TABLE `employees` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `full_name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `employees` (`id`, `full_name`) VALUES
    (1, 'Tester Testovač');

CREATE TABLE `operation_records` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `employee` int(10) unsigned NOT NULL,
    `time` datetime NOT NULL DEFAULT current_timestamp(),
    `operation_type` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    KEY `employee_id` (`employee`) USING BTREE,
    KEY `operaion_type_id` (`operation_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `operation_types` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `value` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `operation_types` (`id`, `value`) VALUES
    (1, 'začiatok sústruženia'),
    (2, 'koniec sústruženia'),
    (3, 'začiatok frézovania'),
    (4, 'koniec frézovania');