-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2022 at 03:59 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_salesorder`
--

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

DROP TABLE IF EXISTS `carriers`;
CREATE TABLE IF NOT EXISTS `carriers` (
  `carrierID` int(11) NOT NULL AUTO_INCREMENT,
  `carrierDescription` varchar(255) NOT NULL,
  `carrierStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`carrierID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`carrierID`, `carrierDescription`, `carrierStatus`) VALUES
(1, 'DHL Courier', 1),
(2, 'DHL Express', 1),
(3, 'United Percel Service', 1),
(4, 'Self', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(255) NOT NULL,
  `customerContactName` varchar(255) NOT NULL,
  `customerContactNumber` varchar(60) NOT NULL,
  `billingAddress` text NOT NULL,
  `shippingAddress` text NOT NULL,
  `customerCity` varchar(255) NOT NULL,
  `customerState` varchar(255) NOT NULL,
  `customerStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`customerID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `customerName`, `customerContactName`, `customerContactNumber`, `billingAddress`, `shippingAddress`, `customerCity`, `customerState`, `customerStatus`) VALUES
(1, 'bitflux communications limited', 'Samuel Alonge', '08091332133', '1, Alfred Rewane Road, Falomo, Ikoyi, Lagos', '1, Alfred Rewane Road, Falomo, Ikoyi, Lagos', 'Lagos', '3', 1),
(2, 'vdt communications limited', 'Manny Ibuje', '07034340393', '37, Doyin Omololu Street, Ketu, Lagos', '37, Doyin Omololu Street, Ketu, Lagos', 'Lagos', '10', 1),
(3, 'samuel olisa', 'Samuel', '08033334444', 'Ikoyi', 'Ikoyi', 'Lagos', '24', 1),
(4, 'samuel', 'Samuel', '08022224444', 'Ikoyi', 'Egbeda', 'Lagos', '24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `departmentID` int(11) NOT NULL AUTO_INCREMENT,
  `departmentDescription` varchar(255) NOT NULL,
  `departmentStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`departmentID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentID`, `departmentDescription`, `departmentStatus`) VALUES
(1, 'Sales and Marketing', 1),
(2, 'Information Technology', 1),
(3, 'Human Resource and Administration', 1),
(4, 'Operations', 1),
(6, 'Network Performance', 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemDescription` varchar(255) NOT NULL,
  `itemUnitPrice` float(20,2) NOT NULL,
  `itemStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`itemID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemDescription`, `itemUnitPrice`, `itemStatus`) VALUES
