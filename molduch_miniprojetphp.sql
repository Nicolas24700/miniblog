-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 30 nov. 2024 à 15:12
-- Version du serveur : 10.6.19-MariaDB
-- Version de PHP : 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `molduch_miniprojetphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE `billets` (
  `id_billets` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_post` datetime NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `photo_post` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id_billets`, `titre`, `contenu`, `date_post`, `auteur_id`, `photo_post`) VALUES
(115, 'L\'Économie Verte : Vers un Avenir Durable ?', 'L’économie verte vise à concilier croissance économique et respect de l’environnement en promouvant des pratiques durables, comme l’adoption des énergies renouvelables, la réduction des déchets, et l’économie circulaire. Ce modèle encourage l\'abandon progressif des énergies fossiles au profit de sources comme le solaire, l’éolien et l’hydrogène vert, permettant ainsi de réduire les émissions de gaz à effet de serre.\r\n\r\nLa transition vers une économie verte est cependant coûteuse et présente des défis. Elle nécessite des investissements massifs dans les infrastructures et la formation professionnelle, car certains secteurs, comme les énergies fossiles, perdront des emplois. Des programmes de reconversion sont donc essentiels pour rendre cette transition juste.\r\n\r\nEnfin, les consommateurs jouent un rôle crucial : en choisissant des produits durables et en soutenant les entreprises responsables, ils influencent l’adoption de pratiques plus écologiques. Cependant, cette transition ne peut réussir qu’avec des régulations ambitieuses et une coopération internationale pour garantir un avenir durable pour tous.', '2024-11-11 17:55:32', 17, NULL),
(118, 'Télétravail et Productivité : Quels Sont les Vrais Impacts ?', 'Le télétravail permet aux employés de réduire les trajets et d\'aménager un environnement de travail plus confortable. Cependant, il a aussi des inconvénients, comme le risque d\'isolement social et la difficulté à déconnecter. Des études montrent que la productivité peut être améliorée pour certains, mais que d’autres souffrent d’un manque de motivation et d’interactions directes.\r\n\r\nD’un point de vue managérial, certaines entreprises hésitent encore à adopter le télétravail à long terme, craignant un relâchement dans la discipline ou des problèmes de sécurité des données. Néanmoins, le télétravail offre des économies potentielles sur les frais d\'infrastructure et pourrait attirer de nouveaux talents désireux de plus de flexibilité.', '2024-11-11 18:07:13', 17, 'images/uploads_post/post_1731344833.jpg'),
(119, 'Les Cryptomonnaies : Un Placement d\'Avenir ou une Bulle Spéculative ?', 'Les cryptomonnaies sont-elles un moyen révolutionnaire de gérer la monnaie ou simplement une bulle qui finira par éclater ? Le Bitcoin, l\'Ethereum et d\'autres actifs numériques ont vu leur valeur exploser, suscitant l\'intérêt des investisseurs et la crainte des régulateurs. Alors que certains considèrent le Bitcoin comme de l\'or numérique, d\'autres estiment qu\'il repose sur une spéculation qui finira mal.\r\n\r\nLes cryptomonnaies posent également des questions de sécurité et de régulation. Les piratages et les fraudes restent des risques majeurs dans ce secteur non régulé, et les gouvernements cherchent des moyens de légiférer pour protéger les investisseurs tout en évitant d’étouffer l\'innovation.', '2024-11-11 18:14:28', 17, 'images/uploads_post/post_1731345268.jpg'),
(137, 'L’Alimentation Durable : Comment Manger Plus Écologique au Quotidien ?', ' L\'alimentation durable consiste à choisir des produits qui ont un faible impact sur l\'environnement tout en étant bénéfiques pour la santé. Cela inclut, par exemple, de privilégier les produits locaux, de saison, et d\'origine biologique, ainsi que de réduire la consommation de viande, dont l\'empreinte carbone est importante. Selon plusieurs études, la production de viande et de produits laitiers représente environ 15 % des émissions de gaz à effet de serre mondiales, un chiffre qui pourrait être réduit si les consommateurs optaient pour des alternatives végétales.\r\n\r\nManger durable ne signifie pas nécessairement devenir végétarien, mais implique de consommer de manière plus réfléchie. Planifier ses repas, acheter en vrac, et limiter le gaspillage alimentaire sont des actions concrètes qui permettent d’adopter une alimentation plus respectueuse de la planète. De nombreux consommateurs trouvent qu\'en prenant conscience de l\'origine et de l\'impact de leurs aliments, ils gagnent en santé et économisent aussi de l\'argent.\r\n\r\nCependant, l\'alimentation durable n\'est pas exempte de défis. Le coût de certains produits biologiques, par exemple, peut être prohibitif pour de nombreuses familles. De plus, des efforts sont encore nécessaires pour améliorer l\'accessibilité des alternatives durables, surtout dans les zones urbaines et rurales isolées.', '2024-11-11 18:37:40', 17, 'images/uploads_post/post_1731346660.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaires` int(11) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `date_post` datetime NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaires`, `contenu`, `date_post`, `auteur_id`, `billet_id`) VALUES
(101, 'Je pense que c’est une bonne chose. On ne peut plus continuer à ignorer l\'impact de notre économie sur la planète. La croissance doit être durable, sinon elle n’aura pas d\'avenir.\"', '2024-11-11 17:59:14', 55, 115),
(102, 'Il y a encore beaucoup à faire pour que cette transition soit juste. Les grandes entreprises doivent être responsables et jouer un rôle actif, sinon ce sont toujours les citoyens qui paieront le prix.\"', '2024-11-11 17:59:39', 18, 115),
(103, 'Je suis en télétravail depuis 2 ans et j’adore la flexibilité que cela m’apporte. J’ai l’impression de mieux gérer mon temps, et je me sens même plus productive !\"', '2024-11-11 18:43:27', 18, 118),
(104, 'Je pense que les cryptomonnaies sont l’avenir de la finance. Oui, c’est risqué, mais toute innovation l’est au début. C’est comme Internet dans les années 90 !', '2024-11-11 18:43:46', 18, 119),
(105, 'Merci pour cet article ! Personnellement, j\'ai réduit ma consommation de viande et commencé à acheter plus de produits locaux. Ce n\'est pas facile tous les jours, mais on se sent mieux dans sa peau et dans son assiette !', '2024-11-11 18:44:03', 18, 137),
(106, 'Le télétravail est une bonne solution, mais il faut fixer des règles claires et mesurer les résultats pour garantir que cela fonctionne pour l’entreprise', '2024-11-11 18:44:30', 55, 118),
(107, 'Les cryptomonnaies ont un vrai potentiel pour moderniser le système monétaire, mais elles doivent être mieux encadrées. Sinon, ça risque de se retourner contre les petits investisseurs.', '2024-11-11 18:45:43', 55, 119),
(108, 'C’est vrai que manger durable peut coûter cher, surtout pour une famille nombreuse. On fait de notre mieux, mais je trouve que les grandes surfaces devraient proposer plus de produits bio et locaux à prix abordables.', '2024-11-11 18:46:01', 55, 137);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_personne` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_personne`, `login`, `nom`, `prenom`, `motdepasse`, `photo`, `admin`) VALUES
(17, 'ADMIN', 'ADMIN', 'ADMIN', '$2y$10$mU6bhw6FjIgEFSiz7.fw3.N8PcbymLLdZefC22BFbXqOI4dqTcHUu', 'images/uploads/profil_17.png', 1),
(18, 'TOTO', 'TOTO', 'TOTO', '$2y$10$zvyGo3cZq6OhpGRzYZv4T.ziyn3fuhwebni/p16X9EjfZ.yfOdAc6', 'images/uploads/profil_18.jpg', 0),
(55, 'TITI', 'TITI', 'TITI', '$2y$10$J3cK7gZ./7MQ1ZDKT08DDOF6hoE/qEG92zN0wzX3C/H4uRA6icxZ.', 'images/uploads/profil_default.png', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD PRIMARY KEY (`id_billets`),
  ADD KEY `FK_auteur_utilisateurs` (`auteur_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaires`),
  ADD KEY `FK_auteur_utilisateurs_commentaire` (`auteur_id`),
  ADD KEY `FK_post_commentaire` (`billet_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_personne`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `id_billets` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaires` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
  ADD CONSTRAINT `FK_auteur_utilisateurs` FOREIGN KEY (`auteur_id`) REFERENCES `utilisateurs` (`id_personne`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `FK_auteur_utilisateurs_commentaire` FOREIGN KEY (`auteur_id`) REFERENCES `utilisateurs` (`id_personne`),
  ADD CONSTRAINT `FK_post_commentaire` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`id_billets`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
