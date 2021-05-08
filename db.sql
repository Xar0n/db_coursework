-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 08 2021 г., 15:00
-- Версия сервера: 8.0.19
-- Версия PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ticket`
--

-- --------------------------------------------------------

--
-- Структура таблицы `aviakompaniya`
--

CREATE TABLE `aviakompaniya` (
  `id` int NOT NULL,
  `nazvanie` varchar(255) NOT NULL,
  `naselennyj_punkt` varchar(255) NOT NULL,
  `ulica` varchar(255) NOT NULL,
  `nomer_doma` varchar(255) NOT NULL,
  `ofis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `bilet`
--

CREATE TABLE `bilet` (
  `id` int NOT NULL,
  `shifr_aviakompanii` int NOT NULL,
  `nomer_kassy` int NOT NULL,
  `tabelnyj_nomer_kassira` int NOT NULL,
  `tip` varchar(255) NOT NULL,
  `data_prodazhi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `kassa`
--

CREATE TABLE `kassa` (
  `id` int NOT NULL,
  `naselennyj_punkt` varchar(255) NOT NULL,
  `ulica` varchar(255) NOT NULL,
  `nomer_doma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `kassir`
--

CREATE TABLE `kassir` (
  `id` int NOT NULL,
  `nomer_kassy` int NOT NULL,
  `familiya` varchar(255) NOT NULL,
  `imya` varchar(255) NOT NULL,
  `otchestvo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `klient`
--

CREATE TABLE `klient` (
  `id` int NOT NULL,
  `nomer_i_seriya_pasporta` varchar(10) NOT NULL,
  `familiya` varchar(255) NOT NULL,
  `imya` varchar(255) NOT NULL,
  `otchestvo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `kupon`
--

CREATE TABLE `kupon` (
  `id` int NOT NULL,
  `nomer_bileta` int NOT NULL,
  `nomer_i_seriya_pasporta_klienta` varchar(10) NOT NULL,
  `nunkt_posadki` varchar(255) NOT NULL,
  `nunkt_vysadki` varchar(255) NOT NULL,
  `tarif` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `aviakompaniya`
--
ALTER TABLE `aviakompaniya`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nazvanie` (`nazvanie`);

--
-- Индексы таблицы `bilet`
--
ALTER TABLE `bilet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bilet_fk0` (`shifr_aviakompanii`),
  ADD KEY `bilet_fk1` (`nomer_kassy`),
  ADD KEY `bilet_fk2` (`tabelnyj_nomer_kassira`);

--
-- Индексы таблицы `kassa`
--
ALTER TABLE `kassa`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kassir`
--
ALTER TABLE `kassir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kassir_fk0` (`nomer_kassy`);

--
-- Индексы таблицы `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomer_i_seriya_pasporta` (`nomer_i_seriya_pasporta`);

--
-- Индексы таблицы `kupon`
--
ALTER TABLE `kupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kupon_fk0` (`nomer_bileta`),
  ADD KEY `kupon_fk1` (`nomer_i_seriya_pasporta_klienta`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `aviakompaniya`
--
ALTER TABLE `aviakompaniya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bilet`
--
ALTER TABLE `bilet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `kassa`
--
ALTER TABLE `kassa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `kassir`
--
ALTER TABLE `kassir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `klient`
--
ALTER TABLE `klient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bilet`
--
ALTER TABLE `bilet`
  ADD CONSTRAINT `bilet_cascade_delete` FOREIGN KEY (`id`) REFERENCES `kupon` (`nomer_bileta`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `bilet_fk0` FOREIGN KEY (`shifr_aviakompanii`) REFERENCES `aviakompaniya` (`id`),
  ADD CONSTRAINT `bilet_fk1` FOREIGN KEY (`nomer_kassy`) REFERENCES `kassa` (`id`),
  ADD CONSTRAINT `bilet_fk2` FOREIGN KEY (`tabelnyj_nomer_kassira`) REFERENCES `kassir` (`id`);

--
-- Ограничения внешнего ключа таблицы `kassir`
--
ALTER TABLE `kassir`
  ADD CONSTRAINT `kassir_fk0` FOREIGN KEY (`nomer_kassy`) REFERENCES `kassa` (`id`);

--
-- Ограничения внешнего ключа таблицы `kupon`
--
ALTER TABLE `kupon`
  ADD CONSTRAINT `kupon_fk0` FOREIGN KEY (`nomer_bileta`) REFERENCES `bilet` (`id`),
  ADD CONSTRAINT `kupon_fk1` FOREIGN KEY (`nomer_i_seriya_pasporta_klienta`) REFERENCES `klient` (`nomer_i_seriya_pasporta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
