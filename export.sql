-- Adminer 4.8.1 MySQL 5.5.5-10.9.2-MariaDB-1:10.9.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titel` varchar(255) NOT NULL,
  `Beschreibung` varchar(510) DEFAULT NULL,
  `Bild` mediumblob DEFAULT NULL,
  `Kategorie` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_kategorie` (`Kategorie`),
  CONSTRAINT `FK_kategorie` FOREIGN KEY (`Kategorie`) REFERENCES `kategorie` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `content` (`ID`, `Titel`, `Beschreibung`, `Bild`, `Kategorie`) VALUES
(1,	'John Wick',	NULL,	NULL,	2),
(2,	'John Wick 2',	NULL,	NULL,	2),
(3,	'John Wick 3',	NULL,	NULL,	2),
(4,	'Hunter X Hunter',	NULL,	NULL,	3),
(5,	'Breaking Bad',	NULL,	NULL,	3);

DROP TABLE IF EXISTS `folgeliste`;
CREATE TABLE `folgeliste` (
  `folger` int(11) NOT NULL,
  `gefolgt` int(11) NOT NULL,
  PRIMARY KEY (`folger`,`gefolgt`),
  KEY `gefolgt` (`gefolgt`),
  KEY `folger` (`folger`),
  CONSTRAINT `folgeliste_ibfk_3` FOREIGN KEY (`folger`) REFERENCES `user` (`ID`),
  CONSTRAINT `gefolgtfk` FOREIGN KEY (`gefolgt`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE `kategorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Kategoriebezeichnung` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `kategorie` (`ID`, `Kategoriebezeichnung`) VALUES
(1,	'Videospiel'),
(2,	'Film'),
(3,	'Serie'),
(4,	'Buch'),
(5,	'Musik');

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `User` int(11) NOT NULL,
  `Content` int(11) NOT NULL,
  `Inhalt` text NOT NULL,
  `Bewertung` decimal(3,1) NOT NULL,
  `Timestamp` datetime NOT NULL,
  PRIMARY KEY (`User`,`Content`),
  KEY `Content` (`Content`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Content`) REFERENCES `content` (`ID`),
  CONSTRAINT `review_ibfk_3` FOREIGN KEY (`User`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `review` (`User`, `Content`, `Inhalt`, `Bewertung`, `Timestamp`) VALUES
(1000,	1,	'Tolle Sache',	5.0,	'2019-03-10 02:55:05'),
(1000,	3,	'Schwach',	2.0,	'2019-03-10 02:55:05'),
(1001,	3,	'Richtig toll',	6.0,	'2019-03-10 02:58:05'),
(1000,	5,	'Klasse',	9.0,	'2019-03-10 02:55:05');

DROP TABLE IF EXISTS `rolle`;
CREATE TABLE `rolle` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Rollenbezeichnung` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rolle` (`ID`, `Rollenbezeichnung`) VALUES
(1,	'Moderator'),
(2,	'User');

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Statusbezeichnung` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(30) NOT NULL,
  `PassHash` varchar(255) NOT NULL,
  `Beschreibung` varchar(512) DEFAULT NULL,
  `Bild` mediumblob DEFAULT NULL,
  `Rolle` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `rollefk` (`Rolle`),
  CONSTRAINT `rollefk` FOREIGN KEY (`Rolle`) REFERENCES `rolle` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`ID`, `Username`, `PassHash`, `Bild`, `Rolle`) VALUES
(1000,	'tester',	'$2y$10$qZQ3luz0Wm6AQu94Jet.QOedYkwzAkACm1lfWdYOg5RdbXMlvA4Dm',	NULL,	2),
(1001,	'tester2',	'$2y$10$qZQ3luz0Wm6AQu94Jet.QOedYkwzAkACm1lfWdYOg5RdbXMlvA4Dm',	NULL,	2);

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE `watchlist` (
  `User` int(11) NOT NULL,
  `Content` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  PRIMARY KEY (`User`,`Content`),
  KEY `contentfk` (`Content`),
  KEY `usefk` (`User`),
  KEY `statusfk` (`Status`),
  CONSTRAINT `contentfk` FOREIGN KEY (`Content`) REFERENCES `content` (`ID`),
  CONSTRAINT `statusfk` FOREIGN KEY (`Status`) REFERENCES `status` (`ID`),
  CONSTRAINT `usefk` FOREIGN KEY (`User`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2022-09-11 15:08:26
