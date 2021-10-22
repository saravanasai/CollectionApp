-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2021 at 03:15 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collect`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=CURRENT_USER PROCEDURE `get_collection_of_customer` (IN `CUS_ID` INT)  BEGIN
  SELECT * FROM collection_master,plan_master WHERE collection_master.COL_TB_CUS_PL=plan_master.PL_ID
  AND collection_master.COL_FOR_CUS_ID=CUS_ID;
END$$

CREATE DEFINER=CURRENT_USER PROCEDURE `super_collection_list` ()  BEGIN
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
  `ADMIN_ID` bigint(20) NOT NULL,
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
(3, 'admin', '7708454539', '$2y$10$voM15Z6Q88Py7thlAwkDmeWdS9UpalCQ/NhxXVfuZr4oLDgG.WtAG', 1, '2021-10-11 06:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `agent_master`
--

CREATE TABLE `agent_master` (
  `AGENT_ID` bigint(20) NOT NULL,
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
(1, 'RAKIDA RAKIDA', '7708454539', 1, 1, '2021-10-09'),
(2, 'ADI ADI', '7708454539', 1, 1, '2021-10-09');

-- --------------------------------------------------------

--
-- Stand-in structure for view `collection_list_view`
-- (See below for the actual view)
--
CREATE TABLE `collection_list_view` (
`CUS_ID` bigint(20)
,`CUS_NAME` varchar(50)
,`CUS_SUR_NAME` varchar(50)
,`CUS_PM_PH_NO` varchar(50)
,`CUS_SE_PH_NO` varchar(50)
,`CUS_PLACE_ID` bigint(20)
,`CUS_REF_BY` bigint(20)
,`CUS_PLAN_ID` bigint(20)
,`CUS_DL_STATUS` int(11)
,`CUS_COM_ONE` int(11)
,`CUS_COM_TWO` int(11)
,`CUS_CREATED_AT` date
,`CUS_SCHEME_ID` bigint(20)
,`PLACE_ID` bigint(20)
,`PLACE_NAME` varchar(50)
,`PLACE_DL_STATUS` int(11)
,`PLACE_CREATED_AT` date
,`PL_ID` bigint(20)
,`PL_AMOUNT` varchar(50)
,`SCHEME_ID` bigint(20)
,`SCHEME_NAME` varchar(100)
,`SCHEME_START_DATE` date
,`SCHEME_END_DATE` date
,`SCHEME_ACTIVE_STATUS` bit(1)
,`SCHEME_DL_STATUS` bit(1)
,`COL_ID` bigint(20) unsigned
,`COL_FOR_CUS_ID` bigint(20)
,`CUS_TOTAL_DUE` bigint(20)
,`COL_DUE_BALANCE` bigint(20)
,`CL_LAST_UPDATED_ON` date
,`CL_CREATED_ON` date
);

-- --------------------------------------------------------

--
-- Table structure for table `collection_master`
--

CREATE TABLE `collection_master` (
  `COL_ID` bigint(20) UNSIGNED NOT NULL,
  `COL_FOR_CUS_ID` bigint(20) NOT NULL,
  `CUS_TOTAL_DUE` bigint(20) NOT NULL COMMENT 'TOTAL AMOUNT NEED TO BE PAID BY CUSTOMER  INSERT  BY MULTIPLYING THE PLAN AMOUNT AND INSERTING HERE',
  `COL_DUE_BALANCE` bigint(20) NOT NULL DEFAULT 0,
  `CL_LAST_UPDATED_ON` date NOT NULL DEFAULT curdate(),
  `CL_CREATED_ON` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TO STORE ALL THE COLLECTIONS OF THE SPECIFIC SCHEME';

--
-- Dumping data for table `collection_master`
--

INSERT INTO `collection_master` (`COL_ID`, `COL_FOR_CUS_ID`, `CUS_TOTAL_DUE`, `COL_DUE_BALANCE`, `CL_LAST_UPDATED_ON`, `CL_CREATED_ON`) VALUES
(3, 20, 1950, 0, '2021-10-11', '2021-10-11'),
(4, 21, 2400, 1800, '2021-10-11', '2021-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `CUS_ID` bigint(20) NOT NULL,
  `CUS_NAME` varchar(50) DEFAULT NULL,
  `CUS_SUR_NAME` varchar(50) DEFAULT NULL,
  `CUS_PM_PH_NO` varchar(50) NOT NULL,
  `CUS_SE_PH_NO` varchar(50) DEFAULT NULL,
  `CUS_PLACE_ID` bigint(20) NOT NULL,
  `CUS_REF_BY` bigint(20) NOT NULL,
  `CUS_PLAN_ID` bigint(20) NOT NULL,
  `CUS_DL_STATUS` int(11) DEFAULT 1,
  `CUS_COM_ONE` int(11) DEFAULT 0,
  `CUS_COM_TWO` int(11) DEFAULT 0,
  `CUS_CREATED_AT` date DEFAULT curdate(),
  `CUS_SCHEME_ID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`CUS_ID`, `CUS_NAME`, `CUS_SUR_NAME`, `CUS_PM_PH_NO`, `CUS_SE_PH_NO`, `CUS_PLACE_ID`, `CUS_REF_BY`, `CUS_PLAN_ID`, `CUS_DL_STATUS`, `CUS_COM_ONE`, `CUS_COM_TWO`, `CUS_CREATED_AT`, `CUS_SCHEME_ID`) VALUES
