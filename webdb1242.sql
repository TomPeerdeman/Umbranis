-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 24 jan 2012 om 20:21
-- Serverversie: 5.5.16
-- PHP-Versie: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webdb1242`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cart_products`
--

CREATE TABLE IF NOT EXISTS `cart_products` (
  `user_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`product_id`,`amount`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `cat_name` varchar(32) NOT NULL,
  `image_path` varchar(32) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Gegevens worden uitgevoerd voor tabel `categories`
--

INSERT INTO `categories` (`cat_id`, `parent_id`, `cat_name`, `image_path`) VALUES
(1, 0, 'Muziek', ''),
(2, 0, 'Films', ''),
(3, 0, 'Games', ''),
(4, 0, 'Boeken', ''),
(5, 1, 'Jazz', 'muziek.png'),
(6, 1, 'Blues', 'muziek.png'),
(7, 1, 'Disco', 'muziek.png'),
(8, 1, 'Death Metal', 'muziek.png'),
(9, 2, 'Horror', 'film.png'),
(10, 2, 'Actie', 'film.png'),
(11, 2, 'Alternative', 'film.png'),
(12, 2, 'Scifi', 'film.png'),
(13, 3, 'Pc', 'pc.png'),
(14, 3, 'Xbox 360', 'test.png'),
(15, 3, 'PS3', 'test.png'),
(16, 3, 'Wii', 'test.png'),
(17, 4, 'Suspense', 'boek.png'),
(18, 4, 'Roman', 'boek.png'),
(19, 4, 'Non-fiction', 'boek.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `delivery_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `payment_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `total_price` double unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivery_status`, `payment_status`, `total_price`, `date`) VALUES
(2, 6, 1, 1, 114.95, '2012-01-20 18:37:31'),
(3, 5, 0, 0, 822.55, '2012-01-24 16:12:49'),
(4, 5, 0, 0, 30, '2012-01-24 16:27:32');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `price` double NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  UNIQUE KEY `order_id` (`order_id`,`product_id`,`amount`,`price`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `order_products`
--

INSERT INTO `order_products` (`order_id`, `product_id`, `price`, `amount`) VALUES
(2, 5, 12.99, 5),
(3, 2, 755.45, 11),
(3, 3, 23.55, 2),
(4, 1, 40, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `product_name` varchar(32) NOT NULL,
  `normal_price` double NOT NULL,
  `price` double NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT '0',
  `delivery_time` int(10) unsigned NOT NULL DEFAULT '0',
  `publisher` varchar(32) NOT NULL,
  `author` varchar(32) NOT NULL,
  `image_path` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `ean_code` varchar(16) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `products`
--

INSERT INTO `products` (`product_id`, `cat_id`, `product_name`, `normal_price`, `price`, `stock`, `delivery_time`, `publisher`, `author`, `image_path`, `description`, `ean_code`, `date`) VALUES
(1, 13, 'The elder Scrolls: Skyrim', 49.99, 49.99, 10, 0, 'Bethesda Softworks', '', 'skyrim.png', '', '1234567891012', '2012-01-18 17:04:48'),
(2, 13, 'Portal 2', 59.99, 59.99, 10, 2, 'Valve Corporation', '', 'portal.png', '', '1234567891013', '2012-01-18 17:04:48'),
(3, 5, 'Birds of Fire', 15.99, 15.99, 10, 1, 'Sony music entertainment', 'Mahavishnu Orchestra', '', '', '4209714987224', '2012-01-18 18:36:43'),
(4, 5, 'Unrecognizable screeches from a ', 15.99, 10.99, 10, 1, '', 'Ramses Ijff', '', '', '4209714987125', '2012-01-18 18:37:18'),
(5, 9, 'Final destination 5', 22.99, 22.99, 0, 15, 'Warner Home Video', 'Steven Quale', 'final_destination_5.png', '', '5051888087602', '2012-01-20 12:48:10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password_salt` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `zipcode` char(6) NOT NULL,
  `city` varchar(32) NOT NULL,
  `street` varchar(32) NOT NULL,
  `house_number` varchar(8) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `gender` char(1) NOT NULL,
  `tel1` varchar(16) NOT NULL,
  `tel2` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `admin_rights` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `last_action` int(10) unsigned NOT NULL DEFAULT '0',
  `login_tries` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password_salt`, `zipcode`, `city`, `street`, `house_number`, `firstname`, `lastname`, `gender`, `tel1`, `tel2`, `email`, `admin_rights`, `last_action`, `login_tries`) VALUES
(1, 'admin', '094296a1102ec1a5c9582cad1eec599c636475f2f4df7a64e6f6c8bb7f998cffed72e21143cced447a7cdc3240a876ceac2889eca92a8d064235cffc18cab0d4', 'YVKrTy&YHQ3sH|ry:V', '1234AB', 'Amsterdam', 'Science Park', '904', 'Ad', 'Min', 'M', '1234567890', '', 'umbranis@hotmail.com', 1, 0, 0),
(2, 'rene', 'blablabla', '', '4321BA', 'Amsterdam', 'gaatjeniksaanstraat', '321', 'René', 'Aparicio', 'M', '0987654321', '', 'rene66613@gmail.com', 0, 0, 0),
(3, 'pietpiraat12', 'piraatpiet21', '', '1782LK', 'Den Helder', 'Tuinstraat', '59', 'Piet', 'Pieterson', 'M', '06573919395', '', 'pietpiraat@yahoo.com', 0, 0, 0),
(4, 'kim', 'kimrulez', '', '6235AS', 'weekveelwaar stad', 'middelofnowhere', '67', 'Kimberly', 'de Vries', 'F', '10602358', '', 'kimberly543@hotmail.com', 0, 0, 0),
(5, 'jan', 'be3d7f6c9652d6cb8e029cc712ee7eb5d8dfeee202713c1e480d4e39b6a68bf3cee6009a7e812f9871b6a7c03c5cb3dab11cf9b5f8341e785e8fde23e86989d5', '\\%$jvG+~k|j/Sz7(_"9HL;hV', '2973HJ', 'Maaskantje', 'Koekwousstraat', '92', 'Jan', 'Jannssen', 'M', '0237598274', '', 'jj@hotmail.com', 0, 0, 0),
(6, 'tom', '579c0c5840079a82ea35beb6d0547a49ef1d568492f9210098f47271d86968cc42bbc9ecc04c99f2adbc3051d3441bbb5953b52b46c00c67f2b1facf25f5336f', 'Ts9-68OG49(%q(soMm', '0000AA', 'Gaatjeniksaan', 'Gaatjenogminderaan', '0b', 'Tom', 'Peerdeman', 'M', '06-00000000', '', 'nogwat4@gmail.com', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
