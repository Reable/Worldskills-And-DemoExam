-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 11 2022 г., 22:59
-- Версия сервера: 10.3.29-MariaDB
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subs` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='subscribes';

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`news_id`, `user_id`, `company`, `title`, `category`, `description`, `subs`, `image`, `created_at`, `updated_at`) VALUES
(6, 12, '1111111', '111111111111', '111111111111', '11111111111', 0, 'images/NR6jbnk7eQWC0Yo0iueebXMDKmJKkgCW5E6oEJ6r.jpg', '2022-03-11 18:38:31', '2022-03-11 15:38:31'),
(7, 12, '22222222', '333333333', '444444444', 'ewqwewqewqeqew', 0, 'images/oFlCtUOMzo36suctpqFdZ3E0vQcr7Wx5tntDHxR7.jpg', '2022-03-11 18:39:53', '2022-03-11 15:39:53'),
(8, 12, 'Company', 'Ядовитые плантации', 'Растения', 'Ядовитые плантации находяться в пригороде Москвы', 0, 'images/BvgAfFZaMqZvDfQezBgHRtlewt3GPZZt6Pxy0BEg.jpg', '2022-03-11 19:03:37', '2022-03-11 16:03:37');

-- --------------------------------------------------------

--
-- Структура таблицы `subs`
--

CREATE TABLE `subs` (
  `sub_id` int(11) NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `password`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 'admin', 'Иван', '$2y$10$IEIbrUtY63USNJ4o.3RZiu.6OB57llNGzxjgyk..ukDe1qo3WUMti', 'images/oroyhB6WZL1cDO41fQOBDA4KwcEdZynkkPMdHlYA.jpg', 'H1RjNDBQT0OKwdM1sgN8gJxhlBRA6bT6das6YviGTEnMiqRAgZ', '2022-03-10 18:11:36', '2022-03-11 16:43:22'),
(13, 'moder', 'Иван', '$2y$10$pRcl9syAuZPKsZsooOZeOeX8gifun51AF7m3xiEFIY.sZziMQqes6', 'images/NvuBAXIUVLXqVC5QxqNph9PBx018BGaPJTqQKe5A.jpg', 'CkYZYAyIpVOCjboQP0HLkieHPm3L3upW9dZeuVeEHr1V6LQ8cd', '2022-03-11 10:52:49', '2022-03-11 11:54:07'),
(14, 'user', 'Иван', '$2y$10$E1/o0hTRB3bh1q6t9EA5/eu15Dbk5jdzOojLSjc/6DmPwq95BkoaW', 'images/F1Lj0LsvIG8FEd7iJLjVPXnwfPVjwihXWEive35s.jpg', NULL, '2022-03-11 11:01:04', '2022-03-11 08:01:04'),
(15, 'user1', 'Иван', '$2y$10$cNCwYjMdwJduoVw1TCAYF.FowXlRHfvnqeRAzyXCxhs22JJyz3yzm', 'images/WIvZCO84iVPBMFOWCjUMnhVg1dsBzhdKkX0g3nsK.jpg', NULL, '2022-03-11 11:01:29', '2022-03-11 08:01:29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Индексы таблицы `subs`
--
ALTER TABLE `subs`
  ADD PRIMARY KEY (`sub_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `subs`
--
ALTER TABLE `subs`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