(6, 'SARAVANA', 'SAI', '7708458702', '5252522525', 2, 1, 1, 1, 1, 0, '2021-10-09', 2),
(12, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(13, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(14, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(15, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(16, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(17, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(18, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(19, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(20, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2),
(21, 'david', 'prabu', '8899223366', '8889223366', 2, 1, 1, 1, 1, 0, '2021-10-11', 2);

-- --------------------------------------------------------

--
-- Table structure for table `place_master`
--

CREATE TABLE `place_master` (
  `PLACE_ID` bigint(20) NOT NULL,
  `PLACE_NAME` varchar(50) DEFAULT NULL,
  `PLACE_DL_STATUS` int(11) DEFAULT 1,
  `PLACE_CREATED_AT` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `place_master`
--

INSERT INTO `place_master` (`PLACE_ID`, `PLACE_NAME`, `PLACE_DL_STATUS`, `PLACE_CREATED_AT`) VALUES
(1, 'dfgdf', 1, '2021-10-09'),
(2, 'k.k.nagar', 1, '2021-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `plan_master`
--

CREATE TABLE `plan_master` (
  `PL_ID` bigint(20) NOT NULL,
  `PL_AMOUNT` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan_master`
--

INSERT INTO `plan_master` (`PL_ID`, `PL_AMOUNT`) VALUES
(1, '200'),
(2, '300');

-- --------------------------------------------------------

--
-- Table structure for table `scheme_master`
--

CREATE TABLE `scheme_master` (
  `SCHEME_ID` bigint(20) NOT NULL,
  `SCHEME_NAME` varchar(100) NOT NULL COMMENT 'NAME OF THE SCHEME THAT CAN HANDLE MULTUPLE SCHEMES FOR YEAR',
  `SCHEME_START_DATE` date NOT NULL COMMENT 'IT SHOUDE BE THE SCHEME STARTING DATE',
  `SCHEME_END_DATE` date DEFAULT NULL COMMENT 'IT SHOULDE BE 12 MONTHS AFTER START DATE',
  `SCHEME_ACTIVE_STATUS` bit(1) NOT NULL DEFAULT b'1' COMMENT '1 MEANS ACTIVE 0 MEANS CLOSED',
  `SCHEME_DL_STATUS` bit(1) DEFAULT b'1' COMMENT 'SOFT_DELETE FOR SCHEME 1 MEANS NO DELETED  MEANS DELETED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='THIS TABLES HANDLES THE SCHEME FOR  MONTHS';

--
-- Dumping data for table `scheme_master`
--

INSERT INTO `scheme_master` (`SCHEME_ID`, `SCHEME_NAME`, `SCHEME_START_DATE`, `SCHEME_END_DATE`, `SCHEME_ACTIVE_STATUS`, `SCHEME_DL_STATUS`) VALUES
(1, 'FIRTS SCHEME', '2021-10-12', '2021-11-12', b'1', b'1'),
(2, 'SECOND SCHEME', '2021-10-12', '2021-11-12', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_master`
--

CREATE TABLE `transaction_master` (
  `TR_ID` bigint(20) UNSIGNED NOT NULL,
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
(1, 21, NULL, 3, '2250', '2021-10-11', '2021-10-11 09:44:40'),
(2, 21, NULL, 3, '150', '2021-10-11', '2021-10-11 09:45:14'),
(3, 21, NULL, 3, '3000', '2021-10-11', '2021-10-11 09:45:28'),
(4, 23, NULL, 3, '150', '2021-10-11', '2021-10-11 09:45:30');

-- --------------------------------------------------------

--
-- Structure for view `collection_list_view`
--
DROP TABLE IF EXISTS `collection_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `collection_list_view`  AS SELECT `customer_master`.`CUS_ID` AS `CUS_ID`, `customer_master`.`CUS_NAME` AS `CUS_NAME`, `customer_master`.`CUS_SUR_NAME` AS `CUS_SUR_NAME`, `customer_master`.`CUS_PM_PH_NO` AS `CUS_PM_PH_NO`, `customer_master`.`CUS_SE_PH_NO` AS `CUS_SE_PH_NO`, `customer_master`.`CUS_PLACE_ID` AS `CUS_PLACE_ID`, `customer_master`.`CUS_REF_BY` AS `CUS_REF_BY`, `customer_master`.`CUS_PLAN_ID` AS `CUS_PLAN_ID`, `customer_master`.`CUS_DL_STATUS` AS `CUS_DL_STATUS`, `customer_master`.`CUS_COM_ONE` AS `CUS_COM_ONE`, `customer_master`.`CUS_COM_TWO` AS `CUS_COM_TWO`, `customer_master`.`CUS_CREATED_AT` AS `CUS_CREATED_AT`, `customer_master`.`CUS_SCHEME_ID` AS `CUS_SCHEME_ID`, `place_master`.`PLACE_ID` AS `PLACE_ID`, `place_master`.`PLACE_NAME` AS `PLACE_NAME`, `place_master`.`PLACE_DL_STATUS` AS `PLACE_DL_STATUS`, `place_master`.`PLACE_CREATED_AT` AS `PLACE_CREATED_AT`, `plan_master`.`PL_ID` AS `PL_ID`, `plan_master`.`PL_AMOUNT` AS `PL_AMOUNT`, `scheme_master`.`SCHEME_ID` AS `SCHEME_ID`, `scheme_master`.`SCHEME_NAME` AS `SCHEME_NAME`, `scheme_master`.`SCHEME_START_DATE` AS `SCHEME_START_DATE`, `scheme_master`.`SCHEME_END_DATE` AS `SCHEME_END_DATE`, `scheme_master`.`SCHEME_ACTIVE_STATUS` AS `SCHEME_ACTIVE_STATUS`, `scheme_master`.`SCHEME_DL_STATUS` AS `SCHEME_DL_STATUS`, `collection_master`.`COL_ID` AS `COL_ID`, `collection_master`.`COL_FOR_CUS_ID` AS `COL_FOR_CUS_ID`, `collection_master`.`CUS_TOTAL_DUE` AS `CUS_TOTAL_DUE`, `collection_master`.`COL_DUE_BALANCE` AS `COL_DUE_BALANCE`, `collection_master`.`CL_LAST_UPDATED_ON` AS `CL_LAST_UPDATED_ON`, `collection_master`.`CL_CREATED_ON` AS `CL_CREATED_ON` FROM ((((`customer_master` join `place_master`) join `plan_master`) join `scheme_master`) join `collection_master`) WHERE `customer_master`.`CUS_ID` = `collection_master`.`COL_FOR_CUS_ID` AND `customer_master`.`CUS_PLACE_ID` = `place_master`.`PLACE_ID` AND `customer_master`.`CUS_PLAN_ID` = `plan_master`.`PL_ID` ;

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
  ADD KEY `Fk_collection_master_cusid` (`COL_FOR_CUS_ID`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`CUS_ID`),
  ADD KEY `fk_customer_master_plan_master` (`CUS_PLAN_ID`),
  ADD KEY `fk_customer_master` (`CUS_PLACE_ID`),
  ADD KEY `Fk_customer_master_scheme` (`CUS_SCHEME_ID`),
  ADD KEY `Fk_customer_master_ref_id` (`CUS_REF_BY`);

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
-- Indexes for table `scheme_master`
--
ALTER TABLE `scheme_master`
  ADD PRIMARY KEY (`SCHEME_ID`);

--
-- Indexes for table `transaction_master`
--
ALTER TABLE `transaction_master`
  ADD PRIMARY KEY (`TR_ID`),
  ADD KEY `TR_OF_CUS` (`TR_OF_CUS`),
  ADD KEY `TR_DONE_TO` (`TR_DONE_TO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `ADMIN_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `agent_master`
--
ALTER TABLE `agent_master`
  MODIFY `AGENT_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collection_master`
--
ALTER TABLE `collection_master`
  MODIFY `COL_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `CUS_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `place_master`
--
ALTER TABLE `place_master`
  MODIFY `PLACE_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `plan_master`
--
ALTER TABLE `plan_master`
  MODIFY `PL_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scheme_master`
--
ALTER TABLE `scheme_master`
  MODIFY `SCHEME_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_master`
--
ALTER TABLE `transaction_master`
  MODIFY `TR_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection_master`
--
ALTER TABLE `collection_master`
  ADD CONSTRAINT `Fk_collection_master_cusid` FOREIGN KEY (`COL_FOR_CUS_ID`) REFERENCES `customer_master` (`CUS_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD CONSTRAINT `Fk_customer_master_ref_id` FOREIGN KEY (`CUS_REF_BY`) REFERENCES `agent_master` (`AGENT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Fk_customer_master_scheme` FOREIGN KEY (`CUS_SCHEME_ID`) REFERENCES `scheme_master` (`SCHEME_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_master` FOREIGN KEY (`CUS_PLACE_ID`) REFERENCES `place_master` (`PLACE_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_master_plan_master` FOREIGN KEY (`CUS_PLAN_ID`) REFERENCES `plan_master` (`PL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
