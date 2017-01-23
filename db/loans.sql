-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2017 at 12:39 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loans`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslevel`
--

CREATE TABLE `accesslevel` (
  `id` int(11) NOT NULL,
  `name` varchar(156) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accesslevel`
--

INSERT INTO `accesslevel` (`id`, `name`, `description`) VALUES
(1, 'Administator', 'This will be able to add settings'),
(2, 'Manager', 'Can view, edit and delete'),
(3, 'Field Operators', 'Can Add, Limited Views');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_number` bigint(20) NOT NULL,
  `balance` decimal(19,2) NOT NULL,
  `person_number` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_number`, `balance`, `person_number`, `status`, `date_created`, `created_by`, `date_modified`) VALUES
(1, 2846298541, '0.00', 1, 1, '2016-11-16', 0, '2016-11-16 09:24:20'),
(2, 6281206434, '5000.00', 2, 1, '2016-11-16', 0, '2016-11-23 10:45:20'),
(3, 3459593919, '0.00', 3, 1, '2016-11-24', 0, '2016-11-24 08:41:05'),
(4, 3190239904, '0.00', 4, 1, '2016-11-24', 1, '2016-11-24 08:54:48'),
(5, 3699647649, '0.00', 5, 1, '2017-01-08', 0, '2017-01-08 17:07:35'),
(6, 1208039482, '0.00', 6, 1, '2017-01-08', 0, '2017-01-08 17:14:52'),
(7, 1581388289, '0.00', 7, 1, '2017-01-08', 1, '2017-01-08 17:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `account_transaction`
--

CREATE TABLE `account_transaction` (
  `id` int(11) NOT NULL,
  `person_number` int(11) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `comment` text NOT NULL,
  `transaction_type` varchar(30) NOT NULL,
  `transacted_by` varchar(120) NOT NULL,
  `date_added` date NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atmcard`
--

CREATE TABLE `atmcard` (
  `id` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `security_id` int(11) NOT NULL,
  `card_number` varchar(45) NOT NULL,
  `card_name` varchar(256) NOT NULL,
  `pin` varchar(256) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atmcard`
--

INSERT INTO `atmcard` (`id`, `bank`, `security_id`, `card_number`, `card_name`, `pin`, `added_by`) VALUES
(1, 2, 1, '3456693930', 'Mugasa Pulatin Alfred', 'MTk4OA==', 3);

-- --------------------------------------------------------

--
-- Table structure for table `atmwithdrawal`
--

CREATE TABLE `atmwithdrawal` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(30) NOT NULL,
  `atm_card` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `amount` varchar(45) NOT NULL,
  `withdrawal_date` date NOT NULL,
  `bank` varchar(45) NOT NULL,
  `bank_branch` varchar(45) DEFAULT NULL,
  `withdrawn_by` varchar(45) NOT NULL,
  `justification` text NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atmwithdrawal`
--

INSERT INTO `atmwithdrawal` (`id`, `transaction_id`, `atm_card`, `loan`, `amount`, `withdrawal_date`, `bank`, `bank_branch`, `withdrawn_by`, `justification`, `added_by`) VALUES
(1, 'ATMW115510', 1, 1, '50000', '2016-10-24', '1', '1', '3', 'Hello', 3);

-- --------------------------------------------------------

--
-- Table structure for table `atm_status`
--

CREATE TABLE `atm_status` (
  `id` int(11) NOT NULL,
  `status` int(50) NOT NULL,
  `atm` int(11) NOT NULL,
  `description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atm_status`
--

INSERT INTO `atm_status` (`id`, `status`, `atm`, `description`) VALUES
(1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `availablecash`
--

CREATE TABLE `availablecash` (
  `id` int(11) NOT NULL,
  `cash_date` date NOT NULL,
  `amount` varchar(100) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `bank_name`, `description`) VALUES
(1, 'Stanbik Bank', 'Stanbik'),
(2, 'Equity Bank', 'Equity'),
(3, 'Barclays Bank', 'Bank');

-- --------------------------------------------------------

--
-- Table structure for table `bankbranch`
--

CREATE TABLE `bankbranch` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `office_phone` text NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankbranch`
--

INSERT INTO `bankbranch` (`id`, `bank_id`, `branch_name`, `office_phone`, `email_address`, `location`) VALUES
(1, 1, 'Kampala Road', '0702771124', 'info@stambicbankug.com', 'Kampala'),
(2, 3, 'Masengere Branch', '0702771124', 'masengere@barclays.com', 'Kampala');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch_number` varchar(45) NOT NULL,
  `branch_name` varchar(150) NOT NULL,
  `physical_address` text NOT NULL,
  `office_phone` varchar(45) DEFAULT NULL,
  `postal_address` varchar(156) DEFAULT NULL,
  `email_address` varchar(156) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_number`, `branch_name`, `physical_address`, `office_phone`, `postal_address`, `email_address`) VALUES
(1, 'BR00001', 'Muganzirwaza', 'Muganzirwaza First Floor', '073-666-999', '', 'financialservices@buladde.or.ug');

-- --------------------------------------------------------

--
-- Table structure for table `clientpayback`
--

CREATE TABLE `clientpayback` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `amount` text NOT NULL,
  `paid_by` int(11) NOT NULL,
  `date_paid_back` date NOT NULL,
  `mode_paid` varchar(20) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `bank` int(11) NOT NULL,
  `bank_branch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE `counties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`id`, `name`, `district_id`) VALUES
(1, 'Kawempe', 1),
(2, 'Kampala Central', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Uganda'),
(2, 'Kenya');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `country_id`) VALUES
(1, 'Kampala', 1),
(2, 'Masaka', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `expense_type` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `amount_used` text NOT NULL,
  `amount_description` text NOT NULL,
  `date_of_expense` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expensetypes`
--

CREATE TABLE `expensetypes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `name`, `description`) VALUES
(1, 'Male', NULL),
(2, 'Female', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guarantor`
--

CREATE TABLE `guarantor` (
  `id` int(11) NOT NULL,
  `person_number` int(11) NOT NULL,
  `loan_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guarantor`
--

INSERT INTO `guarantor` (`id`, `person_number`, `loan_number`) VALUES
(1, 3, 4),
(2, 4, 4),
(3, 3, 5),
(4, 4, 5),
(5, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `income_type` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `income_type`, `amount`, `date_added`, `added_by`, `description`, `date_modified`) VALUES
(1, 1, 20000, '2016-11-24', 1, 'Annual subscription paid by Cissy  Ge for year 2016', '2016-11-24 10:19:52'),
(2, 1, 20000, '2017-01-08', 1, 'Annual subscription paid by Ronald  Matovu for year 2017', '2017-01-08 17:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `income_sources`
--

CREATE TABLE `income_sources` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income_sources`
--

INSERT INTO `income_sources` (`id`, `name`, `description`) VALUES
(1, 'Annual Subscription', 'This will be the annual subscription for each member'),
(2, 'Shares', 'Shares of each member');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `person_number` int(11) NOT NULL,
  `loan_number` varchar(45) NOT NULL,
  `branch_number` varchar(45) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `loan_type` int(11) NOT NULL,
  `loan_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `loan_end_date` datetime NOT NULL,
  `loan_amount` decimal(15,2) NOT NULL,
  `loan_amount_word` varchar(256) DEFAULT NULL,
  `interest_rate` varchar(45) NOT NULL,
  `expected_payback` decimal(15,2) NOT NULL,
  `daily_default_amount` decimal(15,2) NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `loan_duration` int(11) NOT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `person_number`, `loan_number`, `branch_number`, `active`, `loan_type`, `loan_date`, `loan_end_date`, `loan_amount`, `loan_amount_word`, `interest_rate`, `expected_payback`, `daily_default_amount`, `approved_by`, `loan_duration`, `comments`) VALUES
(1, 2, 'MUGANZIRWAZA-1611240015', 'BR00001', 1, 1, '2016-10-10 10:22:20', '0000-00-00 00:00:00', '8900000.00', 'Eight Million Nine hundred Thousand ', '13', '10057000.00', '20000.00', '1', 1, 'pending approval'),
(2, 2, 'MUGANZIRWAZA-1611241124', 'BR00001', 1, 1, '2016-11-25 09:24:22', '0000-00-00 00:00:00', '560000.00', 'Five hundred Sixty Thousand ', '12', '627200.00', '10000.00', '1', 4, 'Pending confirmation'),
(3, 2, 'MUGANZIRWAZA-1611242200', 'BR00001', 1, 1, '2016-11-09 21:20:10', '0000-00-00 00:00:00', '5600000.00', 'Five Million Six hundred Thousand ', '12', '6272000.00', '120000.00', '1', 1, 'Provided security'),
(4, 2, 'MUGANZIRWAZA-1611242200', 'BR00001', 1, 1, '2016-11-20 00:00:00', '0000-00-00 00:00:00', '1200000.00', 'One Million Two hundred Thousand ', '10', '1320000.00', '12000.00', '1', 1, 'Yours truly'),
(5, 2, 'MUGANZIRWAZA-1611240919', 'BR00001', 1, 1, '2016-11-17 14:44:21', '0000-00-00 00:00:00', '650000.00', 'Six hundred Fifty Thousand ', '12', '728000.00', '9800.00', '1', 1, 'Please avail yourself'),
(6, 7, 'MUGANZIRWAZA-1701080338', 'BR00001', 1, 1, '2017-01-08 00:00:00', '2017-01-15 21:03:59', '300000.00', 'Three hundred Thousand ', '15', '345000.00', '2.00', '1', 7, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `loan_documents`
--

CREATE TABLE `loan_documents` (
  `id` int(11) NOT NULL,
  `loand_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment`
--

CREATE TABLE `loan_repayment` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `branch_number` int(11) NOT NULL,
  `client_number` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL COMMENT 'Loan ID',
  `amount` text NOT NULL,
  `transaction_date` date NOT NULL,
  `comments` text NOT NULL,
  `recieving_staff` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_type`
--

CREATE TABLE `loan_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_type`
--

INSERT INTO `loan_type` (`id`, `name`, `description`) VALUES
(1, 'Development Loan', ''),
(2, 'Land Acquisition', ''),
(3, 'Quick Loan', ''),
(4, 'Land Title Acquisition', '');

-- --------------------------------------------------------

--
-- Table structure for table `mdtransfer`
--

CREATE TABLE `mdtransfer` (
  `id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `date_sent` date NOT NULL,
  `branch` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `bank_branch` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `direction` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `person_number` varchar(45) NOT NULL,
  `branch_number` varchar(45) NOT NULL,
  `member_type` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `added_by` varchar(45) NOT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `person_number`, `branch_number`, `member_type`, `date_added`, `added_by`, `comment`) VALUES
(1, '2', 'BR00001', 1, '2016-11-16', '1', 'New member'),
(2, '3', 'BR00001', 0, '2016-11-24', '1', 'Comments from here'),
(3, '4', 'BR00001', 0, '2016-11-24', '1', 'Cissy buladde sacco'),
(4, '7', 'BR00001', 0, '2017-01-08', '1', 'Registered from muganzirwaza');

-- --------------------------------------------------------

--
-- Table structure for table `membertype`
--

CREATE TABLE `membertype` (
  `1` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membertype`
--

INSERT INTO `membertype` (`1`, `name`, `description`) VALUES
(1, 'Member Only', 'Will only be a member without shares'),
(2, 'Member and Share Holder', 'Member and Has Shares');

-- --------------------------------------------------------

--
-- Table structure for table `nextofkin`
--

CREATE TABLE `nextofkin` (
  `id` int(11) NOT NULL,
  `person_number` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `other_names` varchar(156) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `relationship` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `other_settings`
--

CREATE TABLE `other_settings` (
  `id` int(11) NOT NULL,
  `minimum_balance` bigint(20) NOT NULL,
  `maximum_guarantors` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `other_settings`
--

INSERT INTO `other_settings` (`id`, `minimum_balance`, `maximum_guarantors`) VALUES
(1, 5000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `parish`
--

CREATE TABLE `parish` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subcounty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parish`
--

INSERT INTO `parish` (`id`, `name`, `subcounty_id`) VALUES
(1, 'Kawempe central', 1),
(2, 'Kawempe North', 1);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `title` varchar(8) NOT NULL,
  `person_type` int(11) NOT NULL,
  `person_number` varchar(45) NOT NULL COMMENT 'Based on person Type -- Client/Staff',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `othername` varchar(156) DEFAULT NULL,
  `id_type` varchar(80) NOT NULL,
  `id_number` varchar(80) NOT NULL,
  `gender` varchar(3) NOT NULL,
  `dateofbirth` date NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(156) DEFAULT NULL,
  `postal_address` varchar(156) DEFAULT NULL,
  `physical_address` varchar(156) DEFAULT NULL,
  `occupation` text NOT NULL,
  `photograph` text,
  `comment` text,
  `date_registered` datetime NOT NULL,
  `registered_by` varchar(45) NOT NULL,
  `country` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `county` int(11) NOT NULL,
  `subcounty` int(11) NOT NULL,
  `parish` int(11) NOT NULL,
  `village` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `title`, `person_type`, `person_number`, `firstname`, `lastname`, `othername`, `id_type`, `id_number`, `gender`, `dateofbirth`, `phone`, `email`, `postal_address`, `physical_address`, `occupation`, `photograph`, `comment`, `date_registered`, `registered_by`, `country`, `district`, `county`, `subcounty`, `parish`, `village`) VALUES
(1, 'Mr', 2, 'S161116102242', 'Alfred', 'Platin', 'M', 'passport_no', 'B94994', 'M', '1988-08-08', '0702-771-124', 'mplat84@gmail.com', '', 'Kampala', '', '', 'First user registration', '2016-11-16 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(2, 'Mr', 1, 'M161116200538', 'Brayan', 'Matovu', 'W', 'national_id', '898438948934', 'M', '1987-08-08', '(0701) 108-622', 'mplat84@gmail.com', '36211 Kampala', 'Kampala', 'IT', '', 'New member', '2016-11-16 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(3, 'Mr', 1, 'M241116093854', 'Allan', 'Jesse', '', 'national_id', '8483934', 'M', '1987-03-02', '0702 771-124', 'mplat84@gmail.com', 'Hello there', 'Kampala ', 'Consultancy', '', 'Comments from here', '2016-11-24 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(4, 'Mrs', 1, 'M241116095244', 'Cissy', 'Ge', '', 'passport_no', '8382383', 'F', '1984-01-07', '0702 771-124', 'mplat84@gmail.com', '', '36211 kampala', 'Finance', '', 'Cissy buladde sacco', '2016-11-24 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(5, 'Mr', 2, 'S080117180211', 'Mathias', 'Musoke', '', 'national_id', 'CM89808303939', '1', '1986-09-21', '0700-987-309', 'mmusoke@gmail.com', 'P O Box 34909 Kampala', 'Kitezi complex', '', '', 'Staff credentials accepted', '2017-01-08 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(6, 'Mr', 2, 'S080117181259', 'Leonard', 'Kabuye', '', 'national_id', '37838793893', 'M', '1976-02-08', '0702-711-332', 'mplat84@gmail.com', '', 'kampala', '', '', 'eweewe', '2017-01-08 00:00:00', '1', 1, 1, 1, 1, 1, 1),
(7, 'Mr', 1, 'BFS080117182251', 'Ronald', 'Matovu', '', 'national_id', '67367367363', 'M', '1987-08-08', '0702 771-124', 'freddagates@empire.com', '256', 'kampala', 'IT Consultant', 'img/profiles/IMG_20160901_130726.jpg', 'Registered from muganzirwaza', '2017-01-08 00:00:00', '1', 1, 1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `persontype`
--

CREATE TABLE `persontype` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persontype`
--

INSERT INTO `persontype` (`id`, `name`, `description`) VALUES
(1, 'member', 'Person as Member'),
(2, 'staff', 'Person as staff');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `name` varchar(156) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `description`) VALUES
(1, 'Administrator', NULL),
(2, 'Manager', NULL),
(3, 'Loans Officer', NULL),
(4, 'Supervisor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repaymentduration`
--

CREATE TABLE `repaymentduration` (
  `id` int(11) NOT NULL,
  `name` varchar(156) NOT NULL COMMENT 'Durations for a client to be repaying back the loan -- Weekly, Monthly, ',
  `no_of_days` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repaymentduration`
--

INSERT INTO `repaymentduration` (`id`, `name`, `no_of_days`) VALUES
(1, 'Monthly repayment', 0),
(2, 'Quarterly repayment\r\n', 0),
(3, 'Half year repayment', 0),
(4, 'Annual repayment\r\n', 0),
(5, 'Weekly', 0);

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `id` int(11) NOT NULL,
  `security_type` int(11) NOT NULL,
  `loan_number` varchar(45) NOT NULL,
  `name` varchar(156) NOT NULL,
  `specification` text NOT NULL,
  `date_added` date NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`id`, `security_type`, `loan_number`, `name`, `specification`, `date_added`, `approved_by`, `status`, `comment`) VALUES
(1, 1, '1', 'Land Title 50 X 100', 'Not developed lan', '2016-10-24', '3', 0, 'Land title was approved');

-- --------------------------------------------------------

--
-- Table structure for table `securitytype`
--

CREATE TABLE `securitytype` (
  `id` int(11) NOT NULL,
  `name` varchar(156) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securitytype`
--

INSERT INTO `securitytype` (`id`, `name`, `description`) VALUES
(1, 'Land Title', 'This will be the land title used as security on the loan'),
(2, 'Laptop', 'Laptop security'),
(3, 'Car Log Book', 'Log book details'),
(4, 'Salary ATM Card', 'Salary atm card');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE `shares` (
  `id` int(11) NOT NULL,
  `person_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date_paid` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recorded_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shares`
--

INSERT INTO `shares` (`id`, `person_number`, `amount`, `date_paid`, `recorded_by`) VALUES
(1, 2, 43, '2016-11-29 11:50:41', 1),
(2, 3, 42, '2016-11-29 11:50:41', 1),
(3, 4, 28, '2016-11-29 11:50:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `person_number` varchar(45) NOT NULL,
  `branch_number` varchar(45) NOT NULL,
  `position_id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` text NOT NULL,
  `access_level` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `date_added` date NOT NULL,
  `added_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `person_number`, `branch_number`, `position_id`, `username`, `password`, `access_level`, `status`, `start_date`, `end_date`, `date_added`, `added_by`) VALUES
(1, '1', 'BR00001', 1, 'platin', '807c1c8ea54c81e6167a19275211b2a3', 1, 1, '0000-00-00', NULL, '2016-11-16', '1'),
(2, '5', 'BR00001', 3, 'mmusoke', 'a698aac3a8775508d6a03cb9fa002a1f', 3, 1, '0000-00-00', NULL, '2017-01-08', '1'),
(3, '6', 'BR00001', 4, 'lkabuye', '6dd59a8d3ddd2527963b972c7014b1e9', 2, 1, '0000-00-00', NULL, '2017-01-08', '1');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `description`) VALUES
(1, 'Available ', ''),
(2, 'Taken ', '');

-- --------------------------------------------------------

--
-- Table structure for table `subcounty`
--

CREATE TABLE `subcounty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `county_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcounty`
--

INSERT INTO `subcounty` (`id`, `name`, `county_id`) VALUES
(1, 'Kawempe', 1),
(2, 'Kawempe 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `person_number` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `subscription_year` year(4) NOT NULL,
  `paid_by` varchar(100) NOT NULL,
  `received_by` int(11) NOT NULL,
  `date_paid` date NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `person_number`, `amount`, `subscription_year`, `paid_by`, `received_by`, `date_paid`, `date_modified`) VALUES
(1, 4, 20000, 2016, 'Alfred', 1, '2016-11-24', '2016-11-24 10:19:52'),
(2, 7, 20000, 2017, 'Allan', 1, '2017-01-08', '2017-01-08 17:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `systemaccesslogs`
--

CREATE TABLE `systemaccesslogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_logged_in` datetime NOT NULL,
  `date_logged_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `transaction_type` varchar(45) NOT NULL,
  `branch_number` varchar(45) NOT NULL,
  `person_number` int(45) NOT NULL,
  `amount` varchar(45) NOT NULL,
  `amount_description` varchar(256) NOT NULL,
  `transacted_by` varchar(100) NOT NULL,
  `transaction_date` date NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `comments` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `transaction_type`, `branch_number`, `person_number`, `amount`, `amount_description`, `transacted_by`, `transaction_date`, `approved_by`, `comments`, `date_modified`) VALUES
(1, '1', 'BR00001', 2, '49990', 'Forty Nine Thousand Nine hundred Ninety  Ugandan Shillings Only', 'Alfred', '2016-11-23', '1', 'Kampala', '2016-11-23 09:33:16'),
(2, '2', 'BR00001', 2, '-5000', 'Five Thousand  Ugandan Shillings Only', 'Alfred', '2016-11-23', '1', 'P', '2016-11-23 10:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `deposited_from` int(11) NOT NULL,
  `from_bank_branch` int(11) NOT NULL,
  `from_branch` int(11) NOT NULL,
  `to_branch` int(11) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `amount` text NOT NULL,
  `transfered_by` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `staff_number` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `validity` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `staff_number`, `username`, `password`, `access_level`, `date_created`, `validity`, `status`, `created_by`) VALUES
(1, '1', 'platin', '9e11830101b6b723ae3fb11e660a2123', 2, '2016-10-23 00:00:00', 1, '1', '1'),
(2, '2', 'cmurungi', '2d38c92d23c2f449db7c016c4f7e56e9', 1, '2016-10-24 07:21:40', 1, 'Active', '1 - platin'),
(3, '3', 'bmatovu', '542183e2280fde195b0cd2b2339dabac', 3, '2016-10-24 07:24:18', 1, 'Active', '2 - cmurungi');

-- --------------------------------------------------------

--
-- Table structure for table `village`
--

CREATE TABLE `village` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `village`
--

INSERT INTO `village` (`id`, `name`, `parish_id`) VALUES
(1, 'Kawempe TC', 1),
(2, 'Kawempe Town', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslevel`
--
ALTER TABLE `accesslevel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atmcard`
--
ALTER TABLE `atmcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atmwithdrawal`
--
ALTER TABLE `atmwithdrawal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atm_status`
--
ALTER TABLE `atm_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availablecash`
--
ALTER TABLE `availablecash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankbranch`
--
ALTER TABLE `bankbranch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientpayback`
--
ALTER TABLE `clientpayback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counties`
--
ALTER TABLE `counties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensetypes`
--
ALTER TABLE `expensetypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guarantor`
--
ALTER TABLE `guarantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_sources`
--
ALTER TABLE `income_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_documents`
--
ALTER TABLE `loan_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_type`
--
ALTER TABLE `loan_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdtransfer`
--
ALTER TABLE `mdtransfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membertype`
--
ALTER TABLE `membertype`
  ADD PRIMARY KEY (`1`);

--
-- Indexes for table `nextofkin`
--
ALTER TABLE `nextofkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_settings`
--
ALTER TABLE `other_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parish`
--
ALTER TABLE `parish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persontype`
--
ALTER TABLE `persontype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repaymentduration`
--
ALTER TABLE `repaymentduration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `securitytype`
--
ALTER TABLE `securitytype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_date` (`date_paid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcounty`
--
ALTER TABLE `subcounty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systemaccesslogs`
--
ALTER TABLE `systemaccesslogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslevel`
--
ALTER TABLE `accesslevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `atmcard`
--
ALTER TABLE `atmcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `atmwithdrawal`
--
ALTER TABLE `atmwithdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `atm_status`
--
ALTER TABLE `atm_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `availablecash`
--
ALTER TABLE `availablecash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bankbranch`
--
ALTER TABLE `bankbranch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clientpayback`
--
ALTER TABLE `clientpayback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `counties`
--
ALTER TABLE `counties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expensetypes`
--
ALTER TABLE `expensetypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `guarantor`
--
ALTER TABLE `guarantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `income_sources`
--
ALTER TABLE `income_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `loan_documents`
--
ALTER TABLE `loan_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loan_type`
--
ALTER TABLE `loan_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mdtransfer`
--
ALTER TABLE `mdtransfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `membertype`
--
ALTER TABLE `membertype`
  MODIFY `1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nextofkin`
--
ALTER TABLE `nextofkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `other_settings`
--
ALTER TABLE `other_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `parish`
--
ALTER TABLE `parish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `persontype`
--
ALTER TABLE `persontype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `repaymentduration`
--
ALTER TABLE `repaymentduration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `securitytype`
--
ALTER TABLE `securitytype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subcounty`
--
ALTER TABLE `subcounty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `systemaccesslogs`
--
ALTER TABLE `systemaccesslogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `village`
--
ALTER TABLE `village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
