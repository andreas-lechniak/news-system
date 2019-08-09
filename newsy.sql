-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Sie 2019, 10:00
-- Wersja serwera: 10.3.15-MariaDB
-- Wersja PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `testowa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsy`
--

CREATE TABLE `newsy` (
  `id` tinyint(4) NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `tytul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `tresc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `kategorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `data_dodania` date NOT NULL,
  `data_edycji` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `newsy`
--

INSERT INTO `newsy` (`id`, `autor`, `email`, `tytul`, `tresc`, `kategorie`, `data_dodania`, `data_edycji`) VALUES
(1, 'Admin', 'andrzej@o2.pl', 'WiadomoÅ›Ä‡ testowa', 'Lorem ipsum, dupa blada... bla bla b;la', 'Bez kategorii', '2019-08-08', '2019-08-09'),
(6, 'Wielki Lolo', 'lolo@o2.pl', 'News testowy', 'Nie wiem, co konkretnie napisaÄ‡. MoÅ¼e jednak TO...', 'Sprawy bieÅ¼Ä…ce', '2019-08-08', '2019-08-09'),
(7, 'Wielki LolesÅ‚aw', 'lola234@ola.pl', 'News testowa', 'Kurde, ile jeszcze', 'Sport', '2019-08-08', '0000-00-00'),
(8, 'Alunus', 'andrzejlechniak@wp.pl', 'News nowy', 'Inne, inne,', 'Informatyka', '2019-08-08', '0000-00-00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `newsy`
--
ALTER TABLE `newsy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `newsy`
--
ALTER TABLE `newsy`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
