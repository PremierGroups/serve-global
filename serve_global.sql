-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 09:19 AM
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
-- Database: `serve_global`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverImage` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint(20) DEFAULT '0',
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `partner_id`, `category_id`, `description`, `coverImage`, `slug`, `views`, `lastUpdated`, `dateCreated`) VALUES
(3, 'News three forum edit twice', 0, 19, '<p><span style=\"color: rgb(96, 96, 96); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" text-align:=\"\" center;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua. Ut enim ad minim</span></p><p><span style=\"color: rgb(96, 96, 96); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" text-align:=\"\" center;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua. Ut enim ad minim</span></p><p><span style=\"color: rgb(96, 96, 96); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" text-align:=\"\" center;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua. Ut enim ad minim</span></p><p><span style=\"color: rgb(96, 96, 96); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" text-align:=\"\" center;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua. Ut enim ad minim Edited!</span></p><p>                                                            </p>                                                                                                                                                                                                                            ', '20052020211010_56659877_422620291876004_5481447042242838528_n.jpg', 'news-threefourm', 0, '2020-06-09 09:29:38', '2020-05-20 21:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment`
--

CREATE TABLE `blog_comment` (
  `commentId` bigint(20) NOT NULL,
  `blogId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `coverImage` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `slug`, `description`, `coverImage`, `dateCreated`) VALUES
(5, 'Blood Donation', 2, 'tradition', 'Updated Category Description.....', 'http://localhost/vtraining/assets/images/categories/1.jpg', '2019-05-02 16:45:14'),
(9, 'Tutorial class for students', 3, 'women', '', 'http://localhost/vtraining/images/16_02_2020_09_44_53_Annotation 2019-08-30 142842.png', '2019-05-02 16:46:53'),
(12, 'Game Development', NULL, 'game-development', '', NULL, '2020-02-23 23:50:48'),
(13, 'Data Science', NULL, 'data-science', '', NULL, '2020-02-23 23:51:00'),
(14, 'AI', NULL, 'ai', '', NULL, '2020-02-23 23:51:07'),
(15, 'Database', NULL, 'database', '', NULL, '2020-03-17 09:45:35'),
(16, 'CMS', NULL, 'cms', '', 'http://localhost/vtraining/assets/images/categories/1.jpg', '2020-03-20 13:34:07'),
(18, 'House repairing of Elders and poor people', 2, 'humanitarian-service', '', 'http://localhost/vtraining/images/16_02_2020_09_16_21_build1.png', '2020-05-10 15:04:48'),
(19, 'School feeding ', 3, 'school-feeding', '', '', '2020-05-12 09:45:47'),
(20, 'Care & Support for People living with HIV/AIDS', 4, 'care-support-for-people-living-with-hiv-aids', '', '', '2020-05-12 09:46:19'),
(21, 'Care & Support for Orphans ', 4, 'care-support-for-orphans', '', '', '2020-05-12 09:46:51'),
(22, 'Care & Support for older people', 4, 'care-support-for-older-people', '', '', '2020-05-12 09:47:10'),
(23, 'Care & Support for People with Disability', 4, 'care-support-for-people-with-disability', '', '', '2020-05-12 09:50:06'),
(24, 'Care & Support for Street children ', 4, 'care-support-for-street-children', '', '', '2020-05-12 09:50:30'),
(25, 'Donation of cloths ', 5, 'donation-of-cloths', '', '', '2020-05-12 09:51:01'),
(26, 'Donation of school materials', 5, 'donation-of-school-materials', '', '', '2020-05-12 09:51:46'),
(27, 'Donation of books / including out of school setting ', 5, 'donation-of-books-including-out-of-school-setting', '', '', '2020-05-12 09:52:09'),
(28, 'Donation of medical equipment', 5, 'donation-of-medical-equipment', '', '', '2020-05-12 09:52:29'),
(29, 'Long or short term professional training ', 6, 'long-or-short-term-professional-training', '', '', '2020-05-12 09:52:58'),
(30, 'Computer training ', 6, 'computer-training', '', '', '2020-05-12 09:53:19'),
(31, 'Art training', 6, 'art-training', '', '', '2020-05-12 09:53:51'),
(32, 'Different Sport training', 6, 'different-sport-training', '', '', '2020-05-12 09:54:56'),
(33, 'Different Technical training', 6, 'different-technical-training', '', '', '2020-05-12 09:55:30'),
(34, 'Emergency situation volunteering service', 7, 'emergency-situation-volunteering-service', '', '', '2020-05-12 09:56:05'),
(35, 'Forestation ', 8, 'forestation', '', '', '2020-05-12 09:57:34'),
(36, 'City cleaning', 8, 'city-cleaning', '', '', '2020-05-12 09:57:52'),
(37, 'Gardening  ', 8, 'gardening', '', '', '2020-05-12 09:58:31'),
(38, 'Voluntary road traffic ', 9, 'voluntary-road-traffic', '', '', '2020-05-12 09:58:55'),
(39, 'Outdoors', 10, 'outdoors', '', '', '2020-05-12 09:59:51'),
(40, 'Workout', 10, 'workout', '', '', '2020-05-12 10:02:21'),
(41, 'Swimming', 10, 'swimming', '', '', '2020-05-12 10:02:48'),
(42, 'Movies', 11, 'movies', '', '', '2020-05-12 10:03:45'),
(43, 'Plays', 11, 'plays', '', '', '2020-05-12 10:04:04'),
(44, 'Sports', 11, 'sports', '', '', '2020-05-12 10:04:27'),
(45, 'Music', 11, 'music', '', '', '2020-05-12 10:04:47'),
(46, 'Cards/Games', 11, 'cards-games', '', '', '2020-05-12 10:05:07'),
(47, 'Sewing/Quilting', 12, 'sewing-quilting', '', '', '2020-05-12 10:05:28'),
(48, 'Jewelry Making', 12, 'jewelry-making', '', '', '2020-05-12 10:05:46'),
(49, 'Photography', 12, 'photography', '', '', '2020-05-12 10:06:09'),
(50, 'Drawing/Painting', 12, 'drawing-painting', '', '', '2020-05-12 10:06:50'),
(51, 'Card Making', 12, 'card-making', '', '', '2020-05-12 10:07:13'),
(52, 'Writing', 13, 'writing', '', '', '2020-05-12 10:07:54'),
(53, 'Meetings', 13, 'meetings', '', '', '2020-05-12 10:08:09'),
(54, 'Worship', 13, 'worship', '', '', '2020-05-12 10:08:26'),
(55, 'Budgeting', 14, 'budgeting', '', '', '2020-05-12 10:08:44'),
(56, 'Financial Planning', 14, 'financial-planning', '', '', '2020-05-12 10:09:42'),
(57, 'Grant Writing/Fundraising', 14, 'grant-writing-fundraising', '', '', '2020-05-12 10:09:59'),
(58, 'Legislative Issues', 15, 'legislative-issues', '', '', '2020-05-12 10:10:15'),
(59, 'Community Organizing', 15, 'community-organizing', '', '', '2020-05-12 10:10:35'),
(60, 'Graphic Design', 16, 'graphic-design', '', '', '2020-05-12 10:11:02'),
(61, 'Public Speaking', 16, 'public-speaking', '', '', '2020-05-12 10:11:22'),
(62, 'Marketing', 16, 'marketing', '', '', '2020-05-12 10:11:36'),
(63, 'Computer Programming', 17, 'computer-programming', '', '', '2020-05-12 10:11:52'),
(64, 'Computer Instruction', 17, 'computer-instruction', '', '', '2020-05-12 10:12:12'),
(65, 'Videography', 17, 'videography', '', '', '2020-05-12 10:12:40'),
(66, 'Data Entry', 18, 'data-entry', '', '', '2020-05-12 10:12:55'),
(67, 'Filing', 18, 'filing', '', '', '2020-05-12 10:13:06'),
(68, 'Answering Phones', 18, 'answering-phones', '', '', '2020-05-12 10:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `region_id`, `date_created`) VALUES
(1, 'Addis Ababa', 1, '2020-05-01 11:47:36'),
(4, 'Gonder', 2, '2020-05-01 12:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(132) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ethiopia',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_id`, `name`, `email`, `country`, `date_created`) VALUES
(4, 'cus_HR5VOYzo1xIb4F', 'Aemiro Mekete', 'aemiromekete12@gmail.com', 'Ethiopia', '2020-06-09 22:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `customer_id`, `amount`, `description`, `status`, `anonymous`, `date_created`) VALUES
(11, 'cus_HR5VOYzo1xIb4F', 20000, 'desc1', 'succeeded', 0, '2020-06-09 22:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverImage` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint(20) DEFAULT '0',
  `dueDate` date DEFAULT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `category_id`, `description`, `coverImage`, `slug`, `location`, `views`, `dueDate`, `lastUpdated`, `dateCreated`) VALUES
(2, 'Event 3', '5,19,21', '<span style=\"color: rgb(96, 96, 96); font-family: \"Open Sans\", sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua....Â </span><span style=\"color: rgb(96, 96, 96); font-family: \"Open Sans\", sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua....Â </span><span style=\"color: rgb(96, 96, 96); font-family: \"Open Sans\", sans-serif;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua....</span>                                                ', '01062020094755_WIN_20190724_16_53_53_ProFinalEdited.jpg', 'event-3', 'Addis Ababa', 0, '2020-06-26', '2020-06-01 08:11:05', '2020-06-01 10:47:55'),
(3, 'Event 4', '9', 'Event four Description', '09062020120947_56603101_382243032622013_2737672095033982976_n.jpg', 'event-4', 'Gonder, Ethiopia', 0, '2020-06-30', '2020-06-09 10:09:47', '2020-06-09 13:09:47'),
(4, 'Event 5 Edited', '9', 'Sample desc                                                ', '09062020231640_WIN_20200527_11_13_59_Pro.jpg', 'event-5', 'Addis Ababa', 0, '2020-06-11', '2020-06-09 21:17:19', '2020-06-10 00:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `event_comment`
--

CREATE TABLE `event_comment` (
  `commentId` bigint(20) NOT NULL,
  `eventId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `sender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `caption`, `path`, `dateCreated`) VALUES
(2, 'Gallery Four', '20052020224951_fees.png', '2020-05-20 22:35:53'),
(3, 'á‹µá‰­á‹µ á‰­áŠ­áŒáŒ…áˆ­áˆ…', '02062020193619_56659877_422620291876004_5481447042242838528_n.jpg', '2020-06-02 20:36:19'),
(4, 'Gallery Foury Edit', '02062020193658_56603101_382243032622013_2737672095033982976_n.jpg', '2020-06-02 20:36:58'),
(5, 'Gallery Foury Edit', '02062020193717_53439750_2301082016608617_6527721090096037888_n.jpg', '2020-06-02 20:37:17'),
(6, 'Gallery Foury Edit', '02062020193731_55489182_2141641592584205_7324952898104721408_n.jpg', '2020-06-02 20:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `main_category`
--

CREATE TABLE `main_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_category`
--

INSERT INTO `main_category` (`id`, `name`, `is_mandatory`, `date_created`) VALUES
(2, 'Humanitarian Service', 1, '2020-05-10 13:53:48'),
(3, 'Social Service', 1, '2020-05-10 13:56:13'),
(4, 'Care and Support', 1, '2020-05-10 14:06:26'),
(5, 'Charity', 1, '2020-05-12 08:57:46'),
(6, 'Professional Volunteer Service', 1, '2020-05-12 08:58:09'),
(7, 'Emergency Volunteering Service', 1, '2020-05-12 08:58:40'),
(8, 'Environment protection ', 1, '2020-05-12 08:59:02'),
(9, 'Road trafficking', 1, '2020-05-12 09:36:40'),
(10, 'Recreation', 0, '2020-05-12 09:37:24'),
(11, 'Entertainment', 0, '2020-05-12 09:37:44'),
(12, 'Arts & Crafts', 0, '2020-05-12 09:38:21'),
(13, ' Organizing parties ', 0, '2020-05-12 09:38:59'),
(14, 'Administrative ', 0, '2020-05-12 09:39:19'),
(15, 'Outreach/Advocacy ', 0, '2020-05-12 09:39:34'),
(16, 'Public Relations', 0, '2020-05-12 09:40:02'),
(17, 'Technical Skills ', 0, '2020-05-12 09:40:22'),
(18, 'Office/Clerical', 0, '2020-05-12 09:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone1` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `region` int(11) DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ethiopia',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `can_create` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`id`, `name`, `slug`, `email`, `phone1`, `phone2`, `fax`, `website`, `logo`, `facebook`, `twitter`, `instagram`, `telegram`, `user_id`, `parent_id`, `city`, `region`, `country`, `enabled`, `can_create`, `date_created`, `last_updated`) VALUES
(3, 'Serve Global Edit', 'serve-global', 'aemiromekete12@gmail.com', '+15768896798', NULL, NULL, 'http://serveglobal.org', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 'United States', 0, 1, '2020-05-06 10:45:18', '2020-05-09 05:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resetSelector` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resetToken` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resetExpires` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `resetSelector`, `resetToken`, `resetExpires`, `dateCreated`) VALUES
(1, 'aemiromekete12@gmail.com', '910d0a3c983db8e0', '$2y$10$rh0ZZTbVciihOk5CximZOOPCm4X/fcMXA2QQ/vg5qek7RwcakwjSu', '1591739558', '2020-06-09 21:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `name`, `date_created`) VALUES
(1, 'Addis Ababa', '2020-04-29 21:14:27'),
(2, 'Amhara', '2020-04-29 21:14:27'),
(3, 'Oromia', '2020-04-30 08:48:16'),
(4, 'SSPN', '2020-04-30 08:52:09'),
(8, 'Gambella', '2020-04-30 09:03:03'),
(9, 'Dire Dawa', '2020-05-01 18:14:16'),
(10, 'Afar', '2020-05-01 18:14:31'),
(11, 'Somalia', '2020-05-01 18:14:52'),
(12, 'Tigriy', '2020-05-01 18:15:08'),
(13, 'Binshangugumz', '2020-05-01 18:15:49'),
(14, 'Harere', '2020-05-01 18:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(132) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'undefined',
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`id`, `name`, `email`, `website`, `location`, `phone1`, `phone2`, `logo`, `about`, `type`, `startDate`, `endDate`, `dateCreated`) VALUES
(4, 'Premier Group ', 'aemiromekete137@gmail.com', 'http://serveglobal.org', 'Atlas', '0918577461', '0917564321', '12062020094059_55835411_2293488860714026_4458435649661304832_n.jpg', 'Sponsor Description                                                ', 'platinium', '2020-06-12', '2021-04-22', '2020-06-12 10:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `subcity`
--

CREATE TABLE `subcity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcity`
--

INSERT INTO `subcity` (`id`, `name`, `region_id`, `date_created`) VALUES
(2, 'Lafto', 1, '2020-05-01 19:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL,
  `email` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`id`, `email`, `status`, `dateCreated`, `lastUpdated`) VALUES
(1, 'AyeleWolde@gmail.com', 'active', '2020-02-26 11:29:14', '2020-02-26 04:54:38'),
(2, 'aemiromekete13@gmail.com', 'active', '2020-02-18 11:29:28', '2020-02-26 04:41:20'),
(3, 'admin@gmail.com', 'active', '2020-02-18 11:30:19', '2020-02-26 04:41:20'),
(4, 'aemiromekete137@gmail.com', 'disabled', '2020-02-18 11:33:14', '2020-02-26 05:01:16'),
(5, 'aemiromeketeew@gmail.com', 'active', '2020-02-18 11:33:56', '2020-02-26 04:41:20'),
(6, 'aemiromekete12@gmail.com', 'active', '2020-05-27 17:00:17', '2020-05-27 17:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(132) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `name`, `content`, `email`, `respo`, `provider`, `image`, `dateCreated`) VALUES
(2, 'Aemiro Mekete', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum.', 'aemiromekete12@gmail.com', NULL, NULL, NULL, '2020-03-26 15:18:00'),
(3, 'Aemiro Mekete', 'In the first example, a string variable is created with mixed letter text. The strtoupper function is used and that string variable is specified for converting all letters to capitals. See the code and output:', 'aemiromekete12@gmail.com', NULL, NULL, NULL, '2020-04-09 20:32:34'),
(4, 'Aemiro Mekete', 'Bootstrap 4 is the newest version of Bootstrap; with new components, faster stylesheet and more responsiveness. Bootstrap 4 supports the latest, stable releases of all major browsers and platforms. However, Internet Explorer 9 and down is not supported.', 'aemiromekete12@gmail.com', NULL, 'gmail', 'https://lh3.googleusercontent.com/a-/AOh14GidJMJZsIH3fIVGoom88qg76RzvtsdMIRJ32ycpKA', '2020-04-09 22:31:58'),
(5, 'Aemiro Mekete', 'ruty h5h tiyh59y40', 'aemiromekete12@gmail.com', 'Programmer  at  Vintage Technologies', 'gmail', 'https://lh3.googleusercontent.com/a-/AOh14GidJMJZsIH3fIVGoom88qg76RzvtsdMIRJ32ycpKA', '2020-05-30 14:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `fname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(130) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'volunteer',
  `profile_image` text COLLATE utf8mb4_unicode_ci,
  `sex` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ethiopia',
  `region` int(11) DEFAULT NULL,
  `zone` int(11) DEFAULT NULL,
  `woreda` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `career` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oauth_id` bigint(20) DEFAULT NULL,
  `fcm_id` text COLLATE utf8mb4_unicode_ci,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `mname`, `lname`, `username`, `email`, `phone`, `role`, `profile_image`, `sex`, `birth_date`, `password`, `country`, `region`, `zone`, `woreda`, `city`, `career`, `support_by`, `provider`, `oauth_id`, `fcm_id`, `enabled`, `last_updated`, `date_created`) VALUES
(1, 'Serve ', 'Global', '', 'admin', 'admin@gmail.com', '', 'admin', 'images/avatar.png', 'M', '1995-01-01', '$2y$13$w1zwWWNwrSSl7fzFD7syMu3T8ZsWpxAaYiLfcOitbawKW16ah9qHW', 'United States', 0, 0, 0, 0, '', '', NULL, NULL, NULL, 1, '2020-07-14 07:09:20', '2020-04-29 20:25:27'),
(2, 'Aemiro', 'Mekete', 'Yalemzaf', 'aemiro', 'aemiromeketeew@gmail.com', '0918577461', 'volunteer', '12052020215512_WIN_20191226_13_18_26_Pro.jpg', 'M', '1994-02-24', '$2y$13$HlEnezP9B7kv.iQls.hwEuHOi0/hGK9twQ3KqXSmaoUvT0R6N7.ci', 'Ethiopia', 2, 0, 0, 4, '', '5,9,24,26,30,34,37,50,53,63', NULL, NULL, NULL, 1, '2020-05-13 20:38:44', '2020-05-09 10:27:51'),
(3, 'Duresa', 'Furi', NULL, 'duresa', 'duresafuri139@gmail.com', '0916772303', 'volunteer', 'http://localhost/community/images/12052020215512_WIN_20191226_13_18_26_Pro.jpg', 'F', '1984-12-02', '$2y$13$MFsr.3rK7ymlVcZgVuFIl..JQOwfsL3GT3PzR.eVtHnNrQprZam.S', 'Ethiopia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-14 06:47:43', '2020-05-11 11:21:08'),
(12, 'Aemiro', 'Mekete', 'Vintageplc', '128605865495203', '', NULL, 'volunteer', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=128605865495203&height=50&width=50&ext=1592723289&hash=AeRg2EEmjDiPcNZH', 'M', '1994-02-28', NULL, 'Ethiopia', NULL, NULL, NULL, NULL, NULL, NULL, 'facebook', 128605865495203, NULL, 1, '2020-05-22 07:08:09', '2020-05-22 07:08:09'),
(13, 'aemiro', 'mekete', NULL, 'aemiromekete12@gmail.com', 'aemiromekete12@gmail.com', NULL, 'volunteer', 'https://lh3.googleusercontent.com/a-/AOh14GidJMJZsIH3fIVGoom88qg76RzvtsdMIRJ32ycpKA', 'M', NULL, NULL, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, 'google', 9223372036854775807, NULL, 1, '2020-06-11 22:21:11', '2020-05-22 07:09:48'),
(16, 'Addis', 'Ababa', NULL, 'addis@gmail.com', 'addis@gmail.com', '0912345656', 'partner', NULL, NULL, NULL, '$2y$13$OaX31CF.d0RiBgclr9e2BeU1dLAApCawnc7rSfuSneO3K0o55X6xS', 'Ethiopia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-05-26 05:18:37', '2020-05-26 05:18:37'),
(18, 'Begashaw', 'Mekete', 'Yalemzaf', 'aemiromekete137@gmail.com', 'aemiromekete137@gmail.com', '0990987654', 'volunteer', '13072020181653_WIN_20200527_11_13_59_Pro.jpg', 'M', '1995-01-01', '$2y$13$jzxjXrRq/8VBhCFv6uqsw.dvXqVFMKYITYIvCh2wskFPM1rQ7CT1u', 'Ethiopia', 1, 0, 3, 1, NULL, '18,44,64', NULL, NULL, NULL, 1, '2020-07-13 16:17:23', '2020-07-13 16:17:23'),
(21, 'Fanaye', 'Yismaw', 'Tizazu', 'fanaye@gmail.com', 'fanaye@gmail.com', '0978654312', 'volunteer', '13072020182656_', 'M', '1995-01-01', '$2y$13$oLd.sDl0hle21fFwhXxSZOku5.4PSnR2eJLgH0mxg/Y/dsJkLCJzS', 'Ethiopia', 2, 0, 0, 4, NULL, '18,49,53', NULL, NULL, NULL, 1, '2020-07-13 16:54:54', '2020-07-13 16:54:54'),
(22, 'Yenegeta', 'Mekete', 'Yalemzaf', 'yenegeta@gmail.com', 'yenegeta@gmail.com', '0978645321', 'volunteer', '13072020185737_WIN_20200527_11_13_58_Pro.jpg', 'M', '1995-01-01', '$2y$13$2LK5it6.V.tS7rmrpArIq.EXulTxenP99K7DKMA8H/JZwpOSIA9kO', 'Ethiopia', 2, 0, 0, 4, NULL, '18,22', NULL, NULL, NULL, 1, '2020-07-13 16:57:38', '2020-07-13 16:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `facebook` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `woreda`
--

CREATE TABLE `woreda` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(11) NOT NULL,
  `sub_city` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `woreda`
--

INSERT INTO `woreda` (`id`, `name`, `region_id`, `sub_city`, `date_created`) VALUES
(3, 'Woreda 01', 1, 2, '2020-05-01 20:17:03'),
(4, 'Woreda 02', 1, 2, '2020-05-01 20:17:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`commentId`),
  ADD UNIQUE KEY `commentId` (`commentId`),
  ADD UNIQUE KEY `commentId_2` (`commentId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_comment`
--
ALTER TABLE `event_comment`
  ADD PRIMARY KEY (`commentId`),
  ADD UNIQUE KEY `commentId` (`commentId`),
  ADD UNIQUE KEY `commentId_2` (`commentId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcity`
--
ALTER TABLE `subcity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `zone` (`zone`),
  ADD KEY `woreda` (`woreda`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `woreda`
--
ALTER TABLE `woreda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `sub_city` (`sub_city`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `commentId` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_category`
--
ALTER TABLE `main_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subcity`
--
ALTER TABLE `subcity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `woreda`
--
ALTER TABLE `woreda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `main_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
