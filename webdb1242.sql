-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2012 at 07:15 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

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
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
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
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `rating`, `message`, `user_id`, `time`) VALUES
(1, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 15:55:27'),
(2, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 16:00:45'),
(3, 1, 10, 'test', 1, '2012-01-26 18:04:29'),
(4, 1, 10, 'test', 1, '2012-01-26 18:21:46'),
(5, 1, 1, 'muahahha', 1, '2012-01-26 18:21:53'),
(6, 1, 2, 'abc', 1, '2012-01-26 18:23:57'),
(7, 2, 10, 'vet cool', 1, '2012-01-26 18:46:14'),
(8, 1, 10, 'ik ben cool', 1, '2012-01-26 18:51:25'),
(9, 1, 6, 'abc', 1, '2012-01-27 19:25:34'),
(10, 1, 6, 'abc', 1, '2012-01-27 19:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `user_id` int(10) unsigned NOT NULL,
  `last_action` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_hash` varchar(64) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivery_status`, `payment_status`, `total_price`, `date`) VALUES
(2, 1, 0, 0, 822.55, '2012-01-24 15:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `price` double NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  UNIQUE KEY `order_id` (`order_id`,`product_id`,`amount`,`price`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`order_id`, `product_id`, `price`, `amount`) VALUES
(2, 2, 755.45, 11),
(2, 3, 23.55, 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_requests`
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
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `product_name` varchar(32) NOT NULL,
  `normal_price` double NOT NULL,
  `price` double NOT NULL,
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `cat_id`, `product_name`, `normal_price`, `price`, `sales`, `stock`, `delivery_time`, `publisher`, `author`, `image_path`, `description`, `ean_code`, `date`) VALUES
(1, 13, 'The elder Scrolls: Skyrim', 49.99, 49.99, 5, 10, 0, 'Bethesda Softworks', '', 'skyrim.png', '', '1234567891012', '2012-01-18 17:04:24'),
(2, 13, 'Portal 2', 59.99, 59.99, 3, 10, 2, 'Valve Corporation', '', 'portal.png', '', '1234567891013', '2012-01-18 17:04:24'),
(3, 5, 'Birds of Fire', 15.99, 15.99, 9, 10, 1, 'Sony music entertainment', 'Mahavishnu Orchestra', 'birds_of_fire.png', '', '4209714987224', '2012-01-18 18:36:19'),
(4, 5, 'Unrecognizable screeches from a ', 15.99, 10.99, 0, 10, 1, '', 'Ramses Ijff', 'no_image.png', '', '4209714987125', '2012-01-18 18:36:54'),
(5, 9, 'Final destination 5', 22.99, 22.99, 2, 0, 15, 'Warner Home Video', 'Steven Quale', 'final_destination_5.png', '', '5051888087602', '2012-01-20 12:47:46'),
(6, 6, 'Got My Mojo Working', 9.99, 9.99, 3, 22, 2, '', 'Muddy Waters', 'mojo_working.png', '', '', '2012-02-03 16:54:46'),
(7, 7, 'In the Navy', 12.99, 12.99, 1, 23, 7, 'Can''t stop productions', 'the village people', 'in_the_navy.png', '', '', '2012-02-03 17:08:03'),
(8, 8, 'While heaven wept', 4.99, 4.99, 5, 55, 616, 'nuclear blast records', 'fear of infinity', 'while_heaven_wept.png', '', '', '2012-02-03 17:22:35'),
(9, 10, 'Robowar', 1.99, 1.99, 0, 50, 10, '', 'Bruno Mattei', 'robowar.png', '', '', '2012-02-03 17:25:14'),
(10, 11, 'Cool as Ice', 21.99, 21.99, 1, 54, 1, 'Universal pictures', '', 'cool_as_ice.png', '', '', '2012-02-03 17:28:46'),
(11, 12, 'I, Robot', 12.99, 12.99, 3, 5, 11, 'Davis Entertainment', '', 'i_robot.png\n', '', '', '2012-02-03 17:34:43'),
(12, 14, 'call_of_duty_2', 45.44, 34.34, 12, 9, 1111, 'Activision', '', 'call_of_duty_2.png', '', '', '2012-02-03 17:46:30'),
(13, 15, 'Ghost Recon: Ghost Soldier', 35.99, 35.99, 3, 6, 7, 'Red Storm Entertainment', 'Tom Clancy', 'ghost_recon_future.png', '', '', '2012-02-03 17:49:30'),
(14, 16, 'a Boy and his Blob', 13.99, 12.99, 9, 3, 22, 'WayForward Technologies', '', 'boy_and_his_blob.png', '', '', '2012-02-03 17:52:46'),
(15, 17, 'Forever Odd', 11.99, 10.99, 3, 2, 1, '', 'Dean Koontz', 'forever_odd.png', '', '', '2012-02-03 17:58:25'),
(16, 18, 'Het verdriet van belgië', 23.33, 12.11, 3, 2, 11, 'De bezige bij', 'Hugo Claus', 'verdriet_van_belgie.png', '', '', '2012-02-03 18:09:50'),
(17, 19, 'Linear and Geometric Algebra', 21.99, 21.99, 21, 8, 66, '', 'Alan Macdonald', 'linear_geometric_algebra.png', '', '', '2012-02-03 18:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `password_salt`, `zipcode`, `city`, `street`, `house_number`, `firstname`, `lastname`, `gender`, `tel1`, `tel2`, `email`, `admin_rights`, `login_tries`) VALUES
(1, 'jan', '6bbc1d45cf2bc16bbaf39bffb654e85fe28e02328de451360f3499a50f77d8257bb218ed516dd693350eadba7ee37d44e0acfe7f5973a30630ff254f053bcd1f', '9WYEtFmX6ECJcmjd9', '2973HJ', 'Maaskantje', 'Koekwousstraat', '92', 'Jan', 'Jannssen', 'M', '0237598274', '', 'jj@hotmail.com', 1, 0),
(2, 'tom', '517a9114d4075d07f8f62bedb2752e9e88afe02715d134285a0f8928f1b622ca0b3e15e2819fa09b00c1115c7af8219700c6afae02b5c832e9021f4b4b69a656', 'xNLqxcuDQ', '1000AA', 'Geen', 'Geen', '1a', 'Tom', 'Peerdeman', 'M', '0000000000', '', 'nogwat4@gmail.com', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `winkelwagen`
--

CREATE TABLE IF NOT EXISTS `winkelwagen` (
  `user_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`prod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `winkelwagen`
--

INSERT INTO `winkelwagen` (`user_id`, `prod_id`, `amount`) VALUES
(1, 1, 13);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
