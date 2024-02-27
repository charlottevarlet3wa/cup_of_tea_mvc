-- TODO : adapter et tester

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `cup_of_tea`;
USE `cup_of_tea`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL UNIQUE,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `admin` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


DROP TABLE IF EXISTS `tea`;
CREATE TABLE `tea` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `category_id` int unsigned NOT NULL,
  `favorite` tinyint NOT NULL DEFAULT '0',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `format`;
CREATE TABLE `format` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tea_id` int unsigned NOT NULL,
  `conditioning` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `price` decimal(10, 2),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tea_id`) REFERENCES `tea`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int unsigned NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `cond` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `price` decimal(10, 2),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `order`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `tea`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;



INSERT INTO `category` (`name`) VALUES ('Thé Noir'), ('Thé Vert'), ('Oolong'), ('Thé Blanc'), ('Rooibos');

INSERT INTO `tea` (`name`, `subtitle`, `description`, `image`, `category_id`, `favorite`) VALUES 
('Thé Noir Premium', 'Intense et Profond', 'Un thé noir aux arômes riches et à la saveur intense.', 'noir_premium.jpg', 1, 0),
('Thé Noir Classique', 'Riche en Goût', 'Un classique indémodable pour tous les amateurs de thé noir.', 'noir_classique.jpg', 1, 0),
('Thé Noir Fumé', 'Arôme Unique', 'Un thé noir fumé au bois de cèdre, offrant une expérience gustative unique.', 'noir_fume.jpg', 1, 0),

('Thé Vert Sencha', 'Frais et Revigorant', 'Un thé vert traditionnel japonais offrant fraîcheur et finesse.', 'vert_sencha.jpg', 2, 0),
('Thé Vert Matcha', 'Pur et Puissant', 'Le matcha offre un goût riche et une couleur éclatante.', 'vert_matcha.jpg', 2, 1),
('Thé Vert Jasmin', 'Parfumé et Delicat', 'Un thé vert délicatement parfumé aux fleurs de jasmin.', 'vert_jasmin.jpg', 2, 0),

('Oolong Formosa', 'Doux et Floral', 'Un oolong de Taiwan aux notes naturellement sucrées et florales.', 'oolong_formosa.jpg', 3, 0),
('Oolong Tieguanyin', 'Complexe et Aromatique', 'Un des thés oolong les plus réputés de Chine.', 'oolong_tieguanyin.jpg', 3, 0),
('Oolong Milk', 'Crémeux et Confortable', 'Un oolong unique avec des notes douces et crémeuses.', 'oolong_milk.jpg', 3, 0),

('Thé Blanc Pai Mu Tan', 'Léger et Rafraîchissant', 'Un thé blanc aux saveurs subtiles et à l’arôme délicat.', 'blanc_paimutan.jpg', 4, 0),
('Thé Blanc Fleur de Sakura', 'Délicatement Parfumé', 'Un thé blanc marié aux fleurs de cerisier pour une saveur douce.', 'blanc_sakura.jpg', 4, 0),
('Thé Blanc Silver Needle', 'Prestigieux et Raffiné', 'Le plus prestigieux des thés blancs, aux bourgeons duveteux.', 'blanc_silverneedle.jpg', 4, 0),

('Rooibos Nature', 'Sans Caféine', 'Un rooibos pur offrant une infusion douce et apaisante.', 'rooibos_nature.jpg', 5, 0),
('Rooibos Vanille', 'Doux et Aromatisé', 'Un rooibos enrichi de vanille pour une douceur réconfortante.', 'rooibos_vanille.jpg', 5, 0),
('Rooibos Citron', 'Vivifiant et Frais', 'Un rooibos agrémenté de citron pour une touche de fraîcheur.', 'rooibos_citron.jpg', 5, 0);



-- Formats pour Thé Noir Premium (ID 1)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(1, 'Sachet individuel', 0.50),
(1, 'Boîte de 25 sachets', 10.00),
(1, 'Vrac 100g', 15.00);

-- Formats pour Thé Noir Classique (ID 2)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(2, 'Sachet individuel', 0.45),
(2, 'Boîte de 25 sachets', 9.50),
(2, 'Vrac 100g', 14.50);

-- Formats pour Thé Noir Fumé (ID 3)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(3, 'Sachet individuel', 0.55),
(3, 'Boîte de 25 sachets', 11.00),
(3, 'Vrac 100g', 16.00);


-- Formats pour Thé Vert Sencha (ID 4)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(4, 'Sachet individuel', 0.60),
(4, 'Boîte de 20 sachets', 12.00),
(4, 'Vrac 50g', 8.00);

-- Formats pour Thé Vert Matcha (ID 5)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(5, 'Boîte 30g', 20.00),
(5, 'Boîte 50g', 30.00),
(5, 'Boîte 100g', 55.00);

-- Formats pour Thé Vert Jasmin (ID 6)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(6, 'Sachet individuel', 0.65),
(6, 'Boîte de 20 sachets', 13.00),
(6, 'Vrac 50g', 9.00);


