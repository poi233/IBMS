-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-28 12:34:48
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `IBMS`
--

-- --------------------------------------------------------

--
-- 表的结构 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `project_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `project_version` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_version`) VALUES
('P1', 'project1', 'v1.2'),
('P2', 'project2', 'v0.3');

-- --------------------------------------------------------

--
-- 表的结构 `project_subsystem`
--

CREATE TABLE IF NOT EXISTS `project_subsystem` (
  `project_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `subsystem` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `project_subsystem`
--

INSERT INTO `project_subsystem` (`project_id`, `subsystem`) VALUES
('P1', 'sub1'),
('P1', 'sub2'),
('P1', 'sub3'),
('P2', 'subpro1'),
('P2', 'subpro2');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `user_account` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_authority` int(11) NOT NULL COMMENT '0:超级管理员 1:授权用户 2:审查用户'
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_account`, `user_password`, `user_name`, `user_authority`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '12345', 2),
(22, 'peter1', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'st1', 2),
(23, '123', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '12344', 1),
(24, '1232', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '123123123', 0),
(25, '1234123', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '41234123412', 1),
(26, '21342341234123', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '412341234', 1),
(27, '123412312351234', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2341234', 2);

-- --------------------------------------------------------

--
-- 表的结构 `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `user_id` int(11) NOT NULL,
  `project_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user_project`
--

INSERT INTO `user_project` (`user_id`, `project_id`) VALUES
(22, 'P2'),
(24, 'P1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
 ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
