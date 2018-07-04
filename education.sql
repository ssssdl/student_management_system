-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-07-04 06:41:04
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `education`
--

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `Cno` char(7) NOT NULL,
  `Cteacherno` char(8) NOT NULL,
  `Cname` varchar(40) NOT NULL,
  `Chour` smallint(6) NOT NULL,
  `Ccredit` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`Cno`, `Cteacherno`, `Cname`, `Chour`, `Ccredit`) VALUES
('2016001', '20160001', '操作系统', 55, 3),
('2016002', '20160002', '数据库', 50, 2),
('2016003', '20160002', '数据结构', 50, 2),
('2016004', '20160003', '高等数学', 50, 2),
('2016005', '20160001', '离散数学', 22, 3);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `login`
-- (See below for the actual view)
--
CREATE TABLE `login` (
`sno` char(10)
,`spass` varchar(32)
);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `Sno` char(10) NOT NULL,
  `Sname` varchar(50) NOT NULL,
  `Ssex` char(4) NOT NULL,
  `Sage` smallint(6) NOT NULL,
  `Sarea` varchar(100) NOT NULL,
  `Seducational` varchar(30) NOT NULL,
  `Spolitical` varchar(13) NOT NULL,
  `Snation` varchar(20) DEFAULT NULL,
  `Sleave` varchar(7) DEFAULT NULL,
  `Sreward` varchar(100) DEFAULT NULL,
  `Stele` varchar(15) NOT NULL,
  `Spass` char(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`Sno`, `Sname`, `Ssex`, `Sage`, `Sarea`, `Seducational`, `Spolitical`, `Snation`, `Sleave`, `Sreward`, `Stele`, `Spass`) VALUES
('2016083101', '张三', '男', 25, '内蒙古自治区赤峰市天义', '专科四年在校', '群众', '蒙古族', '退学', '考试作弊记过', '18902020102', 'f7869726d05f40a4147cee8020a0ccf4'),
('2016083102', '李四', '女', 25, '内蒙古自治区什么', '专科四年在校', '群众', '回族', '', '', '18902020101', 'b34f6c1b3cd362dc91ed37f9ac136200'),
('2016083103', '王五', '男', 18, '内蒙古', '本科四年', '群众', '汉族', '休学', '', '15512345678', '36e8ff449faf585aa6d326cd43b03db7');

-- --------------------------------------------------------

--
-- 表的结构 `stu_cour`
--

CREATE TABLE `stu_cour` (
  `Sno` char(10) NOT NULL,
  `Cno` char(7) NOT NULL,
  `Grade` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `stu_cour`
--

INSERT INTO `stu_cour` (`Sno`, `Cno`, `Grade`) VALUES
('2016083102', '2016001', 90),
('2016083102', '2016002', 90),
('2016083101', '2016002', 60),
('2016083103', '2016003', NULL),
('2016083101', '2016001', 60),
('2016083101', '2016003', 100),
('2016083101', '2016004', 70),
('2016083102', '2016003', 55),
('2016083102', '2016004', 80);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `Tno` char(8) NOT NULL,
  `Tname` varchar(50) NOT NULL,
  `Tsex` char(4) NOT NULL,
  `Tage` smallint(6) NOT NULL,
  `Tposit` varchar(30) NOT NULL,
  `Tpolitical` varchar(13) NOT NULL,
  `Ttele` varchar(15) NOT NULL,
  `Tpass` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`Tno`, `Tname`, `Tsex`, `Tage`, `Tposit`, `Tpolitical`, `Ttele`, `Tpass`) VALUES
('20160001', '张校长', '男', 18, '校长', '共青团员', '18988888887', '2910c7a176f3c4ab47e6886b0e2e44fb'),
('20160002', '李管理', '男', 18, '系统管理员', '共青团员', '18966666667', 'da750ff9986a866a122183a06ccd3891'),
('20160003', '王院长', '男', 18, '计算机院长', '共青团员', '18900000000', 'd41d8cd98f00b204e9800998ecf8427e');

-- --------------------------------------------------------

--
-- 视图结构 `login`
--
DROP TABLE IF EXISTS `login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `login`  AS  select `student`.`Sno` AS `sno`,`student`.`Spass` AS `spass` from `student` union select `teacher`.`Tno` AS `tno`,`teacher`.`Tpass` AS `tpass` from `teacher` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`Cno`),
  ADD KEY `Cteacherno` (`Cteacherno`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Sno`),
  ADD UNIQUE KEY `index_stu` (`Sno`);

--
-- Indexes for table `stu_cour`
--
ALTER TABLE `stu_cour`
  ADD PRIMARY KEY (`Sno`,`Cno`),
  ADD KEY `Cno` (`Cno`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`Tno`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
