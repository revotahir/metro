-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 04:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metro`
--

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `catID` int(11) NOT NULL,
  `catName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`catID`, `catName`) VALUES
(1, 'Ivory Knapp'),
(2, 'Brian Taylor');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productName` varchar(200) NOT NULL,
  `productPrice` varchar(20) NOT NULL,
  `productCuisineItem` varchar(200) NOT NULL,
  `productCuisineUpc` varchar(200) NOT NULL,
  `productLength` varchar(200) NOT NULL,
  `productHeight` varchar(200) NOT NULL,
  `productWidth` varchar(200) NOT NULL,
  `productWeight` varchar(200) NOT NULL,
  `productDesp` varchar(2000) NOT NULL,
  `productImage` varchar(2000) NOT NULL,
  `productStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `catID`, `userID`, `productName`, `productPrice`, `productCuisineItem`, `productCuisineUpc`, `productLength`, `productHeight`, `productWidth`, `productWeight`, `productDesp`, `productImage`, `productStatus`) VALUES
(1, 2, 7, 'cake', '43.3', '', '', '', '', '', '', 'k', '', 1),
(2, 1, 2, 'Jillian Copeland', '932', 'Incidunt modi quia ', 'Accusamus ut in illu', '', '', '', '', 'Beatae sit optio ve', '', 1),
(3, 1, 13, 'Adrienne Guerra', '737', 'Qui aut laboris a ar', 'Distinctio Inventor', 'Delectus incididunt', 'Quia qui voluptatem ', 'Veniam aspernatur v', 'Proident ut laborum', 'Quia dolore consecte', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userPass` varchar(200) NOT NULL,
  `userType` tinyint(1) NOT NULL COMMENT '1=admin 2=customer 3=vendor',
  `userStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `userPhone`, `userPass`, `userType`, `userStatus`) VALUES
(1, 'Admin', 'admin@admin.com', '03001234567', 'admin', 1, 1),
(2, 'Vendor', 'Vendor@Vendor.com', '03121122334', 'vendor', 3, 1),
(7, 'linabinuoooooooooooooooooooooooooooooo', 'xihuc@mailinator.com', '+1 (663) 641-2813', '(_jhIjuma#4Nc%D', 3, 1),
(8, 'Customerr', 'Customer@Customer.com', '03333333333', 'customer', 2, 1),
(13, 'wulejydyf', 'sowedykupy@mailinator.com', '+1 (722) 868-3239', 'zv5j+KUnCSbawL0', 3, 1),
(14, 'ziryd', 'rynocyf@mailinator.com', '+1 (716) 726-5622', '7ONj5kO1Kdrvjq&', 3, 1),
(15, 'lytyzaxo', 'kygesice@mailinator.com', '+1 (974) 664-4666', 'k0tfNv9i@77qbBC', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
