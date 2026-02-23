CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Одежда и обувь'),
(2, 'Электроника'),
(3, 'Товары для дома');

CREATE TABLE IF NOT EXISTS `magazine` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `magazine` (`id`, `title`, `description`, `owner`) VALUES
(1, 'BestPC', 'Магазин компьютерной техники', 'hadesray'),
(2, 'Clothes', 'Магазин брендовой одежды', 'user2'),
(3, 'ForHome', 'Товары для дома', 'user3');

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` int(20) NOT NULL,
  `magazine` int(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `title`, `description`, `type`, `photo`, `price`, `magazine`) VALUES
(1, 'Adata Legend 960', 'Внутренний SSD 1TB', 'Электроника', '1771674416_1.jpg', 16000, 1),
(2, 'Ajazz A159NL-800', 'Беспроводная мышь, 3 типа подключения, чип PAW 3311, емкость аккумулятора 800mAh', 'Электроника', '1771674516_1.jpg', 2000, 1),
(3, 'Palit GeForce RTX 5060 Infinity 3 8Gb', 'Видеокарта RTX 5060 Infinity 3 8Gb', 'Электроника', '1771674614_1.jpg', 36000, 1),
(4, 'Gigabyte B550M Gaming X WiFi', 'Материнская плата на АМ4 сокете, поддерживающий DDR4 память', 'Электроника', '1771674763_1.jpg', 11500, 1),
(5, 'Джинсы Acne Studios', 'Синие джинсы Acne Studios', 'Одежда и обувь', '1771675334_8.jpg', 4500, 2),
(6, 'Maison Mihara Yasuhiro', 'Кеды Maison Mihara Yasuhiro', 'Одежда и обувь', '1771675398_8.jpg', 8900, 2),
(7, 'Футболка TFD', 'Футболка кроп из коллекции MИKИTA ЯUZIN черная 100% хлопок', 'Одежда и обувь', '1771675495_8.jpg', 2200, 2),
(8, 'Набор посуда', 'Кастрюли, сковородка', 'Товары для дома', '1771676011_9.jpg', 5500, 3),
(9, 'Набор для готовки', 'Прихватки, кисточки, лопатки', 'Товары для дома', '1771676090_9.jpg', 1200, 3);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default_avatar.jpg',
  `role` enum('user','seller','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `username` (`username`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `username`, `password`, `phone`, `avatar`, `role`) VALUES
(1, 'admin', '1234', '+79964275124', 'admin_avatar.jpg', 'admin'),
(2, 'hadesray', '1234', '+79538458598', 'default_avatar.jpg', 'user'),
(3, 'user2', '1234', '+79538856532', 'default_avatar.jpg', 'user'),
(4, 'user3', '1234', '+79241245212', 'default_avatar.jpg', 'user');
