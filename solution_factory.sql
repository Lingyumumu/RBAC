-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2023 at 02:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solution_factory`
--

-- --------------------------------------------------------

--
-- Table structure for table `etude`
--

CREATE TABLE `etude` (
  `ID` int(10) NOT NULL,
  `nom_formation` varchar(50) NOT NULL,
  `nom_cours` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etude`
--

INSERT INTO `etude` (`ID`, `nom_formation`, `nom_cours`, `type`) VALUES
(49, 'francais', '', 'formation'),
(50, 'francais', 'edfefgef', 'cours'),
(51, 'francais', 'fefefe', 'cours'),
(52, 'francais', 'fefe', 'cours'),
(54, 'francais', 'tesr2', 'cours'),
(55, 'Informatique', '', 'formation');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `ID` int(50) NOT NULL,
  `expediteur_email` varchar(50) NOT NULL,
  `destinataire_email` varchar(50) NOT NULL,
  `contexte` varchar(1000) NOT NULL,
  `date_envoi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`ID`, `expediteur_email`, `destinataire_email`, `contexte`, `date_envoi`) VALUES
(3, 'marc.zhao@efrei.fr', 'rabab.soleiman@efrei.fr', 'cc ?', '2023-06-20 13:35:57'),
(4, 'marc.zhao@efrei.fr', 'marc.zhao@efrei.fr', 'salut', '2023-06-20 13:43:07'),
(5, 'marc.zhao@efrei.fr', 'marc.zhao@efrei.fr', '1234', '2023-06-20 13:52:54'),
(6, 'marc.zhao@efrei.fr', 'marc.zhao@efrei.fr', 'slt_petit connard', '2023-06-20 14:03:03'),
(7, 'rabab.soleiman@efrei.fr', 'marc.zhao@efrei.fr', '1234', '2023-06-20 14:07:34'),
(8, 'rabab.soleiman@efrei.fr', 'rabab.soleiman@efrei.fr', 'raboub soleiman', '2023-06-20 14:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `formation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `nom`, `prenom`, `email`, `password`, `role`, `statut`, `formation`) VALUES
(26, 'zhao', 'marc', 'marc.zhao@efrei.fr', '1234', 'personnel', 'validé', ''),
(27, 'soleiman', 'rabab', 'rabab.soleiman@efrei.fr', '1234', 'professeur', 'validé', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etude`
--
ALTER TABLE `etude`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etude`
--
ALTER TABLE `etude`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
