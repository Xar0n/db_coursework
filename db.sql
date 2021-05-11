-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 11 2021 г., 11:54
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

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `PlistClientsOnDate` (IN `date` DATE)  SELECT klient.nomer_i_seriya_pasporta, klient.familiya, klient.imya, klient.otchestvo, kupon.nunkt_posadki, kupon.nunkt_vysadki, kupon.tarif, bilet.tip, bilet.data_prodazhi, bilet.shifr_aviakompanii, aviakompaniya.nazvanie, aviakompaniya.naselennyj_punkt, aviakompaniya.ulica, aviakompaniya.nomer_doma, aviakompaniya.ofis FROM `klient`, `kupon`, `bilet`, `aviakompaniya` WHERE bilet.id = kupon.nomer_bileta AND klient.nomer_i_seriya_pasporta = kupon.nomer_i_seriya_pasporta_klienta and bilet.shifr_aviakompanii = aviakompaniya.id and bilet.data_prodazhi = date$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `PsalesMonthSelectCompany` (IN `date` DATE, IN `shifr_aviakompanii` INT UNSIGNED)  SELECT bilet.*, aviakompaniya.nazvanie AS nazvanie_a, aviakompaniya.naselennyj_punkt AS naselennyj_punkt_a,  aviakompaniya.ulica AS ulica_a, aviakompaniya.nomer_doma AS nomer_doma_a, aviakompaniya.ofis AS ofis_a, kassa.naselennyj_punkt, kassa.ulica, kassa.nomer_doma, kassir.familiya, kassir.imya, kassir.otchestvo FROM `bilet`, `aviakompaniya`, `kassa`, `kassir` WHERE month(`data_prodazhi`) = month(date) AND `shifr_aviakompanii` = shifr_aviakompanii AND bilet.shifr_aviakompanii = aviakompaniya.id AND bilet.nomer_kassy = kassa.id AND bilet.tabelnyj_nomer_kassira = kassir.id$$

DELIMITER ;

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


--
-- Дублирующая структура для представления `bilet_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `bilet_view` (
`id` int
,`shifr_aviakompanii` int
,`nomer_kassy` int
,`tabelnyj_nomer_kassira` int
,`tip` varchar(255)
,`data_prodazhi` date
,`nazvanie_a` varchar(255)
,`naselennyj_punkt_a` varchar(255)
,`ulica_a` varchar(255)
,`nomer_doma_a` varchar(255)
,`ofis_a` varchar(255)
,`naselennyj_punkt` varchar(255)
,`ulica` varchar(255)
,`nomer_doma` varchar(255)
,`familiya` varchar(255)
,`imya` varchar(255)
,`otchestvo` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `generalsales_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `generalsales_view` (
`SUM(sum_sales)` decimal(54,0)
,`id` int
,`nazvanie` varchar(255)
,`naselennyj_punkt` varchar(255)
,`ulica` varchar(255)
,`nomer_doma` varchar(255)
,`ofis` varchar(255)
);

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

