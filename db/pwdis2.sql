-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 01:10 PM
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
-- Database: `pwdis2`
--

-- --------------------------------------------------------

--
-- Table structure for table `emergency_hotlines`
--

CREATE TABLE `emergency_hotlines` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_hotlines`
--

INSERT INTO `emergency_hotlines` (`id`, `title`, `number`) VALUES
(2, 'Bureau of FIre Protection', '0495367965'),
(3, 'Philippine National Police', '0495345631'),
(4, 'Los Baños Doctors Hospital and Medical Center', '09063992757'),
(6, 'Los Baños Action Center', '09267170718'),
(7, 'MDRRMO  Los Baños, Laguna', '09772049641');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `message`, `timestamp`) VALUES
(46, 34, 'Welcome', '2024-10-17 05:12:46'),
(47, 42, 'Magandang hapon po', '2024-10-29 08:39:26'),
(49, 45, 'Magandang araw po sainyo', '2024-10-30 07:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `place_accessibility`
--

CREATE TABLE `place_accessibility` (
  `id` int(11) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `wheelchairAccessibleParking` tinyint(1) DEFAULT 0,
  `wheelchairAccessibleEntrance` tinyint(1) DEFAULT 0,
  `wheelchairAccessibleRestroom` tinyint(1) DEFAULT 0,
  `wheelchairAccessibleSeating` tinyint(1) DEFAULT 0,
  `accessibility_level` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place_accessibility`
--

INSERT INTO `place_accessibility` (`id`, `place_id`, `full_name`, `display_name`, `wheelchairAccessibleParking`, `wheelchairAccessibleEntrance`, `wheelchairAccessibleRestroom`, `wheelchairAccessibleSeating`, `accessibility_level`, `created_at`) VALUES
(81, 'ChIJWY7sDLVgvTMRgv-w9yPWaS8', 'Adela San Isidro', 'Freedom Park', 1, 1, 0, 0, 'Partially Accessible', '2024-10-21 00:53:06'),
(82, 'ChIJW5F67N1gvTMRn1Yvcgu3AEs', 'Adela San Isidro', 'Los Baños Mountain and Lake View Park', 1, 1, 0, 0, 'Partially Accessible', '2024-10-21 00:53:27'),
(83, 'ChIJb-7isPxhvTMRq513Jum4Iy0', 'Adela San Isidro', 'RibSarap - Los Baños', 0, 0, 0, 0, 'Not Accessible', '2024-10-21 00:53:37'),
(84, 'ChIJHQ12dthhvTMR2y1ll9FQB20', 'Adela San Isidro', 'The Burger Garage - Los Baños', 0, 0, 0, 0, 'Not Accessible', '2024-10-21 00:53:51'),
(85, 'ChIJhVd9XyhhvTMRlSTDcgFRl4o', 'Adela San Isidro', 'Barangay Lalakay Health Center', 0, 0, 0, 0, 'Not Accessible', '2024-10-21 01:04:14'),
(86, 'ChIJr2kZHr9gvTMRQSjRGstNpzw', 'Adela San Isidro', 'Cheline Estacio Medical Clinic office', 1, 1, 1, 1, 'Highly Accessible', '2024-10-21 01:07:45'),
(87, 'ChIJG_ivwL9gvTMReMC9NVDoCu8', 'Dimas Servio Lim', 'Healthserv Los Baños Medical Center', 1, 1, 0, 0, 'Partially Accessible', '2024-10-24 18:13:47'),
(88, 'ChIJVUDVwexgvTMRE_1D_q0an64', 'Dimas Servio Lim', 'Barangay Mayondon Health Center', 0, 1, 0, 0, 'Partially Accessible', '2024-10-24 18:17:37'),
(89, 'ChIJpzR8Et1gvTMRD0QpyUMm2yU', 'Ester Tandang', 'Los Baños Health Care Center', 1, 1, 0, 0, 'Partially Accessible', '2024-10-28 11:12:39'),
(90, 'ChIJU8F-EblgvTMR86hMa0pCSq0', 'Ester Tandang', 'St. Jude Family Hospital', 1, 1, 0, 0, 'Partially Accessible', '2024-10-28 11:16:08'),
(91, 'ChIJ2xZrBLdhvTMR5shCyOdyirM', 'Ester Tandang', 'Shakey\'s Pizza Parlor', 1, 1, 1, 1, 'Highly Accessible', '2024-10-29 08:30:35'),
(92, 'ChIJ9ziET6FhvTMRDXsPboCt858', 'Ester Tandang', 'Meister\'s Uncorked', 1, 1, 1, 1, 'Highly Accessible', '2024-10-30 19:11:18'),
(93, 'ChIJZ20BEQ9hvTMRdVsjAdE7MSY', 'Ester Tandang', 'Emiliana’s Grill and Restaurant', 1, 1, 0, 1, 'Highly Accessible', '2024-10-30 19:18:51');

-- --------------------------------------------------------

--
-- Table structure for table `private_messages`
--

CREATE TABLE `private_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `place_type` varchar(255) NOT NULL,
  `formatted_address` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `photo_url` varchar(500) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp(),
  `avatar_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `full_name`, `place_id`, `display_name`, `place_type`, `formatted_address`, `review`, `rating`, `photo_url`, `review_date`, `avatar_url`) VALUES
