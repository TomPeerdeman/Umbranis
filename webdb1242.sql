-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 26 jan 2012 om 19:58
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
-- Tabelstructuur voor tabel `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden uitgevoerd voor tabel `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `rating`, `message`, `user_id`, `time`) VALUES
(1, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 15:55:51'),
(2, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 16:01:09'),
(3, 1, 10, 'test', 1, '2012-01-26 18:04:53'),
(4, 1, 10, 'test', 1, '2012-01-26 18:22:10'),
(5, 1, 1, 'muahahha', 1, '2012-01-26 18:22:17'),
(6, 1, 2, 'abc', 1, '2012-01-26 18:24:21'),
(7, 1, 10, 'test', 1, '2012-01-26 18:48:14'),
(8, 1, 10, 'test2', 1, '2012-01-26 18:49:53'),
(9, 1, 10, 'test12', 1, '2012-01-26 18:54:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `user_id` int(10) unsigned NOT NULL,
  `last_action` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_hash` varchar(64) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `logins`
--

INSERT INTO `logins` (`user_id`, `last_action`, `login_hash`) VALUES
(1, '2012-01-26 18:54:05', 'be9995460cdc46087dedea0a8082e5f96283891b5ddd8cfad87a420747387b08');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivery_status`, `payment_status`, `total_price`, `date`) VALUES
(1, 6, 1, 1, 114.95, '2012-01-20 17:37:31'),
(2, 5, 0, 0, 822.55, '2012-01-24 15:12:49'),
(3, 5, 0, 0, 30, '2012-01-24 15:27:32');

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
(1, 5, 12.99, 5),
(2, 2, 755.45, 11),
(2, 3, 23.55, 2),
(3, 1, 40, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_requests`
--

CREATE TABLE IF NOT EXISTS `password_requests` (
  `user_id` int(10) unsigned NOT NULL,
  `request_hash` varchar(40) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `request_hash` (`request_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `login_tries` smallint(1) unsigned NOT NULL DEFAULT '7',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password_salt`, `zipcode`, `city`, `street`, `house_number`, `firstname`, `lastname`, `gender`, `tel1`, `tel2`, `email`, `admin_rights`, `login_tries`) VALUES
(1, 'jan', 'becd7781558a57200088bfbb5bafae1fc2a901f8dbd7ef8d415ccf4f249826b0fd337a9d7c06c513d3418258b68b1ae4debbd3d8a69a77589fa3714efd47ede0', '.$KfZ~ %_rw6MA|47^^$', '2973HJ', 'Maaskantje', 'Koekwousstraat', '92', 'Jan', 'Jannssen', 'M', '0237598274', '', 'jj@hotmail.com', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
