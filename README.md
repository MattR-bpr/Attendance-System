# Attendance System
Školský projekt k firme Webkári s.r.o.

## Inštalácia
Na spojazdnenie budete potrebovať webový server, ktorý podporuje php (napríklad Apache) a taktiež databázový server, ktorý podporuje MariaDB.
Skopírujte priečinok `attendance-system` do priečinku s web stránkami na vašom webovom serveri.
Spustite tento sql príkaz vo vašom databázovom klientovi, ktorý vytvorí potrebné tabuľky a dáta:
```sql
CREATE DATABASE `attendance_system`;
USE `attendance_system`;

CREATE TABLE `chip_types` (
  `id` char(1) NOT NULL,
  `value` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `chip_types` (`id`, `value`) VALUES
	('A', 'príchod'),
	('B', 'prestávka'),
	('D', 'odchod'),
	('L', 'obed');

CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `employees` (`id`, `full_name`) VALUES
	(1, 'Tester Testovač');

CREATE TABLE `operations` (
  `operaion_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `operation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `operation_type_id` char(1) NOT NULL,
  PRIMARY KEY (`operaion_id`),
  KEY `employee_id` (`employee_id`),
  KEY `operaion_type_id` (`operation_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `operation_types` (
  `id` char(1) NOT NULL,
  `value` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `operation_types` (`id`, `value`) VALUES
	('T', 'Test');

CREATE TABLE `records` (
  `record_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `chip_time` datetime NOT NULL DEFAULT current_timestamp(),
  `chip_type_id` char(1) NOT NULL,
  PRIMARY KEY (`record_id`) USING BTREE,
  KEY `employee_id` (`employee_id`),
  KEY `chip_type_id` (`chip_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
```

## Náhľad
![preview](https://user-images.githubusercontent.com/54020396/161595651-64e72b8a-1080-4c11-a96c-895d8c8d44f7.png)

## Poznámky
Ak máte problém pripojiť sa k Vašej lokálnej databáze, tak skontrolujte prihlasovacie údaje [tu](https://github.com/MattR-bpr/Attendance-System/blob/main/attendance-system/api/db.php#L9).
