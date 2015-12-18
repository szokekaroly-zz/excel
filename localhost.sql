-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Gép: localhost
-- Létrehozás ideje: 2015. Dec 17. 08:01
-- Kiszolgáló verziója: 10.0.22-MariaDB-0ubuntu0.15.10.1
-- PHP verzió: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `excel`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `excel`
--

CREATE TABLE IF NOT EXISTS `excel` (
  `col` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `value` varchar(200) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `excel`
--

INSERT INTO `excel` (`col`, `row`, `value`) VALUES
(4, 4, '1'),
(9, 1, '1'),
(8, 8, '11'),
(5, 3, '123'),
(8, 9, '1968.04.27'),
(4, 5, '2'),
(4, 6, '3'),
(9, 2, '3'),
(4, 7, '4'),
(9, 3, '4'),
(5, 4, '44'),
(7, 1, '44'),
(4, 8, '5'),
(9, 4, '5'),
(8, 10, '55'),
(4, 9, '6'),
(9, 5, '6'),
(4, 10, '7'),
(9, 6, '7'),
(4, 11, '8'),
(9, 7, '8'),
(4, 12, '9'),
(9, 8, '9'),
(5, 2, 'aaa'),
(3, 6, 'dd'),
(9, 10, 'dd'),
(4, 1, 'ddd'),
(2, 9, 'eetet'),
(5, 1, 'ff'),
(7, 4, 'ff'),
(6, 5, 'fff'),
(2, 10, 'fffff'),
(7, 2, 'fghjkl'),
(9, 11, 'g'),
(5, 12, 'gg'),
(7, 8, 'gg'),
(6, 6, 'h'),
(6, 4, 'hgd'),
(12, 7, 'hh'),
(9, 12, 'j'),
(11, 12, 'karcsi'),
(8, 5, 'nnkn '),
(4, 13, 'ö'),
(9, 9, 'ö'),
(9, 13, 'w');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `maxcol` int(11) NOT NULL DEFAULT '15',
  `maxrow` int(11) NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `settings`
--

INSERT INTO `settings` (`maxcol`, `maxrow`) VALUES
(15, 16);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `excel`
--
ALTER TABLE `excel`
  ADD UNIQUE KEY `col` (`col`,`row`),
  ADD KEY `value` (`value`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
