-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 05 Février 2017 à 22:48
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `battlefield_weapons`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`) VALUES
(2, 'mitraillettes'),
(4, 'fusils assaut'),
(5, 'fusils-mitrailleurs'),
(6, 'Lanceurs et explosifs'),
(7, 'fusils de sniper'),
(8, 'fusils semi-automatiques'),
(9, 'carabines');

-- --------------------------------------------------------

--
-- Structure de la table `products_transactions`
--

CREATE TABLE `products_transactions` (
  `id` int(11) NOT NULL,
  `products` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `products_transactions`
--

INSERT INTO `products_transactions` (`id`, `products`, `quantity`, `transaction_id`) VALUES
(1, 'velo', 2, '\r\n9TH211882C828762C \r\n ');

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `street` varchar(255) CHARACTER SET utf8 NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `currency_code` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `transaction`
--

INSERT INTO `transaction` (`id`, `name`, `street`, `city`, `country`, `date`, `transaction_id`, `amount`, `shipping`, `currency_code`, `user_id`) VALUES
(1, 'thomas lefebvre', 'Av. de la Pelouse, 87648672 Mayet', 'Paris', 'Alsace', '2017-01-30 00:22:13', '9TH211882C828762C', 141, 5, 'EUR', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(2, 'toto', 't@t.fr', 'aa'),
(3, 'toto', 'toto@toto.fr', 'az'),
(4, 'randy56', 'randy@gmail.fr', 'aa');

-- --------------------------------------------------------

--
-- Structure de la table `weapons`
--

CREATE TABLE `weapons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `shipping` int(11) NOT NULL,
  `TVA` double NOT NULL,
  `final_price` float NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `weapons`
--

INSERT INTO `weapons` (`id`, `name`, `description`, `price`, `categorie`, `weight`, `shipping`, `TVA`, `final_price`, `stock`) VALUES
(46, 'uzi', 'pistolet-mitrailleur des forces armÃ©es israÃ«liennes', 900, 'mitraillettes', '4', 30, 20, 1116, 3),
(47, 'barett .50', 'fusil de prÃ©cision anti-matÃ©riel de calibre 50 dÃ©vastateur', 5000, 'fusils de sniper', '15', 30, 20, 6036, 5),
(48, 'fgm-148 javelin', 'lance-missiles antichar auto-guidÃ©', 20000, 'Lanceurs et explosifs', '30', 50, 20, 24060, 5),
(49, 'type 88 fm', 'fusil-mitrailleur chinois', 2600, 'fusils-mitrailleurs', '15', 30, 20, 3156, 5),
(50, 'mtar21', 'carabine israÃ«lienne compacte', 3000, 'carabines', '8', 25, 20, 3630, 5),
(52, 'sks', 'fusil de prÃ©cision russe', 1600, 'fusils semi-automatiques', '15', 30, 20, 1956, 1);

-- --------------------------------------------------------

--
-- Structure de la table `weight`
--

CREATE TABLE `weight` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `weight`
--

INSERT INTO `weight` (`id`, `name`, `price`) VALUES
(1, '4', 30),
(2, '8', 25),
(3, '15', 30),
(4, '25', 45),
(5, '30', 50);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products_transactions`
--
ALTER TABLE `products_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `weight`
--
ALTER TABLE `weight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `products_transactions`
--
ALTER TABLE `products_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `weapons`
--
ALTER TABLE `weapons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT pour la table `weight`
--
ALTER TABLE `weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