(1, 'Iron Rod 6 Inches', 1500.00, 1),
(2, 'Iron Rod 3 Inches', 750.00, 1),
(3, 'Iron Rod 1 Inche ', 300.00, 1),
(4, 'samuel', 500.00, 1),
(5, 'olisa', 600.00, 1),
(6, '32 inch lg lcd tv', 150000.00, 1),
(7, '6foot refrigerator', 120000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salesorder`
--

DROP TABLE IF EXISTS `salesorder`;
CREATE TABLE IF NOT EXISTS `salesorder` (
  `salesOrderID` int(11) NOT NULL AUTO_INCREMENT,
  `salesOrderNumber` varchar(255) NOT NULL,
  `purchaseOrderNumber` varchar(255) NOT NULL,
  `salesOrderOwner` int(11) NOT NULL,
  `salesOrderDescription` varchar(255) NOT NULL,
  `customerPhoneNumber` varchar(255) NOT NULL,
  `invoiceNumber` varchar(255) DEFAULT NULL,
  `createdDate` varchar(255) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `dueDate` varchar(15) NOT NULL,
  `salesOrderCarrier` int(11) NOT NULL,
  `salesCommission` varchar(255) NOT NULL,
  `assignedTo` int(11) DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedDate` varchar(255) DEFAULT NULL,
  `billingAddress` text NOT NULL,
  `shippingAddress` text NOT NULL,
  `itemName` int(11) NOT NULL,
  `itemQuantity` int(11) NOT NULL,
  `itemUnitPrice` float(20,2) NOT NULL DEFAULT 0.00,
  `salesOrderTax` float(20,2) NOT NULL DEFAULT 0.00,
  `salesAdjustment` varchar(50) DEFAULT NULL,
  `salesTotal` float(20,2) NOT NULL DEFAULT 0.00,
  `additionalInformation` text NOT NULL,
  `salesOrderStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`salesOrderID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesorder`
--

INSERT INTO `salesorder` (`salesOrderID`, `salesOrderNumber`, `purchaseOrderNumber`, `salesOrderOwner`, `salesOrderDescription`, `customerPhoneNumber`, `invoiceNumber`, `createdDate`, `contactName`, `dueDate`, `salesOrderCarrier`, `salesCommission`, `assignedTo`, `createdBy`, `modifiedBy`, `modifiedDate`, `billingAddress`, `shippingAddress`, `itemName`, `itemQuantity`, `itemUnitPrice`, `salesOrderTax`, `salesAdjustment`, `salesTotal`, `additionalInformation`, `salesOrderStatus`) VALUES
(1, '2022032513', 'PO/20220325/111122233', 2, 'order description', '07034340393', '20220326/390149512', '25-03-2022', 'Manny Ibuje', '25-03-2022', 1, '70', 2, 1, 2, '26-03-2022', '37, Doyin Omololu Street, Ketu, Lagos', '37, Doyin Omololu Street, Ketu, Lagos', 3, 5, 300.00, 30.00, '50.00', 1500.00, 'Additional Information', 1),
(2, '2022032513', 'PO/20220325/111122233', 2, 'order description', '07034340393', '20220326/390149512', '25-03-2022', 'Manny Ibuje', '25-03-2022', 1, '70', 2, 1, 2, '26-03-2022', '37, Doyin Omololu Street, Ketu, Lagos', '37, Doyin Omololu Street, Ketu, Lagos', 2, 10, 750.00, 30.00, '50.00', 7500.00, 'Additional Information', 1),
(3, '2022032513', 'PO/20220325/111122233', 2, 'order description', '07034340393', '20220326/390149512', '25-03-2022', 'Manny Ibuje', '25-03-2022', 1, '70', 2, 1, 2, '26-03-2022', '37, Doyin Omololu Street, Ketu, Lagos', '37, Doyin Omololu Street, Ketu, Lagos', 1, 15, 1500.00, 30.00, '50.00', 22500.00, 'Additional Information', 1),
(4, '2022032628', 'PO/20220326/000011', 4, 'Supply of 50 pieces of 32 inches LCD TV', '08022224444', '20220326/234935343', '26-03-2022', 'Samuel', '31-03-2022', 3, '0', 3, 2, 3, '26-03-2022', 'Ikoyi', 'Egbeda', 1, 10, 1500.00, 50.00, '0', 15000.00, 'Your due date to receive your goods is 31-03-2022', 1),
(5, '2022032628', 'PO/20220326/000011', 4, 'Supply of 50 pieces of 32 inches LCD TV', '08022224444', '20220326/234935343', '26-03-2022', 'Samuel', '31-03-2022', 3, '0', 3, 2, 3, '26-03-2022', 'Ikoyi', 'Egbeda', 3, 20, 300.00, 50.00, '0', 6000.00, 'Your due date to receive your goods is 31-03-2022', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salesorderstatus`
--

DROP TABLE IF EXISTS `salesorderstatus`;
CREATE TABLE IF NOT EXISTS `salesorderstatus` (
  `orderstatusID` int(11) NOT NULL AUTO_INCREMENT,
  `orderstatusDescription` varchar(50) NOT NULL,
  `orderStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`orderstatusID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesorderstatus`
--

INSERT INTO `salesorderstatus` (`orderstatusID`, `orderstatusDescription`, `orderStatus`) VALUES
(1, 'Cancelled', 1),
(2, 'Completed', 1),
(3, 'Pending', 1),
(4, 'Suspended', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE IF NOT EXISTS `staffs` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `staffID` varchar(50) NOT NULL,
  `staffFirstName` varchar(50) NOT NULL,
  `staffOtherNames` varchar(255) NOT NULL,
  `staffLastName` varchar(50) NOT NULL,
  `staffPhoneNumber` varchar(36) NOT NULL,
  `staffHomeAddress` text NOT NULL,
  `staffPermanentAddress` text NOT NULL,
  `staffCity` varchar(255) NOT NULL,
  `staffState` int(11) NOT NULL,
  `staffDepartment` int(11) NOT NULL,
  `staffUsername` varchar(50) NOT NULL,
  `staffPassword` varchar(50) NOT NULL DEFAULT 'password123',
  `staffStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`userID`, `staffID`, `staffFirstName`, `staffOtherNames`, `staffLastName`, `staffPhoneNumber`, `staffHomeAddress`, `staffPermanentAddress`, `staffCity`, `staffState`, `staffDepartment`, `staffUsername`, `staffPassword`, `staffStatus`) VALUES
(1, '0142', 'Igho', 'Manny', 'Ibuje', '07034340393, 08091332133', 'Falomo, Ikoyi, Lagos', 'Falomo, Ikoyi, Lagos', 'Lagos', 11, 2, 'imigreat@yahoo.com', 'password123', 1),
(2, '0143', 'Samuel', '', 'Alonge', '08091332133', 'Bariga', 'Bariga', 'Abeokuta', 27, 4, 'imigreat2011@gmail.com', 'password123', 1),
(3, '1001', 'Olisa', 'John', 'Doe', '07044445555', 'Awka', 'Awka', 'Awka', 4, 1, 'samuelbinitie123@gmail.com', 'password123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `stateID` int(11) NOT NULL AUTO_INCREMENT,
  `stateDescription` varchar(255) NOT NULL,
  `stateStatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`stateID`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`stateID`, `stateDescription`, `stateStatus`) VALUES
(1, 'Abia', 1),
(2, 'Adamawa', 1),
(3, 'Akwa Ibom', 1),
(4, 'Anambra', 1),
(5, 'Bauchi', 1),
(6, 'Bayelsa', 1),
(7, 'Benue', 1),
(8, 'Borno', 1),
(9, 'Cross River', 1),
(10, 'Delta', 1),
(11, 'Ebonyi', 1),
(12, 'Edo', 1),
(13, 'Ekiti', 1),
(14, 'Enugu', 1),
(15, 'Gombe', 1),
(16, 'Imo', 1),
(17, 'Jigawa', 1),
(18, 'Kaduna', 1),
(19, 'Kano', 1),
(20, 'Katsina', 1),
(21, 'Kebbi', 1),
(22, 'Kogi', 1),
(23, 'Kwara', 1),
(24, 'Lagos', 1),
(25, 'Nasarawa', 1),
(26, 'Niger', 1),
(27, 'Ogun', 1),
(28, 'Ondo', 1),
(29, 'Osun', 1),
(30, 'Oyo', 1),
(31, 'Plateau', 1),
(32, 'Rivers', 1),
(33, 'Sokoto', 1),
(34, 'Taraba', 1),
(35, 'Yobe', 1),
(36, 'Zamfara', 1),
(37, 'Federal Capital Territory', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
