-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2025 at 05:38 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'irgindanursika3@gmail.com', '2025-05-09 15:25:13'),
(3, 'irgindanursika2@gmail.com', '2025-05-09 15:29:02'),
(4, 'aaa@gmail.com', '2025-05-09 15:31:27'),
(5, 'sdssdsd@gmail.com', '2025-05-09 15:33:00'),
(6, 'ASSA@GMAIL.COM', '2025-05-09 18:52:50'),
(7, 'irgin1@gmail.com', '2025-05-21 17:04:00'),
(8, 'Randikontol@gmail.com', '2025-05-21 17:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers_easy`
--

CREATE TABLE `user_answers_easy` (
  `id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `question_id` int NOT NULL,
  `answer` varchar(10) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

--
-- Dumping data for table `user_answers_easy`
--

INSERT INTO `user_answers_easy` (`id`, `fullname`, `question_id`, `answer`, `is_correct`, `created_at`) VALUES
(1, 'IRGIN DANURSIKA', 1, 'B', 1, '2025-05-23 20:17:48'),
(2, 'IRGIN DANURSIKA', 2, 'A', 1, '2025-05-23 20:23:32'),
(3, 'IRGIN DANURSIKA', 3, 'C', 1, '2025-05-23 20:23:51'),
(4, 'IRGIN DANURSIKA', 4, 'D', 1, '2025-05-23 20:23:53'),
(5, 'IRGIN DANURSIKA', 5, 'D', 0, '2025-05-23 20:23:55'),
(6, 'IRGIN DANURSIKA', 6, 'D', 0, '2025-05-23 20:23:57'),
(15, 'GLOOOO', 1, 'A', 0, '2025-05-25 13:00:37'),
(16, 'GLOOOO', 2, 'D', 0, '2025-05-25 13:01:00'),
(17, 'GLOOOO', 3, 'B', 0, '2025-05-25 13:01:04'),
(18, 'GLOOOO', 4, 'D', 1, '2025-05-25 13:01:07'),
(19, 'GLOOOO', 5, 'C', 0, '2025-05-25 13:01:10'),
(20, 'GLOOOO', 6, 'A', 0, '2025-05-25 13:01:14'),
(39, 'GINNNN', 1, 'C', 0, '2025-05-25 17:24:55'),
(40, 'GINNNN', 2, 'B', 0, '2025-05-25 17:25:02'),
(41, 'GINNNN', 3, 'D', 0, '2025-05-25 17:36:19'),
(42, 'GINNNN', 4, 'C', 0, '2025-05-25 17:36:27'),
(43, 'GINNNN', 5, 'D', 0, '2025-05-25 17:36:40'),
(44, 'GINNNN', 6, 'B', 1, '2025-05-25 17:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers_hard`
--

CREATE TABLE `user_answers_hard` (
  `answer_id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `question_id` int NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

--
-- Dumping data for table `user_answers_hard`
--

INSERT INTO `user_answers_hard` (`answer_id`, `fullname`, `question_id`, `answer`, `is_correct`, `created_at`) VALUES
(18, 'GINNNN', 1, 'asdasd', 0, '2025-05-25 17:19:09'),
(19, 'GINNNN', 2, 'MAMA', 0, '2025-05-25 17:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers_medium`
--

CREATE TABLE `user_answers_medium` (
  `answer_id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `question_id` int NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

--
-- Dumping data for table `user_answers_medium`
--

INSERT INTO `user_answers_medium` (`answer_id`, `fullname`, `question_id`, `answer`, `is_correct`, `created_at`) VALUES
(38, 'GINNNN', 1, 'MAMA', 0, '2025-05-25 15:51:05'),
(39, 'GINNNN', 2, 'TEACHER', 0, '2025-05-25 15:52:09'),
(40, 'GINNNN', 3, 'a', 0, '2025-05-25 15:52:13'),
(41, 'GINNNN', 4, 'AD', 0, '2025-05-25 15:52:18'),
(42, 'GINNNN', 5, 'd', 0, '2025-05-25 15:52:22'),
(43, 'GINNNN', 6, 'ada', 0, '2025-05-25 15:52:27'),
(44, 'GINNNN', 1, 'TEACHER', 1, '2025-05-25 16:06:56'),
(45, 'GINNNN', 2, 'blackboard', 1, '2025-05-25 16:07:03'),
(46, 'GINNNN', 3, 'notebook', 1, '2025-05-25 16:07:14'),
(47, 'GINNNN', 4, 'classroom', 1, '2025-05-25 16:07:24'),
(48, 'GINNNN', 5, 'student', 1, '2025-05-25 16:07:38'),
(49, 'GINNNN', 6, 'LESSON', 1, '2025-05-25 16:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_general`
--

CREATE TABLE `user_general` (
  `id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_general`
--

INSERT INTO `user_general` (`id`, `fullname`, `username`, `password`) VALUES
(1, 'IRGIN', 'irgin@gmail.com', '$2y$10$qje3cPaNxCb3W8wIJf34SutXJGCSEUD/YaCZxr/0dT9e4bZWqgroG'),
(2, 'IRGIN', 'irgin@gmail.com', '$2y$10$/ouCs3WlHNcyQ53lYKtSBOH7YkBvh2CwBvnxCePBNWubf2d7wYq4W'),
(3, 'IRGIN', 'irgin@gmail.com', '$2y$10$fzX6X5a5Q2/uk7B3gcjmaeUw3h4mZs3Zsr8unwzCB2gQT.IMkRQxC'),
(4, 'IRGIN', 'irgin1@gmail.com', '$2y$10$QpLHqLXVWA7legwDR/jfA.V56OJb0VbOW6rZ14OEU4ec2UMyE7dae'),
(5, 'irgin danursika', '123@gmail.com', '$2y$10$4bUgnLsStCw73ve4EFZTJOlLsap/xYmtsoYa0R0rE12ko3Q8gWb4e'),
(6, 'irgin danursika', 'irgin@gmai.com', '$2y$10$50UUcX12Gt.ZZEhpXRteoeH0tyF4b9XpPM6HSDqe29rxVrgdgHV0W'),
(7, 'HEHE', '1234@gmail.com', '$2y$10$iWSm/a2Y9W8qowrv3lpLWO/KViN93pUiz0PKB.PEbab2DJphdqtlm'),
(8, 'HAH', '12345@gmail.com', '$2y$10$28WV9bnJfP57kO2jIssquOBUuTvauOeZZEXVVK.OtLZExg9GyZY2u'),
(9, 'bbbbb', '0@gmail.com', '$2y$10$na273wcjHszVIhWZ8Ne0rOWsjmxBZZnoN12cfFDFK9OhkIkSNnLlq'),
(10, 'ANJ', '1@gmail.com', '$2y$10$T78rWvVeubQMy2HyZPgqTe07t.JKZsZ43JiGN0T0Hvyq6gR7au/hC'),
(11, 'IRGIN DANURSIKA', '12@gmail.com', '$2y$10$l8PNmtFl3bGH/8JGU6lVkOVsOwiQOSjug7M/l.T9xqvgmQwmCIYty'),
(12, 'GINNNN', 'gin@gmail.com', '$2y$10$yVIZUsEkosl.94NVZTeu6uGIximwRDEUVnsyCBQr6U1gQGczy93Uq'),
(13, 'GLOOOO', 'a@gmail.com', '$2y$10$mXcYVakeY37MO2PNwTorSOonl9520Q28Dt2Ny9fzIIQewKAznL9za');

-- --------------------------------------------------------

--
-- Table structure for table `user_teacher`
--

CREATE TABLE `user_teacher` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nig` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_teacher`
--

INSERT INTO `user_teacher` (`id`, `nama`, `nig`, `username`, `password`) VALUES
(1, 'DASFDSA', 'AS', 'hamdani89@gmail.com', '$2y$10$ZZqs4nWj/Rts1EfJbRRXPO/IdpbyX0T5Oy7d9EKpv4TXn7K9ApezC'),
(2, 'DASFDSA', 'AS', 'hamdani89@gmail.com', '$2y$10$evpKxgSBzHdl5X00XcF1V.Qa/ylBcnkxXOxHEqYYjpq64IZ8KgJhu'),
(3, 'irgin', '21535127', 'hamdani89@gmail.com', '$2y$10$45qI1wc7bz0YSCMlJaGDxOEGiTr64cNp1OvfS/VN.qvZgJlM5bff.'),
(4, '', '', '', '$2y$10$VE0lSb/idTJu006FZK1yL.zzieqEuYDvNulEHDaPgOf0yO92aMIQi'),
(5, 'BAYU BAGAS PUTRA', '97979868965', 'hamdani89@gmail.com', '$2y$10$llVDeuNlpKc45E9eoTV.pO3QQ1Iz7uGCGQdLOGRnV3F.jKFehQYJq'),
(6, 'GINN', '878686868', 'hamdani89@gmail.com', '$2y$10$FG2aP/jbI5U.Kt4mn0zLOuQKEF7MSIW5ikrgM2bPQocRXHAT5w9.G'),
(7, 'BAYU BAGAS PUTRA S.Kom', '2432', 'hamdani89@gmail.com', '$2y$10$zAn1vnquyNXn8rc.L3QyCORWv2XbGJgk9hS51yfIA9ASRg7GEgjvm'),
(8, 'SADSASSSS12312', '2411421421', 'hamdani89@gmail.com', '$2y$10$upRh0/3GwBAhRyg8xO3Xp.qZkkRW8sp5heC7Ajx6FaamxOqaUUXtC'),
(9, 'SADSASSSS12312', '2411421421', 'hamdani89@gmail.com', '$2y$10$X7nv2rMk2F6gqNp4UZJ44.cSWwJFarh57JmU6cwcWZ2fBWt6cxx62'),
(10, 'SADSASSSS12312', '2411421421', 'hamdani89@gmail.com', '$2y$10$IxIqeW7yA5fgs/s.MD/a.OAOw5LNJ3YBvfXFQYxreMcLrldrfsyqq'),
(11, 'SADSASSSS12312', '2411421421', 'hamdani89@gmail.com', '$2y$10$XRBINtM3lJ2SsJkZQ3DOQOcJZJ.KaJx4OADMY5/l12oe282Joo6DO'),
(12, 'BAYU BAGAS PUTRA S.Kom', '2132132131', 'hamdani89@gmail.com', '$2y$10$YEgXNdxxtQoiHTvcrCjiDOPsMmtJnUtc4vdKn4zfLsBM.sr7Ccl/.'),
(13, 'BAYU BAGAS PUTRA S.Kom', '2132132131', 'hamdani89@gmail.com', '$2y$10$zKsPYcmBFieJ5iNcAfgJOeMwbj/tpucmGtu9RTYWhsdbS2ebDVckC'),
(14, 'BAYU BAGAS PUTRA S.Kom', '2132132131', 'hamdani89@gmail.com', '$2y$10$SxB.bTmN38s3TgKIpdItDuu72TjfFlnhjPpZozpPrU.UzeBOsXcmS'),
(15, 'irgindanursika', '3242332', 'irgindanursika@gmail.com', '$2y$10$/fbF9eEsi4/UxltEY6JdQerGtabj0IfnuBkA9T7uMlBKI6Y/EYvum'),
(16, 'yaya', '3497237', 'hamdani89@gmail.com', '$2y$10$dRxdZQGz97d3FnuiQkuMD.H3nuyR0ljpPcpCWmrHrE7yW4sK7YRgu'),
(17, 'IRGIN', '214141', 'irgin@gmai.com', '$2y$10$6NR2HYSPBSawvrrWe2fhheaI5uzKZfw78uZV0/jeX7Hzev/eV54bu'),
(18, 'GINNNN', '2422141', 'irgin@abc.com', '$2y$10$0l6niO9gtE9aKJqeclTAqOAETLyb6168DCloHR6rRxHgYut/54Y.G'),
(19, 'IRGINNNNN', '231312', 'irgin@gmail.com', '$2y$10$q7MrD4oZvRS24eVAhLWGve7JXH5NLTBzAViyEyI.t5qFaaf9hd4FS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_answers_easy`
--
ALTER TABLE `user_answers_easy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_question` (`fullname`,`question_id`);

--
-- Indexes for table `user_answers_hard`
--
ALTER TABLE `user_answers_hard`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `user_answers_medium`
--
ALTER TABLE `user_answers_medium`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `user_general`
--
ALTER TABLE `user_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_teacher`
--
ALTER TABLE `user_teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_answers_easy`
--
ALTER TABLE `user_answers_easy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_answers_hard`
--
ALTER TABLE `user_answers_hard`
  MODIFY `answer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_answers_medium`
--
ALTER TABLE `user_answers_medium`
  MODIFY `answer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_general`
--
ALTER TABLE `user_general`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_teacher`
--
ALTER TABLE `user_teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
