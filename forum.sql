-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2016 at 04:40 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `bid` int(11) NOT NULL,
  `title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `enable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`bid`, `title`, `description`, `link`, `image`, `position`, `enable`) VALUES
(1, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(2, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(3, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(4, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(5, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(6, '', '', '', 'http://skinhade.circlecamp.com/upload/banner120_120_1360753282.png', 0, 1),
(8, 'Includ', 'แหล่งแจกโปรแกรมและสคริปเว็บไซต์ฟรี', 'www.includ.org', 'http://discuzthai.com/images/discuz.gif', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hcid` int(11) NOT NULL,
  `noid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `cid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `body` varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time_comment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `did` int(11) NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `image` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `view` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `upmid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `headercate`
--

CREATE TABLE `headercate` (
  `hcid` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `noid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `wsname` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(1000) NOT NULL,
  `keyword` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meta` text NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `footer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`wsname`, `image`, `keyword`, `meta`, `description`, `contact`, `footer`) VALUES
('Includ Forum', 'inc.png', 'Includ , C# , VB.NET , C   , หัดเขียนโปรแกรม , โปรแกรมแจกฟรี , PHP , JQUERY , สอนเขียนโปรแกรม', '<meta name="google-site-verification" content="C-mK5MwW_uP0Aqm0ppekEGWUf1U5U11XIdruMDFrG3Q" />', 'พัฒนาซอฟแวร์โดยใช้ VB.NET, C# , C   , PHP , JQUERY , ฯลฯ', 'support@includ.org', '');

-- --------------------------------------------------------

--
-- Table structure for table `logip`
--

CREATE TABLE `logip` (
  `ipaddress` varchar(100) NOT NULL,
  `count` int(11) NOT NULL,
  `time_view` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logip`
--

INSERT INTO `logip` (`ipaddress`, `count`, `time_view`) VALUES
('127.0.0.1', 0, '2016-08-12'),
('127.0.0.1', 0, '2016-08-12');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mid` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) NOT NULL,
  `avatar` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `line` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ipadress` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `islogin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `mid` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `nid` int(11) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `time_notice` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE `online` (
  `mid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `onlinetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pm`
--

CREATE TABLE `pm` (
  `pmid` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `to_read` int(11) NOT NULL,
  `form_read` int(11) NOT NULL,
  `timecreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `timeupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rid` int(11) NOT NULL,
  `rank_name` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rank_css` varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rid`, `rank_name`, `rank_css`) VALUES
(1, 'Administrator', 'admin'),
(2, 'Moderator', 'moder'),
(3, 'Member', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `repm`
--

CREATE TABLE `repm` (
  `repmid` int(11) NOT NULL,
  `pmid` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timesend` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `headercate`
--
ALTER TABLE `headercate`
  ADD PRIMARY KEY (`hcid`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `pm`
--
ALTER TABLE `pm`
  ADD PRIMARY KEY (`pmid`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `repm`
--
ALTER TABLE `repm`
  ADD PRIMARY KEY (`repmid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `headercate`
--
ALTER TABLE `headercate`
  MODIFY `hcid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pm`
--
ALTER TABLE `pm`
  MODIFY `pmid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `repm`
--
ALTER TABLE `repm`
  MODIFY `repmid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