--
-- Дублирующая структура для представления `kassir_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `kassir_view` (
`id` int
,`nomer_kassy` int
,`familiya` varchar(255)
,`imya` varchar(255)
,`otchestvo` varchar(255)
,`naselennyj_punkt` varchar(255)
,`ulica` varchar(255)
,`nomer_doma` varchar(255)
);

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
-- Дублирующая структура для представления `kupon_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `kupon_view` (
`id` int
,`nomer_bileta` int
,`nomer_i_seriya_pasporta_klienta` varchar(10)
,`nunkt_posadki` varchar(255)
,`nunkt_vysadki` varchar(255)
,`tarif` int
,`tip` varchar(255)
,`data_prodazhi` date
,`shifr_aviakompanii` int
,`tabelnyj_nomer_kassira` int
,`familiya` varchar(255)
,`imya` varchar(255)
,`otchestvo` varchar(255)
,`nazvanie_a` varchar(255)
,`naselennyj_punkt_a` varchar(255)
,`ulica_a` varchar(255)
,`nomer_doma_a` varchar(255)
,`ofis_a` varchar(255)
,`familiya_kas` varchar(255)
,`imya_kas` varchar(255)
,`otchestvo_kas` varchar(255)
,`naselennyj_punkt` varchar(255)
,`ulica` varchar(255)
,`nomer_doma` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `profitbybilets_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `profitbybilets_view` (
`id` int
,`shifr_aviakompanii` int
,`nomer_kassy` int
,`tabelnyj_nomer_kassira` int
,`tip` varchar(255)
,`data_prodazhi` date
,`id_a` int
,`nazvanie` varchar(255)
,`naselennyj_punkt` varchar(255)
,`ulica` varchar(255)
,`nomer_doma` varchar(255)
,`ofis` varchar(255)
,`sum_sales` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Структура для представления `bilet_view`
--
DROP TABLE IF EXISTS `bilet_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `bilet_view`  AS SELECT `bilet`.`id` AS `id`, `bilet`.`shifr_aviakompanii` AS `shifr_aviakompanii`, `bilet`.`nomer_kassy` AS `nomer_kassy`, `bilet`.`tabelnyj_nomer_kassira` AS `tabelnyj_nomer_kassira`, `bilet`.`tip` AS `tip`, `bilet`.`data_prodazhi` AS `data_prodazhi`, `aviakompaniya`.`nazvanie` AS `nazvanie_a`, `aviakompaniya`.`naselennyj_punkt` AS `naselennyj_punkt_a`, `aviakompaniya`.`ulica` AS `ulica_a`, `aviakompaniya`.`nomer_doma` AS `nomer_doma_a`, `aviakompaniya`.`ofis` AS `ofis_a`, `kassa`.`naselennyj_punkt` AS `naselennyj_punkt`, `kassa`.`ulica` AS `ulica`, `kassa`.`nomer_doma` AS `nomer_doma`, `kassir`.`familiya` AS `familiya`, `kassir`.`imya` AS `imya`, `kassir`.`otchestvo` AS `otchestvo` FROM (((`bilet` join `aviakompaniya`) join `kassa`) join `kassir`) WHERE ((`bilet`.`shifr_aviakompanii` = `aviakompaniya`.`id`) AND (`bilet`.`nomer_kassy` = `kassa`.`id`) AND (`bilet`.`tabelnyj_nomer_kassira` = `kassir`.`id`)) ;

-- --------------------------------------------------------

--
-- Структура для представления `generalsales_view`
--
DROP TABLE IF EXISTS `generalsales_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `generalsales_view`  AS SELECT sum(`profitbybilets_view`.`sum_sales`) AS `SUM(sum_sales)`, `aviakompaniya`.`id` AS `id`, `aviakompaniya`.`nazvanie` AS `nazvanie`, `aviakompaniya`.`naselennyj_punkt` AS `naselennyj_punkt`, `aviakompaniya`.`ulica` AS `ulica`, `aviakompaniya`.`nomer_doma` AS `nomer_doma`, `aviakompaniya`.`ofis` AS `ofis` FROM (`profitbybilets_view` join `aviakompaniya`) WHERE (`aviakompaniya`.`id` = `profitbybilets_view`.`shifr_aviakompanii`) GROUP BY `profitbybilets_view`.`shifr_aviakompanii` ;

-- --------------------------------------------------------

--
-- Структура для представления `kassir_view`
--
DROP TABLE IF EXISTS `kassir_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `kassir_view`  AS SELECT `kassir`.`id` AS `id`, `kassir`.`nomer_kassy` AS `nomer_kassy`, `kassir`.`familiya` AS `familiya`, `kassir`.`imya` AS `imya`, `kassir`.`otchestvo` AS `otchestvo`, `kassa`.`naselennyj_punkt` AS `naselennyj_punkt`, `kassa`.`ulica` AS `ulica`, `kassa`.`nomer_doma` AS `nomer_doma` FROM (`kassir` join `kassa`) WHERE (`kassir`.`nomer_kassy` = `kassa`.`id`) ;

-- --------------------------------------------------------

--
-- Структура для представления `kupon_view`
--
DROP TABLE IF EXISTS `kupon_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `kupon_view`  AS SELECT `kupon`.`id` AS `id`, `kupon`.`nomer_bileta` AS `nomer_bileta`, `kupon`.`nomer_i_seriya_pasporta_klienta` AS `nomer_i_seriya_pasporta_klienta`, `kupon`.`nunkt_posadki` AS `nunkt_posadki`, `kupon`.`nunkt_vysadki` AS `nunkt_vysadki`, `kupon`.`tarif` AS `tarif`, `bilet`.`tip` AS `tip`, `bilet`.`data_prodazhi` AS `data_prodazhi`, `bilet`.`shifr_aviakompanii` AS `shifr_aviakompanii`, `bilet`.`tabelnyj_nomer_kassira` AS `tabelnyj_nomer_kassira`, `klient`.`familiya` AS `familiya`, `klient`.`imya` AS `imya`, `klient`.`otchestvo` AS `otchestvo`, `aviakompaniya`.`nazvanie` AS `nazvanie_a`, `aviakompaniya`.`naselennyj_punkt` AS `naselennyj_punkt_a`, `aviakompaniya`.`ulica` AS `ulica_a`, `aviakompaniya`.`nomer_doma` AS `nomer_doma_a`, `aviakompaniya`.`ofis` AS `ofis_a`, `kassir`.`familiya` AS `familiya_kas`, `kassir`.`imya` AS `imya_kas`, `kassir`.`otchestvo` AS `otchestvo_kas`, `kassa`.`naselennyj_punkt` AS `naselennyj_punkt`, `kassa`.`ulica` AS `ulica`, `kassa`.`nomer_doma` AS `nomer_doma` FROM (((((`kupon` join `bilet`) join `klient`) join `aviakompaniya`) join `kassir`) join `kassa`) WHERE ((`kupon`.`nomer_bileta` = `bilet`.`id`) AND (`klient`.`nomer_i_seriya_pasporta` = `kupon`.`nomer_i_seriya_pasporta_klienta`) AND (`bilet`.`shifr_aviakompanii` = `aviakompaniya`.`id`) AND (`bilet`.`tabelnyj_nomer_kassira` = `kassir`.`id`) AND (`kassa`.`id` = `kassir`.`nomer_kassy`)) ;

-- --------------------------------------------------------

--
-- Структура для представления `profitbybilets_view`
--
DROP TABLE IF EXISTS `profitbybilets_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `profitbybilets_view`  AS SELECT `bilet`.`id` AS `id`, `bilet`.`shifr_aviakompanii` AS `shifr_aviakompanii`, `bilet`.`nomer_kassy` AS `nomer_kassy`, `bilet`.`tabelnyj_nomer_kassira` AS `tabelnyj_nomer_kassira`, `bilet`.`tip` AS `tip`, `bilet`.`data_prodazhi` AS `data_prodazhi`, `aviakompaniya`.`id` AS `id_a`, `aviakompaniya`.`nazvanie` AS `nazvanie`, `aviakompaniya`.`naselennyj_punkt` AS `naselennyj_punkt`, `aviakompaniya`.`ulica` AS `ulica`, `aviakompaniya`.`nomer_doma` AS `nomer_doma`, `aviakompaniya`.`ofis` AS `ofis`, (select sum(`kupon`.`tarif`) from `kupon` where ((`bilet`.`id` = `kupon`.`nomer_bileta`) and (`aviakompaniya`.`id` = `bilet`.`shifr_aviakompanii`))) AS `sum_sales` FROM ((`bilet` join `kupon`) join `aviakompaniya`) WHERE ((`bilet`.`id` = `kupon`.`nomer_bileta`) AND (`aviakompaniya`.`id` = `bilet`.`shifr_aviakompanii`)) GROUP BY `bilet`.`id` ;

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
  ADD KEY `kupon_fk1` (`nomer_i_seriya_pasporta_klienta`),
  ADD KEY `kupon_delete_cascade` (`nomer_bileta`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `aviakompaniya`
--
ALTER TABLE `aviakompaniya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bilet`
--
ALTER TABLE `bilet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `kassa`
--
ALTER TABLE `kassa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `kassir`
--
ALTER TABLE `kassir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `klient`
--
ALTER TABLE `klient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bilet`
--
ALTER TABLE `bilet`
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
  ADD CONSTRAINT `kupon_delete_cascade` FOREIGN KEY (`nomer_bileta`) REFERENCES `bilet` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `kupon_fk0` FOREIGN KEY (`nomer_bileta`) REFERENCES `bilet` (`id`),
  ADD CONSTRAINT `kupon_fk1` FOREIGN KEY (`nomer_i_seriya_pasporta_klienta`) REFERENCES `klient` (`nomer_i_seriya_pasporta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
