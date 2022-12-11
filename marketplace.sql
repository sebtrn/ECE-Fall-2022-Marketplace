-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 11 déc. 2022 à 12:17
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `marketplace`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `IdArticle` int(11) NOT NULL AUTO_INCREMENT,
  `IdUtilisateur` int(11) NOT NULL,
  `NomArticle` varchar(255) NOT NULL,
  `Marque` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Img` varchar(255) NOT NULL,
  `QuantiteMax` int(11) NOT NULL,
  `Prix` float NOT NULL,
  `IdTypeArticle` int(11) NOT NULL,
  `DateCreation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DateExpBestOffer` datetime DEFAULT NULL,
  `IdTypeVente` int(11) NOT NULL,
  `PrixNegociation` float DEFAULT NULL,
  `NombreNegociation` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`IdArticle`),
  KEY `fk_Article_IdVendeur` (`IdUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`IdArticle`, `IdUtilisateur`, `NomArticle`, `Marque`, `Description`, `Img`, `QuantiteMax`, `Prix`, `IdTypeArticle`, `DateCreation`, `DateExpBestOffer`, `IdTypeVente`, `PrixNegociation`, `NombreNegociation`) VALUES
(5, 1, 'Pull Dior', 'Dior', 'Pull Manche Longue Motifs', 'https://i.ibb.co/TBgKhKC/f1.jpg', 0, 300, 2, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(6, 1, 'Pull Ralph Lauren', 'Ralph Lauren', 'Pull Manche Longue Creme', 'https://i.ibb.co/8DWyYh7/f2.jpg', 5, 80, 2, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(7, 1, 'Pull Sandro', 'Sandro', 'Pull Manche Longue Motifs', 'https://i.ibb.co/tbGVFWn/f3.jpg', 5, 90, 2, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(8, 1, 'Polo Lacoste', 'Lacoste', 'Polo Lacoste Classique L.12.12 Uni', 'https://i.ibb.co/V9VJfH3/f4.jpg', 5, 70, 1, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(9, 1, 'Pantalon Uniqlo', 'Uniqlo', 'Pantalon habillé confort strech', 'https://i.ibb.co/zQZYY0s/f5.jpg', 5, 20, 3, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(10, 1, 'T-Shirt Uniqlo', 'Uniqlo', 'T-shirt SPY X FAMILY', 'https://i.ibb.co/XzwQn3b/n1.webp', 5, 20, 1, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(11, 1, 'Shoes Nike', 'Nike', 'BLAZER MID \'77 VNTG', 'https://i.ibb.co/41SSX2L/f7.jpg', 5, 65, 4, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(12, 1, 'Shoes Converse', 'Converse', 'Chuck Taylor All Star', 'https://i.ibb.co/jGLHDCx/f8.jpg', 5, 65, 4, '2022-12-05 19:49:31', NULL, 1, NULL, 5),
(14, 1, 'Chaussure !!!!', 'geox', '', 'https://www.loding.fr/5080-home_default_2x/chaussures-richelieu-brogue-bout-fleuri-317-soleto.jpg', 5, 600, 4, '2022-12-07 21:24:56', NULL, 1, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `IdPanier` int(11) NOT NULL AUTO_INCREMENT,
  `IdArticle` int(11) NOT NULL,
  `IdUtilisateur` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  PRIMARY KEY (`IdPanier`),
  KEY `fk_Panier_IdArticle` (`IdArticle`),
  KEY `fk_Panier_IdUtilisateur` (`IdUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`IdPanier`, `IdArticle`, `IdUtilisateur`, `Quantite`) VALUES
(22, 14, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `typearticle`
--

DROP TABLE IF EXISTS `typearticle`;
CREATE TABLE IF NOT EXISTS `typearticle` (
  `IdTypeArticle` int(11) NOT NULL AUTO_INCREMENT,
  `TypeArticle` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTypeArticle`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typearticle`
--

INSERT INTO `typearticle` (`IdTypeArticle`, `TypeArticle`) VALUES
(1, 'Tshirt'),
(2, 'Pull'),
(3, 'Pantalon'),
(4, 'Chaussure');

-- --------------------------------------------------------

--
-- Structure de la table `typecarte`
--

DROP TABLE IF EXISTS `typecarte`;
CREATE TABLE IF NOT EXISTS `typecarte` (
  `IdTypeCarte` int(11) NOT NULL AUTO_INCREMENT,
  `TypeCarte` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTypeCarte`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typecarte`
--

INSERT INTO `typecarte` (`IdTypeCarte`, `TypeCarte`) VALUES
(1, 'Visa'),
(2, 'Mastercard'),
(3, 'Maestro'),
(4, 'Amex'),
(5, 'ECE');

-- --------------------------------------------------------

--
-- Structure de la table `typerole`
--

DROP TABLE IF EXISTS `typerole`;
CREATE TABLE IF NOT EXISTS `typerole` (
  `IdTypeRole` int(11) NOT NULL AUTO_INCREMENT,
  `TypeRole` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTypeRole`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typerole`
--

INSERT INTO `typerole` (`IdTypeRole`, `TypeRole`) VALUES
(1, 'Admin'),
(2, 'Vendeur'),
(3, 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `typevente`
--

DROP TABLE IF EXISTS `typevente`;
CREATE TABLE IF NOT EXISTS `typevente` (
  `IdTypeVente` int(11) NOT NULL AUTO_INCREMENT,
  `TypeVente` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTypeVente`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typevente`
--

INSERT INTO `typevente` (`IdTypeVente`, `TypeVente`) VALUES
(1, 'Immediat'),
(2, 'Negociation'),
(3, 'Enchere');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `IdUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `Pseudo` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `ImgFond` varchar(255) DEFAULT NULL,
  `Adresse` varchar(255) NOT NULL,
  `Ville` varchar(255) NOT NULL,
  `Pays` varchar(255) NOT NULL,
  `CodePostal` int(11) NOT NULL,
  `Telephone` int(11) DEFAULT NULL,
  `IdTypeRole` int(11) NOT NULL,
  `DateCreation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdUtilisateur`),
  KEY `fk_Utilisateur_IdTypeRole` (`IdTypeRole`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IdUtilisateur`, `Pseudo`, `Email`, `Password`, `Prenom`, `Nom`, `Photo`, `ImgFond`, `Adresse`, `Ville`, `Pays`, `CodePostal`, `Telephone`, `IdTypeRole`, `DateCreation`) VALUES
(1, 'Admin', 'admin@admin.fr', 'admin', 'Admin', 'Admin', NULL, NULL, '10 RUE SEXTIUS MICHEL', 'Paris', 'France', 75015, 651388101, 1, '2022-12-07 21:58:34'),
(9, 'vendeur', 'vendeur@vendeur.com', 'vendeur', 'Romain', 'BUGE', NULL, NULL, 'RUE VICTOR HUGO', 'LEVALLOIS-PERRET', 'FRANCE', 92300, 612345678, 2, '2022-12-07 21:58:34'),
(16, 'seb', 'sebastien.tran@edu.ece.fr', '12121', 'Sebastien', 'TRAN', NULL, NULL, 'RUE VICTOR HUGO', 'LEVALLOIS-PERRET', 'FRANCE', 92300, 651388101, 3, '2022-12-07 22:06:00');

-- --------------------------------------------------------

--
-- Structure de la table `wallet`
--

DROP TABLE IF EXISTS `wallet`;
CREATE TABLE IF NOT EXISTS `wallet` (
  `IdWallet` int(11) NOT NULL AUTO_INCREMENT,
  `IdUtilisateur` int(11) NOT NULL,
  `IdTypeCarte` int(11) NOT NULL,
  `NumeroCarte` varchar(255) NOT NULL,
  `NomCarte` varchar(255) NOT NULL,
  `DateExp` varchar(255) NOT NULL,
  `CodeSecu` int(11) NOT NULL,
  `Solde` float NOT NULL,
  PRIMARY KEY (`IdWallet`),
  KEY `fk_Wallet_IdUtilisateur` (`IdUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `wallet`
--

INSERT INTO `wallet` (`IdWallet`, `IdUtilisateur`, `IdTypeCarte`, `NumeroCarte`, `NomCarte`, `DateExp`, `CodeSecu`, `Solde`) VALUES
(1, 16, 1, '1234567812345678', 'TRAN', '01/23', 123, 100000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
