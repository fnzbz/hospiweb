-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2018 at 05:35 PM
-- Server version: 5.6.39-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `novacdan_hospiweb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`novacdan`@`localhost` PROCEDURE `deleteChart` ()  NO SQL
DELETE FROM heartbeat_chart$$

CREATE DEFINER=`novacdan`@`localhost` PROCEDURE `deleteRowsEmail` ()  NO SQL
DELETE FROM email_confirm WHERE dTimestamp <= UNIX_TIMESTAMP()$$

CREATE DEFINER=`novacdan`@`localhost` PROCEDURE `deleteRowsReq` ()  NO SQL
DELETE FROM password_reset_req WHERE expireTimestamp <= UNIX_TIMESTAMP()$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `aditional_medic`
--

CREATE TABLE `aditional_medic` (
  `accountID` int(11) NOT NULL,
  `spital` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `limbasec` tinyint(2) NOT NULL,
  `specializare` varchar(255) COLLATE utf8_romanian_ci NOT NULL DEFAULT 'Nespecificat',
  `program` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `cabinet` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `pret` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `reqStatus` tinyint(1) NOT NULL DEFAULT '1',
  `lastModified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


--
-- Table structure for table `aditional_pacient`
--

CREATE TABLE `aditional_pacient` (
  `accountID` int(11) NOT NULL,
  `limbasec` tinyint(2) NOT NULL,
  `greutate` int(3) NOT NULL,
  `inaltime` int(3) NOT NULL,
  `vaccinuri` tinyint(2) NOT NULL,
  `oredormit` tinyint(2) NOT NULL,
  `dependenta` tinyint(2) NOT NULL,
  `exfizice` tinyint(2) NOT NULL,
  `domiciliu` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `alergii` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `intoleranta` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `lastModified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `consultatii_pacient`
--

CREATE TABLE `consultatii_pacient` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `medicName` varchar(64) COLLATE utf8_romanian_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mention` text COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `diagnostic_pacient`
--

CREATE TABLE `diagnostic_pacient` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `text` varchar(512) COLLATE utf8_romanian_ci NOT NULL,
  `medic` varchar(64) COLLATE utf8_romanian_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `email_confirm`
--

CREATE TABLE `email_confirm` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_romanian_ci DEFAULT '',
  `code` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `cTimestamp` int(11) NOT NULL,
  `dTimestamp` int(11) NOT NULL,
  `timesValidated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heartbeat_chart`
--

CREATE TABLE `heartbeat_chart` (
  `keyID` int(11) NOT NULL,
  `accountCNP` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `sistola` int(11) NOT NULL,
  `diastola` int(11) NOT NULL,
  `pulse` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `medicperm`
--

CREATE TABLE `medicperm` (
  `id` int(11) NOT NULL,
  `pacientID` int(11) NOT NULL,
  `namePacient` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `medicID` int(11) NOT NULL,
  `isAcc` tinyint(1) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_req`
--

CREATE TABLE `password_reset_req` (
  `ID` int(11) NOT NULL,
  `CNP` varchar(16) COLLATE utf8_romanian_ci NOT NULL,
  `email` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
  `code` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
  `createTimestamp` int(11) DEFAULT NULL,
  `expireTimestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `simptome_pacient`
--

CREATE TABLE `simptome_pacient` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `text` text COLLATE utf8_romanian_ci NOT NULL,
  `medic` varchar(64) COLLATE utf8_romanian_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `numeCreator` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `subiect` varchar(128) COLLATE utf8_romanian_ci NOT NULL,
  `departament` tinyint(1) NOT NULL,
  `urgenta` tinyint(1) NOT NULL,
  `text` varchar(500) COLLATE utf8_romanian_ci NOT NULL,
  `data` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;



-- --------------------------------------------------------

--
-- Table structure for table `tickets_comments`
--

CREATE TABLE `tickets_comments` (
  `id` int(11) NOT NULL,
  `ticketID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `nameCreator` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `date` int(11) NOT NULL,
  `text` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
  `medicComment` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `transplanturi_pacient`
--

CREATE TABLE `transplanturi_pacient` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `medicName` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `mention` text COLLATE utf8_romanian_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tratament_pacient`
--

CREATE TABLE `tratament_pacient` (
  `id` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `medicName` varchar(64) COLLATE utf8_romanian_ci NOT NULL,
  `treatment` text COLLATE utf8_romanian_ci NOT NULL,
  `startDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `CNP` varchar(16) COLLATE utf8_romanian_ci NOT NULL COMMENT 'SAALLZZCJXXXC',
  `utilizator` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_romanian_ci NOT NULL,
  `telefon` varchar(16) COLLATE utf8_romanian_ci NOT NULL,
  `sex` int(1) NOT NULL COMMENT '1=M 2=F 3=/',
  `sange` int(1) NOT NULL COMMENT '1=0 2=A 3=B 4=AB',
  `stare` int(11) NOT NULL DEFAULT '1' COMMENT '1=Sanatos 2=Bolnav 3=Grav',
  `nascut` int(11) NOT NULL,
  `judet` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `isMedic` tinyint(1) NOT NULL DEFAULT '0',
  `confirmedEmail` tinyint(1) NOT NULL DEFAULT '0',
  `lastLogin` int(11) NOT NULL DEFAULT '0',
  `isMod` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aditional_medic`
--
ALTER TABLE `aditional_medic`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `aditional_pacient`
--
ALTER TABLE `aditional_pacient`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `consultatii_pacient`
--
ALTER TABLE `consultatii_pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id_consultatii_pacient` (`accountID`);

--
-- Indexes for table `diagnostic_pacient`
--
ALTER TABLE `diagnostic_pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id_diagnostic` (`accountID`);

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_change_FK_Utilizatori` (`accountID`);

--
-- Indexes for table `heartbeat_chart`
--
ALTER TABLE `heartbeat_chart`
  ADD PRIMARY KEY (`keyID`),
  ADD KEY `acc_cnp_heartbeat` (`accountCNP`);

--
-- Indexes for table `medicperm`
--
ALTER TABLE `medicperm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pacientID` (`pacientID`),
  ADD KEY `medicID` (`medicID`);

--
-- Indexes for table `password_reset_req`
--
ALTER TABLE `password_reset_req`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `acc_cnp_reset_req` (`CNP`);

--
-- Indexes for table `simptome_pacient`
--
ALTER TABLE `simptome_pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id_simptome_pacient` (`accountID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `tickets_comments`
--
ALTER TABLE `tickets_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticketID` (`ticketID`),
  ADD KEY `accout_fk_comticket` (`accountID`);

--
-- Indexes for table `transplanturi_pacient`
--
ALTER TABLE `transplanturi_pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id_transplanturi_pacient` (`accountID`),
  ADD KEY `medic_name_transplanturi_pacient` (`medicName`);

--
-- Indexes for table `tratament_pacient`
--
ALTER TABLE `tratament_pacient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acc_id_tratament_pacient` (`accountID`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `CNP` (`CNP`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultatii_pacient`
--
ALTER TABLE `consultatii_pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `diagnostic_pacient`
--
ALTER TABLE `diagnostic_pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `heartbeat_chart`
--
ALTER TABLE `heartbeat_chart`
  MODIFY `keyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `medicperm`
--
ALTER TABLE `medicperm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `password_reset_req`
--
ALTER TABLE `password_reset_req`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `simptome_pacient`
--
ALTER TABLE `simptome_pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tickets_comments`
--
ALTER TABLE `tickets_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `transplanturi_pacient`
--
ALTER TABLE `transplanturi_pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tratament_pacient`
--
ALTER TABLE `tratament_pacient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aditional_medic`
--
ALTER TABLE `aditional_medic`
  ADD CONSTRAINT `acc_id_aditional_medic` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `aditional_pacient`
--
ALTER TABLE `aditional_pacient`
  ADD CONSTRAINT `acc_id_aditional_pacient` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `consultatii_pacient`
--
ALTER TABLE `consultatii_pacient`
  ADD CONSTRAINT `acc_id_consultatii_pacient` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diagnostic_pacient`
--
ALTER TABLE `diagnostic_pacient`
  ADD CONSTRAINT `acc_id_diagnostic` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD CONSTRAINT `email_change_FK_Utilizatori` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `heartbeat_chart`
--
ALTER TABLE `heartbeat_chart`
  ADD CONSTRAINT `acc_cnp_heartbeat` FOREIGN KEY (`accountCNP`) REFERENCES `utilizatori` (`CNP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicperm`
--
ALTER TABLE `medicperm`
  ADD CONSTRAINT `medic_relation` FOREIGN KEY (`medicID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pacient_relation` FOREIGN KEY (`pacientID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_reset_req`
--
ALTER TABLE `password_reset_req`
  ADD CONSTRAINT `acc_cnp_reset_req` FOREIGN KEY (`CNP`) REFERENCES `utilizatori` (`CNP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simptome_pacient`
--
ALTER TABLE `simptome_pacient`
  ADD CONSTRAINT `acc_id_simptome_pacient` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `ticket_fk_users` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets_comments`
--
ALTER TABLE `tickets_comments`
  ADD CONSTRAINT `accout_fk_comticket` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comticket_fk_tickets` FOREIGN KEY (`ticketID`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transplanturi_pacient`
--
ALTER TABLE `transplanturi_pacient`
  ADD CONSTRAINT `acc_id_transplanturi_pacient` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tratament_pacient`
--
ALTER TABLE `tratament_pacient`
  ADD CONSTRAINT `acc_id_tratament_pacient` FOREIGN KEY (`accountID`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`novacdan`@`localhost` EVENT `deleteOldReq` ON SCHEDULE EVERY 1 SECOND STARTS '2018-05-12 23:32:31' ON COMPLETION PRESERVE ENABLE DO CALL deleteRowsReq()$$

CREATE DEFINER=`novacdan`@`localhost` EVENT `deleteChartHeartBeat` ON SCHEDULE EVERY '0-1' YEAR_MONTH STARTS '2018-05-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL deleteChart()$$

CREATE DEFINER=`novacdan`@`localhost` EVENT `deleteOldReqEmail` ON SCHEDULE EVERY 1 SECOND STARTS '2018-07-04 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL deleteRowsEmail()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
