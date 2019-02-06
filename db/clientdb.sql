-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2019 at 11:08 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clientdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `mailing_address` varchar(1000) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `membership_type` varchar(100) NOT NULL,
  `membership_expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `address`, `mailing_address`, `phone_number`, `membership_type`, `membership_expiry_date`) VALUES
(1, 'Jack', 'Liu', '4 Tool Street, Loius Park, 2989 NSW', '4 Tool Street, Loius Park, 2989 NSW', '0408987767', 'Gold', '2019-02-21'),
(2, 'Less', 'Paul', '30 Lood street, BH', '30 Lood street, BH', '0496876786', 'Gold', '2019-02-15'),
(3, 'Klaus', 'Lam', '8 Cross road, Leod Ct, London, UK', '8 Cross road, Leod Ct, London, UK', '789778393783', 'Silver', '2019-06-21'),
(5, 'Tom', 'Jerry', '3 link st, SU', '3 link st, SU', '45887898767', 'Platinum', '2019-02-27'),
(7, 'Mike', 'Haris', '3 kurt st', '', '9809789870889', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
