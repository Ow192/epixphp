-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 26 2016 г., 12:56
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
(135, 11, '2', '2016-02-26 15:55:11'),
(136, 11, '3', '2016-02-26 15:55:14'),
(137, 11, '4', '2016-02-26 15:55:16'),
(138, 11, '5', '2016-02-26 15:55:19'),
(139, 11, '6', '2016-02-26 15:55:24'),
(140, 11, 'tag: spase, tag1 ', '2016-02-26 15:55:56'),
(141, 11, '7', '2016-02-26 15:56:05'),
(142, 11, '8', '2016-02-26 15:56:08'),
(143, 11, '9', '2016-02-26 15:56:11'),
(144, 11, '10', '2016-02-26 15:56:14');

-- --------------------------------------------------------

--
-- Структура таблицы `tagmessageid`
--

CREATE TABLE `tagmessageid` (
  `id` int(10) UNSIGNED NOT NULL,
  `tagid` int(11) NOT NULL,
  `messageid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tagmessageid`
--

INSERT INTO `tagmessageid` (`id`, `tagid`, `messageid`) VALUES
(20, 23, 134),
(21, 21, 135),
(22, 21, 136),
(23, 21, 137),
(24, 21, 138),
(25, 21, 139),
(26, 24, 140),
(27, 6, 140),
(28, 24, 141),
(29, 21, 142),
(30, 21, 143),
(31, 21, 144);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'md5'),
(2, 'space'),
(3, 'SQl'),
(4, 'Lunix'),
(5, 'planet'),
(6, 'tag1'),
(7, 'tag2'),
(21, 'tags'),
(22, 'bbbbb'),
(23, 'firsttag'),
(24, 'spase');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(11, 'admin', '$2y$10$qwbaNMSDOWXm6pdabLJtfewlGQfNe/A36KvfMlscaQffKyjW5SQHK');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mesage`
--
ALTER TABLE `mesage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tagmessageid`
--
ALTER TABLE `tagmessageid`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT для таблицы `tagmessageid`
--
ALTER TABLE `tagmessageid`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
