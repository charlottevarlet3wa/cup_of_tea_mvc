-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 20 mars 2024 à 15:15
-- Version du serveur : 5.7.31
-- Version de PHP : 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";
-- ou pour l'heure d'été SET time_zone = "+02:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cup_of_tea`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `category` (`id`, `name`, `description`, `image`) VALUES
(1, 'Thé noir', 'Le thé noir, que les chinois appellent thé rouge en référence à la couleur cuivrée de son infusion, est un thé complètement oxydé. La fabrication du thé noir se fait en cinq étapes : le flétrissage, le roulage, l\'oxydation, la torréfaction et le triage. Cette dernière opération permet de différencier les différents grades.', 'tea/1.jpg'),
(2, 'Thé vert', 'Réputé pour ses nombreuses vertus grâce à sa richesse en antioxydants, le thé vert désaltère, tonifie, apaise, fortifie, et procure une incontestable sensation de bien-être. Délicat et peu amer, il est apprécié à tout moment de la journée et propose une palette d\'arômes très variés : végétal, minéral, floral, fruité.', 'tea/2.jpg'),
(3, 'Oolong', 'Les Oolong, que les chinois appellent thés bleu-vert en référence à la couleur de leurs feuilles infusées, sont des thés semi-oxydés : leur oxydation n\'a pas été menée à son terme. Spécialités de Chine et de Taïwan, il en existe une grande variété, en fonction de la région de culture, de l\'espèce du théier ou encore du processus de fabrication.', 'tea/3.jpg'),
(4, 'Thé blanc', 'Le thé blanc est une spécialité de la province chinoise du Fujian. De toutes les familles de thé, c\'est celle dont la feuille est la moins transformée par rapport à son état naturel. Non oxydé, le thé blanc ne subit que deux opérations : un flétrissage et une dessiccation. Il existe deux grands types de thés blancs : les Aiguilles d\'Argent et les Bai Mu Dan.', 'tea/4.jpg'),
(5, 'Rooibos', 'Le Rooibos (appelé thé rouge bien qu\'il ne s\'agisse pas de thé) est une plante poussant uniquement en Afrique du Sud et qui ne contient pas du tout de théine. Son infusion donne une boisson très agréable, ronde et légèrement sucrée. Riche en antioxydants, faible en tanins et dénué de théine, le Rooibos peut être dégusté en journée comme en soirée.', 'tea/5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `format`
--

-- ! price et conditioning inversés
DROP TABLE IF EXISTS `format`;
CREATE TABLE IF NOT EXISTS `format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tea_id` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `conditioning` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tea_id` (`tea_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `format`
--

INSERT INTO `format` (`id`, `tea_id`, `price`, `conditioning`) VALUES
(1, 1, '5.00', 'Pochette de 100gr'),
(2, 1, '12.00', 'Pochette de 500gr'),
(3, 1, '20.00', 'Pochette de 1kg'),
(4, 2, '9.90', 'Pochette de 100gr'),
(5, 2, '17.00', 'Pochette de 500gr'),
(6, 3, '8.50', 'Pochette de 100gr'),
(7, 3, '15.00', 'Pochette de 500gr'),
(8, 4, '4.50', 'Sachet de 100gr'),
(9, 4, '12.00', 'Sachet de 500gr'),
(10, 4, '18.00', 'Sachet de 1kg'),
(11, 5, '12.90', 'Sachet de 100gr'),
(12, 5, '17.50', 'Sachet de 300gr'),
(13, 6, '3.00', 'Sachet de 100gr'),
(14, 6, '8.00', 'Sachet de 500gr'),
(15, 7, '9.40', 'Pochette vrac 100gr'),
(16, 7, '10.40', 'Sachets mousselines x20'),
(17, 7, '12.90', 'Boîte métal 100g'),
(18, 8, '10.50', 'Pochette vrac 100g'),
(19, 8, '49.88', 'Pochette vrac 500g'),
(20, 8, '94.50', 'Pochette vrac 1kg'),
(21, 9, '9.20', 'Pochette vrac 100g'),
(22, 9, '43.70', 'Pochette vrac 500g'),
(23, 10, '13.50', 'Pochette vrac 100g'),
(24, 11, '12.50', 'Pochette de 100g'),
(25, 11, '36.00', 'Pochette de 500g'),
(26, 12, '58.00', 'Pochette vrac 100g'),
(27, 12, '105.00', 'Pochette vrac 300g'),
(28, 13, '9.50', 'Pochette vrac 100g'),
(29, 13, '13.00', 'Boîte métal 100g'),
(30, 13, '47.50', 'Pochette vrac 500g'),
(31, 13, '85.50', 'Pochette vrac 1kg'),
(32, 14, '9.40', 'Pochette vrac 100g'),
(33, 14, '44.65', 'Pochette vrac 500g'),
(34, 15, '9.40', 'Pochette vrac 100g'),
(35, 15, '44.65', 'Pochette vrac 500g');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `date`, `user_id`, `status`) VALUES
(1, '2022-07-20', 6, 0),
(2, '2022-07-20', 6, 1),
(3, '2022-07-20', 6, 1),
(4, '2022-07-20', 6, 1),
(5, '2022-07-20', 6, 1),
(6, '2022-07-20', 6, 1),
(7, '2022-07-20', 6, 1),
(8, '2022-07-20', 6, 0),
(9, '2022-07-20', 6, 0),
(10, '2022-07-20', 6, 1),
(11, '2022-07-20', 6, 1),
(12, '2022-07-20', 6, 1),
(13, '2022-07-21', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cond` varchar(255) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `cond`, `price`) VALUES
(1, 2, 6, 'Sachet de 100gr', '3.00'),
(2, 2, 2, 'Pochette de 500gr', '17.00'),
(3, 3, 2, 'Pochette de 500gr', '17.00'),
(4, 3, 6, 'Sachet de 100gr', '3.00'),
(5, 4, 2, 'Pochette de 500gr', '17.00'),
(6, 4, 6, 'Sachet de 100gr', '3.00'),
(7, 5, 3, 'Pochette de 500gr', '15.00'),
(8, 6, 3, 'Pochette de 500gr', '15.00'),
(9, 7, 3, 'Pochette de 500gr', '15.00'),
(10, 8, 3, 'Pochette de 100gr', '8.50'),
(11, 8, 12, 'Pochette vrac 100g', '58.00'),
(12, 9, 3, 'Pochette de 100gr', '8.50'),
(13, 9, 12, 'Pochette vrac 100g', '58.00'),
(14, 10, 3, 'Pochette de 100gr', '8.50'),
(15, 10, 12, 'Pochette vrac 100g', '58.00'),
(16, 11, 2, 'Pochette de 100gr', '9.90'),
(17, 12, 2, 'Pochette de 100gr', '9.90'),
(18, 12, 2, 'Pochette de 500gr', '17.00'),
(19, 12, 2, 'Pochette de 500gr', '17.00'),
(20, 13, 2, 'Pochette de 500gr', '17.00'),
(21, 13, 4, 'Sachet de 1kg', '18.00');

-- --------------------------------------------------------

--
-- Structure de la table `tea`
--

-- ! change order : reference, category_id, favorite, date, image, description
-- ! added : stock
DROP TABLE IF EXISTS `tea`;
CREATE TABLE IF NOT EXISTS `tea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subtitle` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `reference` varchar(50) NOT NULL,
  `stock` int(5) NOT NULL,
  `date` date NOT NULL,
  `favorite` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thes`
--

INSERT INTO `tea` (`id`, `category_id`, `name`, `subtitle`, `image`, `description`, `reference`, `stock`, `date`, `favorite`) VALUES
(1, 1, 'Blue of London', 'Thé noir à la bergamote', 'product/product3_big.jpg', '<p>Blue of London est un Earl Grey d\'exception qui associe un des meilleurs thés noirs au monde, le Yunnan, et une bergamote fraîche et délicate. Un mélange remarquable d\'équilibre et de finesse.</p>\r\n					<p>Le Earl Grey est un grand classique anglais, depuis que Charles Grey, comte (earl en anglais) de Falodon et Ministre des Affaires étrangères du Royaume britannique au milieu du XIX ème siècle, reçut d\'un mandarin chinois une vieille recette consistant à aromatiser son thé avec de la bergamote.</p>\r\n					<p><strong>Profitez d\'une remise de 5% sur la pochette de 500g (prix déjà remisé).</strong></p>\r\n					<p><strong>Profitez d\'une remise de 10% sur le lot de 2 pochettes de 500g (prix déjà remisé).</strong></p>', '133742', 12, '2022-06-14', 0),
(2, 1, 'Thé des lords', 'Thé noir (Sri Lanka, Chine) (97%), arôme bergamote (2%), pétales de carthame', 'product/product6_big.jpg', '<strong>Le thé Des Lords est un emblématique</strong> <p>Earl Grey, un thé noir dont les arômes de bergamote et de pétale de carthame font toute sa renommée. Sa finesse et sa douceur lui donne sa noblesse.<br>\r\nPour les amoureux de la bergamote, le thé Des Lords est le plus parfumé de toute la gamme des Earl Grey proposée par Palais Des Thés.<br>\r\nUn sachet de thé noir qui se laisse infuser 4 à 5 minutes, dans une eau bien chaude, pour diffuser toute sa puissance et libérer ses saveurs. Appréciez ces quelques minutes de bonheur !</p>\r\n\r\n<p>\r\nPour votre santé, évitez de manger trop gras, trop sucré, trop salé.</p>', '22985', 12, '2022-07-06', 0),
(3, 2, 'Thé du hammam', 'Rooibos (Afrique du Sud) (94%), arômes (dont fraise 2%), pétales de fleurs (carthame, rose, souci)', 'product/product1_big.jpg', '<p>Le thé Hammam est agrémenté, selon la plus pure tradition orientale, de pétales de fleurs. Sa fragrance extraordinaire naît de la subtile association du thé vert de Chine, réputé pour sa fraîcheur et ses vertus désaltérantes, et des parfums gourmands de fruits. Le thé du Hammam est un des must-have de la maison Palais des Thés.\r\nPour encore plus de gourmandise, ce thé est idéal avec un morceau de chocolat blanc, qui lui donnera finesse et onctuosité.</p>\r\n<p>Ce rooibos se déguste aussi bien chaud que glacé. Infusez 15g de votre thé par litre d\'eau à température ambiante pendant 30 minutes.</p>', '10635', 8, '2022-07-06', 1),
(4, 1, 'Thé des vahinés', 'Thé (93%), arôme vanille (3%), pétales de souci, vanille, arômes crème et amande (1%)', 'product/product7_big.jpg', '<p>Pour un moment 100% plaisir, laissez infuser 5 minutes votre Rooibos Des Vahinés, dans une eau bien chaude. Laissez-vous envelopper par les parfums qui s\'en dégagent et par les pouvoirs réconfortants de la vanille et de l\'amande.<br>\r\nUn rooibos sans théine ni caféine, qui peut se déguster tout au long de la journée. Rien de tel qu\'une bonne tasse de tisane le soir, après une dure journée de labeur. Savourez ce petit moment rien que pour vous et préparez-vous à passer une nuit calme et apaisante.<br>\r\nSes saveurs des îles vous feront voyager !</p>', '22979', 36, '2022-07-05', 0),
(5, 2, 'Vive le thé !', 'Boîte Vive le thé BIO', 'product/product4_big.jpg', '<p>Thé de la bonne humeur et de la joie de vivre, Vive le thé ! peut se déguster bien chaud au cœur de l’hiver, ou glacé en plein été. Naturellement antioxydant, il est également tonifiant et stimulant. Un combo que tous les amateurs de thé vont adorer… </p>', '83732', 3, '2022-07-03', 0),
(6, 2, 'Thé des alizés', 'Thé vert (Chine) (90%), pêche (pêche, farine de riz) (5%), fleur d\'oranger, arôme pêche', 'product/product5_big.jpg', 'Le Thé des Alizés est un thé vert frais et fruité, évoquant la pêche blanche, le kiwi, la pastèque et la fleur d\'oranger. Il se consomme aussi bien chaud que glacé. Boite de 100g en vrac ou plus. ', '85323', 4, '2022-07-13', 0),
(7, 3, 'Vive les fêtes', 'Mélange de thé vert et de oolong aux notes d’amande et de cannelle.', 'product/product8_big.jpg', '<p>Inspiré des souvenirs merveilleux de l’enfance, Vive les Fêtes est une délicieuse création parfumée aux notes d’amande et de cannelle qui nous transporte dans l’univers gourmand de la fête foraine.</p>\r\n<p>\r\n<strong>Suggestion de préparation</strong><br>\r\nPréparer ce thé chaud :<br>\r\n\r\nPrendre 6 g de feuilles de thé et faire chauffer à 90°. Faire infuser 5 minutes.</p>', '14956', 12, '2022-07-12', 0),
(8, 3, 'Fleur d\'oranger Oolong', 'Les parfums délicats de la fleur d\'oranger sont associés au velouté d\'un thé vert de Chine en aiguilles', 'product/product9_big.jpg', '<p>Revisitez les grands classiques du thé parfumé avec La Fleur d\'Oranger !  Une alliance douce et fraîche d\'un thé vert de Chine aux notes fraîches de pulpe d’orange, aux extraits 100% naturels.Découvrez un thé parfumé de très haute qualité autour d’un ingrédient unique emprunté à la nature : la fleur d’oranger. Il allie la texture veloutée d’un thé vert en aiguilles, récolté en Chine, aux parfums délicats de la fleur d’oranger.</p>\r\n\r\n<p>Doux et voluptueux !</p>\r\n\r\n\r\n<p>La fleur d’oranger est en note centrale, une note douce, élégante, ronde, suave, fine. Elle est complétée par des notes plus vives, agrume orangé, et par des pics de zestes d’orange.Le thé soutient sans être trop présent. Il apporte une structure, il rehausse les notes et les prolonge.</p>\r\n\r\n\r\n<p>Les notes du thé se fondent dans le profil, elles s’intègrent dans la note globale.</p>', '19485', 4, '2022-07-01', 0),
(9, 3, 'Oolong 7 agrumes', 'Une délicieuse recette où le caractère boisé du oolong se marie à la perfection aux notes hespéridées des agrumes', 'product/product10_big.jpg', '<p><strong>Un très beau Oolong</strong> parfumé avec le célèbre cocktail de 7 agrumes créé par Palais des Thés en référence à la spécialité slave : essences naturelles de citron, citron vert, orange douce, orange amère, pamplemousse, bergamote et mandarine.</p>\r\n\r\n<p>Associé aux notes hespéridées des agrumes, le caractère boisé du Oolong prend un goût délicieux, tout en conservant sa longueur en bouche.</p>\r\n\r\n<p>Différents des thés qui poussent en Géorgie, les Goûts Russes sont les thés consommés régulièrement en Russie depuis le XVII ème siècle. A l\'origine mélanges de thés noirs chinois, les thés consommés par les Russes se diversifient avec l\'arrivée à la fin du XIX ème siècle des thés de l\'Inde - Darjeeling notamment - à la cour de Russie. On a pris depuis l\'habitude d\'appeler Goût Russe, tout mélange de différents thés noirs chinois et de Darjeeling, parfumé ou non avec des essences naturelles d\'agrumes.</p>\r\n\r\nLa consommation de thé Oolong pendant ou après un repas riche en cholestérol aide à réduire l\'absorption des matières grasses par le sang. Il est également idéal en dégustation du soir, et délicieux en thé glacé !', '48596', 12, '2022-07-19', 0),
(10, 4, 'Thé des songes blanc', 'Ce délicieux thé blanc évoque la rose, la fleur d\'oranger et les fruits rouges. Il est rehaussé de pétales de carthame et de morceaux de fraises.', 'product/product11_big.jpg', '<p>Le Thé des Songes Blanc est une recette créée par Palais des Thés, associant le thé blanc, les fleurs et les fruits.</p>\r\n\r\n<p>Délicatement parfumé, il évoque la rose, la fleur d\'oranger et les fruits rouges. Agrémenté de pétales de carthame et de morceaux de fraises, il a pour base un très beau Bai Mu Dan, raffiné et délicat.</p>\r\n\r\n<p><strong>Suggestion de préparation</strong><br>\r\nPrendre 6 g de feuilles de thé pour 30cL d\'eau filtrée et faire chauffer à 70°C. Faire infuser pendant 5 minutes.</p>', '49658', 7, '2022-07-06', 0),
(11, 4, 'Bai mu dan', 'Ce très beau thé blanc de Chine au goût boisé rappelle les fruits mûrs de l\'automne comme la noisette et la châtaigne', 'product/product12_big.jpg', '<p>Le Bai Mu Dan, littéralement \"\" Pivoine blanche \"\" est un célèbre thé blanc de Chine. D\'une grande finesse, il est composé de morceaux de feuilles de toutes sortes à l\'état naturel : bourgeons argentés, Souchong, premières et deuxièmes feuilles, tiges.</p>\r\n\r\n<p>Son goût boisé rappelle les fruits mûrs de l\'automne comme la noisette et la châtaigne.</p>', '68574', 36, '2022-07-07', 0),
(12, 4, 'Aiguilles d\'argent', 'Un Grand Cru aux notes florales, fruitées et végétales.', 'product/product13_big.jpg', '<p>Ce Grand Cru, exclusivement composé de fins bourgeons duveteux, est le thé blanc le plus célèbre de Chine. Il est aussi l\'un des plus subtils. Récolté à Fuding, sur le mont Tai Mu, ces Aiguilles d\'Argent sont réalisées à partir du célèbre cultivar Fuding Da Bai.</p>\r\n\r\n<p>Un thé blanc de Chine complexe et subtil, aux notes florales, fruitées et végétales, déployées sur une superbe texture huileuse. Un magnifique classique.</p>', '74692', 1, '2022-07-04', 0),
(13, 5, 'Rooibos à la verveine', 'Les inconditionnels de Earl Grey retrouveront ici les notes zestées de la bergamote associées à la rondeur du rooibos', 'product/product14_big.jpg', '<p>Palais des Thés décline son Earl Grey favori, le Thé des Lords, sur une base de Rooibos. Une recette qui associe harmonieusement la puissance citronnée de la bergamote à la rondeur du Rooibos.</p>\r\n\r\n<p>Naturellement sans théine, il est idéal le soir pour les inconditionnels d\'Earl Grey.</p>', '65236', 2, '2022-07-07', 0),
(14, 5, 'Spicy Passion', 'La rencontre inattendue entre la rondeur du rooibos d\'Afrique du Sud et les épices du Chaï indien pour un instant sensuel.', 'product/product15_big.jpg', '<p>Spicy Passion est la rencontre étonnante du rooibos, plante d\'Afrique du Sud qui offre une boisson tout en rondeur et sans théine, et des accents épicés du Chaï indien traditionnel. Avec ses notes de gingembre, de cannelle et de cardamome, cette création exclusive envoûte et régale les sens le temps d\'un instant délicieusement sensuel.</p>\r\n\r\n<p>*Passion épicée</p>\r\n\r\n<h4>Un métissage sous le signe de la séduction</h4>\r\n<p>Puisant son inspiration dans des traditions exotiques, l\'équipe de Palais des Thés a créé cette rencontre inattendue et a donné naissance à une recette équilibrée et savoureuse. Composé dans un esprit de séduction, Spicy Passion charme les sens. Totalement dépourvu de théine, il se déguste à toute heure.</p>', '13985', 4, '2022-07-03', 0),
(15, 5, 'Rooibos des amants', 'Rooibos aux parfums de pomme et d’épices, relevés par une pointe de vanille et de gingembre', 'product/product16_big.jpg', '<p>Toujours plus voluptueuse, cette nouvelle variation séduira les amateurs du Thé des Amants. Un très beau mélange de thé rouge, de pomme, d\'amande, de cannelle et de vanille, épicé d\'une pointe de gingembre.</p>\r\n\r\n<p>A la fois fruité et épicé, il séduira tous les amoureux du thé gourmand.\r\nCette création à base de Rooibos est idéale le soir.</p>', '49852', 15, '2022-07-04', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `name`, `email`, `password`, `admin`) VALUES
(1, 'vilport', 'cécile', 'cecilevilport@gmail.com', '$2b$10$xuLT1aICrDPj4DP6iAZlOOq///d7xFwfgUGpXCePvkxx8hJLgHwem', 0),
(2, 'Hugo', 'Victore', 'victorhugo@gmail.com', '$2b$10$PvBz0l3ms.gZSfNTNh9YfOLZcv9TB8W3aego5mxRfuPh4iuZX/POK', 0),
(3, 'vilport', 'cécile', 'cecile@gmail.com', '$2b$10$0mFH7XE/87WX5mr5MI2HLO7ZbASp6IORq5/gzuGny.K71hWW1CjGS', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `format`
--
ALTER TABLE `format`
  ADD CONSTRAINT `format_ibfk_1` FOREIGN KEY (`tea_id`) REFERENCES `tea` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION;

--
-- Contraintes pour la table `orderdetail`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detaild_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tea` (`id`);

--
-- Contraintes pour la table `thes`
--
ALTER TABLE `tea`
  ADD CONSTRAINT `tea_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
