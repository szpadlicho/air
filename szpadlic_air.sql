-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Gru 2016, 00:05
-- Wersja serwera: 5.7.14
-- Wersja PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `szpadlic_air`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `category` text,
  `protect` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `c_visibility` int(1) UNSIGNED DEFAULT NULL,
  `mod` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`c_id`, `category`, `protect`, `password`, `c_visibility`, `mod`) VALUES
(1, 'Air Show Warszawa', '0', '', 1, 0),
(2, 'Air Show Radom', '0', '', 1, 0),
(3, 'Air Shop', '0', '', 1, 0),
(4, 'Chill', '0', '', 1, NULL),
(5, 'USA 2016 wilk', '0', '', 1, NULL),
(6, 'something', '0', '', 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `description`
--

CREATE TABLE `description` (
  `d_id` int(11) NOT NULL,
  `home_des` text,
  `d_visibility` int(1) UNSIGNED DEFAULT NULL,
  `mod` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `description`
--

INSERT INTO `description` (`d_id`, `home_des`, `d_visibility`, `mod`) VALUES
(1, 'Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id, eleifend justo vel bibendum sapien massa ac turpis faucibus orci luctus non, consectetuer lobortis quis, varius in, purus. Integer ultrices posuere cubilia Curae, Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque penatibus et ultrices volutpat. Nullam wisi ultricies a, gravida vitae, dapibus risus ante sodales lectus blandit eu, tempor diam pede cursus vitae, ultricies eu, faucibus quis, porttitor eros cursus lectus, pellentesque eget, bibendum a, gravida ullamcorper quam. Nullam viverra consectetuer. Quisque cursus et, porttitor risus. Aliquam sem. In hendrerit nulla quam nunc, accumsan congue. Lorem ipsum primis in nibh vel risus. Sed vel lectus. Ut sagittis, ipsum dolor quam.', 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `p_id` int(11) NOT NULL,
  `photo_name` text,
  `photo_mime` varchar(20) DEFAULT NULL,
  `photo_size` varchar(20) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `sub_category` varchar(20) DEFAULT NULL,
  `add_data` datetime DEFAULT NULL,
  `update_data` datetime DEFAULT NULL,
  `show_data` date DEFAULT NULL,
  `show_place` varchar(50) DEFAULT NULL,
  `tag` text,
  `author` varchar(20) DEFAULT NULL,
  `home` varchar(20) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `protect` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `p_visibility` int(1) UNSIGNED DEFAULT NULL,
  `mod` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `photos`
--

INSERT INTO `photos` (`p_id`, `photo_name`, `photo_mime`, `photo_size`, `category`, `sub_category`, `add_data`, `update_data`, `show_data`, `show_place`, `tag`, `author`, `home`, `position`, `protect`, `password`, `p_visibility`, `mod`) VALUES
(1, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (1).jpg', 'jpg', '468017', '1', '', '2016-11-30 17:09:53', '2016-11-30 17:09:53', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(2, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (2).jpg', 'jpg', '725813', '1', '', '2016-11-30 17:09:53', '2016-11-30 17:09:53', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(3, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (3).jpg', 'jpg', '890806', '1', '', '2016-11-30 17:09:54', '2016-11-30 17:09:54', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(4, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (4).jpg', 'jpg', '239074', '1', '', '2016-11-30 17:09:54', '2016-11-30 17:09:54', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(5, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (5).jpg', 'jpg', '832077', '1', '', '2016-11-30 17:09:54', '2016-11-30 17:09:54', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(6, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (6).jpg', 'jpg', '1688672', '1', '', '2016-11-30 17:09:54', '2016-11-30 17:09:54', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(7, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (7).jpg', 'jpg', '2045711', '1', '', '2016-11-30 17:09:54', '2016-11-30 17:09:54', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(8, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (8).jpg', 'jpg', '3593197', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(9, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (9).jpg', 'jpg', '580016', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(10, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (10).jpg', 'jpg', '322658', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(11, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (11).jpg', 'jpg', '566052', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(12, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (12).jpg', 'jpg', '457449', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(13, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (13).jpg', 'jpg', '448116', '1', '', '2016-11-30 17:09:55', '2016-11-30 17:09:55', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(14, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (14).jpg', 'jpg', '750943', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(15, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (15).jpg', 'jpg', '667621', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(16, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (16).jpg', 'jpg', '940866', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(17, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (17).jpg', 'jpg', '800908', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(18, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (18).jpg', 'jpg', '925719', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(19, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (19).jpg', 'jpg', '920228', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(20, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (20).jpg', 'jpg', '595142', '1', '', '2016-11-30 17:09:56', '2016-11-30 17:09:56', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(21, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (21).jpg', 'jpg', '969408', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(22, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (22).jpg', 'jpg', '589904', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(23, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (23).jpg', 'jpg', '787209', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(24, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (24).jpg', 'jpg', '900217', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(25, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (25).jpg', 'jpg', '1428961', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(26, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (26).jpg', 'jpg', '1242299', '1', '', '2016-11-30 17:09:57', '2016-11-30 17:09:57', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(27, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (27).jpg', 'jpg', '1528319', '1', '', '2016-11-30 17:09:58', '2016-11-30 17:09:58', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(28, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (28).jpg', 'jpg', '1939752', '1', '', '2016-11-30 17:09:58', '2016-11-30 17:09:58', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(29, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (29).jpg', 'jpg', '738531', '1', '', '2016-11-30 17:09:58', '2016-11-30 17:09:58', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(30, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (30).jpg', 'jpg', '1649161', '1', '', '2016-11-30 17:09:58', '2016-11-30 17:09:58', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(31, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (31).jpg', 'jpg', '1828411', '1', '', '2016-11-30 17:09:59', '2016-11-30 17:09:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(32, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (32).jpg', 'jpg', '2125662', '1', '', '2016-11-30 17:09:59', '2016-11-30 17:09:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(33, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (33).jpg', 'jpg', '1974310', '1', '', '2016-11-30 17:09:59', '2016-11-30 17:09:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(34, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (34).jpg', 'jpg', '1805637', '1', '', '2016-11-30 17:09:59', '2016-11-30 17:09:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(35, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (35).jpg', 'jpg', '2174449', '1', '', '2016-11-30 17:10:00', '2016-11-30 17:10:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(36, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (36).jpg', 'jpg', '2302953', '1', '', '2016-11-30 17:10:00', '2016-11-30 17:10:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(37, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (37).jpg', 'jpg', '2918800', '1', '', '2016-11-30 17:10:00', '2016-11-30 17:10:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(38, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (38).jpg', 'jpg', '6447554', '1', '', '2016-11-30 17:10:01', '2016-11-30 17:10:01', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(39, '', 'jpg', '279773', '4', '', '2016-11-30 17:10:01', '2016-11-30 17:33:02', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '1', '', '0', '', 1, NULL),
(40, '', 'jpg', '838491', '1', '', '2016-11-30 17:10:01', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(41, '', 'jpg', '740007', '1', '', '2016-11-30 17:10:01', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(42, '', 'jpg', '457302', '1', '', '2016-11-30 17:10:01', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(43, '', 'jpg', '735938', '1', '', '2016-11-30 17:10:02', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(44, '', 'jpg', '558900', '1', '', '2016-11-30 17:10:02', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(45, '', 'jpg', '945101', '1', '', '2016-11-30 17:10:02', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(46, '', 'jpg', '252806', '1', '', '2016-11-30 17:10:02', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '', '', '0', '', 1, NULL),
(47, '', 'jpg', '1255558', '1', '', '2016-11-30 17:10:02', '2016-12-01 15:52:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '', '', '0', '', 1, NULL),
(48, '', 'jpg', '794892', '1', '', '2016-11-30 17:10:02', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(49, '', 'jpg', '1078487', '1', '', '2016-11-30 17:10:03', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(50, '', 'jpg', '441404', '1', '', '2016-11-30 17:10:03', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(51, '', 'jpg', '1019168', '1', '', '2016-11-30 17:10:03', '2016-12-01 15:52:59', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(52, '', 'jpg', '1174981', '1', '', '2016-11-30 17:10:03', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(53, '', 'jpg', '1157638', '1', '', '2016-11-30 17:10:03', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(54, '', 'jpg', '2491906', '4', '', '2016-11-30 17:10:04', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '1', '', '0', '', 1, NULL),
(55, '', 'jpg', '2159447', '4', '', '2016-11-30 17:10:04', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(56, '', 'jpg', '2937843', '1', '', '2016-11-30 17:10:04', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(57, '', 'jpg', '2772792', '4', '', '2016-11-30 17:10:04', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '1', '', '0', '', 1, NULL),
(58, '', 'jpg', '3061615', '4', '', '2016-11-30 17:10:05', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(59, '', 'jpg', '3020733', '4', '', '2016-11-30 17:10:05', '2016-11-30 17:32:49', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(60, '', 'jpg', '3069942', '4', '', '2016-11-30 17:10:06', '2016-11-30 17:32:16', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(61, '', 'jpg', '1478106', '1', '', '2016-11-30 17:10:06', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(62, '', 'jpg', '752978', '1', '', '2016-11-30 17:10:06', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(63, '', 'jpg', '2455110', '4', '', '2016-11-30 17:10:06', '2016-11-30 17:32:16', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(64, '', 'jpg', '1930136', '4', '', '2016-11-30 17:10:07', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(65, '', 'jpg', '721813', '1', '', '2016-11-30 17:10:07', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(66, '', 'jpg', '753861', '1', '', '2016-11-30 17:10:07', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(67, '', 'jpg', '733254', '1', '', '2016-11-30 17:10:07', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(68, '', 'jpg', '886209', '1', '', '2016-11-30 17:10:07', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(69, '', 'jpg', '859220', '1', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(70, '', 'jpg', '581097', '1', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(71, '', 'jpg', '575602', '1', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(72, '', 'jpg', '546251', '1', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(73, '', 'jpg', '639445', '4', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(74, '', 'jpg', '619262', '4', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(75, '', 'jpg', '620436', '4', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(76, '', 'jpg', '372132', '1', '', '2016-11-30 17:10:08', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(77, '', 'jpg', '2257220', '4', '', '2016-11-30 17:10:09', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(78, '', 'jpg', '1981398', '4', '', '2016-11-30 17:10:09', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(79, '', 'jpg', '934577', '4', '', '2016-11-30 17:10:09', '2016-12-01 15:53:00', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '', '', '0', '', 1, NULL),
(80, '', 'jpg', '1127798', '4', '', '2016-11-30 17:10:09', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(81, '', 'jpg', '1168138', '2', '', '2016-11-30 17:10:10', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(82, '', 'jpg', '787311', '2', '', '2016-11-30 17:10:10', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(83, '', 'jpg', '645670', '4', '', '2016-11-30 17:10:10', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(84, '', 'jpg', '1450313', '3', '', '2016-11-30 17:10:10', '2016-12-01 19:59:29', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 0, NULL),
(85, '', 'jpg', '2492428', '4', '', '2016-11-30 17:10:10', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(86, '', 'jpg', '777484', '4', '', '2016-11-30 17:10:10', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(87, '', 'jpg', '1005391', '4', '', '2016-11-30 17:10:11', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(88, '', 'jpg', '584347', '4', '', '2016-11-30 17:10:11', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(89, '', 'jpg', '1319164', '4', '', '2016-11-30 17:10:11', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(90, '', 'jpg', '465504', '2', '', '2016-11-30 17:10:11', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(91, '', 'jpg', '1401937', '4', '', '2016-11-30 17:10:11', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(92, '', 'jpg', '1325035', '4', '', '2016-11-30 17:10:12', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(93, '', 'jpg', '1814256', '2', '', '2016-11-30 17:10:12', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(94, '', 'jpg', '2382279', '4', '', '2016-11-30 17:10:12', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(95, '', 'jpg', '2343817', '4', '', '2016-11-30 17:10:13', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(96, '', 'jpg', '2228861', '2', '', '2016-11-30 17:10:13', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(97, '', 'jpg', '2033588', '2', '', '2016-11-30 17:10:13', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 0, NULL),
(98, '', 'jpg', '2408294', '4', '', '2016-11-30 17:10:13', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'deoc', '0', '', '0', '', 1, NULL),
(99, '', 'jpg', '976619', '4', '', '2016-12-01 17:10:13', '2016-12-01 18:27:06', '2016-11-30', 'cz-wa', 'raz dwa trzy', 'pio', '0', '', '0', '', 1, NULL),
(100, '', 'jpg', '787209', '5', '', '2016-12-01 18:52:48', '2016-12-01 23:04:06', '2016-12-01', 'cze', 'one', 'red', '0', '', '0', '', 1, NULL),
(101, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (24).jpg', 'jpg', '900217', '5', '', '2016-12-01 22:51:48', '2016-12-01 18:52:48', '2016-12-01', 'cze', 'one', 'mmm', '0', '', '0', '', 1, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slider`
--

CREATE TABLE `slider` (
  `s_id` int(11) NOT NULL,
  `slider_name` text,
  `slider_mime` varchar(20) DEFAULT NULL,
  `slider_src` text,
  `slider_href` text,
  `slider_alt` text,
  `slider_title` text,
  `slider_des` text,
  `s_visibility` int(1) UNSIGNED DEFAULT NULL,
  `mod` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `slider`
--

INSERT INTO `slider` (`s_id`, `slider_name`, `slider_mime`, `slider_src`, `slider_href`, `slider_alt`, `slider_title`, `slider_des`, `s_visibility`, `mod`) VALUES
(1, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (57).jpg', 'jpg', '', 'galery&cat_id=4', 'alt text 1', 'title text 1', 'decryption text 1', 1, NULL),
(2, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (60).jpg', 'jpg', '', '#', 'alt text 2', 'title text 2', 'decryption text 2', 1, NULL),
(3, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (64).jpg', 'jpg', '', '#', 'alt text 3', 'title text 3', 'decryption text 3', 1, NULL),
(4, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (74).jpg', 'jpg', '', '#', 'alt text 4', 'title text 4', 'decryption text 4', 1, NULL),
(5, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (83).jpg', 'jpg', '', '#', 'alt text 5', 'title text 5', 'decryption text 5', 1, NULL),
(6, '100 Beautiful Girls Wallpapers Set-13 [ewallpics] (92).jpg', 'jpg', '', '#', 'alt text 6', 'title text 6', 'decryption text 6', 1, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `description`
--
ALTER TABLE `description`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT dla tabeli `slider`
--
ALTER TABLE `slider`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
