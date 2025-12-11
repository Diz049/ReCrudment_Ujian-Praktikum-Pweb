-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2025 at 05:47 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_jobless`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `app_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cv_file` varchar(255) DEFAULT NULL,
  `date_applied` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`app_id`, `job_id`, `user_id`, `name`, `email`, `phone`, `cv_file`, `date_applied`) VALUES
(4, 11, 4, 'qwerty', 'any@gmail.com', '088976654321', 'cv_68a80cf594df9.jpg', '2025-08-22 06:23:49'),
(5, 8, 1, 'Diaz Sugiarto Icksan', 'diaz.icksan2@gmail.com', '0895347927979', 'cv_68a822b16090d.jpg', '2025-08-22 07:56:33'),
(6, 6, 1, 'Diaz Sugiarto Icksan', 'diaz.icksan@gmail.com', '0895347927979', 'cv_68a822c6bf79e.jpg', '2025-08-22 07:56:54'),
(7, 8, 4, 'qwert', 'any@gmail.com', '088976654321', 'cv_68a82e2acbc44.jpg', '2025-08-22 08:45:30'),
(8, 10, 4, 'qwerty', 'any@gmail.com', '088976654321', 'cv_68a82e3e5a4a2.jpg', '2025-08-22 08:45:50'),
(9, 9, 1, 'Diaz Icksan Sugiarto', 'diaz.icksan@gmail.com', '0895347927979', 'cv_68a8579f73fe7.jpg', '2025-08-22 11:42:23'),
(10, 7, 1, 'Diaz Icksan Sugiarto', 'diaz.icksan@gmail.com', '0895347927979', 'cv_68a8859495958.jpg', '2025-08-22 14:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `title`, `description`, `requirements`, `location`, `salary`, `date_posted`) VALUES
(1, 'Pelatih kuda', 'Latih Kuda... idk', 'S1 Perkudaan', 'Tracen', '1500 - 3000 carats/month', '2025-08-17 16:05:14'),
(3, 'Pelatih Kapal Emas', 'Hidup', 'Kuat fisik\r\nBersabar\r\nkeras kepala (bukan metafora)\r\ndo not make him mad', 'Akademi Tracen', '5000-8000 carats/bulan', '2025-08-18 02:08:38'),
(6, 'Backend Dev', 'Design, develop, and maintain highly performant, reliable, scalable, and secure backend systems and server side logic. Oversee projects from conception to deployment, ensuring smooth execution and delivery to create a great and on-brand user experience.', '- S1 Informatika\r\n- experience in backend development\r\n- 2 years of work experience', 'Jakarta Timur', 'Rp. 6.500.000 - 10.000.000', '2025-08-18 03:30:03'),
(7, 'Frontend Dev', 'Responsible for developing and implementing user-facing features using modern web technologies. This includes writing clean, efficient, and maintainable code in HTML, CSS, and JavaScript, as well as leveraging front-end frameworks and libraries like React, Angular, and Vue.', 'S1 Sistem Informasi/lulusan sederajat\r\n', 'Cibubur', 'Rp. 4.500.000 - 12.000.000', '2025-08-18 06:57:26'),
(8, 'IT Specialist', 'Managing and maintaining computer systems, networks, and software for an organization. \r\nthe handling of tasks like troubleshooting, installing hardware and software, providing technical support, and ensuring data security. ', 'S1 Sistem Informasi', 'Jakarta Selatan', 'Rp. 4.500.000 - 8.000.000', '2025-08-18 06:59:34'),
(9, 'Accountant', '- Analyzes, manages, and reports on an organizations financial data.\r\n- Duties include recording and classifying transactions, preparing financial statements, reconciling accounts, and ensuring compliance with regulations. \r\n- Provides financial advice and support to management for decision-making. ', 'S1 - Akutansi', 'Cibubur', 'Rp. 4.500.000 - 8.000.000', '2025-08-20 04:28:55'),
(10, 'UI/UX Designer', 'Responsible for creating intuitive and engaging user experiences across digital products like websites and apps', 'S1 Sistem Informasi', 'Jakarta Selatan', 'Rp. 4.500.000 - 10.000.000', '2025-08-20 04:38:33'),
(11, 'Personal Celebrity Photographer ', 'Creates images of famous individuals for various purposes, from personal branding to editorial content and public relations.\r\nResponsibilities include not only taking high-quality portraits and candid shots but also managing location scouting, lighting, and styling to convey the celebritys unique personality and narrative.', 'S1 - Seni Rupa', 'Jakarta Utara', 'Relasi & exposure', '2025-08-22 03:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','applicant') DEFAULT 'applicant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'Diaz', 'login123', 'applicant'),
(2, 'admin', 'admin123', 'admin'),
(4, 'tes123', 'login123', 'applicant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
