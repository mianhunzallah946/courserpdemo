-- ==============================================================
-- CourseERP LMS - Database Schema & Initial Data
-- Compatible with: MySQL 5.7+, MariaDB 10.3+, phpMyAdmin (InfinityFree, cPanel)
-- ==============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table structure for table `course`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `videos` varchar(255) NOT NULL,
  `status` enum('public','private') NOT NULL DEFAULT 'public',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`course_id`),
  KEY `idx_title` (`title`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed data for table `course`
-- --------------------------------------------------------

INSERT INTO `course` (`course_id`, `title`, `videos`, `status`) VALUES
(1, 'Full Stack Web Development', '82079.mp4', 'public'),
(2, 'Full Stack Web Development', '25173.mp4', 'public'),
(3, 'Full Stack Web Development', '50209.mp4', 'public'),
(4, 'Full Stack Web Development', '54713.mp4', 'public'),
(5, 'Full Stack Web Development', '56359.mp4', 'public'),
(6, 'Full Stack Web Development', '248328_1788850222.mp4', 'public'),
(7, 'Full Stack Web Development', '488925_1788853776.mp4', 'public'),
(8, 'Python for Data Science & AI', '215104_1788853757.mp4', 'public'),
(9, 'Python for Data Science & AI', '469873_1788853776.mp4', 'public'),
(10, 'Python for Data Science & AI', '52802.mp4', 'public'),
(11, 'Python for Data Science & AI', '98878.mp4', 'public'),
(12, 'Modern JavaScript Mastery', '82079.mp4', 'public'),
(13, 'Modern JavaScript Mastery', '25173.mp4', 'public'),
(14, 'Modern JavaScript Mastery', '50209.mp4', 'public'),
(15, 'UI/UX Design Systems', '54713.mp4', 'public'),
(16, 'UI/UX Design Systems', '56359.mp4', 'private')
ON DUPLICATE KEY UPDATE `course_id`=`course_id`;

-- --------------------------------------------------------
-- Table structure for table `login`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmpassword` varchar(255) DEFAULT '',
  `role` enum('admin','student') NOT NULL DEFAULT 'student',
  `course_name` varchar(255) DEFAULT 'Full Stack Web Development',
  `membership` varchar(50) NOT NULL DEFAULT 'paid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed default accounts for table `login`
-- --------------------------------------------------------

INSERT INTO `login` (`user_id`, `fname`, `lname`, `email`, `password`, `confirmpassword`, `role`, `course_name`, `membership`) VALUES
(1, 'Super', 'Admin', 'admin@courseerp.com', 'admin123', 'admin123', 'admin', '', 'paid'),
(2, 'Alex', 'Morgan', 'student@courseerp.com', 'student123', 'student123', 'student', 'Full Stack Web Development', 'paid'),
(3, 'Sarah', 'Connor', 'sarah@example.com', 'student123', 'student123', 'student', 'Python for Data Science & AI', 'paid'),
(4, 'David', 'Beckham', 'david@example.com', 'student123', 'student123', 'student', 'Modern JavaScript Mastery', 'paid')
ON DUPLICATE KEY UPDATE `user_id`=`user_id`;

-- --------------------------------------------------------
-- Table structure for table `enrollments`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `enrollments` (
  `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`enrollment_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_course` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Seed enrollments
-- --------------------------------------------------------

INSERT INTO `enrollments` (`user_id`, `course_id`) VALUES
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6), (2, 7),
(3, 8), (3, 9), (3, 10), (3, 11),
(4, 12), (4, 13), (4, 14)
ON DUPLICATE KEY UPDATE `enrollment_id`=`enrollment_id`;

-- --------------------------------------------------------
-- Table structure for table `user_course_views`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `user_course_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_views` (`user_id`, `course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
