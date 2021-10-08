-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2021 at 09:11 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_collection_of_customer` (IN `CUS_ID` INT)  BEGIN
  SELECT * FROM collection_master,plan_master WHERE collection_master.COL_TB_CUS_PL=plan_master.PL_ID
  AND collection_master.COL_FOR_CUS_ID=CUS_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `super_collection_list` ()  BEGIN 
   SELECT * FROM customer_master,plan_master,collection_master WHERE 
   collection_master.COL_FOR_CUS_ID=customer_master.CUS_ID
   AND collection_master.COL_TB_CUS_PL=plan_master.PL_ID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `ADMIN_ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `STATUS` tinyint(4) NOT NULL DEFAULT 1,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`ADMIN_ID`, `USERNAME`, `PHONE_NUMBER`, `PASSWORD`, `STATUS`, `CREATED_AT`) VALUES
(1, 'saravanasai', '7708454539', '0e4e946668cf2afc4299b462b812caca', 1, '2021-08-12 08:03:48'),
(3, 'RAM', '9025807876', '0e4e946668cf2afc4299b462b812caca', 1, '2021-08-25 05:02:30'),
(4, 'others', '545454545', '5252', 1, '2021-09-23 09:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `agent_master`
--

CREATE TABLE `agent_master` (
  `AGENT_ID` int(11) NOT NULL,
  `AGENT_NAME` varchar(50) DEFAULT NULL,
  `AGENT_PH_NO` varchar(25) DEFAULT NULL,
  `AGENT_LOCATION` int(11) DEFAULT NULL,
  `AGENT_DL_STATUS` int(11) DEFAULT 1,
  `AGENT_CREATED_AT` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agent_master`
--

INSERT INTO `agent_master` (`AGENT_ID`, `AGENT_NAME`, `AGENT_PH_NO`, `AGENT_LOCATION`, `AGENT_DL_STATUS`, `AGENT_CREATED_AT`) VALUES
(1, 'podu', '7708454539', 1, 1, '2021-08-24'),
(2, 'podu', '7708454539', 1, 0, '2021-08-24');

-- --------------------------------------------------------

--
-- Table structure for table `collection_master`
--

CREATE TABLE `collection_master` (
  `COL_ID` int(11) NOT NULL,
  `COL_FOR_CUS_ID` int(11) DEFAULT NULL,
  `COL_TB_CUS_PL` int(11) DEFAULT NULL,
  `CL_FOR_MONTH_1` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_2` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_3` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_4` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_5` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_6` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_7` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_8` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_9` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_10` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_11` varchar(10) DEFAULT '0',
  `CL_FOR_MONTH_12` varchar(10) DEFAULT '0',
  `CL_BALANCE_DUE_MONTH` varchar(10) DEFAULT '11',
  `CL_STATUS` bit(1) DEFAULT b'1' COMMENT '1 IS FOR COLLECTION IS ACTIVE 0 IS FOR COLLECTION CLOSED',
  `CL_LAST_PAID_TO` int(11) DEFAULT 0 COMMENT 'IT ONLY SHOWS THE LAST COLLECTION DONE BY ADMIN STATUS DEFAULT IS 0',
  `CL_CREATED_AT` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collection_master`
--

INSERT INTO `collection_master` (`COL_ID`, `COL_FOR_CUS_ID`, `COL_TB_CUS_PL`, `CL_FOR_MONTH_1`, `CL_FOR_MONTH_2`, `CL_FOR_MONTH_3`, `CL_FOR_MONTH_4`, `CL_FOR_MONTH_5`, `CL_FOR_MONTH_6`, `CL_FOR_MONTH_7`, `CL_FOR_MONTH_8`, `CL_FOR_MONTH_9`, `CL_FOR_MONTH_10`, `CL_FOR_MONTH_11`, `CL_FOR_MONTH_12`, `CL_BALANCE_DUE_MONTH`, `CL_STATUS`, `CL_LAST_PAID_TO`, `CL_CREATED_AT`) VALUES
(8, 3, 1, '100', '100', '100', '100', '100', '100', '100', '100', '100', '100', '0', '0', '1', b'1', 3, '2021-08-25'),
(11, 6, 1, '100', '100', '100', '100', '100', '100', '100', '100', '100', '0', '0', '0', '2', b'1', 3, '2021-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `CUS_ID` int(11) NOT NULL,
  `CUS_NAME` varchar(50) DEFAULT NULL,
  `CUS_SUR_NAME` varchar(50) DEFAULT NULL,
  `CUS_PM_PH_NO` varchar(50) NOT NULL,
  `CUS_SE_PH_NO` varchar(50) DEFAULT NULL,
  `CUS_PLACE_ID` int(11) NOT NULL,
  `CUS_REF_BY` int(11) NOT NULL COMMENT 'THIS HAVE DEFAULT VALUE FROM AEGENT MASTER OF BY ADMIN ID 1 AND status WILL BE 0 		FOR THAT ROW',
  `CUS_PLAN_ID` int(11) NOT NULL,
  `CUS_DL_STATUS` int(11) DEFAULT 1,
  `CUS_COM_ONE` int(11) DEFAULT 0,
  `CUS_COM_TWO` int(11) DEFAULT 0,
  `CUS_CREATED_AT` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`CUS_ID`, `CUS_NAME`, `CUS_SUR_NAME`, `CUS_PM_PH_NO`, `CUS_SE_PH_NO`, `CUS_PLACE_ID`, `CUS_REF_BY`, `CUS_PLAN_ID`, `CUS_DL_STATUS`, `CUS_COM_ONE`, `CUS_COM_TWO`, `CUS_CREATED_AT`) VALUES
(3, 'SARAVANA', 'SAI', '7708454585', '5252522525', 1, 1, 1, 1, 1, 1, '2021-08-25'),
(4, 'SARAVANA', 'SAI', '7708458703', '5252522525', 2, 1, 1, 1, 1, 1, '2021-09-23'),
(5, 'SARAVANA', 'SAI', '7708458701', '5252522525', 2, 1, 1, 1, 1, 1, '2021-09-23'),
(6, 'SARAVANA', 'SAI', '7708458702', '5252522525', 2, 1, 1, 1, 1, 1, '2021-09-23');

--
-- Triggers `customer_master`
--
DELIMITER $$
CREATE TRIGGER `INSERT_INTO_COLLECTION_LIST` AFTER INSERT ON `customer_master` FOR EACH ROW INSERT INTO `collection_master` (`COL_FOR_CUS_ID`, `COL_TB_CUS_PL`,`CL_LAST_PAID_TO`) 
VALUES (new.CUS_ID,NEW.CUS_PLAN_ID,1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `place_master`
--

CREATE TABLE `place_master` (
  `PLACE_ID` int(11) NOT NULL,
  `PLACE_NAME` varchar(50) DEFAULT NULL,
  `PLACE_DL_STATUS` int(11) DEFAULT 1,
  `PLACE_CREATED_AT` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `place_master`
--

INSERT INTO `place_master` (`PLACE_ID`, `PLACE_NAME`, `PLACE_DL_STATUS`, `PLACE_CREATED_AT`) VALUES
(1, 'k.K NAGAR', 1, '2021-08-13'),
(2, 'THILAI NAGAR', 1, '2021-08-13'),
(3, 'NAGAPUR', 1, '2021-08-13'),
(4, 'AIRPORT', 1, '2021-08-13'),
(5, 'KAJAMALAI', 1, '2021-08-13');

-- --------------------------------------------------------

--
-- Table structure for table `plan_master`
--

CREATE TABLE `plan_master` (
  `PL_ID` int(11) NOT NULL,
  `PL_AMOUNT` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan_master`
--

INSERT INTO `plan_master` (`PL_ID`, `PL_AMOUNT`) VALUES
(1, '100'),
(2, '200');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_master`
--

CREATE TABLE `transaction_master` (
  `TR_ID` int(11) NOT NULL,
  `TR_OF_CUS` int(11) DEFAULT NULL,
  `TR_OF_PL_ID` int(11) DEFAULT NULL,
  `TR_DONE_TO` int(11) DEFAULT NULL COMMENT 'TRANSACTION DONE BY ADMIN',
  `TR_PAID_AMOUNT` varchar(10) DEFAULT NULL COMMENT 'AMOUNT PAID ON TRANSACTION',
  `TR_ON_DATE` date DEFAULT curdate(),
  `TR_ON_TIME` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_master`
--

INSERT INTO `transaction_master` (`TR_ID`, `TR_OF_CUS`, `TR_OF_PL_ID`, `TR_DONE_TO`, `TR_PAID_AMOUNT`, `TR_ON_DATE`, `TR_ON_TIME`) VALUES
(13, 3, 1, 3, '150', '2021-09-28', '2021-09-23 07:36:20'),
(14, 3, 1, 3, '100', '2021-09-29', '2021-09-29 06:40:15'),
(15, 3, 1, 3, '150', '2021-09-29', '2021-09-29 06:40:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`ADMIN_ID`),
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`);

--
-- Indexes for table `agent_master`
--
ALTER TABLE `agent_master`
  ADD PRIMARY KEY (`AGENT_ID`),
  ADD KEY `AGENT_LOCATION` (`AGENT_LOCATION`);

--
-- Indexes for table `collection_master`
--
ALTER TABLE `collection_master`
  ADD PRIMARY KEY (`COL_ID`),
  ADD KEY `COL_FOR_CUS_ID` (`COL_FOR_CUS_ID`),
  ADD KEY `COL_TB_CUS_PL` (`COL_TB_CUS_PL`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`CUS_ID`),
  ADD KEY `CUS_PLACE_ID` (`CUS_PLACE_ID`),
  ADD KEY `CUS_REF_BY` (`CUS_REF_BY`),
  ADD KEY `CUS_PLAN_ID` (`CUS_PLAN_ID`);

--
-- Indexes for table `place_master`
--
ALTER TABLE `place_master`
  ADD PRIMARY KEY (`PLACE_ID`);

--
-- Indexes for table `plan_master`
--
ALTER TABLE `plan_master`
  ADD PRIMARY KEY (`PL_ID`);

--
-- Indexes for table `transaction_master`
--
ALTER TABLE `transaction_master`
  ADD PRIMARY KEY (`TR_ID`),
  ADD KEY `TR_OF_CUS` (`TR_OF_CUS`),
  ADD KEY `TR_OF_PL_ID` (`TR_OF_PL_ID`),
  ADD KEY `TR_DONE_TO` (`TR_DONE_TO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `ADMIN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agent_master`
--
ALTER TABLE `agent_master`
  MODIFY `AGENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collection_master`
--
ALTER TABLE `collection_master`
  MODIFY `COL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `CUS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `place_master`
--
ALTER TABLE `place_master`
  MODIFY `PLACE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `plan_master`
--
ALTER TABLE `plan_master`
  MODIFY `PL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_master`
--
ALTER TABLE `transaction_master`
  MODIFY `TR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_master`
--
ALTER TABLE `agent_master`
  ADD CONSTRAINT `agent_master_ibfk_1` FOREIGN KEY (`AGENT_LOCATION`) REFERENCES `place_master` (`PLACE_ID`);

--
-- Constraints for table `collection_master`
--
ALTER TABLE `collection_master`
  ADD CONSTRAINT `collection_master_ibfk_1` FOREIGN KEY (`COL_FOR_CUS_ID`) REFERENCES `customer_master` (`CUS_ID`),
  ADD CONSTRAINT `collection_master_ibfk_2` FOREIGN KEY (`COL_TB_CUS_PL`) REFERENCES `plan_master` (`PL_ID`),
  ADD CONSTRAINT `collection_master_ibfk_3` FOREIGN KEY (`CL_LAST_PAID_TO`) REFERENCES `admin_login` (`ADMIN_ID`);

--
-- Constraints for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD CONSTRAINT `customer_master_ibfk_1` FOREIGN KEY (`CUS_PLACE_ID`) REFERENCES `place_master` (`PLACE_ID`),
  ADD CONSTRAINT `customer_master_ibfk_2` FOREIGN KEY (`CUS_REF_BY`) REFERENCES `agent_master` (`AGENT_ID`),
  ADD CONSTRAINT `customer_master_ibfk_3` FOREIGN KEY (`CUS_PLAN_ID`) REFERENCES `plan_master` (`PL_ID`);

--
-- Constraints for table `transaction_master`
--
ALTER TABLE `transaction_master`
  ADD CONSTRAINT `transaction_master_ibfk_1` FOREIGN KEY (`TR_OF_CUS`) REFERENCES `customer_master` (`CUS_ID`),
  ADD CONSTRAINT `transaction_master_ibfk_2` FOREIGN KEY (`TR_OF_PL_ID`) REFERENCES `plan_master` (`PL_ID`),
  ADD CONSTRAINT `transaction_master_ibfk_3` FOREIGN KEY (`TR_DONE_TO`) REFERENCES `admin_login` (`ADMIN_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
