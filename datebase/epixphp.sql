-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 22 2016 г., 21:57
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
  `date` datetime NOT NULL,
  `tags` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mesage`
--

INSERT INTO `mesage` (`id`, `userid`, `mes`, `date`, `tags`) VALUES
(1, 1, 'phpmyadmin insert,  id_user1', '0000-00-00 00:00:00', ''),
(2, 2, 'phpmyadmin insert, id_user 2, and time now', '0000-00-00 00:00:00', ''),
(4, 4, 'phpmy id4 now()', '2016-02-21 00:00:00', ''),
(18, 123, 'window 3', '2016-02-22 01:57:33', '');

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
(2, 'phpmyadmin', 'insert'),
(4, 'phpadm2', 'insert'),
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
