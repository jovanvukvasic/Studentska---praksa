-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 11, 2025 at 03:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentska_praksa`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivnosti`
--

CREATE TABLE `aktivnosti` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opis` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivnosti`
--

INSERT INTO `aktivnosti` (`id`, `student_id`, `datum`, `opis`, `created_at`) VALUES
(1, 1, '2025-07-25', 'asdd', '2025-07-27 18:01:43'),
(2, 1, '2025-07-26', 'asdasdasd', '2025-07-27 17:53:49'),
(3, 1, '2025-07-27', 'petar', '2025-07-27 18:07:21'),
(4, 5, '2025-07-28', 'unos 4', '2025-07-28 20:30:34'),
(5, 5, '2025-07-25', 'Unos1', '2025-07-28 20:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik`
--

CREATE TABLE `dnevnik` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `aktivnost` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik_prakse`
--

CREATE TABLE `dnevnik_prakse` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `praksa_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `aktivnost` text DEFAULT NULL,
  `popunjeno` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komentari_mentora`
--

CREATE TABLE `komentari_mentora` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `komentar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentari_mentora`
--

INSERT INTO `komentari_mentora` (`id`, `student_id`, `mentor_id`, `datum`, `komentar`) VALUES
(1, 1, 19, '2025-07-25', 'a1');

-- --------------------------------------------------------

--
-- Table structure for table `komentari_profesora`
--

CREATE TABLE `komentari_profesora` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `vrijeme` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentari_profesora`
--

INSERT INTO `komentari_profesora` (`id`, `profesor_id`, `student_id`, `datum`, `komentar`, `vrijeme`) VALUES
(1, 1, 1, '2025-07-25', 'maro', '2025-07-28 02:28:31'),
(2, 2, 1, '2025-07-25', 'komentar', '2025-07-28 00:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `komisije_profesori`
--

CREATE TABLE `komisije_profesori` (
  `id` int(11) NOT NULL,
  `komisija` varchar(50) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komisije_profesori`
--

INSERT INTO `komisije_profesori` (`id`, `komisija`, `profesor_id`) VALUES
(5, 'softver', 1),
(6, 'softver', 3),
(8, 'Hardverski', 1),
(9, 'Hardverski', 4);

-- --------------------------------------------------------

--
-- Table structure for table `kompanije`
--

CREATE TABLE `kompanije` (
  `id` int(11) NOT NULL,
  `naziv` varchar(150) NOT NULL,
  `adresa` varchar(255) DEFAULT NULL,
  `kontakt_osoba` varchar(150) DEFAULT NULL,
  `moderator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kompanije`
--

INSERT INTO `kompanije` (`id`, `naziv`, `adresa`, `kontakt_osoba`, `moderator_id`) VALUES
(1, 'IT Solutions d.o.o.', 'Zmaja od Bosne 12, Sarajevo', 'Ana Kovač', 1),
(2, 'TechLab', 'Bulevar Kralja Tvrtka 8, Mostar', 'Ivan Marić', 1),
(3, 'Inovacije Plus', 'Aleja Bosne Srebrene 45, Tuzla', 'Emina Delić', 1),
(4, 'Digitalni Svijet', 'Titova 17, Banja Luka', 'Nikola Jovanović', 1),
(6, 'Kompanija Test', 'Adresa Test', 'Marko Petrov', 1);

-- --------------------------------------------------------

--
-- Table structure for table `konkursi`
--

CREATE TABLE `konkursi` (
  `id` int(11) NOT NULL,
  `praksa_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `dodatno` text DEFAULT NULL,
  `datum_prijave` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'na čekanju',
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konkursi`
--

INSERT INTO `konkursi` (`id`, `praksa_id`, `student_id`, `dodatno`, `datum_prijave`, `status`, `mentor_id`) VALUES
(1, 5, 1, 'a', '2025-07-26 03:18:06', 'prihvaćen', 19),
(2, 4, 1, '', '2025-07-26 03:37:38', 'prihvaćen', 19),
(3, 5, 2, '3', '2025-07-26 05:12:41', 'prihvaćen', 19),
(4, 5, 5, '', '2025-07-28 22:28:59', 'prihvaćen', 19);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sifra` varchar(255) NOT NULL,
  `uloga` enum('student','profesor','mentor','moderator','komisija','admin') NOT NULL,
  `povezani_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `email`, `sifra`, `uloga`, `povezani_id`) VALUES
(1, 'marko.petrovic@univerzitet.ba', '12345678', 'profesor', 1),
(2, 'marko.markovic@student.etf.unibl.org', '12345678', 'student', 1),
(4, 'marko.petrov@mentor.com', '12345678', 'moderator', 1),
(5, 'marko.markovic@mentor.com', '12345678', 'mentor', 19),
(6, 'marko1.markovic@mentor.com', '12345678', 'mentor', 20),
(7, 'mirko1.mirkovic@student.etf.unibl.org', '12345678', 'student', 2),
(8, 'admin', 'admin', 'admin', 0),
(9, 'petar.petrovic@etf.unibl.org', '12345678', 'profesor', 3),
(10, 'ivan.ivanic@etf.unibl.org', '12345678', 'profesor', 4),
(12, 'petar.petrovic@student.etf.unibl.org', '12345678', 'student', 5);

-- --------------------------------------------------------

--
-- Table structure for table `mentori`
--

CREATE TABLE `mentori` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `prezime` varchar(100) NOT NULL,
  `uloga_kompanije` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `id_moderatora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentori`
--

INSERT INTO `mentori` (`id`, `ime`, `prezime`, `uloga_kompanije`, `email`, `telefon`, `slika`, `id_moderatora`) VALUES
(19, 'Marko', 'Markovic', 'test', 'marko.markovic@mentor.com', '+38765555555', '', 1),
(20, 'Marko1', 'Markovic1', 'test', 'marko1.markovic@mentor.com', '+38765555555', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moderatori`
--

CREATE TABLE `moderatori` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `prezime` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sifra` varchar(255) NOT NULL,
  `telefon` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moderatori`
--

INSERT INTO `moderatori` (`id`, `ime`, `prezime`, `email`, `sifra`, `telefon`) VALUES
(1, 'Marko', 'Petrov', 'marko.petrov@mentor.com', '12345678', '+38765555555');

-- --------------------------------------------------------

--
-- Table structure for table `praksa`
--

CREATE TABLE `praksa` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `organizacija` varchar(100) DEFAULT NULL,
  `pocetak` date DEFAULT NULL,
  `kraj` date DEFAULT NULL,
  `kompanija_id` int(11) NOT NULL,
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `praksa`
--

INSERT INTO `praksa` (`id`, `naziv`, `organizacija`, `pocetak`, `kraj`, `kompanija_id`, `mentor_id`) VALUES
(1, 'Praksa iz programiranja', 'Softverska Firma d.o.o.', '2025-07-01', '2025-07-07', 0, NULL),
(3, 'Test praksa', 'Test firma', '2025-06-01', '2025-06-30', 0, NULL),
(4, 'Praksa test', 'Organizacija Tesst', '2025-07-24', '2025-07-31', 1, NULL),
(5, 'Praksa test1', 'Organizacija Tesst1', '2025-07-25', '2025-07-31', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `praksa_dani`
--

CREATE TABLE `praksa_dani` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `praksa_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opis` text DEFAULT NULL,
  `zadaci` text DEFAULT NULL,
  `napomena` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `praksa_dani`
--

INSERT INTO `praksa_dani` (`id`, `student_id`, `praksa_id`, `datum`, `opis`, `zadaci`, `napomena`) VALUES
(1, 1, 1, '2025-05-20', 'Rad na aplikaciji', 'Implementacija forme za unos', 'Nema posebnih napomena'),
(2, 1, 1, '2025-05-20', 'Rad na aplikaciji', 'Implementacija forme za unos', 'Nema posebnih napomena');

-- --------------------------------------------------------

--
-- Table structure for table `profesori`
--

CREATE TABLE `profesori` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `prezime` varchar(100) NOT NULL,
  `zvanje` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefon` varchar(50) DEFAULT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `sifra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profesori`
--

INSERT INTO `profesori` (`id`, `ime`, `prezime`, `zvanje`, `email`, `telefon`, `slika`, `sifra`) VALUES
(1, 'Marko', 'Petrović', 'Redovni profesor', 'marko.petrovic@univerzitet.ba', '+387 61 123 456', 'images/profesor1.jpg', '12345678'),
(3, 'Petar', 'Petrovic', 'redofni profesor', 'petar.petrovic@etf.unibl.org', '+38765555555', NULL, '12345678'),
(4, 'Ivan', 'Ivanic', 'redofni profesor', 'ivan.ivanic@etf.unibl.org', '+38765555555', NULL, '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `studenti`
--

CREATE TABLE `studenti` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `indeks` varchar(20) NOT NULL,
  `fakultet` varchar(100) NOT NULL,
  `smjer` varchar(100) NOT NULL,
  `usmjerenje` varchar(100) NOT NULL,
  `prosjek` decimal(3,2) DEFAULT 0.00,
  `slika` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `sifra` varchar(255) NOT NULL,
  `komisija` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studenti`
--

INSERT INTO `studenti` (`id`, `ime`, `prezime`, `indeks`, `fakultet`, `smjer`, `usmjerenje`, `prosjek`, `slika`, `email`, `sifra`, `komisija`) VALUES
(1, 'Marko', 'Marković', 'RA123/2024', 'Elektrotehnički fakultet', 'Računarstvo', 'Softversko inženjerstvo', 8.75, '', 'marko.markovic@student.etf.unibl.org', '12345678', 'softver'),
(2, 'Mirko', 'Mirkovic', 'RA1234/2023', 'Elek', 'sa', 'dsa', 9.99, '', 'mirko1.mirkovic@student.etf.unibl.org', '12345678', 'softver'),
(5, 'Petar', 'Petrovic', 'RA16asd', 'ETG', 'SMJEr', 'IS', 6.00, NULL, 'petar.petrovic@student.etf.unibl.org', '12345678', 'Hardverski');

-- --------------------------------------------------------

--
-- Table structure for table `student_aktivnosti`
--

CREATE TABLE `student_aktivnosti` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `praksa_dan_id` int(11) NOT NULL,
  `polje` varchar(100) NOT NULL,
  `sadrzaj` text NOT NULL,
  `vreme_izmene` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_aktivnosti`
--

INSERT INTO `student_aktivnosti` (`id`, `student_id`, `praksa_dan_id`, `polje`, `sadrzaj`, `vreme_izmene`) VALUES
(1, 1, 1, 'Opis dana', 'Danas sam naučio osnove PHP-a.', '2025-05-20 08:45:56'),
(2, 1, 2, 'Zadatak', 'Završio sam zadatak iz baze podataka.', '2025-05-20 08:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `student_konkursi`
--

CREATE TABLE `student_konkursi` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `praksa_id` int(11) NOT NULL,
  `dodatno` text DEFAULT NULL,
  `datum_konkursa` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_praksa`
--

CREATE TABLE `student_praksa` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `praksa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_praksa`
--

INSERT INTO `student_praksa` (`id`, `student_id`, `praksa_id`) VALUES
(1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivnosti`
--
ALTER TABLE `aktivnosti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`datum`);

--
-- Indexes for table `dnevnik_prakse`
--
ALTER TABLE `dnevnik_prakse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_dnevnik_praksa` (`praksa_id`);

--
-- Indexes for table `komentari_mentora`
--
ALTER TABLE `komentari_mentora`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`mentor_id`,`datum`);

--
-- Indexes for table `komentari_profesora`
--
ALTER TABLE `komentari_profesora`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komisije_profesori`
--
ALTER TABLE `komisije_profesori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_id` (`profesor_id`);

--
-- Indexes for table `kompanije`
--
ALTER TABLE `kompanije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konkursi`
--
ALTER TABLE `konkursi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `praksa_id` (`praksa_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mentori`
--
ALTER TABLE `mentori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_moderatora` (`id_moderatora`);

--
-- Indexes for table `moderatori`
--
ALTER TABLE `moderatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `praksa`
--
ALTER TABLE `praksa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `praksa_dani`
--
ALTER TABLE `praksa_dani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `praksa_id` (`praksa_id`);

--
-- Indexes for table `profesori`
--
ALTER TABLE `profesori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indeks` (`indeks`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_aktivnosti`
--
ALTER TABLE `student_aktivnosti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `praksa_dan_id` (`praksa_dan_id`);

--
-- Indexes for table `student_konkursi`
--
ALTER TABLE `student_konkursi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `praksa_id` (`praksa_id`);

--
-- Indexes for table `student_praksa`
--
ALTER TABLE `student_praksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `praksa_id` (`praksa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivnosti`
--
ALTER TABLE `aktivnosti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dnevnik`
--
ALTER TABLE `dnevnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dnevnik_prakse`
--
ALTER TABLE `dnevnik_prakse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentari_mentora`
--
ALTER TABLE `komentari_mentora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `komentari_profesora`
--
ALTER TABLE `komentari_profesora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `komisije_profesori`
--
ALTER TABLE `komisije_profesori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kompanije`
--
ALTER TABLE `kompanije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `konkursi`
--
ALTER TABLE `konkursi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mentori`
--
ALTER TABLE `mentori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `moderatori`
--
ALTER TABLE `moderatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `praksa`
--
ALTER TABLE `praksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `praksa_dani`
--
ALTER TABLE `praksa_dani`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profesori`
--
ALTER TABLE `profesori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `studenti`
--
ALTER TABLE `studenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_aktivnosti`
--
ALTER TABLE `student_aktivnosti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_konkursi`
--
ALTER TABLE `student_konkursi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_praksa`
--
ALTER TABLE `student_praksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD CONSTRAINT `dnevnik_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`);

--
-- Constraints for table `dnevnik_prakse`
--
ALTER TABLE `dnevnik_prakse`
  ADD CONSTRAINT `dnevnik_prakse_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dnevnik_praksa` FOREIGN KEY (`praksa_id`) REFERENCES `praksa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komisije_profesori`
--
ALTER TABLE `komisije_profesori`
  ADD CONSTRAINT `komisije_profesori_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesori` (`id`);

--
-- Constraints for table `konkursi`
--
ALTER TABLE `konkursi`
  ADD CONSTRAINT `konkursi_ibfk_1` FOREIGN KEY (`praksa_id`) REFERENCES `praksa` (`id`),
  ADD CONSTRAINT `konkursi_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`);

--
-- Constraints for table `mentori`
--
ALTER TABLE `mentori`
  ADD CONSTRAINT `mentori_ibfk_1` FOREIGN KEY (`id_moderatora`) REFERENCES `moderatori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `praksa_dani`
--
ALTER TABLE `praksa_dani`
  ADD CONSTRAINT `praksa_dani_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`),
  ADD CONSTRAINT `praksa_dani_ibfk_2` FOREIGN KEY (`praksa_id`) REFERENCES `praksa` (`id`);

--
-- Constraints for table `student_aktivnosti`
--
ALTER TABLE `student_aktivnosti`
  ADD CONSTRAINT `student_aktivnosti_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`),
  ADD CONSTRAINT `student_aktivnosti_ibfk_2` FOREIGN KEY (`praksa_dan_id`) REFERENCES `praksa_dani` (`id`);

--
-- Constraints for table `student_konkursi`
--
ALTER TABLE `student_konkursi`
  ADD CONSTRAINT `student_konkursi_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`),
  ADD CONSTRAINT `student_konkursi_ibfk_2` FOREIGN KEY (`praksa_id`) REFERENCES `praksa` (`id`);

--
-- Constraints for table `student_praksa`
--
ALTER TABLE `student_praksa`
  ADD CONSTRAINT `student_praksa_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `studenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_praksa_ibfk_2` FOREIGN KEY (`praksa_id`) REFERENCES `praksa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
