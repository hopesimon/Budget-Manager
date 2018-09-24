-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2018 at 05:31 AM
-- Server version: 5.7.23
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
-- Database: `budgetmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `orgcurrent`
--

CREATE TABLE `orgcurrent` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `membercnt` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `totalin` int(11) DEFAULT NULL,
  `totalexpense` int(11) DEFAULT NULL,
  `overhead` int(11) DEFAULT NULL,
  `totalbudget` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orgcurrent`
--

INSERT INTO `orgcurrent` (`id`, `name`, `membercnt`, `manager_id`, `totalin`, `totalexpense`, `overhead`, `totalbudget`) VALUES
(1, 'Example Organization #1', NULL, 2, NULL, NULL, NULL, NULL),
(2, 'Example Organization #2', NULL, 2, NULL, NULL, NULL, NULL),
(3, 'Testing', NULL, 3, NULL, NULL, NULL, NULL),
(12, 'Testing 2', NULL, 3, NULL, NULL, NULL, NULL),
(13, 'Example Organization #3', NULL, 2, NULL, NULL, NULL, NULL),
(14, 'Org Name', NULL, 6, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orgpast`
--

CREATE TABLE `orgpast` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `membercnt` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `totalin` int(11) DEFAULT NULL,
  `totalexpense` int(11) DEFAULT NULL,
  `overhead` int(11) DEFAULT NULL,
  `totalbudget` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otherexpenses`
--

CREATE TABLE `otherexpenses` (
  `id` int(11) NOT NULL,
  `o_name` varchar(30) NOT NULL,
  `form_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otherexpenses`
--

INSERT INTO `otherexpenses` (`id`, `o_name`, `form_id`, `name`, `amount`) VALUES
(4, 'Org Name', 16, 'qrs', 66),
(5, 'Org Name', 16, 'tuv', 99);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `o_name` varchar(30) NOT NULL,
  `tintotal` int(11) NOT NULL DEFAULT '0',
  `other_amount` int(11) NOT NULL DEFAULT '0',
  `equipment_amount` int(11) NOT NULL DEFAULT '0',
  `improvements_amount` int(11) NOT NULL DEFAULT '0',
  `contingencies_amount` int(11) NOT NULL DEFAULT '0',
  `expensetotal` int(11) NOT NULL DEFAULT '0',
  `touttotal` int(11) NOT NULL DEFAULT '0',
  `net_inoutflow` int(11) NOT NULL DEFAULT '0',
  `tin_description` varchar(140) DEFAULT NULL,
  `tout_description` varchar(140) DEFAULT NULL,
  `other_description` varchar(140) DEFAULT NULL,
  `eq_description` varchar(140) DEFAULT NULL,
  `im_description` varchar(140) DEFAULT NULL,
  `co_description` varchar(140) DEFAULT NULL,
  `datesubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appstatus` varchar(15) NOT NULL DEFAULT 'In Review',
  `comments` varchar(140) DEFAULT NULL,
  `reviewer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `o_name`, `tintotal`, `other_amount`, `equipment_amount`, `improvements_amount`, `contingencies_amount`, `expensetotal`, `touttotal`, `net_inoutflow`, `tin_description`, `tout_description`, `other_description`, `eq_description`, `im_description`, `co_description`, `datesubmitted`, `appstatus`, `comments`, `reviewer`) VALUES
(16, 'Org Name', 79, 165, 22, 64, 128, 509, 129, -430, 'this is my justification', 'this is my justification', 'this is my justification', 'this is my justification', 'this is my justification', 'this is my justification', '2018-09-22 21:23:22', 'Approved', 'this is a test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfersin`
--

CREATE TABLE `transfersin` (
  `id` int(11) NOT NULL,
  `o_name` varchar(30) NOT NULL,
  `form_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfersin`
--

INSERT INTO `transfersin` (`id`, `o_name`, `form_id`, `name`, `amount`) VALUES
(5, 'Org Name', 16, 'abcdefg', 32),
(6, 'Org Name', 16, 'hijklmno', 47);

-- --------------------------------------------------------

--
-- Table structure for table `transfersout`
--

CREATE TABLE `transfersout` (
  `id` int(11) NOT NULL,
  `o_name` varchar(30) NOT NULL,
  `form_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfersout`
--

INSERT INTO `transfersout` (`id`, `o_name`, `form_id`, `name`, `amount`) VALUES
(4, 'Org Name', 16, 'wx', 100),
(5, 'Org Name', 16, 'yz', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `fauemail` varchar(140) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `fauemail`, `type`) VALUES
(1, 'Admin', 'admin', 'ASAB'),
(2, 'Manager', 'manager', 'Budget'),
(3, 'Test', 'example', 'Budget'),
(6, 'My name', 'fauemail', 'Budget');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orgcurrent`
--
ALTER TABLE `orgcurrent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `orgpast`
--
ALTER TABLE `orgpast`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `otherexpenses`
--
ALTER TABLE `otherexpenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfersin`
--
ALTER TABLE `transfersin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfersout`
--
ALTER TABLE `transfersout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `fauemail` (`fauemail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orgcurrent`
--
ALTER TABLE `orgcurrent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orgpast`
--
ALTER TABLE `orgpast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otherexpenses`
--
ALTER TABLE `otherexpenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transfersin`
--
ALTER TABLE `transfersin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transfersout`
--
ALTER TABLE `transfersout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orgcurrent`
--
ALTER TABLE `orgcurrent`
  ADD CONSTRAINT `orgcurrent_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