(114, 'Adela San Isidro', 'ChIJ68V7hsJgvTMRVViEc0E-Ync', 'Lety\'s Buko Pie', 'bakery', '4030 National Hwy, Los Baños, Laguna, Philippines', 'Good stuff but not accessible', 3, 'https://places.googleapis.com/v1/places/ChIJ68V7hsJgvTMRVViEc0E-Ync/photos/AdCG2DM91BEvtNaD2f-b9VrmTJq8f-41Rq_6CrXB3qsVUfmyXa1yXiutaZPlUejuPm7iCWQ7KR4EcG350Wy604jsS2nze0bEAEW-a1RQcLZA1QYSvOxXw6wkjMtbnlemJ7Ys_fI00KxcbOJ4s4LNSohz9O_vRBTt9wWFZ0bX/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-16 03:35:14', 'uploads/default_avatar.jpg'),
(117, 'Belinda Tandang', 'ChIJP1ZcBblgvTMRwPOQ2a7rZHQ', 'Bonitos Bar & Restaurant Los Baños', 'restaurant', 'One Bonitos Place, Bangkal St, Los Baños, 4030 Laguna, Philippines', 'Very delicious food, nice and accessible place, very cozy and friendly staffs. Highly recommended ko to. may parking at cr pa para sa PWD!', 5, 'https://places.googleapis.com/v1/places/ChIJP1ZcBblgvTMRwPOQ2a7rZHQ/photos/AdCG2DNhvc1-N0lzp_aT9FCRvDjBagA79FcOZSbuEoYoRCL5e0mJl-BPaiHyWaSjYeAYQUVAVl_ZTkzTHlCepTxqUu4kd3Ivo_QKQ5GS1ugwRpSHl_HUMxQvBEFibN3wgA9rrDeWO-XDEzxFp54NisOR99_OoUwI8W-yt8-c/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-16 10:36:59', 'uploads/avatar_29.jpg'),
(118, 'Belinda Tandang', 'ChIJ2xZrBLdhvTMR5shCyOdyirM', 'Shakey\'s Pizza Parlor', 'restaurant', '57G5+GJ5, National Hwy, Los Baños, Laguna, Philippines', 'Affordable and very accessible restaurant, friendly yung mga staff and malawak yung mga upuan, meron din reserved parking para sa mga PWD at designated restroom and parking.', 5, 'https://places.googleapis.com/v1/places/ChIJ2xZrBLdhvTMR5shCyOdyirM/photos/AdCG2DPBYcIjc0a5ErDFsbmBPsCDTYuFsVvEx4UaOt132KzUgYnHifSenX-pBvUaNtlGs0pJJXTtcjrYJ7GBu1RJpgZpeir38rbVakW_ZZotThK_p2ihQY75GtZdE-7HpylcjzHEifd8PDikYw6y2YXbYIa8qcaCQOXTiQP0/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-16 10:39:51', 'uploads/avatar_29.jpg'),
(119, 'joselito quilloy', 'ChIJEQIO9PphvTMReAIUD49FF7A', 'Jollibee Lopez Ave Los Baños', 'restaurant', 'National Highway, cor Lopez Ave, Los Baños, Laguna, Philippines', 'Maganda dito kumain at mababait ang mga crew... maganda rin ang kanilang cr at mayroon din maayos na parking para sa ating mga may kapansanan', 5, 'https://places.googleapis.com/v1/places/ChIJEQIO9PphvTMReAIUD49FF7A/photos/AdCG2DPIVIeFoKInys3C2k4uDgcBg0UxOWCsCfsKY93p8FIZ2betOLPnX9xsQ8PFf-JzIA-AhczNZs0bjtrTzjgclCAC4Bi9gAhj-TwgPdCTiQr6HwRp1yxBYEUWYxmsIff4wyuZm6LB-3-5l08M-cQ6VXsri5hBfnd_Bz5o/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-16 11:33:41', 'uploads/avatar_31.jpg'),
(120, 'Adela San Isidro', 'ChIJG_ivwL9gvTMReMC9NVDoCu8', 'Healthserv Los Baños Medical Center', 'hospital', '8817 National Hwy, Los Baños, Laguna, Philippines', 'maganda ang mga gamit at puro bago, medyo may kamahalan nga lang. ', 4, 'https://places.googleapis.com/v1/places/ChIJG_ivwL9gvTMReMC9NVDoCu8/photos/AdCG2DOy4yJNDGsHKcjcDSAR2mujVaLG-KvGmNnyh6g3ugeKU8Jq2pSI7WMbqostph4tpoobhc0b8BgrkDEZFK4lwXEGmkK_dXr2QE99j9irbEAx1A9yctOzkQ7J4l4d_uHJTx4TpqBo9cLboHOl-tCDcX7d4KDO8B_G1TJ4/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-21 08:36:07', 'uploads/default_avatar.jpg'),
(121, 'Adela San Isidro', 'ChIJ9ziET6FhvTMRDXsPboCt858', 'Meister\'s Uncorked', 'restaurant', 'Ruby, Umali Subdivision, cor Bulusan St, Los Baños, 4030 Laguna, Philippines', 'Masarap ang mga pagkain at talagang 5 star para sa akin. sobrang komportable lalo na para sa ating mga may kapansanan dahil meron silang reserbang parking, malawak ang entrance at pati narin cr para sa mga pwd.', 5, 'https://places.googleapis.com/v1/places/ChIJ9ziET6FhvTMRDXsPboCt858/photos/AdCG2DPFfY5TRDPR7Wg87jjURPiu0vV4V5U8x_nh06_TX09eK7kE5wg2xxJ_JcKneF6-6BqheZa8usezi56zUiG4pf3zW4_eP11hv7DdZ8NoGGVD8fxH8jAceHEH6FQwVdWOAa0ZMtG-v0rnha9qrUHR0WhwI4uOUgUi8Gbw/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-21 08:37:57', 'uploads/default_avatar.jpg'),
(122, 'Adela San Isidro', 'ChIJR_TpFvRhvTMRfXnsnA97Wxo', 'Jardin de Joie', 'restaurant', '57G2+MPQ, Los Baños, Laguna, Philippines', 'Masarap ang pagkain ngunit walang parking para sa ating pwd, mahihirapan pumasok ang mga wheelchair user at hindi accessible ang entrance, wala rin silang parking para sa ating mga pwd.', 4, 'https://places.googleapis.com/v1/places/ChIJR_TpFvRhvTMRfXnsnA97Wxo/photos/AdCG2DP_459dfUO9wq7g9nchH9dVdHrQY-838rQeQAJ3Zos__PsoZrUYtrtte_TDYNN97LndEnSmZXEI4i0gH9Cjdt-X-cmdkaGuqUNDgq6HVkbM_P4GLUZnFvlkvtX4KUzH0tAZ5tyAtmJEE9P53Hd6glLA_W6AhfBmQEFD/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-21 08:43:21', 'uploads/default_avatar.jpg'),
(123, 'Adela San Isidro', 'ChIJP1ZcBblgvTMRwPOQ2a7rZHQ', 'Bonitos Bar & Restaurant Los Baños', 'restaurant', 'One Bonitos Place, Bangkal St, Los Baños, 4030 Laguna, Philippines', 'Ang sarap ng mga pagkain and must try ang kanila italian pizza, sobrang accessible din ng lugar at malawak ang entrance, ang mga upuan at meron din silang accessible na cr para sa ating mga pwd', 4, 'https://places.googleapis.com/v1/places/ChIJP1ZcBblgvTMRwPOQ2a7rZHQ/photos/AdCG2DPC_oANdiDvvUbm0929lN4L4Wqxxm2c42L9mQCK5JOvjNwtU_ZXxRYOUMEJ_2QIoHUGnUDj5JlIedhW3NtBBoA9HkfCEsrrkuyOsLtLUslA1tN4WVL0JfnRG63BCZWdDDR-jK0mpW-KsnZAP4p9kKVoylSgMHj3p0Li/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-21 09:06:17', 'uploads/default_avatar.jpg'),
(124, 'Ester Tandang', 'ChIJU8F-EblgvTMR86hMa0pCSq0', 'St. Jude Family Hospital', 'hospital', 'Lopez Ave, Los Baños, 4030 Laguna, Philippines', 'ok nmn dto hindi ganon kalaki tulad ng ibang hospital pero mababait ang staff.', 4, 'https://places.googleapis.com/v1/places/ChIJU8F-EblgvTMR86hMa0pCSq0/photos/AdCG2DO-SY86oDxjwwZTB5Nx7zlZFF_V4XYMn-M7FePNorLdPGhLOe-Olk5RNGQnrDbumhoEzPCNrogRWG3w8GnzYHHdCl2zIVagVKv5HRX9njCKpXcPl66eG7Rtqg2A65eZ37sf1mEvO38WmC0ep1j0-TNs7WftNSV4YvFf/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-28 19:18:27', 'uploads/avatar_42.jpg'),
(125, 'Ester Tandang', 'ChIJZ20BEQ9hvTMRdVsjAdE7MSY', 'Emiliana’s Grill and Restaurant', 'restaurant', 'Manila S Rd, Los Baños, 4030 Laguna, Philippines', 'Ang sarap ng pagkain! and sobrang babait ng mga crew, kudos at malawak din ang space meron din reserved parking sakto sating mga PWD', 5, 'https://places.googleapis.com/v1/places/ChIJZ20BEQ9hvTMRdVsjAdE7MSY/photos/AdCG2DMZDMEc9z7E3JPI08hZdnMcxshI8Bs_PpzzH2cVJrC86IOVrsECpheyH_XSZnYgep4kdLzAb_cXL5s5KWEREdXAsZSQbgp6XQG0zDqwIV9ODGyFREPrBUwdFDr-NJv5wEMMjdYin8wyQC1gwThqFuWWHOLLVgxzPjJ9/media?key=AIzaSyBO23kIOUSOKRGYzYoVMbnEMmbriP6IvR8&maxHeightPx=400&maxWidthPx=600', '2024-10-31 03:19:52', 'uploads/avatar_42.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `AdminUserName` varchar(255) NOT NULL,
  `AdminPassword` varchar(255) NOT NULL,
  `AdminEmailId` varchar(255) NOT NULL,
  `Is_Active` int(11) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `AdminUserName`, `AdminPassword`, `AdminEmailId`, `Is_Active`, `CreationDate`, `UpdationDate`) VALUES
(1, 'admin', '$2y$12$u.allDYH5dFtrCHoahvfWewL8KJTQRFaWLtf4DGzOOjprnlRSRzA6', 'jjulsros@gmail.com', 1, '2020-03-27 17:51:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL,
  `Is_Active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Description`, `PostingDate`, `UpdationDate`, `Is_Active`) VALUES
