# Attendance System
Školský projekt k firme Webkári s.r.o.

## Inštalácia
Na spojadznenie budete potrebovať webový server, ktorý podporuje php (napríklad Apache) a taktiež databázový server, ktorý podporuje MariaDB.
Skopírujte priečinok `attendance-system` do priečinku s web stránkami na vašom serveri.
Spustite tento sql príkaz vo vašom databázovom klientovi, ktorý vytvorí potrebné tabuľky a dáta:
```sql
CREATE DATABASE IF NOT EXISTS `school`;
USE `school`;

CREATE TABLE IF NOT EXISTS `attendance_system` (
  `record_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) unsigned NOT NULL,
  `chip_time` datetime NOT NULL DEFAULT current_timestamp(),
  `chip_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`record_id`) USING BTREE,
  KEY `employee_id` (`employee_id`),
  KEY `chip_type_id` (`chip_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `chip_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

REPLACE INTO `chip_types` (`id`, `value`) VALUES
	(1, 'arrival'),
	(2, 'departure'),
	(3, 'lunch'),
	(4, 'break');

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

REPLACE INTO `employees` (`id`, `full_name`) VALUES
	(1, 'Matúš Rosa');
```
