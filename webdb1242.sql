-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 03 feb 2012 om 20:41
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `rating`, `message`, `user_id`, `time`) VALUES
(1, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 15:55:27'),
(2, 1, 7, 'Ik vind dit een goed product.', 1, '2012-01-26 16:00:45'),
(3, 1, 10, 'vet awesome.', 1, '2012-02-02 09:28:47');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

INSERT INTO `products` (`product_id`, `cat_id`, `product_name`, `normal_price`, `price`, `stock`, `delivery_time`, `publisher`, `author`, `image_path`, `description`, `ean_code`, `date`) VALUES
(1, 13, 'The elder Scrolls: Skyrim', 49.99, 49.99, 10, 0, 'Bethesda Softworks', 'Todd Howard', 'skyrim.png', 'Het lang verwachte vervolg op Oblivion. Twee-honderd jaar na de demonische invasie wordt het land op nieuw bedreigd door de herrezen draken en de recente alliantie van elven. Alleen de Dovahkin, de mythische drakenstrijder, kan het land nog redden, maar hij is gevangen genomen bij het oversteken van de grens...', '1234567891012', '2012-01-18 17:04:24'),
(2, 13, 'Portal 2', 59.99, 59.99, 10, 2, 'Valve Corporation', 'Joshua Weier', 'portal.png', 'GlaDoS is terug, en klaar voor wraak.\r\n\r\nHonderden jaren zijn voorbij gegaan sinds de gebeurtenissen van de oorspronkelijke portal, en Aperture is in verval geraakt. Maar als GlaDoS weer wakker wordt, moet Chell op avontuur door de diepste niveaus van de laboratoria, waar vele nieuwe puzzels voor haar klaar liggen.', '1234567891013', '2012-01-18 17:04:24'),
(3, 5, 'Birds of Fire', 15.99, 15.99, 10, 1, 'Sony music entertainment', 'Mahavishnu Orchestra', 'birds_of_fire.png', 'Een van de beroemde eerste platen van het mahavishnu orkest, nu voor het eerst uitgebracht op CD! Het beste van de jaren zeventig in uw huis.', '4209714987224', '2012-01-18 18:36:19'),
(4, 5, 'Unrecognizable screeches from a ', 15.99, 10.99, 10, 1, 'Gritmoaner productions', 'Ramses Ijff', 'no_image.png', 'There... There could be no description. It does not belong.', '4209714987125', '2012-01-18 18:36:54'),
(5, 9, 'Final destination 5', 22.99, 22.99, 0, 15, 'Warner Home Video', 'Steven Quale', 'final_destination_5.png', 'Het leven van vijf mensen is gered, maar voor hoe lang? Een epische thriller, vol griezelen, spanning en plottwists. ', '5051888087602', '2012-01-20 12:47:46'),
(6, 6, 'Got My Mojo Working', 9.99, 9.99, 22, 2, 'Chess Records', 'Muddy Waters', 'mojo_working.png', 'De vader des blues-muziek in zijn meest beroemde album. Mis dit stukje wereld-geschiedenis niet!', '7854269875421', '2012-02-03 16:54:46'),
(7, 7, 'In the Navy', 12.99, 12.99, 23, 7, 'Can''t stop productions', 'the village people', 'in_the_navy.png', 'De wereldberoemde band the village people in hun meest bekende nummers. ', '4587963215478', '2012-02-03 17:08:03'),
(8, 8, 'While heaven wept', 4.99, 4.99, 55, 616, 'nuclear blast records', 'fear of infinity', 'while_heaven_wept.png', 'De amerikaanse metal-band brengt hun opus uit. Donderende muziek geeft de strijd tegen de hemel en het heelal zelf vorm.', '6166166616616', '2012-02-03 17:22:35'),
(9, 10, 'Robowar', 1.99, 1.99, 50, 10, 'Flora Film', 'Bruno Mattei', 'robowar.png', 'Actie-star Bruno Mattei neemt het op tegen een losgebroken superwapen. Actie, spanning en romance, deze film heeft alles voor een uitstekende avond.', '7784512568974', '2012-02-03 17:25:14'),
(10, 11, 'Cool as Ice', 21.99, 21.99, 54, 1, 'Universal pictures', 'David Kellogg', 'cool_as_ice.png', 'Vanilla Ice in zijn eerste film brengt ons een nieuwe kijk in zijn karakter en zijn relaties. Een must-see voor elke fan van Ice!', '4551245357849', '2012-02-03 17:28:46'),
(11, 12, 'I, Robot', 12.99, 12.99, 5, 11, 'Davis Entertainment', 'Alex Proyas', 'i_robot.png\n', 'Isaac Asimov''s visie van de toekomst komt tot leven in deze science-fiction actie-thriller. Zullen de robots de mensheid overwelmen, of brengt een robot ze juist vrijheid?', '4785462189758', '2012-02-03 17:34:43'),
(12, 14, 'Call of Duty 2', 45.44, 34.34, 9, 1111, 'Activision', 'Keith Arem', 'call_of_duty_2.png', 'Ook jij kan nu ten strijde trekken tegen de nazi''s in het lang-verwachte volgende deel in de Call of Duty serie. ', '4587621598743', '2012-02-03 17:46:30'),
(13, 15, 'Ghost Recon: Future Soldier', 35.99, 35.99, 6, 7, 'Red Storm Entertainment', 'Tom Clancy', 'ghost_recon_future.png', 'In een toekomst waar rusland de wereld heeft overgenomen, is er maar een kans op vrijheid. Kozak, Pepper, 30k en Bones vormen de laatste hoop om deze onderdrukker te overweldigen. Maar zijn zij bevrijders, of slechts nieuwe onderdrukkers?', '8759426589745', '2012-02-03 17:49:30'),
(14, 16, 'a Boy and his Blob', 13.99, 12.99, 3, 22, 'WayForward Technologies', 'Sean Velasco', 'boy_and_his_blob.png', 'Een avontuur voor kinderen van alle leeftijden. Een simpel, doch ontroerend verhaal brengt gegarandeerd plezier voor alle spelers.', '1254789547854', '2012-02-03 17:52:46'),
(15, 17, 'Forever Odd', 11.99, 10.99, 2, 1, 'Bantam Publishing', 'Dean Koontz', 'forever_odd.png', 'Het vierde deel in de Odd Thomas serie. Een vrouw geobsedeerd door de psychische krachten van Thomas heeft Danny ontvoerd. Kan Thomas hem redden? En waarom is deze vrouw zo geobsedeerd door geesten?', '3562897456987', '2012-02-03 17:58:25'),
(16, 18, 'Het verdriet van belgië', 23.33, 12.11, 2, 11, 'De bezige bij', 'Hugo Claus', 'verdriet_van_belgie.png', 'Het Magnum Opus van Hugo Claus, over een familie in de tweede wereldoorlog. Leugenaars en collaborateurs, voor hun is de oorlog niet het grootste gevaar.', '7854968759784', '2012-02-03 18:09:50'),
(17, 19, 'Linear and Geometric Algebra', 21.99, 21.99, 8, 66, 'Niet van Toepassing', 'Alan Macdonald', 'linear_geometric_algebra.png', 'Een niet te missen gids voor de lineare en geometrische algebra. Gebruikt door tientallen universiteiten over de hele wereld. Verrijk uw kennis nu!', '2365412546321', '2012-02-03 18:11:58');

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
(1, 'admin', '6bbc1d45cf2bc16bbaf39bffb654e85fe28e02328de451360f3499a50f77d8257bb218ed516dd693350eadba7ee37d44e0acfe7f5973a30630ff254f053bcd1f', '9WYEtFmX6ECJcmjd9', '2973HJ', 'Maaskantje', 'Koekwousstraat', '92', 'The', 'Admin', 'M', '0237598274', '', 'admin@umbranis.nl', 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `winkelwagen`
--

CREATE TABLE IF NOT EXISTS `winkelwagen` (
  `user_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`prod_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