(8, 'Information', 'PWD Related Information', '2024-03-04 13:11:37', NULL, 1),
(9, 'Events', 'Events for PWD in Los Banos, Laguna', '2024-03-04 16:39:11', NULL, 1),
(10, 'Programs', 'Programs for PWDs', '2024-03-04 16:47:15', NULL, 1),
(11, 'PWD Assistance', 'All PWD Assistance Related Posts here.', '2024-09-14 03:37:03', NULL, 1),
(12, 'Learning Materials', 'Online Courses for Persons with Disabilities', '2024-10-20 16:52:24', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcomments`
--

CREATE TABLE `tblcomments` (
  `id` int(11) NOT NULL,
  `postId` char(11) DEFAULT NULL,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `avatar_url` varchar(255) NOT NULL,
  `status` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcomments`
--

INSERT INTO `tblcomments` (`id`, `postId`, `name`, `email`, `comment`, `postingDate`, `avatar_url`, `status`) VALUES
(41, '73', 'Jenn Julian Ros', 'jjulsros@gmail.com', 'salamat po\r\n', '2024-10-17 07:17:39', 'uploads/avatar_23.jpg', '1'),
(42, '75', 'Belinda Tandang', 'belindatandang@gmail.com', 'salamat po sa impormasyon at matagal kona rin pong gustong malaman kung pano nga ba talaga ang 20% na discount\r\n', '2024-10-21 23:55:03', 'uploads/avatar_29.jpg', '1'),
(43, '75', 'Ester Tandang', 'estefatandang@gmail.com', 'salamat naman..', '2024-10-28 11:23:44', 'uploads/avatar_42.jpg', '1'),
(44, '90', 'Julian Ros', 'rosjennjulian@gmail.com', 'Thank ypu po', '2025-08-27 20:33:50', 'uploads/default_avatar.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `PageName` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `Description` longtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `PageName`, `PageTitle`, `Description`, `PostingDate`, `UpdationDate`) VALUES
(1, 'aboutus', 'About PWDIS', '<font color=\"#7b8898\" face=\"Mercury SSm A, Mercury SSm B, Georgia, Times, Times New Roman, Microsoft YaHei New, Microsoft Yahei, å¾®è½¯é›…é»‘, å®‹ä½“, SimSun, STXihei, åŽæ–‡ç»†é»‘, serif\"><span style=\"font-size: 26px;\">This is the official page</span></font><br>', '2018-06-30 18:01:03', '2024-10-17 06:16:31'),
(2, 'contactus', 'Contact Details', '<p><br></p><p><b>Address :&nbsp; LSPU-LB</b></p><p><b>Phone Number : </b>+63 912 9226 929</p><p><b>Email Id : </b>jjulsros@gmail.com</p>', '2018-06-30 18:01:36', '2024-03-20 17:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `tblpostimages`
--

CREATE TABLE `tblpostimages` (
  `id` int(11) NOT NULL,
  `postId` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpostimages`
--

INSERT INTO `tblpostimages` (`id`, `postId`, `image`) VALUES
(70, 53, 'c398c98983525dc90371b298125664d3.jpg'),
(71, 53, 'e57ed4e3671d66711161d04b7128c58e.jpg'),
(72, 53, 'e9bd009a4175f07e52255348d128c908.jpg'),
(73, 53, '9ff5379dc632526fbbc6cd42ade64db5.jpg'),
(74, 53, '1c9ef8303445d81417a0ef07a81116bd.jpg'),
(88, 66, 'a0777f29a4ff166155aa75333a774658.jpg'),
(95, 70, '61e8fc5f76d246364770ccf0cfe2eb59.jpg'),
(96, 70, '639ca7f4a92678a59e18461ad60273c6.jpg'),
(129, 3, '23674e0864d0d945c4b7381fb824b52e.jpg'),
(130, 3, 'adc1d58e58ae9b2a89251f437d29998a.jpg'),
(131, 3, 'bd0e8b5f5bd2f20cf4d6285b0bdf8276.jpg'),
(132, 3, 'ca2490df5b1b787bb2a68334f1d2073c.jpg'),
(133, 55, '17490f6243073e92ffa763b7cb24bfbf.jpg'),
(134, 55, '8a69586e09bc90f537440021e6ad5382.jpg'),
(135, 55, 'a90b497e57030a9a0646bc730a112ea4.jpg'),
(136, 55, '09bd54409df936cea21c0907fe94fd22.jpg'),
(137, 55, '0555bf6cb882947425d90c3c152a1498.jpg'),
(138, 55, '3b877ee4532b5c79ebd1a4990d3500ee.jpg'),
(139, 55, '26ba1d0cd7029e1c8bb32a271fd14114.jpg'),
(140, 55, '2f755138da0bb3b68df6770a177fa6a7.jpg'),
(141, 55, 'f67e25001c9d34a34a86472eb7e36d53.jpg'),
(142, 55, '3ebc22b5c904d5379401cf3c15787725.jpg'),
(143, 55, 'eb3507674317cd4ae998b54086e69ee4.jpg'),
(144, 55, 'bbc24165ddc75ad075c4dcbb68b9a8fc.jpg'),
(145, 2, 'd03bb35aaafd000eee850f5a25d9ac82.jpg'),
(146, 55, '25c9d4f0d5231b0fc8984008a0c0f43c.jpg'),
(147, 55, '256f14017304bbed7c1d47433ece5375.jpg'),
(148, 55, 'c12eb4202ea2ae20f6e59c3a59c8502c.jpg'),
(149, 55, '15bc1ef3d87ab51801fbb8868664611e.jpg'),
(150, 55, '75a9dbb7ab420d991b6b36ff02acbf98.jpg'),
(151, 90, '9f6af1a0e5ec143e711f88410542f3b8.jpg'),
(152, 90, '30197144cba081ab9fcda9a36f39c84f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblposts`
--

CREATE TABLE `tblposts` (
  `id` int(11) NOT NULL,
  `PostTitle` longtext DEFAULT NULL,
  `CategoryId` int(11) DEFAULT NULL,
  `PostDetails` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Is_Active` int(1) DEFAULT NULL,
  `PostUrl` mediumtext DEFAULT NULL,
  `PostImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblposts`
--

INSERT INTO `tblposts` (`id`, `PostTitle`, `CategoryId`, `PostDetails`, `PostingDate`, `UpdationDate`, `Is_Active`, `PostUrl`, `PostImage`) VALUES
(2, 'DSWD Promotes the Rights and Privileges of Persons with Disabilities', 8, '<div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">The Department of Social Welfare and Development (DSWD) reiterates Section 6 of RA 10754 or the \"An Act Expanding the Benefits and Privileges of Persons with Disability,\" wherein “Persons with disability shall be entitled to the <span style=\"font-family: inherit;\"><a tabindex=\"-1\" style=\"color: rgb(56, 88, 152); cursor: pointer; font-family: inherit;\"></a></span>grant of 20% discount and VAT-exemption on the purchase of certain goods and services from all establishments under RA 9442 for their exclusive use, enjoyment or availment. Provided, however, that the purchase of such goods and services from sellers that are not subject to Value Added Tax (VAT) shall be subject to the applicable percentage tax.”</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">For the filing of complaints and other inquiries, you may get in touch with the Persons with Disability Affairs Office (PDAO) under the local government units (LGUs) or the National Council on Disability Affairs (NCDA) through the following:</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Email: council@ncda.gov.ph </div><div dir=\"auto\" style=\"font-family: inherit;\">Telephone: (632) 8932-6422</div><div dir=\"auto\" style=\"font-family: inherit;\">Facebook Page: <span style=\"font-family: inherit;\"><a class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz xt0b8zv x1fey0fg xo1l8bm\" href=\"https://www.facebook.com/nationalcouncilondisabilityaffairs?__cft__[0]=AZW2NTWBQUA-tgdyVEFBHxSv7ijok2jOHW40X1CxV7qfahxUL7li17SOZF7zak5FifTKb4NGEtxnCU-6WhVt9w4JsjM9dJSFiNCNOdvpa6x9rloLy4h2EJ2d4nTuJlel_OhrcEHbZnV4Sz38blCod7XxMdWtHKtkAPrH3ZhzWME6apVsB5VghKU8i0TCX9EUuEM&amp;__tn__=-]K-R\" role=\"link\" tabindex=\"0\" style=\"color: var(--blue-link); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; display: inline; -webkit-tap-highlight-color: transparent; touch-action: manipulation; font-family: inherit;\">https://www.facebook.com/nationalcouncilondisabilityaffairs</a></span> </div><div dir=\"auto\" style=\"font-family: inherit;\">Website: <span style=\"font-family: inherit;\"><a class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz xt0b8zv x1fey0fg\" href=\"https://ncda.gov.ph/?fbclid=IwAR3r60sbgNLaQAB2DbKS3J7NBoA0YdKDy3tbmyX4gFDdRVwhzmhr8YIX4dw\" rel=\"nofollow\" role=\"link\" tabindex=\"0\" target=\"_blank\" style=\"color: var(--blue-link); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; display: inline; -webkit-tap-highlight-color: transparent; touch-action: manipulation; font-family: inherit;\">https://ncda.gov.ph/</a></span> </div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span style=\"font-family: inherit;\"><a class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz xt0b8zv x1fey0fg xo1l8bm\" href=\"https://www.facebook.com/hashtag/bawatbuhaymahalagasadswd?__eep__=6&amp;__cft__[0]=AZW2NTWBQUA-tgdyVEFBHxSv7ijok2jOHW40X1CxV7qfahxUL7li17SOZF7zak5FifTKb4NGEtxnCU-6WhVt9w4JsjM9dJSFiNCNOdvpa6x9rloLy4h2EJ2d4nTuJlel_OhrcEHbZnV4Sz38blCod7XxMdWtHKtkAPrH3ZhzWME6apVsB5VghKU8i0TCX9EUuEM&amp;__tn__=*NK-R\" role=\"link\" tabindex=\"0\" style=\"color: var(--blue-link); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; display: inline; -webkit-tap-highlight-color: transparent; touch-action: manipulation; font-family: inherit;\">#BawatBuhayMahalagaSaDSWD</a></span> <span class=\"x3nfvp2 x1j61x8r x1fcty0u xdj266r xhhsvwb xat24cr xgzva0m xxymvpz xlup9mm x1kky2od\" style=\"display: inline-flex; vertical-align: middle; margin: 0px 1px; height: 16px; width: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"❤️\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t6c/1/16/2764.png\" style=\"object-fit: fill;\"></span></div><div dir=\"auto\" style=\"font-family: inherit;\"><span style=\"font-family: inherit;\"><a class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz xt0b8zv x1fey0fg xo1l8bm\" href=\"https://www.facebook.com/hashtag/personswithdisability?__eep__=6&amp;__cft__[0]=AZW2NTWBQUA-tgdyVEFBHxSv7ijok2jOHW40X1CxV7qfahxUL7li17SOZF7zak5FifTKb4NGEtxnCU-6WhVt9w4JsjM9dJSFiNCNOdvpa6x9rloLy4h2EJ2d4nTuJlel_OhrcEHbZnV4Sz38blCod7XxMdWtHKtkAPrH3ZhzWME6apVsB5VghKU8i0TCX9EUuEM&amp;__tn__=*NK-R\" role=\"link\" tabindex=\"0\" style=\"color: var(--blue-link); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; display: inline; -webkit-tap-highlight-color: transparent; touch-action: manipulation; font-family: inherit;\">#PersonsWithDisability</a></span></div><div dir=\"auto\" style=\"font-family: inherit;\">National Council on Disability Affairs (Government)</div></div>', '2024-03-04 16:44:04', NULL, 1, 'DSWD-Promotes-the-Rights-and-Privileges-of-Persons-with-Disabilities', 'b84953dfc2eb08d90841bac351f995fd.jpg'),
(3, 'Anos PWD Association\'s 1st Foundation Day', 9, '<div class=\"xdj266r x11i5rnm xat24cr x1mh8g0r x1vvkbs x126k92a\" style=\"margin: 0px; overflow-wrap: break-word; white-space-collapse: preserve; color: rgb(5, 5, 5); font-size: 15px;\"><div class=\"xdj266r x11i5rnm xat24cr x1mh8g0r x1vvkbs x126k92a\" style=\"margin: 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"\"><span style=\"font-family: inherit;\">The <b>Anos PWD Association</b> proudly invites everyone to their <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"⭐\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb4/1/16/2b50.png\" style=\"object-fit: fill;\"></span><b>1st Foundation Day</b> <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"⭐\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb4/1/16/2b50.png\" style=\"object-fit: fill;\"></span> with the theme,<b>\"Ang Buhay sa Kabila Ng Kapansanan</b>, <b>Dapat Lakas ng ating Bukas\" </b>on </span><font face=\"Hind Madurai, sans-serif\"><b>April 27, 2024</b></font><font face=\"inherit\"> at the <b>Brgy Anos Covered Court!✨\r\n</b></font><span style=\"font-family: inherit;\">The event will serve as<b> </b>the founding of the organization and also as a fund raising activity. </span></div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"?\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t8c/1/16/1f389.png\" style=\"object-fit: fill;\"></span> Lots of activities are prepared for everyone to enjoy and take part of <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"?\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb7/1/16/1f917.png\" style=\"object-fit: fill;\"></span> Kindly take note of the following prices: </div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\"><b>Bingo Cards</b>- Php 25 each </div><div dir=\"auto\" style=\"font-family: inherit;\"><b>Raffle Tickets </b>- Php 30 each</div><div dir=\"auto\" style=\"font-family: inherit;\"><b>Zumba for a Cause</b>  - Php 30 per person</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\">Also a reminder to kindly bring your own hand fans, water bottles, medicines, and don\'t forget to wear light-colored clothing! <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"?\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tec/1/16/1f455.png\" style=\"object-fit: fill;\"></span><span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"?\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5c/1/16/1faad.png\" style=\"object-fit: fill;\"></span></div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><br></span></div></div></div>', '2024-04-24 23:22:44', '2024-10-27 16:19:15', 1, 'Anos-PWD-Association\'s-1st-Foundation-Day', '563472f0935ba9f3304523831d756d7b.jpg'),
(4, 'National Disability Rights Week', 9, '<div dir=\"auto\" style=\"color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><div dir=\"auto\" style=\"\"><font face=\"Segoe UI Historic, Segoe UI, Helvetica, Arial, sans-serif\">The theme for this year\'s NDRW commemoration is </font><b style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;\">\"PROMOTING INCLUSION</b><b style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;\">: CELEBRATING ABILITIES AND ADVOCATING ACCESS\" </b><font face=\"Segoe UI Historic, Segoe UI, Helvetica, Arial, sans-serif\">reiterating a holistic approach to making the rights real for Persons with Disabilities.</font></div></div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\">PBBM through <b>proclamation 957</b> declared July 17-23 every year as  <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"♥\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tac/1/16/2665.png\" style=\"object-fit: fill;\"></span> NATIONAL DISABILITY RIGHTS WEEK <span class=\"html-span xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xgzva0m xhhsvwb xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; overflow-wrap: break-word; padding: 0px; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" alt=\"♥\" class=\"xz74otr\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tac/1/16/2665.png\" style=\"object-fit: fill;\"></span> (formerly National Disability Prevention &amp; Rehabilitation-NDPR week) heeding the call and clamor from disability rights advocates for the government to shift from medical and charity <span class=\"html-span xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px; font-family: inherit;\"><a tabindex=\"-1\" class=\"html-a xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"color: rgb(56, 88, 152); cursor: pointer; margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px; font-family: inherit;\"></a></span>model to the<b> HUMAN RIGHTS model of disability</b>. This rights-based approach considers persons with disabilities as ʀɪɢʜᴛꜱʜᴏʟᴅᴇʀꜱ while government officials/employees as ᴅᴜᴛʏ ʙᴇᴀʀᴇʀꜱ deviating from the charity model where services and social goods are treated as charity/welfare to the deserving poor, on the other hand, the HUMAN RIGHTS MODEL considers services/assistance as RIGHTS of the individual with disabilities.</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word;\"><div dir=\"auto\" style=\"font-family: inherit;\">The highlights of this significant event were<b> Down Syndrome Got Talent Contest</b>, a message of support and opportunities on an equal basis with others from <b>HON. RUTH MARIANO-HERNANDEZ</b>, and awarding of certificate of recognition for the 3 past presidents of the Laguna Provincial Federation of Persons with Disabilities. sa mga nais pong dumalo, maari pong pumunta sa nabanggit na petsa at lugar maraming salamat po! </div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div></div></div><h2 style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\">Date: July 17-23, 2024</h2><h2 style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\">Lugar kung saan gaganapin: Cultural Center of Laguna</h2><h2 style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><a href=\"https://www.google.com/maps/place/Cultural+Center+of+Laguna/@14.275099,121.4151877,17z/data=!3m1!4b1!4m6!3m5!1s0x3397e3146e27ac8f:0xfb19206cefa5acb6!8m2!3d14.2750938!4d121.4177626!16s%2Fg%2F1hhwdhh0n?entry=ttu&amp;g_ep=EgoyMDI0MTAyMy4wIKXMDSoASAFQAw%3D%3D\" target=\"_blank\" style=\"display: inline-block; padding: 8px 16px; background-color: #007bff; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#007bff\'; this.style.borderColor=\'#007bff\';\">Location</a><br><br></h2><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><br></div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><br></div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><br></div>', '2024-07-14 16:09:56', '2024-10-29 05:50:38', 1, 'National-Disability-Rights-Week', '2151eff91b136cd7dc195075b72fa946.jpg'),
(23, '1,000 Beneficiaries of AKAY ni Sol Xtern Foot Drop', 10, '<p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\">The renowned organization AKAY ni Sol hosted an extraordinary event, the AKAY ni Sol Xtern Foot Drop Event. With the objective of empowering individuals with mobility challenges, the event successfully brought together 1,000 beneficiaries from all over the Philippines. Through a remarkable display of unity and support, this gathering aimed to transform lives and provide a renewed sense of independence to those in need.</p><p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\">Under the meticulous planning and coordination of AKAY ni Sol, the AKAY ni Sol Xtern Foot Drop Event proved to be a milestone in the journey of these deserving beneficiaries. Attendees were treated to a day filled with compassion, resilience, and an unwavering commitment to making a positive impact.</p><p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\">The event kicked off with empowering demonstrations and workshops led by mobility experts. Beneficiaries had the opportunity to learn about innovative techniques and cutting-edge devices designed to enhance their mobility. These workshops were tailored to the unique needs of each, ensuring that they could take away practical knowledge to improve their daily lives.</p><p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\"><br></p><p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br></p><p style=\"padding: 0px; border: none; position: relative; font-family: &quot;Nunito Sans&quot;, sans-serif; color: rgb(95, 94, 94); transition: all 500ms ease 0s; font-size: 18px;\">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/k-Pn7buchBo\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></p>', '2024-03-08 18:11:17', '2024-10-21 00:22:10', 1, '1,000-Beneficiaries-of-AKAY-ni-Sol-Xtern-Foot-Drop', 'd3fca13cc7e777cf4ae142bda31e52e3.jpg'),
(44, 'How to Get PWD ID', 8, '<h2 class=\"wp-block-heading\" id=\"how-to-get-pwd-id\">How To Get PWD ID</h2><p>PWD ID or PWD Card is a useful and beneficial card that you should get if you are a bonafide PWD. The card provides you access not only to certain special privileges but also serves as proof to avail of the numerous discounts provided under the law.&nbsp;</p><h3 class=\"wp-block-heading\" id=\"pwd-id-requirements\">PWD ID Requirements</h3><p>To get a PWD ID, here are what you need to complete:</p><ol><li>Two “1×1” recent ID pictures with the names and signatures or thumb marks at the back of the picture</li><li>One (1)&nbsp;<a href=\"https://filipiknow.net/valid-id-philippines/\" target=\"_blank\" rel=\"noreferrer noopener\" style=\"color: rgb(5, 61, 95);\">Valid ID</a></li><li>Document to confirm the medical or disability condition. You may get the proof of disability in the form of any of the following:</li></ol><ul><li style=\"font-family: &quot;avenir next&quot;, avenir, sans-serif; font-size: medium; background-color: rgb(245, 253, 255);\"><a href=\"https://filipiknow.net/medical-certificate-philippines/\" target=\"_blank\" rel=\"noopener\" style=\"color: rgb(5, 61, 95);\">Medical Certificate</a>&nbsp;from a licensed private or government physician for apparent and non-apparent disability</li><li style=\"font-family: &quot;avenir next&quot;, avenir, sans-serif; font-size: medium; background-color: rgb(245, 253, 255);\">School Assessment from a licensed teacher duly signed by the school principal</li><li style=\"font-family: &quot;avenir next&quot;, avenir, sans-serif; font-size: medium; background-color: rgb(245, 253, 255);\">Certificate of Disability from the head of the business establishment or head of a non-governmental organization</li><li style=\"font-family: &quot;avenir next&quot;, avenir, sans-serif; font-size: medium; background-color: rgb(245, 253, 255);\"><h3 class=\"wp-block-heading\" id=\"how-to-apply-for-pwd-id-a-stepbystep-guide\">How To Apply for PWD ID: A Step-by-Step Guide</h3><p>Getting a PWD ID is pretty straightforward with the following four simple steps:</p><span id=\"ezoic-pub-ad-placeholder-919\" data-method=\"placement-service\" data-ezoic-video-excluded=\"1\"></span><h4 class=\"wp-block-heading\" id=\"1-complete-all-three-requirements\">1. Complete All Three Requirements</h4><p>Gather and complete all the requirements mentioned above.</p><h4 class=\"wp-block-heading\" id=\"2-obtain-the-pwd-registration-or-application-form-pwdrfnbsp\">2. Obtain the PWD Registration or Application Form (PWD-RF)</h4><p>You can get it from any of the following locations:<span style=\"font-weight: bolder;\">&nbsp;</span></p><ul><li>Office of the Mayor</li><li>Office of the Barangay Captain</li><li>National Council on Disability Affairs (NCDA) or its regional counterpart</li><li>DSWD offices</li><li>Participating organizations with Memorandum Agreements with the DOH</li><li>Department of Health (DOH) online registration facility</li></ul><h4 class=\"wp-block-heading\" id=\"3-fill-out-the-pwdrf\">3. Fill Out the PWD-RF</h4><p>There are two ways you can fill out the form:</p><h5 class=\"wp-block-heading\" id=\"a-manual-method\">A. Manual Method</h5><ol><li>Fill out the printed form accurately and completely</li><li>Affix one (1) ID picture on the accomplished form and staple the other. The latter will be used on the actual ID</li><li>Attach a copy of the document confirming your medical or disability condition</li></ol><h5 class=\"wp-block-heading\" id=\"b-online-method\">B. Online Method</h5><ol><li>Access the DOH Philippine PWD Registry System (DOH-PPWDRS) and click the&nbsp;<a href=\"https://pwd.doh.gov.ph/online_applicationadd.php\" target=\"_blank\" rel=\"noreferrer noopener\" style=\"color: rgb(5, 61, 95);\">Online ID Application</a>&nbsp;tab</li><li>Enter completely and accurately all the required PWD registration data</li><li>Print the accomplished form</li><li>Affix one ID picture on the accomplished form, and staple the other</li><li>Attach a copy of the document confirming your medical or disability condition</li></ol><h4 class=\"wp-block-heading\" id=\"4-submit-the-accomplished-pwdrf\">4. Submit the Accomplished PWD-RF</h4><p>Submit the completely filled out form and the attachments to the City or Municipal Mayor or Barangay Captain via the PDAO located in the city/municipality/barangay where you are located.</p><p><span style=\"font-weight: bolder;\">Once submitted, the City or Municipal Mayor or Barangay Captain via the PDAO will do the following:</span></p><ul><li>Check and/or verify the data and document to confirm the disability or medical condition of the applicant</li><li>Assign a PWD number and affix it to the PWD-RF</li><li>Fill out the data required on the ID card</li><li>Issue the ID card to the PWD</li><li>Submit the accomplished PWD-RF and attached requirements to the City or Municipal Social Welfare Development Office for data encoding to the DOH-PPWDRS</li></ul></li></ul><p><br></p><p><br></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:&nbsp;<a href=\"https://filipiknow.net/pwd-benefits-and-pwd-id-application-guide/\">How To Get PWD ID (Plus Guide to PWD Benefits) - FilipiKnow</a></p>', '2024-03-19 11:01:50', '2024-03-19 16:52:57', 1, 'How-to-Get-PWD-ID', '9e49d5e05c6842ec6550b5db4a7e050e.jpg'),
(53, 'ALAMIN: NEW GUIDELINES SA APLIKASYON PARA SA PWD ID', 8, '', '2024-03-19 16:46:09', NULL, 1, 'ALAMIN:-NEW-GUIDELINES-SA-APLIKASYON-PARA-SA-PWD-ID', '6eac2f422a145be8897dab2e436c8498.jpg'),
(55, 'Rescheduled Batch Schedule of Payout sa TULONG PARA SA PWD ni  Cong. Ruth Hernandez', 11, '<p>Narito to po ang listahan ng mga na reschedule para sa payout sa pwd ni Cong. Ruth Hernandez:&nbsp;</p><p><br></p><p><br></p>', '2024-07-21 00:28:18', '2024-10-29 06:34:02', 1, 'Rescheduled-Batch-Schedule-of-Payout-sa-TULONG-PARA-SA-PWD-ni--Cong.-Ruth-Hernandez', '1cf1c2cec9facd1cdf37731398f972b6.jpg'),
(66, 'Cleft Surgical Mission', 10, '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">May kakilala ka ba na mayroong cleft lip or cleft palate?</span><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">Magkakaroon po ng SCREENING sa darating na Agosto 22, 2024 ika-1PM hanggang 4PM sa RHU 1. Ito ay parte ng aktibidad ng Philippine Band of Mercy (PBM) na Libreng Operasyon para sa may mga cleft lip/palate na nakatakdang isagawa sa Agosto 30-31, 2024 sa kanilang Treatment Center sa Quezon City.</span><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">Sa mga nais magpalista, maari po kayong lumapit at mag message rito,&nbsp;&nbsp;</span><a href=\"https://www.facebook.com/PDAOLB\" style=\"font-family: &quot;Arial Black&quot;; background-color: rgb(255, 255, 255);\">PINDUTIN</a></p><p><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span class=\"html-span xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"margin: 0px; overflow-wrap: break-word; padding: 0px; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><a attributionsrc=\"/privacy_sandbox/comet/register/source/?xt=AZVHgPm-_tbzzoisquLis0cPKJMPIbidnZEf5NwK7f7JFe6y0Pv7NUdKwXqkEGwMIrMCT-u13lJFuA9kgZXtZaZLRHz5ztskDW5R8F8OgbifOxDxDRYKN4wtrBYL7tJN6WRiCvnRiKbHD-iwXr8ylXcSeSoynEvIFvj9V9YpH5curuRtSkhmdKAIyMclYwzFr4UsdkeZxLfJUegv1KzejlpFUsvuH3yypVcG8uzvLt_xcv59W77D3tV-yPrHA-pgiBJ8R2uYFurr3-AhD8QM7-wqaCReeZkaDyzoPVnRBx1tjbtlxAngnfYwZDxC6a8mXCBl_tAf5r7gptS_LGBvlSbJX6y6j4mK8I1fI62LDdZO04gp8kVhobXCNV5-oHPbv6mk2LTtEjMtoBCQI7x7w5AN9WLhOdAMz_53F8jNhvWHfdm50bXW8k1n4GKcNCbpWMkjmJvj2hgvToSdwmkphHGstL-GWlsmKQBnNRYQV2vgSIzaJVR-w6pi-gVdEwxAjTr4NW9IREIDQPBmdBZuXq16plpfSCfZvDIhIeA6a6n-v76VtvWG0zpLY4pghYxjthAIJLnbCmzat1Ib2DU-QoAxlUavAhy96hm7moh07m8f-e5zv5XBd2YdD5HpfWV0okhyN7jNVXSgfnCzYqwwXDs-mrbQj8Q3BuWebiR15SmuvMrTwyqF_q4ljnGS_4MOUOJrl3yw-20Gu9J5Z4wj3N7vZMyo02ckATRd8QXcCUwNc6F5_viNyDCO4WurFQQULowjGeJ1oMT9UY6VdvWKAZ66jnxMwJJyFz7YymQjHPBw_1c0LURpEKcjN94Yz8YuXHfpnxw18qNuksu9VdMAkcA85B3F8VALj-60otuTs7-RIokupWXTgFs1E8p2YCDshnUFyKZyECthVPorYuSWsaPsxUQJoWBkwW38eSjgAQEuQkPG52BOS4VXz7aC_Fs4apJg3Pz5nACK3t1PbPI0FmFvthbCcEihWDzc3Oiai5mPlaSfPDPQ1Y_MrztI3tCAvGOP5os4MQUfpwE2Q91zlaaNGzQoOPGnOuogB_B0HgzSpmAMWjt9P9LrrGlP6IGjbaYpKvjEGJQIgE32P00osXEfi6sIDYOQZ2jFbLp9srVenD2Givv6PcA7ITZfiSHGrbf9hWZexmWc-NJVCsHXBUVpJuHOzsuiMUT-DPXPxfnoks4_qpqd5XrG-2BMwbKPUWxWCviO2PxOCKnRzKfcegXowA4-qTPplHoNTa1Kfmap3SllXQlvA_XafJMv612aaDLCvD3y-iVQXA_mzCQtuaaC1q3j6M73_OEDSS0XIDmjXCCCXJcX-KyVRki3g-GDCyQ-l4sxfKYS6JlgC4zSZxAmiwxdI0L2mbUGMAf84d-5Lw\" class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1sur9pj xkrqix3 xzsf02u x1s688f\" href=\"https://www.facebook.com/hashtag/lbmho?__eep__=6&amp;__cft__[0]=AZU8DsVqMsxA86mVwv5CKZwMBHaEU5oKvSjxIoHv8tmUVjxIAo_f5Gmxe0VHJXRbjQtSOEHozsAPQfTzpEeVJq0vx91R-urUIrSlbmR4mERcfaNdk2XpdbXLuO_aqDuweqnC81B-8KEDtWE2yvHfezkujugA0QJSyGjkHPWh_eQDFY4zYdNtD65EmDrMvnyF-FlfjK_r2ZumCVSuoG82kzkR&amp;__tn__=*NK*F\" role=\"link\" tabindex=\"0\" style=\"color: var(--primary-text); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; -webkit-tap-highlight-color: transparent; font-weight: 600; touch-action: manipulation; display: inline; font-family: inherit;\">#LBMHO</a></span><br class=\"html-br\" style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span class=\"html-span xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"margin: 0px; overflow-wrap: break-word; padding: 0px; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><a attributionsrc=\"/privacy_sandbox/comet/register/source/?xt=AZVHgPm-_tbzzoisquLis0cPKJMPIbidnZEf5NwK7f7JFe6y0Pv7NUdKwXqkEGwMIrMCT-u13lJFuA9kgZXtZaZLRHz5ztskDW5R8F8OgbifOxDxDRYKN4wtrBYL7tJN6WRiCvnRiKbHD-iwXr8ylXcSeSoynEvIFvj9V9YpH5curuRtSkhmdKAIyMclYwzFr4UsdkeZxLfJUegv1KzejlpFUsvuH3yypVcG8uzvLt_xcv59W77D3tV-yPrHA-pgiBJ8R2uYFurr3-AhD8QM7-wqaCReeZkaDyzoPVnRBx1tjbtlxAngnfYwZDxC6a8mXCBl_tAf5r7gptS_LGBvlSbJX6y6j4mK8I1fI62LDdZO04gp8kVhobXCNV5-oHPbv6mk2LTtEjMtoBCQI7x7w5AN9WLhOdAMz_53F8jNhvWHfdm50bXW8k1n4GKcNCbpWMkjmJvj2hgvToSdwmkphHGstL-GWlsmKQBnNRYQV2vgSIzaJVR-w6pi-gVdEwxAjTr4NW9IREIDQPBmdBZuXq16plpfSCfZvDIhIeA6a6n-v76VtvWG0zpLY4pghYxjthAIJLnbCmzat1Ib2DU-QoAxlUavAhy96hm7moh07m8f-e5zv5XBd2YdD5HpfWV0okhyN7jNVXSgfnCzYqwwXDs-mrbQj8Q3BuWebiR15SmuvMrTwyqF_q4ljnGS_4MOUOJrl3yw-20Gu9J5Z4wj3N7vZMyo02ckATRd8QXcCUwNc6F5_viNyDCO4WurFQQULowjGeJ1oMT9UY6VdvWKAZ66jnxMwJJyFz7YymQjHPBw_1c0LURpEKcjN94Yz8YuXHfpnxw18qNuksu9VdMAkcA85B3F8VALj-60otuTs7-RIokupWXTgFs1E8p2YCDshnUFyKZyECthVPorYuSWsaPsxUQJoWBkwW38eSjgAQEuQkPG52BOS4VXz7aC_Fs4apJg3Pz5nACK3t1PbPI0FmFvthbCcEihWDzc3Oiai5mPlaSfPDPQ1Y_MrztI3tCAvGOP5os4MQUfpwE2Q91zlaaNGzQoOPGnOuogB_B0HgzSpmAMWjt9P9LrrGlP6IGjbaYpKvjEGJQIgE32P00osXEfi6sIDYOQZ2jFbLp9srVenD2Givv6PcA7ITZfiSHGrbf9hWZexmWc-NJVCsHXBUVpJuHOzsuiMUT-DPXPxfnoks4_qpqd5XrG-2BMwbKPUWxWCviO2PxOCKnRzKfcegXowA4-qTPplHoNTa1Kfmap3SllXQlvA_XafJMv612aaDLCvD3y-iVQXA_mzCQtuaaC1q3j6M73_OEDSS0XIDmjXCCCXJcX-KyVRki3g-GDCyQ-l4sxfKYS6JlgC4zSZxAmiwxdI0L2mbUGMAf84d-5Lw\" class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1sur9pj xkrqix3 xzsf02u x1s688f\" href=\"https://www.facebook.com/hashtag/philbandmission?__eep__=6&amp;__cft__[0]=AZU8DsVqMsxA86mVwv5CKZwMBHaEU5oKvSjxIoHv8tmUVjxIAo_f5Gmxe0VHJXRbjQtSOEHozsAPQfTzpEeVJq0vx91R-urUIrSlbmR4mERcfaNdk2XpdbXLuO_aqDuweqnC81B-8KEDtWE2yvHfezkujugA0QJSyGjkHPWh_eQDFY4zYdNtD65EmDrMvnyF-FlfjK_r2ZumCVSuoG82kzkR&amp;__tn__=*NK*F\" role=\"link\" tabindex=\"0\" style=\"color: var(--primary-text); cursor: pointer; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; -webkit-tap-highlight-color: transparent; font-weight: 600; touch-action: manipulation; display: inline; font-family: inherit;\">#philbandmission</a></span><br></p><br>', '2024-09-13 04:16:49', '2024-10-27 15:55:13', 1, 'Cleft-Surgical-Mission', 'b18f65896cdf4eea2b34c5ac7e2b9ca0.jpg'),
(70, 'National ID Registration - LB', 8, '<blockquote><p>NATIONAL ID REGISTRATION LOS BANOS AREA,&nbsp; according to:<br></p><h2 id=\":R1alaammjabiq9papd5aq:\" class=\"html-h2 x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1vvkbs x1heor9g x1qlqyl8 x1pd3egz x1a2a7pz x1gslohp x1yc453h\" style=\"color: rgb(101, 103, 107); font-size: inherit; font-weight: inherit; margin-top: 4px; margin-bottom: 0px; padding: 0px; overflow-wrap: break-word; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;\"><span class=\"xt0psk2\" style=\"display: inline; font-family: inherit;\"><a attributionsrc=\"/privacy_sandbox/comet/register/source/?xt=AZWFVr23Iw0yx0hrt8nCWeAAt22KO9Jnha9YBqYFKEbpwcQiPdOSkXoT7WsvVfVdCOuF1n17K3ho_hyBh4TDNYiWtQSNc0eM6NeFsJ6YeENfEI3kwJ6t_Bfk5IHyjZhkYgVCwqgRi1BjU_z-Xt2Sscr2lHP1-Ro0_ssytgsrmRSKRO5lFJQX3LegusMukRUlh35w6UN_oheGEWyC9T7y_ZgpatMTf8rKil0Rpw9nhq2UyBbtFznGC5QSaTEYDnq4WHozmUm33dufGvWPqaCpaYMEQ2rQU51DygZEEcXB8yMT09_IsSp3J8dNXAptI28zXUKIDgkvp3iMp6SGjkmo_vhmyE5E8FmJzP1V4AOkcMdfhZ4-oo_MLfopnEm2Q4GZL-RVxpXi4GQOGsybyKoZGNo_A8zKwrgqGiDcDgqBVR2bMqHlFQN3lQd1mYZ0MZQ7cxIlyb4CjPakWuVFzoDi3C0wjenS9CUQe5uZzZxQ1AxdLKZY60VQ-Veo5olHReKStKm77Qk-Gf3i1tyiZsel-4XnsvkXwi1kNMVxPMhbvkszB87vfhhaNckTqJuQN0cFqnmScsdH1bOaGbYIVs4duYUMCj5CyzWbIwJJJ0QEww31TiIa5MYJfP13vskiu2_J9aXTVIudYSy84DAOXZ6JGlr9JmTbP8Hnr8Uctny77QHvK8q7R6QdctkgH0Hq4jIrVBphPs-nH6aCYjtszdpZNc7Qj0LATKn8bJ0OmLT9ziA_vjIa_CeyConz84AOSVFCHbAtvwmX4UhQ8pl1zj_CCHaEVHX4u1s_THE_lqbjK0LW37xMzUDLDknCv2XxVeWEzucZqoYRa-qkaKQ9IshrP79TVBLjIt8wJJJrmeWX3ggqCD0DeXiJWBnf4yTKmb5UT5YkXGg2LhIEgBb3NQj4agGUjCAAtbw8aCIL_PBbZxoeKYH17Klnv8Swj5mndSVlTgmO_m-ynwRXxsqJcnRDJ1nJtsz6cUgVIo2BG9Qv0QWaml8dUIboYjHUanUE8H0e1hp7AdAvTI8hdu80FeEWdoKIzW1wpGNsSWiodHjrwL0E1Q6Fm-ZZSQxAiTfDcWhu11jIV94W7AkFOW1N26L32xniZnxYz9KqDsEacplFjK6QGcKATdmk471uOv-plpJr5vD-BohCkqNNd_gPGHTom1Apm3iCHJgajG4-y79whi7kU-DCES45WXUFFG-Sz9MVDRXPMciod8PmCDjbwKk7IPYZ9C4oD7-3ukSWf9nQKkJcN4V9RJXFrOgQVxe-mOsqhzoo59JmGdf8JtUV51mON7u09ND2rEoUmKcAtXo784McRlrwqib3-TtGK6VwuHzDaNo\" class=\"x1i10hfl xjbqb8w x1ejq31n xd10rxx x1sy0etr x17r0tee x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xt0psk2 xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz x1sur9pj xkrqix3 xzsf02u x1s688f\" href=\"https://www.facebook.com/profile.php?id=61556181343966&amp;__cft__[0]=AZXO_2BfcW8WIv4Kxp1ziF2atpugL_IYSE1vjfWdspT9Q1-3F-rkzxJw8QgvZnfyoZtgHC4BZBx_gnKz9nI-xYHbKH_IqDcm397Eehp0nfoirAW3QS2hRwhF13-cqj_TrN1QRkXA8eUAR6a78uIoKhQD3FiXtJYQfBms3rhHAyv7qw&amp;__tn__=-UC%2CP-R\" role=\"link\" tabindex=\"0\" style=\"color: var(--primary-text); cursor: pointer; text-decoration-line: underline; list-style: none; margin: 0px; text-align: inherit; border-style: none; padding: 0px; border-width: 0px; -webkit-tap-highlight-color: transparent; font-weight: 600; touch-action: manipulation; display: inline; font-family: inherit;\"><span class=\"html-strong xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs x1s688f\" style=\"text-decoration-line: none; margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px;\">Civil Registry Office Los Baños Laguna</span></a></span></h2></blockquote><blockquote></blockquote>', '2024-10-07 22:59:24', '2024-10-21 00:13:36', 1, 'National-ID-Registration---LB', '14a283ccd542554b5cb00c0ea6d7af47.jpg'),
(75, '20% PWD Discount, Puwedeng I Apply sa Group Orders', 8, '<div class=\"xdj266r x11i5rnm xat24cr x1mh8g0r x1vvkbs x126k92a\" style=\"margin: 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Nilinaw ng Department of Justice  na may 20% discount at value-added tax exemption ang mga person with disability  sa group meals kung mismong ang PWD na umorder ang mag-isang kakain nito. <span style=\"font-family: inherit;\">Sa ilalim ng Republic Act No. 10754, entitled ang isang PWD sa diskuwento sa mga restaurant basta para ito sa kanilang \"exclusive use and enjoyment or availment.\"</span></div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">\"(I)n purchase of a group meal which is ideally for food sharing, if it can be clearly determined that it was for the <span class=\"html-span xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px; font-family: inherit;\"><a tabindex=\"-1\" class=\"html-a xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"color: rgb(56, 88, 152); cursor: pointer; margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px; font-family: inherit;\"></a></span>exclusive use, enjoyment or availment of only one person who is a PWD in dine-in transactions, then the 20% discount and VAT exemption should apply to the total amount of the food purchased,\" base sa legal opinion ng DOJ na ipinadala sa National Council on Disability Affairs.</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Pagdating naman sa pagbili ng group meals sa pamamagitan ng online o phone call/SMS transactions, binanggit ng DOJ ang probisyon sa memorandum circular ng Bureau of Internal Revenue.</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">\"The basis of the 20% discount for a senior citizen and person with disability shall be on the amount corresponding to the combination of the most expensive and biggest single serving meal with beverage in a quick service restaurant.\"</div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div><div dir=\"auto\" style=\"font-family: inherit;\"><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/9JcdPPVHLCc\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div><div dir=\"auto\" style=\"font-family: inherit;\">Ctto @News5</div></div>', '2024-10-20 17:35:32', '2024-10-29 06:30:53', 1, '20%-PWD-Discount,-Puwedeng-I-Apply-sa-Group-Orders', '8e9ef17886af0b6b95c3d3b5af5ff31f.jpg'),
(88, 'Deaf Awareness - Tips and Concepts', 12, '<p><span style=\"font-family: Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;\">Understanding how to work with deaf people boosts diversity, equity and inclusion (DEI). This course increases your understanding of the deaf community and the challenges its members face. We explore deaf culture and modes of communication to help you provide a positive perspective on deafness, its social and cultural aspects and the ability of deaf people to make a meaningful difference to society. Sign up to increase your deaf awareness.</span></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"https://alison.com/course/deaf-awareness-tips-and-concepts\" target=\"_blank\" style=\"display: inline-block; padding: 5px 10px; font-size:12px; background-color: #161C27; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#161C27\'; this.style.borderColor=\'#007bff\';\">View Course</a><br></p>', '2024-10-23 16:56:11', '2024-10-29 07:59:23', 1, 'Deaf-Awareness---Tips-and-Concepts', 'f8232c877fa1143cbd0e6318b892c6c4.jpg'),
(89, 'Free Cleft Lip and Cleft Palate Operation', 10, '<div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span style=\"font-family: inherit;\">Para sa mga nagnanais magpaopera ng kanilang cleft palate, ang Moral Development Office sa pakikipagtulungan ng </span><span class=\"html-span xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x1hl2dhg x16tdsg8 x1vvkbs\" style=\"font-family: inherit; margin: 0px; text-align: inherit; overflow-wrap: break-word; padding: 0px;\"></span><span style=\"font-family: inherit;\">Philippine Band of Mercy ay muling magsasagawa ng libreng operasyon sa Gen. Cailles Memorial District Hospital, Pakil, Laguna. Ito ay para sa mga sanggol edad anim na buwan hanggang sa mga may edad na 18.</span><br></div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Para sa lahat ng interesado, narito ang mga petsa na dapat tandaan:</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Screening Date: October  3, 2024 l 8:00 AM</div><div dir=\"auto\" style=\"font-family: inherit;\">Final Screening Date:  October 10, 2024 l 8:00 AM</div><div dir=\"auto\" style=\"font-family: inherit;\">Operation Date: October 11, 2024 l 8:00 AM</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\">Para sa karagdagang impormasyon, maaari kayong tumawag sa tanggapan ng Moral Development Office  #524862 loc 517 | 0998 965 1334 | 0997 563 7502 at hanapin si Ms. Rowena M. Durante.</div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div><div dir=\"auto\" style=\"font-family: inherit;\"><a href=\"https://www.facebook.com/photo/?fbid=1092147948936603&amp;set=a.358688498949222https://www.facebook.com/photo/?fbid=1092147948936603&amp;set=a.358688498949222\" target=\"_blank\" style=\"display: inline-block; padding: 8px 16px; background-color: #007bff; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#007bff\'; this.style.borderColor=\'#007bff\';\">View Here</a></div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div><div dir=\"auto\" style=\"font-family: inherit;\"><br></div></div>', '2024-09-30 17:21:18', '2024-10-29 06:05:21', 1, 'Free-Cleft-Lip-and-Cleft-Palate-Operation', 'd4719bb5856b76e04a17393e1d411275.jpg');
INSERT INTO `tblposts` (`id`, `PostTitle`, `CategoryId`, `PostDetails`, `PostingDate`, `UpdationDate`, `Is_Active`, `PostUrl`, `PostImage`) VALUES
(90, 'The Multiverse of ADHD', 9, '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px; white-space-collapse: preserve;\">To those who want to listen, watch their live and how they talk about how ADHD affects our lives and its manifestation in every individual. ADHD is not just one group of similar symptoms. It can be really different for all of us.</span></p><p><b style=\"color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\">DATE: </b><span style=\"color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\">October 16, 2024</span></p><p><b style=\"color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\">TIME: </b><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px; white-space-collapse: preserve;\">8PM</span></p><p style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space-collapse: preserve;\"><b>WHERE: </b>Facebook live &amp; TikTok live. </p><p><font color=\"#050505\" face=\"Segoe UI Historic, Segoe UI, Helvetica, Arial, sans-serif\"><span style=\"font-size: 15px; white-space-collapse: preserve;\"><b>Link Below</b></span></font></p><div dir=\"auto\" style=\"\"><a href=\"https://www.facebook.com/ADHDSOCPHILS\" target=\"_blank\" style=\"display: inline-block; padding: 5px 10px; font-size:12px; background-color: #161C27; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#161C27\'; this.style.borderColor=\'#007bff\';\">View</a></div>', '2024-10-29 06:16:54', '2024-10-30 11:57:48', 1, 'The-Multiverse-of-ADHD', '07ccdf07ec7e6492dae71ce55a4eef0e.jpg'),
(93, 'Promoting Inclusion: Accessible Online Learning System', 12, '<p style=\"text-align: center;\"><span style=\"font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, &quot;Liberation Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: large;\">Online courses on disability are an excellent way to learn about the challenges faced by people with disabilities and how to create a more inclusive society. These courses cover various topics, from disability awareness and etiquette to accommodations and support units for the needs of Persons With Disability Affairs Office (PDAO) personnel. #InclusiveLearning #KalingangNCDA</span></p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<a href=\"https://ncdacourses.online/index.php?\" target=\"_blank\" style=\"display: inline-block; padding: 5px 10px; font-size:12px; background-color: #161C27; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#161C27\'; this.style.borderColor=\'#007bff\';\">View Course</a><br></p><p></p><h3><br></h3><br><p></p>', '2024-10-20 16:57:31', '2024-10-29 07:57:56', 1, 'Promoting-Inclusion:-Accessible-Online-Learning-System', '5f122f6c582fba80230140950932a894.webp'),
(98, 'Livelihood Training and Entrepreneurship for Persons with Disabilities', 10, '<p><span style=\"color: rgb(5, 5, 5); font-family: Calibri, &quot;sans-serif&quot;; font-size: 16px; text-align: justify;\">Governor Ramil L. Hernandez and Congresswoman Ruth M. Hernandez fully supported the free special livelihood trainings for Laguna’s Persons with Disabilities (PWDs) that will be held at the Laguna Sports Complex in Brgy. Bubukal, Sta. Cruz Laguna.&nbsp;</span></p><p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px; white-space-collapse: preserve;\">The program focuses on different skill sets, including dishwashing liquid, fabric conditioner, powder detergent, rug making, candle making, paper bag making, and beaded jewelry. The training was designed to empower individuals, particularly those with disabilities, to develop sustainable livelihood opportunities.</span><span style=\"color: rgb(5, 5, 5); font-family: Calibri, &quot;sans-serif&quot;; font-size: 16px; text-align: justify;\"></span></p><p><b><span style=\"color: rgb(5, 5, 5); font-family: Calibri, &quot;sans-serif&quot;; font-size: 16px; text-align: justify;\">Date: 21 October 2024.<br></span></b><b><span style=\"color: rgb(5, 5, 5); font-family: Calibri, &quot;sans-serif&quot;; font-size: 16px; text-align: justify;\">Location: Laguna Sports Complex</span></b></p><p><a href=\"https://www.google.com/maps/place/Laguna+Sports+Complex/@14.2550864,121.4025746,17z/data=!3m1!4b1!4m6!3m5!1s0x3397e2febc577015:0x80b789ec367dfb7b!8m2!3d14.2550812!4d121.4051495!16s%2Fg%2F1hm49hs3g?entry=ttu&amp;g_ep=EgoyMDI0MTAyMy4wIKXMDSoASAFQAw%3D%3D\" target=\"_blank\" style=\"display: inline-block; padding: 5px 10px; font-size:12px; background-color: #161C27; color: #ffffff !important; text-decoration: none; border-radius: 4px; margin: 4px; border: 1px solid #007bff; font-weight: 500; transition: all 0.3s ease;\" onmouseover=\"this.style.backgroundColor=\'#0b5ed7\'; this.style.borderColor=\'#0a58ca\';\" onmouseout=\"this.style.backgroundColor=\'#161C27\'; this.style.borderColor=\'#007bff\';\">View Location</a><span style=\"color: rgb(5, 5, 5); font-family: Calibri, &quot;sans-serif&quot;; font-size: 16px; text-align: justify;\"><br></span></p>', '2024-10-20 06:02:21', '2024-10-29 07:51:16', 1, 'Livelihood-Training-and-Entrepreneurship-for-Persons-with-Disabilities', 'c8bec6a3eb2101c9285d8afc6929fa3f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `unread_messages`
--

CREATE TABLE `unread_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `last_message_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `title`, `description`, `file_name`, `file_path`, `date_created`) VALUES
(38, 'RESUME', 'HAHAHA', 'Resume-RosJ.pdf', '/uploaded_files/Resume-RosJ.pdf', '2025-08-28 04:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Barangay` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `disability_type` varchar(255) DEFAULT NULL,
  `Gender` enum('Male','Female','Others') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `avatar_url` varchar(255) NOT NULL DEFAULT 'uploads/default_avatar.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FirstName`, `LastName`, `Barangay`, `Email`, `username`, `password`, `disability_type`, `Gender`, `date_of_birth`, `avatar_url`) VALUES
(28, 'Adela', 'San Isidro', 'Bayog', 'sanisidroadela@gmail.com', 'adelasanisidro', '$2y$10$MYztohpRX7NAPNcaMEUmQeH3F8lglWJFr8lnOsZLDtaLVBTSpX.HS', 'Speech and Language Impairment', 'Female', '1968-01-15', 'uploads/default_avatar.jpg'),
(29, 'Belinda', 'Tandang', 'Lalakay', 'belindatandang@gmail.com', 'belindatandang01', '$2y$10$BcN6D2KNOgUujcq2lHo9XO.ogD/qQisq8v4XN5nPOLS0oEYYaw5XS', 'Speech and Language Impairment', 'Female', '1973-11-28', 'uploads/avatar_29.jpg'),
(32, 'Melinda', 'Evangelista', 'Lalakay', 'melindaevangelista@gmail.com', 'melindaevangelista', '$2y$10$QMHtqbEOPbQPceOTyefCJu1uqBH2AzUaO6ai8pDqaB1zbXG8JkA6K', 'Physical Disability', 'Female', '1973-09-21', 'uploads/default_avatar.jpg'),
(42, 'Ester', 'Tandang', 'Tadlac', 'estefatandang@gmail.com', 'estertandang', '$2y$10$I7KVYQqW.oON9MWEwMsadeP1OmfOQcWlJtmCBnwVhxDudnKe5fmre', 'Physical Disability', 'Female', '1965-06-21', 'uploads/avatar_42.jpg'),
(44, 'Dimas Servio', 'Lim', 'San Antonio', 'dimaslim@gmail.com', 'dimaslim', '$2y$10$2my0zYhYeZijVkqWnhneC.EqL2KHz37smnROggmnIkOShZupzJ67m', 'Speech and Language Impairment', '', '1967-05-13', 'uploads/avatar_44.jpg'),
(45, 'Romulo', 'Torio', 'Tuntungin-Putho', 'romulotorio@gmail.com', 'romulotorio', '$2y$10$vjUNsNFuhKEAPq6ARoUUaOA.Om6H5tWDm/1Q2aBDCu3yZW3KJ/.IS', 'Deaf or Hard of Hearing', '', NULL, 'uploads/avatar_45.jpg'),
(46, 'Jenn Julian', 'Ross', 'Bayog', 'jjulsros@gmail.com', 'jjuliarns', '$2y$10$pHaTy/sgOPMrbMiNNuD/dulBKREpwAcNKi8qMDE/0nTu7AsCjN3p2', 'Physical Disability', '', NULL, 'uploads/default_avatar.jpg'),
(47, 'Julian', 'Ros', 'San Antonio', 'rosjennjulian@gmail.com', 'jjulsros', '$2y$10$KbbqO8UKqtfMKhLmZf1zyO95VQgEX.sds78KaO7MT1HcBHMryK7RS', 'Cancer(RA 11215)', '', NULL, 'uploads/default_avatar.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emergency_hotlines`
--
ALTER TABLE `emergency_hotlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`user_id`);

--
-- Indexes for table `place_accessibility`
--
ALTER TABLE `place_accessibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `private_messages`
--
ALTER TABLE `private_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `private_messages_ibfk_1` (`sender_id`),
  ADD KEY `private_messages_ibfk_2` (`receiver_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcomments`
--
ALTER TABLE `tblcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpostimages`
--
ALTER TABLE `tblpostimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `tblposts`
--
ALTER TABLE `tblposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emergency_hotlines`
--
ALTER TABLE `emergency_hotlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `place_accessibility`
--
ALTER TABLE `place_accessibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `private_messages`
--
ALTER TABLE `private_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblcomments`
--
ALTER TABLE `tblcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpostimages`
--
ALTER TABLE `tblpostimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `tblposts`
--
ALTER TABLE `tblposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `unread_messages`
--
ALTER TABLE `unread_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `private_messages`
--
ALTER TABLE `private_messages`
  ADD CONSTRAINT `private_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `private_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblpostimages`
--
ALTER TABLE `tblpostimages`
  ADD CONSTRAINT `tblpostimages_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `tblposts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unread_messages`
--
ALTER TABLE `unread_messages`
  ADD CONSTRAINT `unread_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `unread_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
