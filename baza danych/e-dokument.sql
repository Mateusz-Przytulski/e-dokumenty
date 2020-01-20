-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Lip 2019, 06:20
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `e-dokument`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dokument`
--

CREATE TABLE `dokument` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(255) NOT NULL,
  `nazwa_dokumentu` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `rodzaj_uzytkownika` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `imie` tinyint(1) NOT NULL,
  `drugie_imie` tinyint(1) NOT NULL,
  `nazwisko` tinyint(1) NOT NULL,
  `nazwa_firmy` tinyint(1) NOT NULL,
  `email_uzytkownik_firma` tinyint(1) NOT NULL,
  `telefon` tinyint(1) NOT NULL,
  `data_urodzenia` tinyint(1) NOT NULL,
  `kraj` tinyint(1) NOT NULL,
  `miasto` tinyint(1) NOT NULL,
  `adres` tinyint(1) NOT NULL,
  `kod_pocztowy` tinyint(1) NOT NULL,
  `pesel_nip` tinyint(1) NOT NULL,
  `regon` tinyint(1) NOT NULL,
  `zatwierdzony` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dokument`
--

INSERT INTO `dokument` (`id`, `id_uzytkownika`, `nazwa_dokumentu`, `rodzaj_uzytkownika`, `imie`, `drugie_imie`, `nazwisko`, `nazwa_firmy`, `email_uzytkownik_firma`, `telefon`, `data_urodzenia`, `kraj`, `miasto`, `adres`, `kod_pocztowy`, `pesel_nip`, `regon`, `zatwierdzony`) VALUES
(2, 14, 'Podanie na praktyki', 'uzytkownik', 1, 0, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0, 0, 1),
(3, 17, ' Stworzony przez uÅ¼ytkownika', 'uzytkownik', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 17, 'tsadgs  Stworzony przez uÅ¼ytkownika', 'uzytkownik', 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 17, ' Stworzony przez uÅ¼ytkownika', 'uzytkownik', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(255) NOT NULL,
  `opinia` varchar(5000) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `opinie`
--

INSERT INTO `opinie` (`id`, `id_uzytkownika`, `opinia`) VALUES
(2, 16, '$iduzytkownika$iduzytkownika$iduzytkownika$iduzytkownika$iduzytkownika$iduzytkownika'),
(3, 16, 'fsdakjnnioasdnfosdnaofn osdanfo asdnofnasodnfo asdfasd'),
(6, 17, 'sfdaf sdafs dafsd afsdafsda fsda fsdaf'),
(7, 16, 'fsdaf sdaf sdafasdf asdfas dfsdafas df');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `id_uzytkownika` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `login` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `telefon` varchar(12) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `drugie_imie` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `kraj` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `miasto` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `adres` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `kod_pocztowy` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `pesel_nip` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `data_urodzenia` varchar(16) COLLATE utf8_polish_ci NOT NULL,
  `nazwa_firmy` varchar(250) COLLATE utf8_polish_ci NOT NULL,
  `rodzaj_uzytkownika` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `regon` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownik`
--

INSERT INTO `uzytkownik` (`id_uzytkownika`, `admin`, `login`, `haslo`, `email`, `telefon`, `imie`, `drugie_imie`, `nazwisko`, `kraj`, `miasto`, `adres`, `kod_pocztowy`, `pesel_nip`, `data_urodzenia`, `nazwa_firmy`, `rodzaj_uzytkownika`, `regon`) VALUES
(14, 1, 'admin123', '$2y$10$aCXMlJqn1.FuQllH7Nf.iu6oXpPWE2x3wSj49Vi1gLdXjGNmkf/42', 'admin123@gmail.com', '000-000-000', 'Admin', '', 'Admin', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Admin', 'UÅ¼ytkownik', '00000000000'),
(16, 0, 'testinstytucja', '$2y$10$oHG9LdUd/vskhA2wfJhECuXh6fK19kiE0ob9Bau6yKHC.MJ1/OTYC', 'testinstytucja2@gmail.com', 'Nie podano', '', '', '', 'Testinstytucja', 'Testinstytucja', 'testinstytucja', '35-445', '845-849-84-94', '', 'fhghdghfdgh fdgh', 'Instytucja', 'Nie podano'),
(17, 0, 'testuzytkownik', '$2y$10$qtVi04QfGt.Ng6803Hsab..ch7GlNYPSxe47Vq5I1BIHuHu3X/SOy', 'testuzytkownik@gmail.com', '516-545-846', 'Fsdafsdfsa', '', 'Testuzytkownik', 'Nie podano', 'BiaÅ‚ystok', 'Mieszka #1', '23-13', '13231233124', 'Nie podano', '', 'UÅ¼ytkownik', ''),
(18, 0, 'mateusz', '$2y$10$ZxY7HmEcEzqYwXi0LeuSKe3EA0mIlf8PbadPUcFjbQBpe/p1MjtFi', 'jan.kowalski@gmail.com', '503-598-927', 'Jan', '', 'Kowalski', 'Nie podano', 'BiaÅ‚ystok', 'Nie podano', 'Nie podano', '99010107294', 'Nie podano', '', 'UÅ¼ytkownik', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

CREATE TABLE `wiadomosci` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(255) NOT NULL,
  `wiadomosc` varchar(500) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wiadomosci`
--

INSERT INTO `wiadomosci` (`id`, `id_uzytkownika`, `wiadomosc`) VALUES
(58, 16, 'fds');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenia`
--

CREATE TABLE `zgloszenia` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(255) NOT NULL,
  `problem` varchar(5000) COLLATE utf8_polish_ci NOT NULL,
  `odpowiedz` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zgloszenia`
--

INSERT INTO `zgloszenia` (`id`, `id_uzytkownika`, `problem`, `odpowiedz`) VALUES
(1, 16, 'asdasfsda fsda fsad fsad fasd fsad @odpowiedz\r\ngdfsgfds @odpowiedz fgds', 0),
(4, 17, 'fds afdsaf sdafsda fsdaf asdf asfd uzytkownik @odpowiedz\r\ndfgsfsdgdfsgsdf gdfs @odpowiedz gdfsgds @odpowiedz gsdfg @odpowiedz fhdg', 0),
(5, 16, 'fdsa fsdfsd afsdaf asdfsda fsda sda fsda instytucja @odpowiedz\r\ndfgsdfsg', 1),
(6, 17, 'fsdafasdf dasf asdf asdf asdf asdfasd fasd @odpowiedz fd', 1),
(7, 17, 'fsdaf asdf asdfads fasdasd fasd afsd', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dokument`
--
ALTER TABLE `dokument`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`id_uzytkownika`);

--
-- Indeksy dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dokument`
--
ALTER TABLE `dokument`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `opinie`
--
ALTER TABLE `opinie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `dokument`
--
ALTER TABLE `dokument`
  ADD CONSTRAINT `dokument_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id_uzytkownika`);

--
-- Ograniczenia dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `opinie_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id_uzytkownika`);

--
-- Ograniczenia dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD CONSTRAINT `wiadomosci_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id_uzytkownika`);

--
-- Ograniczenia dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD CONSTRAINT `zgloszenia_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id_uzytkownika`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
