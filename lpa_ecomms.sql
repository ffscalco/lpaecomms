-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2018 at 03:31 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `id7045576_lpa_ecomms`
--

-- --------------------------------------------------------

--
-- Table structure for table `lpa_clients`
--

CREATE TABLE IF NOT EXISTS `lpa_clients` (
`lpa_client_ID` int(10) NOT NULL,
  `lpa_client_firstname` varchar(50) NOT NULL,
  `lpa_client_lastname` varchar(50) NOT NULL,
  `lpa_client_address` varchar(250) NOT NULL,
  `lpa_client_phone` varchar(30) NOT NULL,
  `lpa_client_status` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=719 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lpa_clients`
--

INSERT INTO `lpa_clients` (`lpa_client_ID`, `lpa_client_firstname`, `lpa_client_lastname`, `lpa_client_address`, `lpa_client_phone`, `lpa_client_status`) VALUES
(1, 'Juan Fernando', 'Osorio Salazar', '135 Bage Street', '0467345283', 'E'),
(2, 'Carlos', 'Velasquez', 'Surfers Paradise', '0423457892', 'D'),
(718, 'Shushant', 'SAthpathy', '11', '11', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `lpa_invoices`
--

CREATE TABLE IF NOT EXISTS `lpa_invoices` (
`lpa_inv_no` int(10) NOT NULL,
  `lpa_inv_date` datetime NOT NULL,
  `lpa_inv_client_ID` varchar(20) NOT NULL,
  `lpa_inv_client_name` varchar(50) NOT NULL,
  `lpa_inv_client_address` varchar(250) NOT NULL,
  `lpa_inv_amount` decimal(8,2) NOT NULL,
  `lpa_inv_status` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=930 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lpa_invoices`
--

INSERT INTO `lpa_invoices` (`lpa_inv_no`, `lpa_inv_date`, `lpa_inv_client_ID`, `lpa_inv_client_name`, `lpa_inv_client_address`, `lpa_inv_amount`, `lpa_inv_status`) VALUES
(1, '2014-06-12 17:10:03', 'jfosorios', 'Juan Fernando Osorio', '135 Bage Street', '450.00', 'P'),
(2, '2014-10-03 14:16:04', 'carlosvz', 'Carlos Velasquez', 'Surfers Paradise', '320.15', 'U'),
(3, '2014-10-02 10:41:12', 'anaosorio', 'Ana Osorio', 'Toombul Shopping Centre', '1250.15', 'P'),
(4, '2014-10-02 10:41:12', 'alma23', 'Alma Torres', '13 Bumbil Street', '230.00', 'P'),
(275, '2018-03-23 12:27:20', '1', 'Juan Fernando Osorio Salazar', '135 Bage Street', '15000.00', 'A'),
(333, '2018-05-25 02:30:20', '1', 'Juan Fernando Osorio Salazar', '135 Bage Street', '33.00', 'A'),
(929, '2018-05-25 02:05:35', '1', 'Juan Fernando Osorio Salazar', '135 Bage Street', '1533.00', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `lpa_invoice_items`
--

CREATE TABLE IF NOT EXISTS `lpa_invoice_items` (
`lpa_invitem_no` int(11) NOT NULL,
  `lpa_invitem_inv_no` varchar(20) NOT NULL,
  `lpa_invitem_stock_ID` varchar(20) NOT NULL,
  `lpa_invitem_stock_name` varchar(250) NOT NULL,
  `lpa_invitem_qty` varchar(6) NOT NULL,
  `lpa_invitem_stock_price` decimal(7,2) NOT NULL,
  `lpa_invitem_stock_amount` decimal(7,2) NOT NULL,
  `lpa_inv_status` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lpa_invoice_items`
--

INSERT INTO `lpa_invoice_items` (`lpa_invitem_no`, `lpa_invitem_inv_no`, `lpa_invitem_stock_ID`, `lpa_invitem_stock_name`, `lpa_invitem_qty`, `lpa_invitem_stock_price`, `lpa_invitem_stock_amount`, `lpa_inv_status`) VALUES
(2, '929', '125', 'Mini Display Port to VGA', '1', '33.00', '33.00', 'A'),
(3, '929', '123', 'Computer', '1', '1500.00', '1500.00', 'A'),
(4, '333', '125', 'Mini Display Port to VGA', '1', '33.00', '33.00', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `lpa_stock`
--

CREATE TABLE IF NOT EXISTS `lpa_stock` (
`lpa_stock_ID` int(10) NOT NULL,
  `lpa_stock_name` varchar(250) NOT NULL,
  `lpa_stock_desc` text NOT NULL,
  `lpa_stock_onhand` varchar(5) NOT NULL,
  `lpa_stock_price` decimal(7,2) NOT NULL,
  `lpa_image` varchar(255) NOT NULL,
  `lpa_stock_status` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=949 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lpa_stock`
--

INSERT INTO `lpa_stock` (`lpa_stock_ID`, `lpa_stock_name`, `lpa_stock_desc`, `lpa_stock_onhand`, `lpa_stock_price`, `lpa_image`, `lpa_stock_status`) VALUES
(123, 'Computer', 'Computer system', '4', '1500.00', 'Computer.png', 'a'),
(124, 'Apple iPad 4', 'This is an apple iPad 4', '4', '250.00', 'iPad.png', 'D'),
(125, 'Mini Display Port to VGA', 'Cable for Apple', '3', '33.00', '', 'a'),
(126, 'StLab U-470 USB 2.0 to VGA Adapter', ' VGA Adapter', '5', '42.00', '', 'a'),
(127, 'USB2.0 To Ethernet Adapter', 'Cable ', '5', '9.00', '', 'a'),
(128, 'Computer Monitor', 'LCD screen', '4', '21.54', 'monitor.png', 'a'),
(513, 'TEst', 'TEst', '1', '10.00', '', 'a'),
(825, 'test item (edited)', 'Creating a test item.\r\nEdited as well', '5', '10.00', '', 'a'),
(948, 'Test', 'Test', '1', '10.00', '', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `lpa_users`
--

CREATE TABLE IF NOT EXISTS `lpa_users` (
`lpa_user_ID` int(10) NOT NULL,
  `lpa_user_username` varchar(30) NOT NULL,
  `lpa_user_password` varchar(50) NOT NULL,
  `lpa_user_firstname` varchar(50) NOT NULL,
  `lpa_user_lastname` varchar(50) NOT NULL,
  `lpa_user_group` varchar(50) NOT NULL,
  `lpa_user_status` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=917 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lpa_users`
--

INSERT INTO `lpa_users` (`lpa_user_ID`, `lpa_user_username`, `lpa_user_password`, `lpa_user_firstname`, `lpa_user_lastname`, `lpa_user_group`, `lpa_user_status`) VALUES
(1, 'admin', 'cGFzc3dvcmQ=', 'Fabiano', 'Fagundes Scalco', 'administrator', 'a'),
(2, 'user', 'cGFzc3dvcmQ=', 'Oscar Mauricio', 'Salazar Ospina', 'user', 'a'),
(3, 'codea', 'cGFzc3dvcmQ=', 'Steve', 'Coleman', 'administrator', 'a'),
(152, 'shushant', 'cGFzc3dvcmQ=', 'Shushant', 'Sathpathy', 'administrator', 'a'),
(916, 'ffscalco2test', 'dGVzdHRlc3Q=', 'test', 'test', 'user', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lpa_clients`
--
ALTER TABLE `lpa_clients`
 ADD PRIMARY KEY (`lpa_client_ID`);

--
-- Indexes for table `lpa_invoices`
--
ALTER TABLE `lpa_invoices`
 ADD PRIMARY KEY (`lpa_inv_no`), ADD UNIQUE KEY `lpa_inv_no_UNIQUE` (`lpa_inv_no`);

--
-- Indexes for table `lpa_invoice_items`
--
ALTER TABLE `lpa_invoice_items`
 ADD PRIMARY KEY (`lpa_invitem_no`), ADD UNIQUE KEY `lpa_invitem_no_UNIQUE` (`lpa_invitem_no`);

--
-- Indexes for table `lpa_stock`
--
ALTER TABLE `lpa_stock`
 ADD PRIMARY KEY (`lpa_stock_ID`);

--
-- Indexes for table `lpa_users`
--
ALTER TABLE `lpa_users`
 ADD PRIMARY KEY (`lpa_user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lpa_clients`
--
ALTER TABLE `lpa_clients`
MODIFY `lpa_client_ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=719;
--
-- AUTO_INCREMENT for table `lpa_invoices`
--
ALTER TABLE `lpa_invoices`
MODIFY `lpa_inv_no` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=930;
--
-- AUTO_INCREMENT for table `lpa_invoice_items`
--
ALTER TABLE `lpa_invoice_items`
MODIFY `lpa_invitem_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lpa_stock`
--
ALTER TABLE `lpa_stock`
MODIFY `lpa_stock_ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=949;
--
-- AUTO_INCREMENT for table `lpa_users`
--
ALTER TABLE `lpa_users`
MODIFY `lpa_user_ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=917;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
