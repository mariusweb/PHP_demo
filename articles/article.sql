-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2021 at 08:17 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `article`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `author` varchar(40) CHARACTER SET utf16 COLLATE utf16_lithuanian_ci NOT NULL,
  `shortContent` varchar(200) CHARACTER SET utf16 COLLATE utf16_lithuanian_ci NOT NULL,
  `content` text CHARACTER SET utf16 COLLATE utf16_lithuanian_ci NOT NULL,
  `publishDate` date NOT NULL,
  `type` varchar(40) CHARACTER SET utf16 COLLATE utf16_lithuanian_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf16 COLLATE utf16_lithuanian_ci NOT NULL,
  `addDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `preview` varchar(225) CHARACTER SET utf16 COLLATE utf16_lithuanian_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `author`, `shortContent`, `content`, `publishDate`, `type`, `title`, `addDate`, `preview`, `user_id`) VALUES
(1, 'John Doe', 'Shorty Shorts', 'Very shorty shorts were found', '2020-04-01', 'NewsArticle', 'Forest', '2021-01-28 16:00:01', 'https://picsum.photos/id/10/200/300', 1),
(2, 'Jonas Jon', 'trumptext', 'ilgesnis tekstukas', '2020-04-02', 'ShortArticle', 'Dog', '2021-02-09 11:10:56', 'https://picsum.photos/id/1001/200/300', 3),
(3, 'PetrPetras', 'velgi trumpas', 'tekstas nedidelis', '2020-04-03', 'PhotoArticle', 'Snow', '2021-01-28 16:00:29', 'https://picsum.photos/id/1001/200/300', 4),
(4, 'Vardenis su Pavarde', 'nebeturiu ideju', 'ilgiausias straipsnis ilgiausias straipsnis ilgiausias straipsnis ilgiausias straipsnis ilgiausias straipsnis ilgiausias straipsnis ilgiausias straipsnis ', '2020-04-06', 'NewsArticle', 'Beach', '2021-01-28 16:01:37', 'https://picsum.photos/id/1002/200/300', 5),
(5, 'Betkas', 'bla', 'blabla', '2020-05-04', 'NewsArticle', 'Ocean', '2021-01-28 16:03:08', 'https://picsum.photos/id/1003/200/300', 6),
(8, 'auotritetas', 'trumpesnis turinys', 'tiesiog turinys', '2021-01-28', 'ShortArticle', 'Cat', '2021-01-28 16:04:33', 'https://picsum.photos/id/1005/200/300', 8),
(18, 'Veikejas', 'trumpulis', 'Ilgas tekstas', '2020-05-25', 'NewsArticle', 'Deer', '2021-01-28 14:03:58', 'https://picsum.photos/id/1004/200/300', 7),
(42, 'me', 'me am', 'me am good', '2021-02-15', 'NewsArticle', 'Me', '2021-02-15 06:48:48', 'my/image', 23),
(43, 'Mariuzz', 'Everything works', 'Magic in PHP', '2021-02-15', 'NewsArticle', 'Somehow', '2021-02-15 06:49:11', 'https://cdn.jsdelivr.net/gh/akabab/superhero-api@0.3.0/api/images/lg/289-goku.jpg', 24),
(44, 'Mariuzz', 'you', 'Magic in PHP', '2021-02-15', 'NewsArticle', 'Somehow', '2021-02-15 07:05:36', 'https://cdn.jsdelivr.net/gh/akabab/superhero-api@0.3.0/api/images/lg/289-goku.jpg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `artocle_topics`
--

CREATE TABLE `artocle_topics` (
  `article_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `artocle_topics`
--

INSERT INTO `artocle_topics` (`article_id`, `topic_id`) VALUES
(3, 1),
(3, 3),
(4, 4),
(4, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_area` varchar(225) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `comment_area`) VALUES
(4, 4, 5, 'Prie juros faina'),
(5, 4, 2, 'Prie juros faina'),
(6, 3, 2, 'Sveiki visi ziema'),
(7, 3, 3, 'Sveiki visi ziema'),
(8, 3, 4, 'Sveiki visi ziema'),
(9, 3, 6, 'Sveiki visi ziema'),
(17, 0, 1, 'Mano komentaras'),
(18, 5, 1, 'Sveiki jura');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `article_id` int(11) NOT NULL,
  `image` varchar(225) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`article_id`, `image`) VALUES
(3, 'https://picsum.photos/id/1038/200/300'),
(3, 'https://picsum.photos/id/1039/200/300'),
(3, 'https://picsum.photos/id/104/200/300'),
(3, 'https://picsum.photos/id/1040/200/300'),
(4, 'https://picsum.photos/id/1041/200/300'),
(4, 'https://picsum.photos/id/1042/200/300'),
(4, 'https://picsum.photos/id/1043/200/300'),
(4, 'https://picsum.photos/id/1044/200/300'),
(1, 'https://picsum.photos/id/1031/200/300'),
(1, 'https://picsum.photos/id/103/200/300'),
(1, 'https://picsum.photos/id/1029/200/300'),
(1, 'https://picsum.photos/id/1032/200/300'),
(5, 'https://picsum.photos/id/1045/200/300'),
(5, 'https://picsum.photos/id/1047/200/300'),
(5, 'https://picsum.photos/id/1048/200/300'),
(5, 'https://picsum.photos/id/1049/200/300'),
(0, 'https://picsum.photos/id/1054/200/300'),
(0, 'https://picsum.photos/id/1055/200/300'),
(0, 'https://picsum.photos/id/1056/200/300'),
(2, 'https://picsum.photos/id/1054/200/300'),
(2, 'https://picsum.photos/id/1055/200/300'),
(2, 'https://picsum.photos/id/1056/200/300');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic` varchar(40) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topic`) VALUES
(1, 'verslas'),
(2, 'kriminalai'),
(3, 'sportas'),
(4, 'orai'),
(5, 'Lietuva'),
(6, 'užsienis');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(80) COLLATE utf8_lithuanian_ci NOT NULL,
  `role` varchar(40) COLLATE utf8_lithuanian_ci NOT NULL,
  `pass` varchar(40) COLLATE utf8_lithuanian_ci NOT NULL,
  `access` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `role`, `pass`, `access`) VALUES
(1, 'John Doe', 'author', '111', 1),
(2, 'Belekas', 'author', '112', 1),
(3, 'Jonas Jon', 'author', '113', 1),
(4, 'PetrPetras', 'author', '114', 1),
(5, 'Vardenis su Pavarde', 'author', '115', 1),
(6, 'Betkas', 'author', '116', 1),
(7, 'Veikejas', 'author', '117', 1),
(8, 'auotritetas', 'author', '118', 1),
(9, 'Paprastas', 'standart', '119', 0),
(11, 'Marius', 'standart', '122', 1),
(12, 'adminas', 'admin', '999', 1),
(23, 'me', 'author', '128', 1),
(24, 'Mariuzz', 'author', '127', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_ibfk_1` (`user_id`);

--
-- Indexes for table `artocle_topics`
--
ALTER TABLE `artocle_topics`
  ADD KEY `artocle_topics_ibfk_2` (`topic_id`),
  ADD KEY `artocle_topics_ibfk_3` (`article_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`user_id`),
  ADD KEY `comments_ibfk_2` (`article_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pass` (`pass`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `artocle_topics`
--
ALTER TABLE `artocle_topics`
  ADD CONSTRAINT `artocle_topics_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `artocle_topics_ibfk_3` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
