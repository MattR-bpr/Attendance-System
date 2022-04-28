# Attendance System
Školský projekt k firme Webkári s.r.o.

## Inštalácia
Na spojazdnenie budete potrebovať webový server, ktorý podporuje php (napríklad Apache) a taktiež databázový server, ktorý podporuje MariaDB.
Skopírujte priečinok `attendance-system` do priečinku s web stránkami na vašom webovom serveri.
Spustite tento sql príkaz vo vašom databázovom klientovi, ktorý vytvorí potrebné tabuľky a dáta:
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `operation_types` (`id`, `value`) VALUES
	(1, 'sústruženie'),
	(2, 'frézovanie');
```

## Náhľad
![preview](https://user-images.githubusercontent.com/54020396/165819695-1421b1a3-32d6-468e-81a6-a2bc261e9fcd.png)

## Poznámky
Ak máte problém pripojiť sa k Vašej lokálnej databáze, tak skontrolujte prihlasovacie údaje [tu](https://github.com/MattR-bpr/Attendance-System/blob/main/attendance-system/api/db.php#L9).
