CREATE TABLE IF NOT EXISTS `magazine` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` enum('Одежда и обувь','Электроника','Товары для дома') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` int(20) NOT NULL,
  `magazine` int(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `phone` varchar(25) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default_avatar.jpg',
  `role` enum('user','seller','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `username` (`username`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `phone`, `avatar`, `role`) VALUES
(1, 'hadesray', '+79538458598', 'hadesray_1770566400.jpg', 'user');
