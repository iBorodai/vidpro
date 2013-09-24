-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2013 at 08:22 PM
-- Server version: 5.1.40
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vidguk`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_type` char(3) NOT NULL DEFAULT 'pnt',
  `com_key_obj` int(11) NOT NULL,
  `com_key_u` int(11) NOT NULL,
  `com_date` datetime NOT NULL,
  `com_text` text NOT NULL,
  `com_short` varchar(255) NOT NULL,
  `com_cachelikes` int(11) NOT NULL,
  `com_cahecomms` int(11) NOT NULL,
  PRIMARY KEY (`com_id`),
  KEY `com_key_u` (`com_key_u`),
  KEY `com_type` (`com_type`,`com_key_obj`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_type`, `com_key_obj`, `com_key_u`, `com_date`, `com_text`, `com_short`, `com_cachelikes`, `com_cahecomms`) VALUES
(1, 'pnt', 1, 1, '2013-09-16 17:14:31', 'Отличное место! Отдых душой и телом + вкусная еда + живая музыка + свое, вкусное пиво!! Налетай! :)', 'Отличное место! Отдых душой и телом + вкусная еда + живая музыка + свое, вкусное пиво!! Налетай! :)', 0, 0),
(2, 'pnt', 2, 1, '2013-08-01 18:38:03', 'КРУТО! Очень понравилось, особенно в субботу вечером! :)', 'КРУТО! Очень понравилось, особенно в субботу вечером! :)', 0, 0),
(3, 'pnt', 3, 1, '2013-09-16 18:38:03', 'Стало хуже намного..', 'Стало хуже намного..', 0, 0),
(17, 'pnt', 3, 1, '2013-09-23 20:02:15', 'Стал очень плохим. Перестал туда ходить вообще!', 'Стал очень плохим. Перестал туда ходить вообще!', 0, 0),
(18, 'pnt', 25, 4, '2013-09-23 20:06:45', 'Маленький он какой-то этот мак... ', 'Маленький он какой-то этот мак... ', 0, 0),
(19, 'pnt', 25, 4, '2013-09-23 20:09:58', 'И ВООБЩЕ! Херня а не мак!', 'И ВООБЩЕ! Херня а не мак!', 0, 0),
(20, 'pnt', 28, 4, '2013-09-23 20:19:49', 'ГАМНО! ', 'ГАМНО! ', 0, 0),
(16, 'pnt', 1, 1, '2013-09-23 20:01:20', 'Отзыв для роута из списка', 'Отзыв для роута из списка', 0, 0),
(13, 'pnt', 2, 1, '2013-09-23 19:17:49', 'JKLHKJHJK', 'JKLHKJHJK', 0, 0),
(14, 'pnt', 2, 1, '2013-09-23 19:18:09', 'AAAA', 'AAAA', 0, 0),
(15, 'pnt', 1, 1, '2013-09-23 19:58:13', 'Добавлю ка я отзыв для портера!', 'Добавлю ка я отзыв для портера!', 0, 0),
(21, 'pnt', 31, 4, '2013-09-23 21:01:50', 'Да, пробовал... вкусно, да... да...', 'Да, пробовал... вкусно, да... да...', 0, 0),
(22, 'pnt', 32, 1, '2013-09-23 21:03:42', 'Все они одинаковые, блин!', 'Все они одинаковые, блин!', 0, 0),
(23, 'pnt', 32, 1, '2013-09-23 21:04:19', 'Дада, ОДИНАКОВО ГОЛИМЫЕ! :)', 'Дада, ОДИНАКОВО ГОЛИМЫЕ! :)', 0, 0),
(24, 'pnt', 32, 1, '2013-09-23 21:04:39', 'УРА!', 'УРА!', 0, 0),
(25, 'pnt', 32, 1, '2013-09-23 21:04:52', 'Еще ура!', 'Еще ура!', 0, 0),
(26, 'pnt', 32, 1, '2013-09-23 21:51:30', 'xcfgvdfg', 'xcfgvdfg', 0, 0),
(27, 'pnt', 32, 1, '2013-09-23 21:51:50', 'sadfsdfg', 'sadfsdfg', 0, 0),
(28, 'pnt', 32, 1, '2013-09-23 21:52:05', 'Все плоххо!', 'Все плоххо!', 0, 0),
(29, 'pnt', 32, 1, '2013-09-23 21:52:26', 'sdfgsdfsg', 'sdfgsdfsg', 0, 0),
(30, 'pnt', 32, 1, '2013-09-23 21:53:27', 'sddfg', 'sddfg', 0, 0),
(31, 'pnt', 32, 1, '2013-09-23 21:53:37', 'xdfgsdfg', 'xdfgsdfg', 0, 0),
(32, 'pnt', 32, 1, '2013-09-23 21:53:52', 'sadtfsdrfg', 'sadtfsdrfg', 0, 0),
(33, 'pnt', 31, 1, '2013-09-23 21:54:57', 'ВСЕ ОЧЕНЬ КЛЕВО!', 'ВСЕ ОЧЕНЬ КЛЕВО!', 0, 0),
(34, 'pnt', 32, 1, '2013-09-23 21:58:23', 'вапваыпва', 'вапваыпва', 0, 0),
(35, 'pnt', 1, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(36, 'pnt', 2, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(37, 'pnt', 3, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(38, 'pnt', 10, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(39, 'pnt', 15, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(40, 'pnt', 22, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(41, 'pnt', 23, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(42, 'pnt', 24, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(43, 'pnt', 25, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(44, 'pnt', 26, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(45, 'pnt', 31, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(46, 'pnt', 32, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(47, 'pnt', 33, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(48, 'pnt', 34, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(49, 'pnt', 35, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(50, 'pnt', 36, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(51, 'pnt', 37, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(52, 'pnt', 38, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(53, 'pnt', 39, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(54, 'pnt', 40, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(55, 'pnt', 41, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(56, 'pnt', 42, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(57, 'pnt', 43, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(58, 'pnt', 44, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(59, 'pnt', 45, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(60, 'pnt', 46, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(61, 'pnt', 47, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(62, 'pnt', 48, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(63, 'pnt', 49, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(64, 'pnt', 50, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(65, 'pnt', 51, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(66, 'pnt', 52, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(67, 'pnt', 53, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(68, 'pnt', 54, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(69, 'pnt', 55, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(70, 'pnt', 56, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(71, 'pnt', 57, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(72, 'pnt', 58, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(73, 'pnt', 59, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(74, 'pnt', 60, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(75, 'pnt', 61, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(76, 'pnt', 62, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(77, 'pnt', 63, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(78, 'pnt', 64, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(79, 'pnt', 65, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(80, 'pnt', 66, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(81, 'pnt', 67, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(82, 'pnt', 68, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(83, 'pnt', 69, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(84, 'pnt', 70, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0),
(85, 'pnt', 71, 2, '2013-09-24 17:09:20', 'Комментарий', 'Комментарий', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fs_category`
--

DROP TABLE IF EXISTS `fs_category`;
CREATE TABLE IF NOT EXISTS `fs_category` (
  `fs_id` varchar(25) NOT NULL,
  `fs_url` varchar(50) NOT NULL,
  `fs_name` varchar(255) NOT NULL,
  `fs_img` varchar(255) NOT NULL,
  PRIMARY KEY (`fs_id`),
  UNIQUE KEY `t_url` (`fs_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fs_category`
--

INSERT INTO `fs_category` (`fs_id`, `fs_url`, `fs_name`, `fs_img`) VALUES
('503288ae91d4c4b30a586d67', 'afganskiirestoran', 'Афганский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1c8941735', 'afrikanskiirestoran', 'Африканский ресторан', 'https://foursquare.com/img/categories_v2/food/african_88.png'),
('4bf58dd8d48988d14e941735', 'amerikanskiirestoran', 'Американский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d152941735', 'venesyelskiearepas', 'Венесуэльские арепас', 'https://foursquare.com/img/categories_v2/food/arepas_88.png'),
('4bf58dd8d48988d107941735', 'argentinskiirestoran', 'Аргентинский ресторан', 'https://foursquare.com/img/categories_v2/food/argentinian_88.png'),
('4bf58dd8d48988d142941735', 'aziatskiirestoran', 'Азиатский ресторан', 'https://foursquare.com/img/categories_v2/food/asian_88.png'),
('4bf58dd8d48988d169941735', 'avstraliiskiirestoran', 'Австралийский ресторан', 'https://foursquare.com/img/categories_v2/food/australian_88.png'),
('4bf58dd8d48988d1df931735', 'gril-bar-shashlychnaia', 'Гриль-бар / Шашлычная', 'https://foursquare.com/img/categories_v2/food/bbq_88.png'),
('4bf58dd8d48988d179941735', 'kafesbeiglami', 'Кафе с бейглами', 'https://foursquare.com/img/categories_v2/food/bagels_88.png'),
('4bf58dd8d48988d16a941735', 'bylochnaia', 'Булочная', 'https://foursquare.com/img/categories_v2/food/bakery_88.png'),
('4bf58dd8d48988d16b941735', 'brazilskiirestoran', 'Бразильский ресторан', 'https://foursquare.com/img/categories_v2/food/brazilian_88.png'),
('4bf58dd8d48988d143941735', 'kafedliazavtraka', 'Кафе для завтрака', 'https://foursquare.com/img/categories_v2/food/breakfast_88.png'),
('4bf58dd8d48988d16c941735', 'zakysochnaiasbyrgerami', 'Закусочная с бургерами', 'https://foursquare.com/img/categories_v2/food/burger_88.png'),
('4bf58dd8d48988d153941735', 'zakysochnaiasbyrrito', 'Закусочная с буррито', 'https://foursquare.com/img/categories_v2/food/burrito_88.png'),
('4bf58dd8d48988d128941735', 'byfet', 'Буфет', 'https://foursquare.com/img/categories_v2/food/cafeteria_88.png'),
('4bf58dd8d48988d16d941735', 'kafe', 'Кафе', 'https://foursquare.com/img/categories_v2/food/cafe_88.png'),
('4bf58dd8d48988d17a941735', 'kadjynskii-kreolskiirestoran', 'Каджунский / Креольский ресторан', 'https://foursquare.com/img/categories_v2/food/cajun_88.png'),
('4bf58dd8d48988d144941735', 'karibskiirestoran', 'Карибский ресторан', 'https://foursquare.com/img/categories_v2/food/caribbean_88.png'),
('4bf58dd8d48988d145941735', 'kitaiskiirestoran', 'Китайский ресторан', 'https://foursquare.com/img/categories_v2/food/chinese_88.png'),
('4bf58dd8d48988d1e0931735', 'kofeinia', 'Кофейня', 'https://foursquare.com/img/categories_v2/food/coffeeshop_88.png'),
('4bf58dd8d48988d154941735', 'kybinskiirestoran', 'Кубинский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1bc941735', 'kafe-konditerskaia', 'Кафе-кондитерская', 'https://foursquare.com/img/categories_v2/food/cupcakes_88.png'),
('4bf58dd8d48988d146941735', 'bistro', 'Бистро', 'https://foursquare.com/img/categories_v2/food/deli_88.png'),
('4bf58dd8d48988d1d0941735', 'desertnoekafe', 'Десертное кафе', 'https://foursquare.com/img/categories_v2/food/dessert_88.png'),
('4bf58dd8d48988d1f5931735', 'restorandimsam', 'Ресторан димсам', 'https://foursquare.com/img/categories_v2/food/dimsum_88.png'),
('4bf58dd8d48988d147941735', 'stolovaia', 'Столовая', 'https://foursquare.com/img/categories_v2/food/diner_88.png'),
('4e0e22f5a56208c4ea9a85a0', 'viskarnia', 'Вискарня', 'https://foursquare.com/img/categories_v2/food/brewery_88.png'),
('4bf58dd8d48988d148941735', 'ponchikovaia', 'Пончиковая', 'https://foursquare.com/img/categories_v2/food/donuts_88.png'),
('4bf58dd8d48988d108941735', 'pelmennaia-varenichnaia', 'Пельменная / Вареничная', 'https://foursquare.com/img/categories_v2/food/dumplings_88.png'),
('4bf58dd8d48988d109941735', 'vostochno-evropeiskiirestoran', 'Восточно-европейский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d10a941735', 'efiopskiirestoran', 'Эфиопский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d10b941735', 'falafel-restoran', 'Фалафель-ресторан', 'https://foursquare.com/img/categories_v2/food/falafel_88.png'),
('4bf58dd8d48988d16e941735', 'restoranfast-fyd', 'Ресторан фаст-фуд', 'https://foursquare.com/img/categories_v2/food/fastfood_88.png'),
('4eb1bd1c3b7b55596b4a748f', 'filippinskiirestoran', 'Филиппинский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4edd64a0c7ddd24ca188df1a', 'fishendchips', 'Фиш энд чипс', 'https://foursquare.com/img/categories_v2/food/fishandchips_88.png'),
('4bf58dd8d48988d1cb941735', 'zakysochnaianakolesah', 'Закусочная на колесах', 'https://foursquare.com/img/categories_v2/food/streetfood_88.png'),
('4bf58dd8d48988d10c941735', 'francyzskiirestoran', 'Французский ресторан', 'https://foursquare.com/img/categories_v2/food/french_88.png'),
('4d4ae6fc7a7b7dea34424761', 'jarenyecypliata', 'Жареные цыплята', 'https://foursquare.com/img/categories_v2/food/friedchicken_88.png'),
('4bf58dd8d48988d155941735', 'gastropab', 'Гастропаб', 'https://foursquare.com/img/categories_v2/food/gastropub_88.png'),
('4bf58dd8d48988d10d941735', 'nemeckiirestoran', 'Немецкий ресторан', 'https://foursquare.com/img/categories_v2/food/german_88.png'),
('4c2cd86ed066bed06c3c5209', 'restoranbezglutenovoikyhni', 'Ресторан безглютеновой кухни', 'https://foursquare.com/img/categories_v2/food/glutenfree_88.png'),
('4bf58dd8d48988d10e941735', 'grecheskiirestoran', 'Греческий ресторан', 'https://foursquare.com/img/categories_v2/food/greek_88.png'),
('4bf58dd8d48988d16f941735', 'zakysochnaiashot-dogami', 'Закусочная с хот-догами', 'https://foursquare.com/img/categories_v2/food/hotdog_88.png'),
('4bf58dd8d48988d1c9941735', 'kafe-morojenoe', 'Кафе-мороженое', 'https://foursquare.com/img/categories_v2/food/icecream_88.png'),
('4bf58dd8d48988d10f941735', 'indiiskiirestoran', 'Индийский ресторан', 'https://foursquare.com/img/categories_v2/food/indian_88.png'),
('4deefc054765f83613cdba6f', 'indoneziiskiirestoran', 'Индонезийский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d110941735', 'italianskiirestoran', 'Итальянский ресторан', 'https://foursquare.com/img/categories_v2/food/italian_88.png'),
('4bf58dd8d48988d111941735', 'iaponskiirestoran', 'Японский ресторан', 'https://foursquare.com/img/categories_v2/food/japanese_88.png'),
('4bf58dd8d48988d112941735', 'sok-bar', 'Сок-бар', 'https://foursquare.com/img/categories_v2/food/juicebar_88.png'),
('4bf58dd8d48988d113941735', 'koreiskiirestoran', 'Корейский ресторан', 'https://foursquare.com/img/categories_v2/food/korean_88.png'),
('4bf58dd8d48988d1be941735', 'latinoamerikanskiirestoran', 'Латиноамериканский ресторан', 'https://foursquare.com/img/categories_v2/food/latinamerican_88.png'),
('4bf58dd8d48988d1bf941735', 'makaronnyirestoran', 'Макаронный ресторан', 'https://foursquare.com/img/categories_v2/food/macandcheese_88.png'),
('4bf58dd8d48988d156941735', 'malaiziiskiirestoran', 'Малайзийский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1c0941735', 'restoransredizemnomorskoikyhni', 'Ресторан средиземноморской кухни', 'https://foursquare.com/img/categories_v2/food/mediterranean_88.png'),
('4bf58dd8d48988d1c1941735', 'meksikanskiirestoran', 'Мексиканский ресторан', 'https://foursquare.com/img/categories_v2/food/mexican_88.png'),
('4bf58dd8d48988d115941735', 'restoranblijnevostochnoikyhni', 'Ресторан ближневосточной кухни', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1c2941735', 'restoranmolekyliarnoikyhni', 'Ресторан молекулярной кухни', 'https://foursquare.com/img/categories_v2/food/moleculargastronomy_88.png'),
('4eb1d5724b900d56c88a45fe', 'mongolskiirestoran', 'Монгольский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1c3941735', 'marokkanskiirestoran', 'Марокканский ресторан', 'https://foursquare.com/img/categories_v2/food/moroccan_88.png'),
('4bf58dd8d48988d157941735', 'restoransovremennoiamerikanskoikyhni', 'Ресторан современной американской кухни', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4eb1bfa43b7b52c0e1adc2e8', 'peryanskiirestoran', 'Перуанский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1ca941735', 'picceriia', 'Пиццерия', 'https://foursquare.com/img/categories_v2/food/pizza_88.png'),
('4def73e84765ae376e57713a', 'portygalskiirestoran', 'Португальский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1d1941735', 'lapshichnaia', 'Лапшичная', 'https://foursquare.com/img/categories_v2/food/ramen_88.png'),
('4bf58dd8d48988d1c4941735', 'restoran', 'Ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1bd941735', 'salat-bar', 'Салат-бар', 'https://foursquare.com/img/categories_v2/food/salad_88.png'),
('4bf58dd8d48988d1c5941735', 'sendvich-bar', 'Сэндвич-бар', 'https://foursquare.com/img/categories_v2/food/sandwiches_88.png'),
('4bf58dd8d48988d1c6941735', 'skandinavskiirestoran', 'Скандинавский ресторан', 'https://foursquare.com/img/categories_v2/food/scandinavian_88.png'),
('4bf58dd8d48988d1ce941735', 'restoranmoreprodyktov', 'Ресторан морепродуктов', 'https://foursquare.com/img/categories_v2/food/seafood_88.png'),
('4bf58dd8d48988d1c7941735', 'zakysochnaia', 'Закусочная', 'https://foursquare.com/img/categories_v2/food/snacks_88.png'),
('4bf58dd8d48988d1dd931735', 'sypnyirestoran', 'Супный ресторан', 'https://foursquare.com/img/categories_v2/food/soup_88.png'),
('4bf58dd8d48988d1cd941735', 'ujnoamerikanskiirestoran', 'Южноамериканский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d14f941735', 'afrikano-amerikanskiirestoran', 'Африкано-американский ресторан', 'https://foursquare.com/img/categories_v2/food/southern_88.png'),
('4bf58dd8d48988d150941735', 'ispanskiirestoran', 'Испанский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d1cc941735', 'steik-hays', 'Стейк-хаус', 'https://foursquare.com/img/categories_v2/food/steakhouse_88.png'),
('4bf58dd8d48988d1d2941735', 'syshi-bar', 'Суши-бар', 'https://foursquare.com/img/categories_v2/food/sushi_88.png'),
('4bf58dd8d48988d158941735', 'shveicarskiirestoran', 'Швейцарский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d151941735', 'tako-bar', 'Тако-бар', 'https://foursquare.com/img/categories_v2/food/taco_88.png'),
('4bf58dd8d48988d1db931735', 'restorantapas', 'Ресторан тапас', 'https://foursquare.com/img/categories_v2/food/tapas_88.png'),
('4bf58dd8d48988d1dc931735', 'chainaia', 'Чайная', 'https://foursquare.com/img/categories_v2/food/tearoom_88.png'),
('4bf58dd8d48988d149941735', 'taiskiirestoran', 'Тайский ресторан', 'https://foursquare.com/img/categories_v2/food/thai_88.png'),
('4f04af1f2fb6e1c99f3db0bb', 'tyreckiirestoran', 'Турецкий ресторан', 'https://foursquare.com/img/categories_v2/food/turkish_88.png'),
('4bf58dd8d48988d1d3941735', 'vegetarianskii-veganskiirestoran', 'Вегетарианский / Веганский ресторан', 'https://foursquare.com/img/categories_v2/food/vegetarian_88.png'),
('4bf58dd8d48988d14a941735', 'vetnamskiirestoran', 'Вьетнамский ресторан', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d14b941735', 'vinodelnia', 'Винодельня', 'https://foursquare.com/img/categories_v2/food/winery_88.png'),
('4bf58dd8d48988d14c941735', 'kyrinyekrylyshki', 'Куриные крылышки', 'https://foursquare.com/img/categories_v2/food/wings_88.png'),
('512e7cae91d4cbb4e5efe0af', 'zamorojennyiiogyrt', 'Замороженный йогурт', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
('4bf58dd8d48988d116941735', 'bar', 'Бар', 'https://foursquare.com/img/categories_v2/nightlife/bar_88.png'),
('4bf58dd8d48988d117941735', 'pivnoisad', 'Пивной сад', 'https://foursquare.com/img/categories_v2/nightlife/beergarden_88.png'),
('50327c8591d4c4b30a586d5d', 'pivovarnia', 'Пивоварня', 'https://foursquare.com/img/categories_v2/food/brewery_88.png'),
('4bf58dd8d48988d11e941735', 'kokteil-bar', 'Коктейль-бар', 'https://foursquare.com/img/categories_v2/nightlife/cocktails_88.png'),
('4bf58dd8d48988d118941735', 'rumochnaia', 'Рюмочная', 'https://foursquare.com/img/categories_v2/nightlife/divebar_88.png'),
('4bf58dd8d48988d1d8941735', 'gei-bar', 'Гей-бар', 'https://foursquare.com/img/categories_v2/nightlife/gaybar_88.png'),
('4bf58dd8d48988d119941735', 'barskalianom', 'Бар с кальяном', 'https://foursquare.com/img/categories_v2/nightlife/hookahbar_88.png'),
('4bf58dd8d48988d1d5941735', 'barprigostinice', 'Бар при гостинице', 'https://foursquare.com/img/categories_v2/travel/hotel_bar_88.png'),
('4bf58dd8d48988d120941735', 'bar-karaoke', 'Бар-караоке', 'https://foursquare.com/img/categories_v2/nightlife/karaoke_88.png'),
('4bf58dd8d48988d121941735', 'laynj-bar', 'Лаунж-бар', 'https://foursquare.com/img/categories_v2/nightlife/lounge_88.png'),
('4bf58dd8d48988d11f941735', 'nochnoiklyb', 'Ночной клуб', 'https://foursquare.com/img/categories_v2/nightlife/nightclub_88.png'),
('4bf58dd8d48988d11a941735', 'nochnaiajizn-prochee', 'Ночная жизнь - Прочее', 'https://foursquare.com/img/categories_v2/nightlife/default_88.png'),
('4bf58dd8d48988d11b941735', 'pab', 'Паб', 'https://foursquare.com/img/categories_v2/nightlife/pub_88.png'),
('4bf58dd8d48988d11c941735', 'sake-bar', 'Сакэ-бар', 'https://foursquare.com/img/categories_v2/nightlife/sake_88.png'),
('4bf58dd8d48988d1d4941735', 'podpolnyibar', 'Подпольный бар', 'https://foursquare.com/img/categories_v2/nightlife/secretbar_88.png'),
('4bf58dd8d48988d11d941735', 'sportivnyibar', 'Спортивный бар', 'https://foursquare.com/img/categories_v2/nightlife/sportsbar_88.png'),
('4bf58dd8d48988d1d6941735', 'strip-klyb', 'Стрип-клуб', 'https://foursquare.com/img/categories_v2/nightlife/stripclub_88.png'),
('4bf58dd8d48988d122941735', 'viski-bar', 'Виски-бар', 'https://foursquare.com/img/categories_v2/nightlife/whiskey_88.png'),
('4bf58dd8d48988d123941735', 'vinnyibar', 'Винный бар', 'https://foursquare.com/img/categories_v2/nightlife/wine_88.png');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `l_weight` tinyint(1) NOT NULL,
  `l_type` char(3) NOT NULL DEFAULT 'pnt',
  `l_key_obj` int(11) NOT NULL,
  `l_key_u` int(11) NOT NULL,
  `l_date` datetime NOT NULL,
  PRIMARY KEY (`l_type`,`l_key_obj`,`l_key_u`),
  KEY `l_weight` (`l_weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`l_weight`, `l_type`, `l_key_obj`, `l_key_u`, `l_date`) VALUES
(-1, 'pnt', 1, 1, '2013-09-10 16:34:34'),
(1, 'pnt', 2, 2, '2013-09-10 16:34:34'),
(-1, 'pnt', 32, 1, '2013-09-23 21:58:23'),
(1, 'pnt', 31, 1, '2013-09-23 21:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `point`
--

DROP TABLE IF EXISTS `point`;
CREATE TABLE IF NOT EXISTS `point` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_url` varchar(255) NOT NULL,
  `p_fsid` varchar(24) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_img` varchar(255) NOT NULL,
  `p_dscr` varchar(255) NOT NULL,
  `p_key_reg` int(11) NOT NULL,
  `p_addr` varchar(255) NOT NULL,
  `p_lat` decimal(20,15) NOT NULL,
  `p_lng` decimal(20,15) NOT NULL,
  `p_createdate` datetime NOT NULL,
  PRIMARY KEY (`p_id`),
  UNIQUE KEY `p_url` (`p_url`),
  UNIQUE KEY `p_fsid` (`p_fsid`),
  KEY `p_key_reg` (`p_key_reg`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `point`
--

INSERT INTO `point` (`p_id`, `p_url`, `p_fsid`, `p_name`, `p_img`, `p_dscr`, `p_key_reg`, `p_addr`, `p_lat`, `p_lng`, `p_createdate`) VALUES
(1, 'route66', '513262d5e4b0e80cdba8eb71', 'Route 66', 'https://irs3.4sqi.net/img/general/200x150/581126_bOynLYo23Ta3PzfD6Pxcj5dv9OpDVV9p86o34gDIw4A.jpg', 'Байк-ресторан Route 66', 1, 'вул. Глушкова, 11', 50.370567403664220, 30.462512969970707, '2013-09-16 17:10:03'),
(2, 'porterpab', '4cc30146b2beb1f78091134c', 'Портер ПАБ', 'https://irs0.4sqi.net/img/general/200x150/42868505_RZyVouOt-NsBDsouzjPogEqukdDLKuJZGExyb1zqw8A.png', '', 1, 'вул. Івана Мазепи, 3', 50.443410301583974, 30.546293516188170, '2013-09-16 18:36:02'),
(3, 'blindaj', '4d5565ece7f1a1cd18fbf9a4', 'Блиндаж', 'https://irs2.4sqi.net/img/general/200x150/50173984_1S1RrbWxGpyJNKkXvhqhr03dKM7k_ZoTqSipzCCgdrY.jpg', '', 1, 'вул. Мала Житомирська, 15', 50.453463533581460, 30.519684653025080, '2013-09-16 18:36:02'),
(10, 'bochkapivnaiaBochka', '4c29f0b1360cef3bd15cbedc', 'Бочка пивная / Bochka', 'https://irs0.4sqi.net/img/general/200x150/48523395_51ZA7mZDLXFE331eGKlacPcWWziUNECvFvzDhlEdrXg.jpg', 'Популярное для приезжих WiFi, Бронирование, Есть места на улице, Кредитные карты, Ужин, Время скидок', 1, 'Київ, вул. Хрещатик, 19-а', 50.446792556800000, 30.523452758800000, '2013-09-20 20:09:36'),
(15, 'gastrorock', '4e2082ad1838712abe678d46', 'GastroRock', 'https://irs3.4sqi.net/img/general/200x150/45769594_USuaF-0yVx9Epr_k63sKKZ-eLidKB2L-Gd1XarasNwU.jpg', 'Многим нравится это место WiFi, Бронирование, Есть места на улице, Доставка, Кредитные карты, Обед, Ужин', 1, 'Київ, вул. Воздвиженська, 10б', 50.461766071200000, 30.508990287800000, '2013-09-20 20:59:07'),
(22, 'pabvikont', '50c4cd2de4b049cab0ef197d', 'Паб "Виконт"', 'https://irs3.4sqi.net/img/general/200x150/41109171_PBG-8dXi8axzS4OuKEbS6ro1_fiOqhleBtdHgUt4r1Q.jpg', ' ', 1, 'Киев, Петра Запорожца, 26а', 50.506947908000000, 30.513777813900000, '2013-09-20 21:18:46'),
(23, 'restoran', '50692890e4b0058e9df93c8c', 'Ресторан', 'https://irs3.4sqi.net/img/general/200x150/42244258_SbPHZQhUkyVid4swIYXoosgJwniU5lOiTOYm33eJifU.jpg', ' Завтрак, Поздний завтрак, Обед', 1, 'Киев, Конгресс Отель "Пуща"', 50.533600805800000, 30.362192586500000, '2013-09-20 21:19:32'),
(24, 'pabvikont-523c91d327007', '515d8af7e4b099e8a8300435', 'Паб "Vikont"', 'https://irs3.4sqi.net/img/general/200x150/26781025_Bm6WWbPtD9j_4kIs_eoti9EEnNcsas3nl1RMFVdL3BU.jpg', ' Обед, Ужин', 1, ', ', 50.479683776900000, 30.604794425400000, '2013-09-20 21:20:03'),
(25, 'mcdonalds', '4c1cb68fb4e62d7f8e6fdb93', 'McDonald''s', 'https://irs1.4sqi.net/img/general/200x150/29655916_qH5wDkjK89vK9Un7VHP51RlHgNod13RNFed5fKmdpWI.jpg', 'Многим нравится это место WiFi, Доставка, Кредитные карты, Поздний завтрак, Обед, Ужин', 1, 'Київ, бул. Лесі Українки, 26', 50.427522214200000, 30.538730621300000, '2013-09-23 20:06:24'),
(26, 'kafekolesonaprotivsto', '5051ddcde4b0bdd5e8da554c', 'Кафе "Колесо" (напротив СТО)', '', ' ', 1, 'Киев, Лазурная 1', 50.339200000000000, 30.545900000000000, '2013-09-23 20:18:06'),
(31, 'pivzavodnapodoli', '4cdd40bbd5495481712f46b2', 'Пивзавод На Подолi', 'https://irs3.4sqi.net/img/general/200x150/35826364_JmGog2rL9shP75HpbXPcISGODznaU0oRVke4nonMz5A.jpg', ' Поздний завтрак, Обед, Ужин', 1, 'Киев, ул. Фрунзе, 41', 50.472270958300000, 30.498717947500000, '2013-09-23 21:00:46'),
(32, 'mcdonalds-52408264b489e', '4c0a64c932daef3bf7a14b50', 'McDonald''s', 'https://irs2.4sqi.net/img/general/200x150/6708402_sief5XowtceZ2OI0303S6iRuSgjqbHk9MfZq6UKjiQw.jpg', 'Многим нравится это место WiFi, Есть места на улице, Кредитные карты, Поздний завтрак, Обед, Ужин', 1, 'Київ, просп. Московський, 12а', 50.488528295800000, 30.497853756000000, '2013-09-23 21:03:16'),
(33, 'pabshtab', '4c317d0209a99c74b9500b2a', 'Паб Штаб', '', ' Ужин', 1, 'Київ, просп. Повітрофлотський, 16', 50.438374705400000, 30.476202964800000, '2013-09-24 17:01:56'),
(34, 'pabtaverna', '51a4dc2c498edeea45e188cd', 'Паб "Таверна"', 'https://irs2.4sqi.net/img/general/200x150/45542452_i9iwnrT2zFldVE0FBTzSO4UqqdVhAaJw8PxpVjCqSW4.jpg', ' Поздний завтрак, Обед, Ужин', 1, 'Киев, Зои Гайдай, 4', 50.515705108600000, 30.491680145300000, '2013-09-24 17:04:06'),
(35, 'kondyktorpab', '4e15fe8a1f6e29fb7d555a38', 'Кондуктор Паб', 'https://irs1.4sqi.net/img/general/200x150/22468462_A73eaBmIg3Z7WNJi2V36pk593ksvjPkaiNBzbeK9Ajk.jpg', ' WiFi, Кредитные карты, Обед, Ужин', 1, 'Київ, вул. Фрунзе, 102', 50.479479602200000, 30.480509440500000, '2013-09-24 17:04:19'),
(36, 'papapab', '51c48eba498e0c20d74ea103', 'Папа паб', 'https://irs3.4sqi.net/img/general/200x150/43917839_6SqkxSBjGsRV3ERbbziYNcy7OQLJbyfJsJFhFynnV8M.jpg', ' ', 1, 'Киев, проспект 40-лет Октября 8', 50.407715000000000, 30.518066000000000, '2013-09-24 17:04:19'),
(37, 'dorotipab', '4c21fa09502b9521bfe06d21', 'Дороти Паб', 'https://irs1.4sqi.net/img/general/200x150/27732631_haM98y99hY5Vaqf-wkXD3pmSSln_vdoGgFGU6-26XWM.jpg', 'Популярное для приезжих WiFi, Кредитные карты, Ужин, Время скидок', 1, 'Київ, вул. Саксаганського, 16/43', 50.436188005600000, 30.516586303700000, '2013-09-24 17:04:21'),
(38, 'pab', '4f15a949e4b0678414fa8dd1', 'Паб «Витамин»', 'https://irs3.4sqi.net/img/general/200x150/19123693_rqY1iNqFAZzqekTeQkla6XoYfrsSUN3Ly4jWQHu8G0w.jpg', ' Бронирование, Кредитные карты, Обед, Ужин, Время скидок', 1, 'Київ, ТРЦ "Магелан"', 50.368227018300000, 30.458071231800000, '2013-09-24 17:04:24'),
(39, 'porterpab-52419bea0d7c1', '52303e2711d29a701167bffd', 'Портер паб', 'https://irs0.4sqi.net/img/general/200x150/32160849_9hNsavfdGCntffPjAfQMg6IJptEE5SVQznYBsa_2v1A.jpg', ' Бронирование, Кредитные карты, Ужин', 1, ', Дорогожицкая', 50.469824493600000, 30.459236655400000, '2013-09-24 17:04:26'),
(40, '7pab', '521a2f5b498e58df32fd2809', '7 паб', 'https://irs2.4sqi.net/img/general/200x150/48656626_qocjrK4kzoPPTmYU9PuO_k0dMLm6ttbHPsp2RtrxfOw.jpg', ' ', 1, ', ', 50.445630122500000, 30.449266165100000, '2013-09-24 17:04:27'),
(41, 'pabchempion', '4da5f2c993a01f42fad1866c', 'Паб Чемпион', 'https://irs0.4sqi.net/img/general/200x150/42326520_dAGiigpyrDtrIQWh-82fIT8giwHmnf4qpyNdnx1IRfw.jpg', ' Ужин', 1, 'Киев, Милославская 43', 50.532135842100000, 30.597174540800000, '2013-09-24 17:04:41'),
(42, 'barrakydapab', '4f9bf81ee4b033ffd391f20f', 'Барракуда Паб', 'https://irs0.4sqi.net/img/general/200x150/jJAkGPq8J9369yZcKTLZFv4joe9LTchpqV71N5Bf4Zc.jpg', ' WiFi, Ужин', 1, ', Соломенская 33', 50.420922612100000, 30.488953704200000, '2013-09-24 17:04:44'),
(43, 'ginnesspab', '4c0bd4fc009a0f4772a5ebbf', 'Гиннесс Паб', 'https://irs3.4sqi.net/img/general/200x150/VLE3PKN5FYGSK4FUR0FW3X5JYCDNMVFID3VTCT1Y1RPFFLD1.jpg', ' WiFi, Есть места на улице, Ужин', 1, 'Київ, просп. Героїв Сталінграда, 24А', 50.512307633100000, 30.509870052300000, '2013-09-24 17:04:49'),
(44, 'pabkompas', '50ae8dede4b0602cfaf372ea', 'Паб Компас', 'https://irs2.4sqi.net/img/general/200x150/50721031_rUsK5cReHyGkydyX_lLpnvd1ii0JdiHqCbDsBJ2rlac.jpg', ' ', 1, 'Киев, ул. Радунская', 50.528228897100000, 30.600636005400000, '2013-09-24 17:04:57'),
(45, 'picapab', '51e26601498e26967f1deb0d', 'Пица Паб', 'https://irs0.4sqi.net/img/general/200x150/24981307_6j_ijN3kKLEBgTVp4yo1MiTxdyiCOUkLO4p6Ak51GKc.jpg', ' ', 1, ', ', 50.428989896500000, 30.604391313000000, '2013-09-24 17:04:58'),
(46, 'pabbrodiaga', '500c2abde4b0f6804f39eacd', 'Паб Бродяга', 'https://irs1.4sqi.net/img/general/200x150/47523509_8oYKFDgOkJaE-L_IcOjNY2H9hwZhlZhc_-JIlG53xw0.jpg', ' Ужин', 1, ', ', 50.467848619100000, 30.510235114900000, '2013-09-24 17:04:59'),
(47, 'tricahapab', '513b84d8e4b07fb429c3f523', 'Трицаха Паб', 'https://irs3.4sqi.net/img/general/200x150/17726269_7qL1QYih_kIoUaxRr4O6KUqBr2ZXqtqjOLd7A2u7_nw.jpg', ' Ужин', 1, ', ', 50.507290914900000, 30.490591285600000, '2013-09-24 17:05:01'),
(48, 'adamspab', '4f399fcbe4b0ae43d0c9683c', 'Адамс ПАБ', 'https://irs3.4sqi.net/img/general/200x150/M90kY8cmyP_8JTI2qkaT_yoc2wU2afua4-9zAhHtInQ.jpg', ' Ужин', 1, 'Киев, Метро Минская', 50.511473010000000, 30.497750621200000, '2013-09-24 17:05:02'),
(49, 'godzillapab', '5183b829498e2c68e9e77d13', 'Годзилла Паб', 'https://irs1.4sqi.net/img/general/200x150/45649744_y6IMxKe3Ty7c4Q69Q0FVgIYwOivXaEfItXCD9XBU6OA.jpg', ' ', 1, ', ', 50.395230356600000, 30.625772599200000, '2013-09-24 17:05:03'),
(50, 'kniajiipab', '4f26f2a3e4b0b2f991edb598', 'Княжий Паб', 'https://irs1.4sqi.net/img/general/200x150/ljWMGEFqo2Wikz7WeKRXJuHbxUCHz_fE3fz8eR-80Rk.jpg', ' Ужин', 1, 'Киев, Княжий Затон, 10', 50.402329000000000, 30.621192000000000, '2013-09-24 17:05:04'),
(51, 'hayspab', '5082e4dae4b0607ce9152fd6', 'Хаус Паб', 'https://irs1.4sqi.net/img/general/200x150/18222881__Igs4GgnA8dH9HQ4IU4s31ubliTbWqOmbIOM_GodFo8.jpg', ' Обед', 1, ', ', 50.506293111800000, 30.417857655500000, '2013-09-24 17:05:05'),
(52, 'pabtroleibys', '522376af11d2218adb52d595', 'Паб Тролейбус', 'https://irs2.4sqi.net/img/general/200x150/44648053_jehUv_fGuu--5jKTkwhnxHijBhPAKeB3tqeBpubABHc.jpg', ' ', 1, ', ', 50.509988998600000, 30.500315138100000, '2013-09-24 17:05:06'),
(53, 'bandanapab', '51e6d71f498ecebfa053fce0', 'Бандана Паб', 'https://irs2.4sqi.net/img/general/200x150/57956816_ShpDXmG8yHN4B9tG9e7wsp_mG092d2uzzJFhUYJFR8o.jpg', ' ', 1, 'Киев, Проспект Мира 17', 50.448281171600000, 30.614834782200000, '2013-09-24 17:05:08'),
(54, 'rapanpab', '510d59dee4b0a7d13d4d15bf', 'Рапан паб', 'https://irs1.4sqi.net/img/general/200x150/26854350_4Qrs1t_GQTjCgcElK_319HrYh3FFf4LxhM_eaPcePVY.jpg', ' ', 1, ', ', 50.459751588100000, 30.353076988200000, '2013-09-24 17:05:10'),
(55, 'shayrmapab', '4f46b606e4b0dd9bf25236b7', 'Шаурма Паб', 'https://irs2.4sqi.net/img/general/200x150/ztjyao-n2RHRn0mCtZ6IXG9vBcr9eL8tMgEjM7B2bME.jpg', ' ', 1, ', М. Оболонь', 50.500849000000000, 30.498920000000000, '2013-09-24 17:05:10'),
(56, 'sherlokpab', '4c1a267bfe5a76b0a29b0415', 'Шерлок Паб', 'https://irs0.4sqi.net/img/general/200x150/oKsS9bEFuWBCRyEp2nsicNWJ97GCNcNUqsrlRD_VO2A', ' WiFi, Кредитные карты, Ужин', 1, 'Київ, Борщагівська вул., 144А', 50.446300645600000, 30.450925827000000, '2013-09-24 17:05:13'),
(57, 'bandanapab-52419c19b1b18', '4cbca963a33bb1f7cd029bfd', 'Бандана Паб', 'https://irs1.4sqi.net/img/general/200x150/AL35FFQU0SPTHWT4MZQ1TUX1X5TQE4T1UBOVLCD5OYEX4UIM.jpg', ' Обед, Ужин', 1, 'Київ, просп. Миру, 17', 50.445314980800000, 30.614289392300000, '2013-09-24 17:05:13'),
(58, 'pab4h4', '4eb8391fbe7bfc284b7ace8b', 'Паб 4х4', 'https://irs3.4sqi.net/img/general/200x150/zFw4sHUiAoVTz_RkgyCXuFKjugLaHFITEWgwHwmRgek.jpg', ' ', 1, 'Київ, вул. Будищанська, 3а', 50.528324381200000, 30.606923103300000, '2013-09-24 17:05:14'),
(59, 'gagarinpab', '4f579684e4b03d89ebd46364', 'Гагарин Паб', 'https://irs3.4sqi.net/img/general/200x150/tdhLuRW8EFigm-vrUoz2diGUk1obs-9cUutBpw4GVjU.jpg', ' Ужин', 1, 'Київ, просп. Героїв Сталінграду, 16в', 50.507531571200000, 30.509161949200000, '2013-09-24 17:05:15'),
(60, 'porterpab-52419c1c55cf9', '516c4d65e4b0b595c685e357', 'Портер Паб', 'https://irs0.4sqi.net/img/general/200x150/48785650_Sd4CPLeZw8upwYAgpu8hTB5WlY-OUeRlVfn6gmRzJmk.jpg', ' Обед, Ужин', 1, 'Киев, Северная', 50.527022036200000, 30.516085896300000, '2013-09-24 17:05:16'),
(61, 'pabshengen', '4d31a95c329e548141c3a81d', 'Паб Шенген', 'https://irs1.4sqi.net/img/general/200x150/34ACIPHYY3LWX1CE24C422Q0OITEHMTJ5TLGLESIGI0UHBAJ.jpg', ' WiFi, Ужин', 1, 'Київ, бул. Русанівський, 7', 50.438730034600000, 30.594692230200000, '2013-09-24 17:05:17'),
(62, 'kypperpabcopperpub', '4e5fb5efb61c67886dc1259b', 'Куппер Паб / Copper Pub', 'https://irs3.4sqi.net/img/general/200x150/wKIDnyMZYF9au_CO0Nr9D360kZMLWcWRQWAWOhJrIk0.jpg', 'Многим нравится это место WiFi, Бронирование, Кредитные карты, Завтрак, Поздний завтрак, Обед, Ужин, Время скидок', 1, 'Київ, вул. Червоноармійська, 63', 50.430775489000000, 30.516414642300000, '2013-09-24 17:05:18'),
(63, 'porterpabporterpub', '50bfa115e4b017b5c2c298e8', 'Портер Паб / Porter Pub', 'https://irs3.4sqi.net/img/general/200x150/43153687_t6sh0psGSkLy4YB7gUpLEIRuJCZOpnJPDkYYSmlMeeI.jpg', ' WiFi, Есть места на улице, Кредитные карты, Ужин, Время скидок', 1, 'Київ, вул. Хрещатик, 15', 50.447621663400000, 30.523546647900000, '2013-09-24 17:05:20'),
(64, 'pabykryjki', '4bc9d9cecc8cd13a3f42bccf', 'Паб "У Кружки"', 'https://irs2.4sqi.net/img/general/200x150/45585077_kEfvkJDQkrodXHCPjjJzSsP7MoDGlR4VNHCXaAFHkqY.jpg', ' Ужин', 1, 'Київ, вул. Декабристів, 12/37', 50.403539504800000, 30.652649402600000, '2013-09-24 17:05:46'),
(65, 'porterpabporterpub-52419c3c468e9', '4f10a63de4b09e81d7d4c2c0', 'Портер Паб / Porter Pub', 'https://irs3.4sqi.net/img/general/200x150/42868505_TqTJ4rAGge_rywitPc5ARgGRCZjTHdaeapAqIHxkQoo.png', ' WiFi, Бронирование, Есть места на улице, Кредитные карты, Время скидок', 1, 'Київ, вул. Златоустівська, 35', 50.451437333400000, 30.487117047800000, '2013-09-24 17:05:48'),
(66, 'kypperpabcopperpub-52419c3d3cd35', '4bb76b80d535b713a877dd21', 'Куппер Паб / Copper Pub', 'https://irs1.4sqi.net/img/general/200x150/8bEPa_FtFTHUTphzKJ2T_z39tSPWf3lJuaRTPrSw-ck.jpg', 'Популярное для приезжих WiFi, Кредитные карты, Ужин', 1, 'Київ, вул. Велика Житомирська, 15а', 50.455236234300000, 30.514011383100000, '2013-09-24 17:05:49'),
(67, 'portapabportapub', '4e044e981f6e97fbec32167a', 'Порта Паб / Porta Pub', 'https://irs1.4sqi.net/img/general/200x150/33559164_N2vTXTqUqj4SNYDsrMGfXlzEggC8VhEpDbwIRpdmDFc.jpg', ' Обед, Ужин', 1, 'Київ, вул. Вишгородська, 52', 50.517712000000000, 30.450051000000000, '2013-09-24 17:05:50'),
(68, 'porterpabporterpub-52419c3fb1d5c', '4c1de7bdb4e62d7faa7add93', 'Портер Паб / Porter Pub', 'https://irs2.4sqi.net/img/general/200x150/20534375_J3JFzFeg0Ox7mdrsbDbk2VI0apsdFpnDRLxIXw01Pdk.jpg', 'Популярное для приезжих WiFi, Есть места на улице, Кредитные карты, Ужин', 1, 'м. Київ, вул. Костьольна, 4', 50.451497906800000, 30.523547977200000, '2013-09-24 17:05:51'),
(69, 'porterpabporterpub-52419c416ca4a', '4c5d88a66147be9a3a399209', 'Портер Паб / Porter Pub', 'https://irs2.4sqi.net/img/general/200x150/RMFIYFA303G2ZZPXNLVCNCMLFAA0W40JHUTL0HE3LAL3RLD3.jpg', 'Многим нравится это место WiFi, Бронирование, Есть места на улице, Кредитные карты, Ужин', 1, 'Київ, вул. Спаська, 13', 50.466893290000000, 30.518871000000000, '2013-09-24 17:05:53'),
(70, 'pabymihalycha', '4e42c4ae2271a7ca7be32976', 'Паб "У Михалыча"', 'https://irs1.4sqi.net/img/general/200x150/6Qjn64mA9ZQlwLn9wHhLd80LGhtFf1LStrbPb62TJbU.jpg', ' ', 1, 'Киев, ул. Полярная 13', 50.518747728700000, 30.462040901200000, '2013-09-24 17:05:54'),
(71, 'porterpabporterpub-52419c43a6329', '4eb41fc0e30006eb118b83ce', 'Портер Паб / Porter Pub', 'https://irs1.4sqi.net/img/general/200x150/27477124_6-sGyYovfQy_I_jCWEsCv5ebtnF2skdyEJ4_-Y3cqXY.jpg', ' WiFi, Бронирование, Есть места на улице, Кредитные карты, Обед, Ужин', 1, 'Київ, вул. Луначарського, 10', 50.454129624500000, 30.597524642900000, '2013-09-24 17:05:55'),
(72, 'shtandart', '4f8c4457e4b07efba06e5917', 'Штандартъ', 'https://irs1.4sqi.net/img/general/200x150/44643743_R_Kdwe-v_YHmeRUr7STFu63gU6hbwdPsV4ijIZ3ptBo.jpg', ' WiFi, Есть места на улице, Ужин', 1, 'Київ, вул. Ревуцького, 2Г', 50.419620475900000, 30.640493014900000, '2013-09-24 17:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `point2theme`
--

DROP TABLE IF EXISTS `point2theme`;
CREATE TABLE IF NOT EXISTS `point2theme` (
  `p2t_key_p` int(11) NOT NULL,
  `p2t_key_t` int(11) NOT NULL,
  PRIMARY KEY (`p2t_key_p`,`p2t_key_t`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `point2theme`
--

INSERT INTO `point2theme` (`p2t_key_p`, `p2t_key_t`) VALUES
(0, 89),
(1, 89),
(2, 89),
(2, 90),
(3, 89),
(3, 91),
(31, 89),
(32, 88),
(33, 89),
(34, 89),
(35, 89),
(36, 89),
(37, 89),
(38, 89),
(39, 88),
(40, 89),
(41, 89),
(42, 89),
(43, 89),
(44, 89),
(45, 91),
(46, 89),
(47, 89),
(48, 89),
(49, 89),
(50, 89),
(51, 89),
(52, 88),
(53, 90),
(55, 89),
(56, 89),
(57, 89),
(58, 89),
(59, 89),
(60, 89),
(61, 89),
(62, 89),
(63, 89),
(64, 89),
(65, 89),
(66, 89),
(67, 89),
(67, 91),
(68, 89),
(69, 89),
(70, 89),
(71, 89),
(71, 90),
(72, 88),
(72, 89);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_pid` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_url` varchar(50) NOT NULL,
  `r_lat` decimal(20,15) NOT NULL,
  `r_lng` decimal(20,15) NOT NULL,
  PRIMARY KEY (`r_id`),
  KEY `r_pid` (`r_pid`),
  KEY `r_url` (`r_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`r_id`, `r_pid`, `r_name`, `r_url`, `r_lat`, `r_lng`) VALUES
(1, 0, 'Киев', 'kiev', 50.449949000000000, 30.524715000000000);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_key_p` int(11) NOT NULL,
  `r_key_u` int(11) NOT NULL,
  `r_date` datetime NOT NULL,
  `r_text` text NOT NULL,
  `r_likes` int(11) NOT NULL,
  `r_comms` int(11) NOT NULL,
  PRIMARY KEY (`r_id`),
  KEY `r_key_p` (`r_key_p`,`r_key_u`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `review`
--


-- --------------------------------------------------------

--
-- Table structure for table `search_words_index`
--

DROP TABLE IF EXISTS `search_words_index`;
CREATE TABLE IF NOT EXISTS `search_words_index` (
  `sw_word` varchar(255) NOT NULL,
  `sw_key_obj` int(11) NOT NULL,
  `sw_obj_type` char(3) NOT NULL DEFAULT 'pnt',
  PRIMARY KEY (`sw_word`,`sw_key_obj`,`sw_obj_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `search_words_index`
--

INSERT INTO `search_words_index` (`sw_word`, `sw_key_obj`, `sw_obj_type`) VALUES
('(напротив', 26, 'pnt'),
('/', 37, 'pnt'),
('4х4', 58, 'pnt'),
('66', 1, 'pnt'),
('Beer', 28, 'pnt'),
('Bochka', 10, 'pnt'),
('Copper', 62, 'pnt'),
('Copper', 66, 'pnt'),
('GastroRock', 13, 'pnt'),
('McDonald', 25, 'pnt'),
('McDonald', 32, 'pnt'),
('Podil', 28, 'pnt'),
('Porta', 67, 'pnt'),
('Porter', 63, 'pnt'),
('Porter', 65, 'pnt'),
('Porter', 68, 'pnt'),
('Porter', 69, 'pnt'),
('Porter', 71, 'pnt'),
('Pub', 62, 'pnt'),
('Pub', 63, 'pnt'),
('Pub', 65, 'pnt'),
('Pub', 66, 'pnt'),
('Pub', 67, 'pnt'),
('Pub', 68, 'pnt'),
('Pub', 69, 'pnt'),
('Pub', 71, 'pnt'),
('Route', 1, 'pnt'),
('Vikont', 24, 'pnt'),
('«Nirvana»', 0, 'pnt'),
('«Бункер»', 0, 'pnt'),
('«Витамин»', 38, 'pnt'),
('Адамс', 48, 'pnt'),
('арепас', 54, 'pnt'),
('Бандана', 53, 'pnt'),
('Бандана', 57, 'pnt'),
('Бар', 35, 'pnt'),
('Бар', 49, 'pnt'),
('Бар', 62, 'pnt'),
('Бар', 65, 'pnt'),
('Бар', 68, 'pnt'),
('Бар', 70, 'pnt'),
('Бар', 72, 'pnt'),
('Барракуда', 42, 'pnt'),
('Бильярдная', 58, 'pnt'),
('Блиндаж', 3, 'pnt'),
('Бочка', 10, 'pnt'),
('Бродяга', 46, 'pnt'),
('бургерами', 25, 'pnt'),
('Венесуэльские', 54, 'pnt'),
('Виконт', 22, 'pnt'),
('Восточно-европейский', 72, 'pnt'),
('Гагарин', 59, 'pnt'),
('Гастропаб', 0, 'pnt'),
('Гастропаб', 35, 'pnt'),
('Гастропаб', 36, 'pnt'),
('Гастропаб', 37, 'pnt'),
('Гастропаб', 46, 'pnt'),
('Гастропаб', 58, 'pnt'),
('Гастропаб', 59, 'pnt'),
('Гастропаб', 70, 'pnt'),
('Гиннесс', 43, 'pnt'),
('Годзилла', 49, 'pnt'),
('гостинице', 49, 'pnt'),
('Гриль-бар', 37, 'pnt'),
('Дороти', 37, 'pnt'),
('Закусочная', 25, 'pnt'),
('Кафе', 26, 'pnt'),
('Кафе', 53, 'pnt'),
('Кафе', 71, 'pnt'),
('Княжий', 50, 'pnt'),
('Колесо', 26, 'pnt'),
('Компас', 44, 'pnt'),
('Кондуктор', 35, 'pnt'),
('Кружки', 64, 'pnt'),
('Куппер', 62, 'pnt'),
('Куппер', 66, 'pnt'),
('Ларек', 28, 'pnt'),
('магазин', 28, 'pnt'),
('Михалыча', 70, 'pnt'),
('На', 27, 'pnt'),
('На', 29, 'pnt'),
('На', 30, 'pnt'),
('На', 31, 'pnt'),
('Паб', 0, 'pnt'),
('ПАБ', 2, 'pnt'),
('Паб', 22, 'pnt'),
('Паб', 24, 'pnt'),
('Паб', 33, 'pnt'),
('Паб', 34, 'pnt'),
('Паб', 35, 'pnt'),
('паб', 36, 'pnt'),
('Паб', 37, 'pnt'),
('Паб', 38, 'pnt'),
('паб', 39, 'pnt'),
('Паб', 40, 'pnt'),
('Паб', 41, 'pnt'),
('Паб', 42, 'pnt'),
('Паб', 43, 'pnt'),
('Паб', 44, 'pnt'),
('Паб', 45, 'pnt'),
('Паб', 46, 'pnt'),
('Паб', 47, 'pnt'),
('ПАБ', 48, 'pnt'),
('Паб', 49, 'pnt'),
('Паб', 50, 'pnt'),
('Паб', 51, 'pnt'),
('Паб', 52, 'pnt'),
('Паб', 53, 'pnt'),
('паб', 54, 'pnt'),
('Паб', 55, 'pnt'),
('Паб', 56, 'pnt'),
('Паб', 57, 'pnt'),
('Паб', 58, 'pnt'),
('Паб', 59, 'pnt'),
('Паб', 60, 'pnt'),
('Паб', 61, 'pnt'),
('Паб', 62, 'pnt'),
('Паб', 63, 'pnt'),
('Паб', 64, 'pnt'),
('Паб', 65, 'pnt'),
('Паб', 66, 'pnt'),
('Паб', 67, 'pnt'),
('Паб', 68, 'pnt'),
('Паб', 69, 'pnt'),
('Паб', 70, 'pnt'),
('Паб', 71, 'pnt'),
('Паб', 72, 'pnt'),
('Папа', 36, 'pnt'),
('Пивзавод', 27, 'pnt'),
('Пивзавод', 29, 'pnt'),
('Пивзавод', 30, 'pnt'),
('Пивзавод', 31, 'pnt'),
('пивная', 10, 'pnt'),
('Пиво', 28, 'pnt'),
('Пивоварня', 0, 'pnt'),
('Пивоварня', 27, 'pnt'),
('Пивоварня', 28, 'pnt'),
('Пивоварня', 29, 'pnt'),
('Пивоварня', 30, 'pnt'),
('Пивоварня', 31, 'pnt'),
('Пивоварня', 43, 'pnt'),
('Пивоварня', 68, 'pnt'),
('Пица', 45, 'pnt'),
('Пиццерия', 45, 'pnt'),
('Пиццерия', 67, 'pnt'),
('Подол', 28, 'pnt'),
('Подолi', 27, 'pnt'),
('Подолi', 29, 'pnt'),
('Подолi', 30, 'pnt'),
('Подолi', 31, 'pnt'),
('Порта', 67, 'pnt'),
('Портер', 2, 'pnt'),
('Портер', 39, 'pnt'),
('Портер', 60, 'pnt'),
('Портер', 63, 'pnt'),
('Портер', 65, 'pnt'),
('Портер', 68, 'pnt'),
('Портер', 69, 'pnt'),
('Портер', 71, 'pnt'),
('при', 49, 'pnt'),
('Продуктовый', 28, 'pnt'),
('Рапан', 54, 'pnt'),
('Ресторан', 22, 'pnt'),
('Ресторан', 23, 'pnt'),
('Ресторан', 24, 'pnt'),
('Ресторан', 25, 'pnt'),
('ресторан', 26, 'pnt'),
('Ресторан', 32, 'pnt'),
('Ресторан', 39, 'pnt'),
('Ресторан', 52, 'pnt'),
('ресторан', 72, 'pnt'),
('с', 25, 'pnt'),
('СТО)', 26, 'pnt'),
('Супный', 26, 'pnt'),
('Таверна', 34, 'pnt'),
('Тако-бар', 48, 'pnt'),
('Тако-бар', 55, 'pnt'),
('Трицаха', 47, 'pnt'),
('Тролейбус', 52, 'pnt'),
('У', 64, 'pnt'),
('У', 70, 'pnt'),
('фаст-фуд', 25, 'pnt'),
('фаст-фуд', 32, 'pnt'),
('Хаус', 51, 'pnt'),
('Чемпион', 41, 'pnt'),
('Шаурма', 55, 'pnt'),
('Шашлычная', 37, 'pnt'),
('Шенген', 61, 'pnt'),
('Шерлок', 56, 'pnt'),
('Штаб', 33, 'pnt'),
('Штандартъ', 72, 'pnt');

-- --------------------------------------------------------

--
-- Table structure for table `sys_meta`
--

DROP TABLE IF EXISTS `sys_meta`;
CREATE TABLE IF NOT EXISTS `sys_meta` (
  `mt_id` int(11) NOT NULL AUTO_INCREMENT,
  `mt_pg` varchar(255) NOT NULL DEFAULT '',
  `mt_typ` varchar(16) NOT NULL DEFAULT '',
  `mt_cnt` varchar(255) NOT NULL DEFAULT '',
  `mt_ovr` tinyint(4) NOT NULL DEFAULT '0',
  `mt_order` int(11) NOT NULL DEFAULT '100',
  `ln` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`mt_id`),
  KEY `pg_typ` (`mt_pg`,`mt_typ`),
  KEY `mt_order` (`mt_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sys_meta`
--

INSERT INTO `sys_meta` (`mt_id`, `mt_pg`, `mt_typ`, `mt_cnt`, `mt_ovr`, `mt_order`, `ln`) VALUES
(1, 'global', 'css', '/css/share.css', 0, 50, 'XX'),
(2, 'default', 'css', '/css/point_list.css', 0, 100, 'XX'),
(3, 'global', 'js', '/js/jquery.js', 0, 101, 'XX'),
(4, 'global', 'js', '/js/JsHttpRequest.js', 0, 100, 'XX'),
(5, 'global', 'js', '/js/share.js', 0, 110, 'XX'),
(6, 'default', 'js', '/js/masonry.pkgd.min.js', 0, 100, 'XX'),
(7, 'default', 'js', '/js/points.js', 0, 105, 'XX'),
(8, 'point/XX', 'css', '/css/point.css', 0, 100, 'XX'),
(10, 'not_auth', 'js', 'http://loginza.ru/js/widget.js', 0, 150, 'XX'),
(11, 'global', 'js', '/js/moment.js', 0, 105, 'XX'),
(13, 'search', 'js', '/js/masonry.pkgd.min.js', 0, 100, 'XX'),
(14, 'search', 'css', '/css/point_list.css', 0, 100, 'XX'),
(15, 'search', 'js', '/js/points.js', 0, 105, 'XX'),
(16, 'global', 'js', '/js/livesearch.js', 0, 107, 'XX');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_url` varchar(50) NOT NULL,
  `t_name` varchar(255) NOT NULL,
  `t_img` varchar(255) NOT NULL,
  PRIMARY KEY (`t_id`),
  UNIQUE KEY `t_url` (`t_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`t_id`, `t_url`, `t_name`, `t_img`) VALUES
(88, 'restaurants', 'Рестораны', '/img/cat/restaurant.png'),
(89, 'pubs', 'Бары/Пабы', '/img/cat/pub.png'),
(90, 'kaffe', 'Кафе/чайные', '/img/cat/cafe.png'),
(91, 'fastfood', 'Фастфуд/закусочные', '/img/cat/fastfood.png');

-- --------------------------------------------------------

--
-- Table structure for table `theme2fs_cat`
--

DROP TABLE IF EXISTS `theme2fs_cat`;
CREATE TABLE IF NOT EXISTS `theme2fs_cat` (
  `t2c_key_t` int(11) NOT NULL,
  `t2c_key_c` varchar(25) NOT NULL,
  PRIMARY KEY (`t2c_key_t`,`t2c_key_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme2fs_cat`
--

INSERT INTO `theme2fs_cat` (`t2c_key_t`, `t2c_key_c`) VALUES
(88, '4bf58dd8d48988d107941735'),
(88, '4bf58dd8d48988d109941735'),
(88, '4bf58dd8d48988d10a941735'),
(88, '4bf58dd8d48988d10b941735'),
(88, '4bf58dd8d48988d10c941735'),
(88, '4bf58dd8d48988d10d941735'),
(88, '4bf58dd8d48988d10e941735'),
(88, '4bf58dd8d48988d10f941735'),
(88, '4bf58dd8d48988d110941735'),
(88, '4bf58dd8d48988d111941735'),
(88, '4bf58dd8d48988d113941735'),
(88, '4bf58dd8d48988d115941735'),
(88, '4bf58dd8d48988d142941735'),
(88, '4bf58dd8d48988d144941735'),
(88, '4bf58dd8d48988d145941735'),
(88, '4bf58dd8d48988d149941735'),
(88, '4bf58dd8d48988d14a941735'),
(88, '4bf58dd8d48988d14e941735'),
(88, '4bf58dd8d48988d14f941735'),
(88, '4bf58dd8d48988d150941735'),
(88, '4bf58dd8d48988d154941735'),
(88, '4bf58dd8d48988d156941735'),
(88, '4bf58dd8d48988d157941735'),
(88, '4bf58dd8d48988d158941735'),
(88, '4bf58dd8d48988d169941735'),
(88, '4bf58dd8d48988d16b941735'),
(88, '4bf58dd8d48988d16e941735'),
(88, '4bf58dd8d48988d17a941735'),
(88, '4bf58dd8d48988d1be941735'),
(88, '4bf58dd8d48988d1bf941735'),
(88, '4bf58dd8d48988d1c0941735'),
(88, '4bf58dd8d48988d1c1941735'),
(88, '4bf58dd8d48988d1c2941735'),
(88, '4bf58dd8d48988d1c3941735'),
(88, '4bf58dd8d48988d1c4941735'),
(88, '4bf58dd8d48988d1c6941735'),
(88, '4bf58dd8d48988d1c8941735'),
(88, '4bf58dd8d48988d1cd941735'),
(88, '4bf58dd8d48988d1ce941735'),
(88, '4bf58dd8d48988d1d3941735'),
(88, '4bf58dd8d48988d1db931735'),
(88, '4bf58dd8d48988d1dd931735'),
(88, '4bf58dd8d48988d1f5931735'),
(88, '4c2cd86ed066bed06c3c5209'),
(88, '4deefc054765f83613cdba6f'),
(88, '4def73e84765ae376e57713a'),
(88, '4eb1bd1c3b7b55596b4a748f'),
(88, '4eb1bfa43b7b52c0e1adc2e8'),
(88, '4eb1d5724b900d56c88a45fe'),
(88, '4f04af1f2fb6e1c99f3db0bb'),
(88, '503288ae91d4c4b30a586d67'),
(89, '4bf58dd8d48988d112941735'),
(89, '4bf58dd8d48988d116941735'),
(89, '4bf58dd8d48988d119941735'),
(89, '4bf58dd8d48988d11b941735'),
(89, '4bf58dd8d48988d11c941735'),
(89, '4bf58dd8d48988d11d941735'),
(89, '4bf58dd8d48988d11e941735'),
(89, '4bf58dd8d48988d120941735'),
(89, '4bf58dd8d48988d121941735'),
(89, '4bf58dd8d48988d122941735'),
(89, '4bf58dd8d48988d123941735'),
(89, '4bf58dd8d48988d151941735'),
(89, '4bf58dd8d48988d155941735'),
(89, '4bf58dd8d48988d1bd941735'),
(89, '4bf58dd8d48988d1c5941735'),
(89, '4bf58dd8d48988d1d2941735'),
(89, '4bf58dd8d48988d1d4941735'),
(89, '4bf58dd8d48988d1d5941735'),
(89, '4bf58dd8d48988d1d8941735'),
(89, '4bf58dd8d48988d1df931735'),
(89, '50327c8591d4c4b30a586d5d'),
(90, '4bf58dd8d48988d128941735'),
(90, '4bf58dd8d48988d143941735'),
(90, '4bf58dd8d48988d16d941735'),
(90, '4bf58dd8d48988d179941735'),
(90, '4bf58dd8d48988d1bc941735'),
(90, '4bf58dd8d48988d1c9941735'),
(90, '4bf58dd8d48988d1d0941735'),
(90, '4bf58dd8d48988d1dc931735'),
(91, '4bf58dd8d48988d147941735'),
(91, '4bf58dd8d48988d153941735'),
(91, '4bf58dd8d48988d16c941735'),
(91, '4bf58dd8d48988d16f941735'),
(91, '4bf58dd8d48988d1c7941735'),
(91, '4bf58dd8d48988d1ca941735'),
(91, '4bf58dd8d48988d1cb941735');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_grp` char(3) NOT NULL DEFAULT 'usr',
  `u_url` varchar(50) NOT NULL,
  `u_email` varchar(255) NOT NULL DEFAULT '',
  `u_pwd` varchar(20) NOT NULL DEFAULT '',
  `u_name` varchar(255) NOT NULL DEFAULT '',
  `u_img` varchar(255) NOT NULL,
  `u_gender` char(3) NOT NULL DEFAULT 'hmm',
  `u_createdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `u_lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `u_lock` varchar(12) NOT NULL DEFAULT '',
  `u_openid` varchar(255) NOT NULL,
  `u_openidprov` varchar(255) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_email` (`u_email`),
  UNIQUE KEY `u_url` (`u_url`),
  KEY `u_pwd` (`u_pwd`,`u_lock`),
  KEY `u_grp` (`u_grp`),
  KEY `u_openid` (`u_openid`),
  KEY `u_openidprov` (`u_openidprov`),
  KEY `u_gender` (`u_gender`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `u_grp`, `u_url`, `u_email`, `u_pwd`, `u_name`, `u_img`, `u_gender`, `u_createdate`, `u_lastlogin`, `u_lock`, `u_openid`, `u_openidprov`) VALUES
(1, 'usr', 'Ivan_52399351da3d9', 'kronius@yandex.ru', '', 'Иван', 'https://graph.facebook.com/100001022971933/picture', 'hmm', '2013-09-18 14:49:37', '2013-09-18 14:49:37', '0', 'https://www.facebook.com/iboroday', 'http://www.facebook.com/'),
(4, 'usr', 'Ivan_523adb8269432', 'johncomua@gmail.com', '', 'Иван', '/img/def_usr.jpg', 'hmm', '2012-01-19 14:09:54', '2013-09-19 14:09:54', '0', 'https://www.google.com/accounts/o8/id?id=AItOawnwTdVQJvgFD10ZcmD5jzsVQOMLOrFY178', 'https://www.google.com/accounts/o8/ud'),
(5, 'usr', '_524074a050f07', '', '', '', '/img/def_usr.jpg', 'hmm', '2013-09-23 20:04:32', '2013-09-23 20:04:32', '0', 'http://kronius.ya.ru/', 'http://openid.yandex.ru/server/'),
(2, 'usr', 'iBor', 'kronius@ya.ru', 'kronius', 'Иван', '/img/def_usr.jpg', 'hmm', '2012-01-19 14:09:54', '2013-09-19 14:09:54', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user2theme`
--

DROP TABLE IF EXISTS `user2theme`;
CREATE TABLE IF NOT EXISTS `user2theme` (
  `u2t_key_u` int(11) NOT NULL,
  `u2t_key_t` int(11) NOT NULL,
  PRIMARY KEY (`u2t_key_u`,`u2t_key_t`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user2theme`
--

INSERT INTO `user2theme` (`u2t_key_u`, `u2t_key_t`) VALUES
(0, 88),
(0, 89),
(0, 90),
(0, 91);

-- --------------------------------------------------------

--
-- Table structure for table `z_fs_queries`
--

DROP TABLE IF EXISTS `z_fs_queries`;
CREATE TABLE IF NOT EXISTS `z_fs_queries` (
  `fq_id` varchar(32) NOT NULL,
  `fq_content` text NOT NULL,
  `fq_create` int(11) NOT NULL,
  `fq_dead` int(11) NOT NULL,
  PRIMARY KEY (`fq_id`),
  KEY `fq_create` (`fq_create`,`fq_dead`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `z_fs_queries`
--

