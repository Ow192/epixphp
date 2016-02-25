-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 25 2016 г., 16:06
-- Версия сервера: 10.1.9-MariaDB
-- Версия PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `epixphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mesage`
--

CREATE TABLE `mesage` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) NOT NULL,
  `mes` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mesage`
--

INSERT INTO `mesage` (`id`, `userid`, `mes`, `date`) VALUES
(1, 1, 'phpmyadmin insert,  id_user1', '0000-00-00 00:00:00'),
(4, 4, 'phpmy id4 now()', '2016-02-21 00:00:00'),
(18, 123, 'window 3', '2016-02-22 01:57:33'),
(26, 11, '2111', '2016-02-25 01:46:46'),
(28, 1, 'asd2', '2016-02-25 11:29:35'),
(80, 5, '1', '2016-02-25 19:01:24'),
(81, 5, '2', '2016-02-25 19:01:27'),
(82, 5, '3', '2016-02-25 19:01:30'),
(83, 5, '4', '2016-02-25 19:01:32'),
(84, 5, '5', '2016-02-25 19:01:35'),
(85, 5, '6', '2016-02-25 19:01:37'),
(86, 5, '7', '2016-02-25 19:01:39'),
(87, 5, '8', '2016-02-25 19:01:41'),
(88, 5, '9', '2016-02-25 19:01:43');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin'),
(5, 'q12', 'q12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mesage`
--
ALTER TABLE `mesage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mesage`
--
ALTER TABLE `mesage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