-- Formats pour Oolong Formosa (ID 7)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(7, 'Sachet individuel', 0.70),
(7, 'Boîte de 20 sachets', 14.00),
(7, 'Vrac 50g', 10.00);

-- Formats pour Oolong Tieguanyin (ID 8)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(8, 'Sachet individuel', 0.75),
(8, 'Boîte de 20 sachets', 15.00),
(8, 'Vrac 50g', 11.00);

-- Formats pour Oolong Milk (ID 9)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(9, 'Sachet individuel', 0.80),
(9, 'Boîte de 20 sachets', 16.00),
(9, 'Vrac 50g', 12.00);


-- Formats pour Thé Blanc Pai Mu Tan (ID 10)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(10, 'Sachet individuel', 0.85),
(10, 'Boîte de 20 sachets', 17.00),
(10, 'Vrac 50g', 13.00);

-- Formats pour Thé Blanc Fleur de Sakura (ID 11)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(11, 'Sachet individuel', 0.90),
(11, 'Boîte de 20 sachets', 18.00),
(11, 'Vrac 50g', 14.00);

-- Formats pour Thé Blanc Silver Needle (ID 12)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(12, 'Sachet individuel', 1.00),
(12, 'Boîte de 20 sachets', 20.00),
(12, 'Vrac 50g', 15.00);

-- Formats pour Rooibos Nature (ID 13)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(13, 'Sachet individuel', 0.55),
(13, 'Boîte de 20 sachets', 11.00),
(13, 'Vrac 100g', 10.00);

-- Formats pour Rooibos Vanille (ID 14)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(14, 'Sachet individuel', 0.60),
(14, 'Boîte de 20 sachets', 12.00),
(14, 'Vrac 100g', 11.00);

-- Formats pour Rooibos Citron (ID 15)
INSERT INTO `format` (`tea_id`, `conditioning`, `price`) VALUES 
(15, 'Sachet individuel', 0.65),
(15, 'Boîte de 20 sachets', 13.00),
(15, 'Vrac 100g', 12.00);





INSERT INTO `user` (`last_name`, `name`, `email`, `password`, `admin`) VALUES
('Smith', 'John', 'john.smith@example.com', 'password123', 0),
('Doe', 'Jane', 'jane.doe@example.com', 'password123', 0),
('Brown', 'Michael', 'michael.brown@example.com', 'password123', 0),
('Davis', 'Emily', 'emily.davis@example.com', 'password123', 0),
('Wilson', 'Anna', 'anna.wilson@example.com', 'password123', 0);




-- Commandes pour l'utilisateur avec l'ID 1 (John Smith)
INSERT INTO `order` (`user_id`, `status`) VALUES (1, 1), (1, 1), (1, 1), (1, 1);

-- Commandes pour l'utilisateur avec l'ID 2 (Jane Doe)
INSERT INTO `order` (`user_id`, `status`) VALUES (2, 1), (2, 1), (2, 1), (2, 1);

-- Commandes pour l'utilisateur avec l'ID 3 (Michael Brown)
INSERT INTO `order` (`user_id`, `status`) VALUES (3, 1), (3, 1), (3, 1), (3, 1);

-- Commandes pour l'utilisateur avec l'ID 4 (Emily Davis)
INSERT INTO `order` (`user_id`, `status`) VALUES (4, 1), (4, 1), (4, 1), (4, 1);

-- Commandes pour l'utilisateur avec l'ID 5 (Anna Wilson)
INSERT INTO `order` (`user_id`, `status`) VALUES (5, 1), (5, 1), (5, 1), (5, 1);





INSERT INTO `order_details` (`order_id`, `product_id`, `cond`, `price`) VALUES 
(2, 11, 'Boîte de 20 sachets', 18.00),
(1, 11, 'Boîte de 20 sachets', 18.00),
(3, 11, 'Boîte de 20 sachets', 18.00),
(5, 11, 'Boîte de 20 sachets', 18.00),
(4, 11, 'Boîte de 20 sachets', 18.00),
(6, 11, 'Boîte de 20 sachets', 18.00),
(7, 11, 'Boîte de 20 sachets', 18.00),
(8, 11, 'Boîte de 20 sachets', 18.00),
(9, 11, 'Boîte de 20 sachets', 18.00),
(10, 11, 'Boîte de 20 sachets', 18.00),
(12, 11, 'Boîte de 20 sachets', 18.00),
(11, 11, 'Boîte de 20 sachets', 18.00),
(13, 11, 'Boîte de 20 sachets', 18.00),
(15, 11, 'Boîte de 20 sachets', 18.00),
(14, 11, 'Boîte de 20 sachets', 18.00),
(16, 11, 'Boîte de 20 sachets', 18.00),
(17, 11, 'Boîte de 20 sachets', 18.00),
(18, 11, 'Boîte de 20 sachets', 18.00),
(19, 11, 'Boîte de 20 sachets', 18.00),
(20, 11, 'Boîte de 20 sachets', 18.00);
