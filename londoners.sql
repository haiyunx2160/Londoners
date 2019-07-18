-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2019 at 08:18 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


DROP USER IF EXISTS 'londoners'@'localhost' ;

DROP DATABASE IF EXISTS Londoners;
CREATE DATABASE Londoners;



grant all privileges on Londoners.* to 'londoners'@'localhost' identified by 'London123!' ;


use Londoners;

CREATE TABLE `admin_master` (
  `admin_master_id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`category_id`, `name`, `description`, `created_by`, `created_datetime`) VALUES
(1, 'Jobs', 'Jobs available in London City', 1, '2019-03-20 21:18:00'),
(2, 'Vehicles', ' Vehicles available in London City', 1, '2019-03-20 21:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `code`, `name`) VALUES
(1, 'CA', 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `location_master`
--

CREATE TABLE `location_master` (
  `location_id` int(11) NOT NULL,
  `location_code` char(3) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_master`
--

INSERT INTO `location_master` (`location_id`, `location_code`, `location_name`, `description`, `created_date`) VALUES
(1, 'N', 'London North', 'London', '2019-03-20 21:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `login_history_id` int(11) NOT NULL,
  `login_user_id` int(11) NOT NULL,
  `sign_in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sign_out_time` timestamp NULL DEFAULT NULL,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_profile`
--

CREATE TABLE `member_profile` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` char(1) CHARACTER SET latin1 NOT NULL,
  `inactive_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar_url` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_profile`
--

INSERT INTO `member_profile` (`member_id`, `first_name`, `last_name`, `address`, `city`, `province_id`, `country_id`, `user_id`, `email`, `created_by`, `created_time`, `active`, `inactive_date`, `comments`, `avatar_url`) VALUES
(1, 'milan', 'milan', NULL, NULL, NULL, NULL, 1, 'milzbhakta@gmail.com', 1, '2019-03-22 18:14:10', '', '2019-03-22 18:14:10', '', '5c9cec9609bed1.jpg'),
(2, 'Milan', 'jlk', NULL, NULL, NULL, NULL, 2, 'milan@gmail.com', 1, '2019-03-23 04:38:30', '', '2019-03-23 04:38:30', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `post_action_type`
--

CREATE TABLE `post_action_type` (
  `action_type_id` int(11) NOT NULL,
  `type_code` char(2) NOT NULL,
  `type_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_action_type`
--

INSERT INTO `post_action_type` (`action_type_id`, `type_code`, `type_name`) VALUES
(1, 'N', 'New'),
(2, 'R', 'Reply'),
(3, 'C', 'comments');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--
-- Error reading structure for table londoners.post_likes: #1932 - Table 'londoners.post_likes' doesn't exist in engine
-- Error reading data for table londoners.post_likes: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `londoners`.`post_likes`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `post_master`
--

CREATE TABLE `post_master` (
  `post_master_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `post_heading` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contents` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime NOT NULL,
  `post_active` char(1) NOT NULL,
  `post_inactive_date` datetime NOT NULL,
  `post_viewer_action_id` int(11) NOT NULL,
  `comments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_master`
--

INSERT INTO `post_master` (`post_master_id`, `member_id`, `category_id`, `location_id`, `post_heading`, `contents`, `post_date`, `approved_by`, `approved_date`, `post_active`, `post_inactive_date`, `post_viewer_action_id`, `comments`) VALUES
(1, 1, 1, 1, 'London City Hiring', ' London City Hiring for following vacancies. Apply soon .. Engineers , Janitors, Garbage collectors etc.. ', '2019-03-20 21:35:08', 1, '2019-03-20 21:35:08', 'Y', '2019-03-20 21:35:08', 1, 'test System'),
(2, 1, 1, 1, 'Integrating WordPress with Your Website', '<p>Many of us work in an endless stream of tasks, browser tasks, social media, emails, meetings, rushing from one thing to another, never pausing and never ending. Then the day is over, and we are exhausted, and we often have very little to show for it. And we start the next day, ready for a mindless stream of tasks and distractions.</p>\r\n\r\n', '2019-03-20 21:38:54', 1, '2019-03-20 21:38:54', 'Y', '2019-03-20 21:38:54', 1, 'test System'),
(3, 1, 1, 1, 'Application Project Bonus API', 'dhgsfhkjasdgfhdasjgfjadhgfhjkahfkjhdasgfkjdhsfgjkadhsfkjadhsfjkhdfkjhadsjfhdasjfjkadshfjkadshfjkadhfkjahdfkjahdfkjhadfkjhadkjfhkjdshfkjadshfkjahdskjfhdjakhfkjadshfkjadshfkjahdskfjhadskjfhkjdhfkjdshfkjdsfkjdshfkjadf', '2019-03-25 17:45:33', 1, '2019-03-25 17:45:33', 'Y', '2019-03-25 17:45:33', 1, 'test'),
(4, 1, 1, 1, 'Word Press', '\r\nProject E\r\nMark 28 Thermonuclear Bomb.jpg\r\nSet of four Mark 28 nuclear bombs of the type supplied to the United Kingdom under Project E\r\nType of project	Deployment of nuclear weapons\r\nCountry	United States\r\nUnited Kingdom\r\n', '2019-03-25 17:54:00', 1, '2019-03-25 17:54:00', 'Y', '2019-03-25 17:54:00', 1, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `post_threads`
--

CREATE TABLE `post_threads` (
  `post_thread_id` int(11) NOT NULL,
  `post_master_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `previous_thread_id` int(11) NOT NULL,
  `thread_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `thread_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_threads`
--

INSERT INTO `post_threads` (`post_thread_id`, `post_master_id`, `member_id`, `previous_thread_id`, `thread_created_date`, `thread_data`) VALUES
(1, 4, 1, 1, '2019-03-25 19:14:14', 'v,hjgdsdsfgfhggf'),
(2, 4, 1, 1, '2019-03-25 19:16:24', 'v,hjgdsdsfgfhggf'),
(3, 4, 1, 1, '2019-03-25 19:17:49', ',kfhjmhngbffghjh,jmhngbdfvdfdgnfhmhngbfvsdbnfxmgcfbvbxnnbvc'),
(4, 2, 1, 1, '2019-03-25 19:20:05', 'khjmghnbdfvsdfgnhmj,');

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` int(11) NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(60) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `code`, `name`, `country_id`) VALUES
(1, 'AB', 'Alberta', 1),
(2, 'BC', 'British Columbia', 1),
(3, 'MB', 'Manitoba', 1),
(4, 'NB', 'New Brunswick', 1),
(5, 'NL', 'Newfoundland and Labrador', 1),
(6, 'NT', 'Northwest Territories', 1),
(7, 'NS', 'Nova Scotia', 1),
(8, 'NU', 'Nunavut', 1),
(9, 'ON', 'Ontario', 1),
(10, 'PE', 'Prince Edward Island', 1),
(11, 'QC', 'Quebec', 1),
(12, 'SK', 'Saskatchewan', 1),
(13, 'YT', 'Yukon', 1);

-- --------------------------------------------------------

--
-- Table structure for table `thread_comments`
--

CREATE TABLE `thread_comments` (
  `thread_comments_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_thread_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `thread_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `user_type`, `created_by`, `created_date`) VALUES
(1, 'milan', '$2y$10$xXw/fK/Pq1XMvadsWW2mE.oRXIbBUpkjmx0eLDA2fvva1nFZms/Ie', 1, 1, '2019-03-22 18:14:10'),
(2, 'milan1', '$2y$10$YlunJh0tJSGqfo8VrAoYsOiPrRmJ42jYO9vIDZgMQwTlrEKc/5fca', 1, 1, '2019-03-23 04:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_type_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_code`, `user_type_name`) VALUES
(1, 'mbr', 'Member'),
(2, 'adm', 'Admin'),
(3, 'cmr', 'Content Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD PRIMARY KEY (`admin_master_id`),
  ADD KEY `admin_master_ibfk_1` (`admin_user_id`);

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `location_master`
--
ALTER TABLE `location_master`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`login_history_id`);

--
-- Indexes for table `member_profile`
--
ALTER TABLE `member_profile`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_action_type`
--
ALTER TABLE `post_action_type`
  ADD PRIMARY KEY (`action_type_id`);

--
-- Indexes for table `post_master`
--
ALTER TABLE `post_master`
  ADD PRIMARY KEY (`post_master_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `post_viewer_action_id` (`post_viewer_action_id`);

--
-- Indexes for table `post_threads`
--
ALTER TABLE `post_threads`
  ADD PRIMARY KEY (`post_thread_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `post_master_id` (`post_master_id`),
  ADD KEY `member_id_2` (`member_id`),
  ADD KEY `previous_thread_id` (`previous_thread_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `thread_comments`
--
ALTER TABLE `thread_comments`
  ADD PRIMARY KEY (`thread_comments_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `post_thread_id` (`post_thread_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_master`
--
ALTER TABLE `admin_master`
  MODIFY `admin_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location_master`
--
ALTER TABLE `location_master`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `login_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_profile`
--
ALTER TABLE `member_profile`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post_action_type`
--
ALTER TABLE `post_action_type`
  MODIFY `action_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_master`
--
ALTER TABLE `post_master`
  MODIFY `post_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post_threads`
--
ALTER TABLE `post_threads`
  MODIFY `post_thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `thread_comments`
--
ALTER TABLE `thread_comments`
  MODIFY `thread_comments_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD CONSTRAINT `admin_master_ibfk_1` FOREIGN KEY (`admin_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`login_history_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `member_profile`
--
ALTER TABLE `member_profile`
  ADD CONSTRAINT `member_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_profile_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_profile_ibfk_3` FOREIGN KEY (`province_id`) REFERENCES `province` (`province_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_master`
--
ALTER TABLE `post_master`
  ADD CONSTRAINT `post_master_ibfk_1` FOREIGN KEY (`post_viewer_action_id`) REFERENCES `post_action_type` (`action_type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_master_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category_master` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_master_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `location_master` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_threads`
--
ALTER TABLE `post_threads`
  ADD CONSTRAINT `post_threads_ibfk_1` FOREIGN KEY (`post_master_id`) REFERENCES `post_master` (`post_master_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_threads_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member_profile` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_threads_ibfk_3` FOREIGN KEY (`previous_thread_id`) REFERENCES `post_threads` (`post_thread_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `province`
--
ALTER TABLE `province`
  ADD CONSTRAINT `province_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_comments`
--
ALTER TABLE `thread_comments`
  ADD CONSTRAINT `thread_comments_ibfk_1` FOREIGN KEY (`post_thread_id`) REFERENCES `post_threads` (`post_thread_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thread_comments_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member_profile` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thread_comments_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post_master` (`post_master_id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
