-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-27 15:35:41
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
  `project_version` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `project_subsys` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_version`, `project_subsys`) VALUES
('123', '123', '123', '123'),
('1234', '123', '123', '123'),
('12345', '123', '1234123', '123124123');

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

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
(22, '123'),
(26, '123'),
(1, '1234'),
(22, '1234'),
(23, '1234'),
(24, '1234'),
(25, '1234'),
(26, '1234'),
(27, '1234'),
(22, '12345'),
(1, '12345'),
(23, '12345'),
(24, '12345'),
(25, '12345');

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
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
