-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2023 at 03:04 PM
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
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `ID` int(11) NOT NULL,
  `date_absence` text DEFAULT NULL,
  `id_cours` int(11) DEFAULT NULL,
  `id_etudiant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

CREATE TABLE `cours` (
  `ID` int(11) NOT NULL,
  `nom_cours` varchar(255) NOT NULL,
  `nom_formation` varchar(255) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `nom_prof` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`ID`, `nom_cours`, `nom_formation`, `duree`, `nom_prof`) VALUES
(27, 'marc', 'test3', 10, 'soleiman'),
(28, 'zhao', 'test3', 10, 'soleiman');

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

CREATE TABLE `formations` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `niveau` varchar(255) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `formations`
--

INSERT INTO `formations` (`ID`, `nom`, `niveau`, `duree`) VALUES
(14, 'test3', 'BAC+1', 1);

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
(8, 'rabab.soleiman@efrei.fr', 'rabab.soleiman@efrei.fr', 'raboub soleiman', '2023-06-20 14:16:10'),
(9, 'rabab.soleiman@efrei.fr', 'marc.zhao@efrei.fr', 'petit connard', '2023-06-23 13:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `ID` int(11) NOT NULL,
  `id_etudiant` int(11) DEFAULT NULL,
  `id_cours` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plannings`
--

CREATE TABLE `plannings` (
  `ID` int(11) NOT NULL,
  `jour` text DEFAULT NULL,
  `heure_debut` text DEFAULT NULL,
  `heure_fin` text DEFAULT NULL,
  `id_cours` int(11) DEFAULT NULL,
  `id_professeur` int(11) DEFAULT NULL,
  `id_salle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salles`
--

CREATE TABLE `salles` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `capacite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salles`
--

INSERT INTO `salles` (`ID`, `nom`, `capacite`) VALUES
(1, 'Gorki', 35),
(2, 'Republique', 50);

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
(27, 'soleiman', 'rabab', 'rabab.soleiman@efrei.fr', '1234', 'professeur', 'validé', ''),
(28, 'raboub', 'soleiman', 'soleiman.raboub@efrei.fr', '1234', 'administrateur', 'validé', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Indexes for table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Indexes for table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cours` (`id_cours`),
  ADD KEY `id_professeur` (`id_professeur`),
  ADD KEY `id_salle` (`id_salle`);

--
-- Indexes for table `salles`
--
ALTER TABLE `salles`
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
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cours`
--
ALTER TABLE `cours`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `formations`
--
ALTER TABLE `formations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plannings`
--
ALTER TABLE `plannings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salles`
--
ALTER TABLE `salles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`ID`),
  ADD CONSTRAINT `absences_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `user` (`ID`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`ID`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `user` (`ID`);

--
-- Constraints for table `plannings`
--
ALTER TABLE `plannings`
  ADD CONSTRAINT `plannings_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`ID`),
  ADD CONSTRAINT `plannings_ibfk_2` FOREIGN KEY (`id_professeur`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `plannings_ibfk_3` FOREIGN KEY (`id_salle`) REFERENCES `salles` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
