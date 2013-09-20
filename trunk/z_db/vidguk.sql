-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2013 at 09:36 PM
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
  UNIQUE KEY `com_type` (`com_type`,`com_key_obj`),
  KEY `com_key_u` (`com_key_u`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_type`, `com_key_obj`, `com_key_u`, `com_date`, `com_text`, `com_short`, `com_cachelikes`, `com_cahecomms`) VALUES
(1, 'pnt', 1, 1, '2013-09-16 17:14:31', 'Отличное место! Отдых душой и телом + вкусная еда + живая музыка + свое, вкусное пиво!! Налетай! :)', 'Отличное место! Отдых душой и телом + вкусная еда + живая музыка + свое, вкусное пиво!! Налетай! :)', 0, 0),
(2, 'pnt', 2, 1, '2013-08-01 18:38:03', 'КРУТО! Очень понравилось, особенно в субботу вечером! :)', 'КРУТО! Очень понравилось, особенно в субботу вечером! :)', 0, 0),
(3, 'pnt', 3, 1, '2013-09-16 18:38:03', 'Стало хуже намного..', 'Стало хуже намного..', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `l_weight` tinyint(1) NOT NULL,
  `l_type` char(3) NOT NULL DEFAULT 'pnt',
  `l_key_obj` int(11) NOT NULL,
  `l_key_u` int(11) NOT NULL,
  `l_date` datetime NOT NULL,
  PRIMARY KEY (`l_id`),
  UNIQUE KEY `l_type` (`l_type`,`l_key_obj`,`l_key_u`),
  KEY `l_weight` (`l_weight`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`l_id`, `l_weight`, `l_type`, `l_key_obj`, `l_key_u`, `l_date`) VALUES
(1, -1, 'pnt', 1, 1, '2013-09-10 16:34:34');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

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
(24, 'pabvikont-523c91d327007', '515d8af7e4b099e8a8300435', 'Паб "Vikont"', 'https://irs3.4sqi.net/img/general/200x150/26781025_Bm6WWbPtD9j_4kIs_eoti9EEnNcsas3nl1RMFVdL3BU.jpg', ' Обед, Ужин', 1, ', ', 50.479683776900000, 30.604794425400000, '2013-09-20 21:20:03');

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
(1, 89),
(2, 89),
(2, 90),
(3, 89),
(3, 91);

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
('66', 1, 'pnt'),
('Bochka', 10, 'pnt'),
('GastroRock', 13, 'pnt'),
('Route', 1, 'pnt'),
('Vikont', 24, 'pnt'),
('Блиндаж', 3, 'pnt'),
('Бочка', 10, 'pnt'),
('Виконт', 22, 'pnt'),
('ПАБ', 2, 'pnt'),
('Паб', 22, 'pnt'),
('Паб', 24, 'pnt'),
('пивная', 10, 'pnt'),
('Портер', 2, 'pnt'),
('Ресторан', 22, 'pnt'),
('Ресторан', 23, 'pnt'),
('Ресторан', 24, 'pnt');

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=16 ;

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
(15, 'search', 'js', '/js/points.js', 0, 105, 'XX');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_pid` int(11) NOT NULL,
  `t_url` varchar(50) NOT NULL,
  `t_name` varchar(255) NOT NULL,
  `t_fs_id` varchar(25) NOT NULL,
  `t_img` varchar(255) NOT NULL,
  PRIMARY KEY (`t_id`),
  UNIQUE KEY `t_url` (`t_url`),
  KEY `t_fs_id` (`t_fs_id`),
  KEY `t_pid` (`t_pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`t_id`, `t_pid`, `t_url`, `t_name`, `t_fs_id`, `t_img`) VALUES
(1, 88, 'afganskiirestoran', 'Афганский ресторан', '503288ae91d4c4b30a586d67', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(2, 88, 'afrikanskiirestoran', 'Африканский ресторан', '4bf58dd8d48988d1c8941735', 'https://foursquare.com/img/categories_v2/food/african_88.png'),
(3, 88, 'amerikanskiirestoran', 'Американский ресторан', '4bf58dd8d48988d14e941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(4, 0, 'venesyelskiearepas', 'Венесуэльские арепас', '4bf58dd8d48988d152941735', 'https://foursquare.com/img/categories_v2/food/arepas_88.png'),
(5, 88, 'argentinskiirestoran', 'Аргентинский ресторан', '4bf58dd8d48988d107941735', 'https://foursquare.com/img/categories_v2/food/argentinian_88.png'),
(6, 88, 'aziatskiirestoran', 'Азиатский ресторан', '4bf58dd8d48988d142941735', 'https://foursquare.com/img/categories_v2/food/asian_88.png'),
(7, 88, 'avstraliiskiirestoran', 'Австралийский ресторан', '4bf58dd8d48988d169941735', 'https://foursquare.com/img/categories_v2/food/australian_88.png'),
(8, 89, 'gril-bar-shashlychnaia', 'Гриль-бар / Шашлычная', '4bf58dd8d48988d1df931735', 'https://foursquare.com/img/categories_v2/food/bbq_88.png'),
(9, 90, 'kafesbeiglami', 'Кафе с бейглами', '4bf58dd8d48988d179941735', 'https://foursquare.com/img/categories_v2/food/bagels_88.png'),
(10, 91, 'bylochnaia', 'Булочная', '4bf58dd8d48988d16a941735', 'https://foursquare.com/img/categories_v2/food/bakery_88.png'),
(11, 88, 'brazilskiirestoran', 'Бразильский ресторан', '4bf58dd8d48988d16b941735', 'https://foursquare.com/img/categories_v2/food/brazilian_88.png'),
(12, 90, 'kafedliazavtraka', 'Кафе для завтрака', '4bf58dd8d48988d143941735', 'https://foursquare.com/img/categories_v2/food/breakfast_88.png'),
(13, 91, 'zakysochnaiasbyrgerami', 'Закусочная с бургерами', '4bf58dd8d48988d16c941735', 'https://foursquare.com/img/categories_v2/food/burger_88.png'),
(14, 91, 'zakysochnaiasbyrrito', 'Закусочная с буррито', '4bf58dd8d48988d153941735', 'https://foursquare.com/img/categories_v2/food/burrito_88.png'),
(15, 91, 'byfet', 'Буфет', '4bf58dd8d48988d128941735', 'https://foursquare.com/img/categories_v2/food/cafeteria_88.png'),
(16, 90, 'kafe', 'Кафе', '4bf58dd8d48988d16d941735', 'https://foursquare.com/img/categories_v2/food/cafe_88.png'),
(17, 88, 'kadjynskii-kreolskiirestoran', 'Каджунский / Креольский ресторан', '4bf58dd8d48988d17a941735', 'https://foursquare.com/img/categories_v2/food/cajun_88.png'),
(18, 88, 'karibskiirestoran', 'Карибский ресторан', '4bf58dd8d48988d144941735', 'https://foursquare.com/img/categories_v2/food/caribbean_88.png'),
(19, 88, 'kitaiskiirestoran', 'Китайский ресторан', '4bf58dd8d48988d145941735', 'https://foursquare.com/img/categories_v2/food/chinese_88.png'),
(20, 90, 'kofeinia', 'Кофейня', '4bf58dd8d48988d1e0931735', 'https://foursquare.com/img/categories_v2/food/coffeeshop_88.png'),
(21, 88, 'kybinskiirestoran', 'Кубинский ресторан', '4bf58dd8d48988d154941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(22, 90, 'kafe-konditerskaia', 'Кафе-кондитерская', '4bf58dd8d48988d1bc941735', 'https://foursquare.com/img/categories_v2/food/cupcakes_88.png'),
(23, 91, 'bistro', 'Бистро', '4bf58dd8d48988d146941735', 'https://foursquare.com/img/categories_v2/food/deli_88.png'),
(24, 90, 'desertnoekafe', 'Десертное кафе', '4bf58dd8d48988d1d0941735', 'https://foursquare.com/img/categories_v2/food/dessert_88.png'),
(25, 88, 'restorandimsam', 'Ресторан димсам', '4bf58dd8d48988d1f5931735', 'https://foursquare.com/img/categories_v2/food/dimsum_88.png'),
(26, 0, 'stolovaia', 'Столовая', '4bf58dd8d48988d147941735', 'https://foursquare.com/img/categories_v2/food/diner_88.png'),
(27, 0, 'viskarnia', 'Вискарня', '4e0e22f5a56208c4ea9a85a0', 'https://foursquare.com/img/categories_v2/food/brewery_88.png'),
(28, 0, 'ponchikovaia', 'Пончиковая', '4bf58dd8d48988d148941735', 'https://foursquare.com/img/categories_v2/food/donuts_88.png'),
(29, 0, 'pelmennaia-varenichnaia', 'Пельменная / Вареничная', '4bf58dd8d48988d108941735', 'https://foursquare.com/img/categories_v2/food/dumplings_88.png'),
(30, 88, 'vostochno-evropeiskiirestoran', 'Восточно-европейский ресторан', '4bf58dd8d48988d109941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(31, 88, 'efiopskiirestoran', 'Эфиопский ресторан', '4bf58dd8d48988d10a941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(32, 88, 'falafel-restoran', 'Фалафель-ресторан', '4bf58dd8d48988d10b941735', 'https://foursquare.com/img/categories_v2/food/falafel_88.png'),
(33, 88, 'restoranfast-fyd', 'Ресторан фаст-фуд', '4bf58dd8d48988d16e941735', 'https://foursquare.com/img/categories_v2/food/fastfood_88.png'),
(34, 88, 'filippinskiirestoran', 'Филиппинский ресторан', '4eb1bd1c3b7b55596b4a748f', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(35, 91, 'fishendchips', 'Фиш энд чипс', '4edd64a0c7ddd24ca188df1a', 'https://foursquare.com/img/categories_v2/food/fishandchips_88.png'),
(36, 91, 'zakysochnaianakolesah', 'Закусочная на колесах', '4bf58dd8d48988d1cb941735', 'https://foursquare.com/img/categories_v2/food/streetfood_88.png'),
(37, 88, 'francyzskiirestoran', 'Французский ресторан', '4bf58dd8d48988d10c941735', 'https://foursquare.com/img/categories_v2/food/french_88.png'),
(38, 0, 'jarenyecypliata', 'Жареные цыплята', '4d4ae6fc7a7b7dea34424761', 'https://foursquare.com/img/categories_v2/food/friedchicken_88.png'),
(39, 0, 'gastropab', 'Гастропаб', '4bf58dd8d48988d155941735', 'https://foursquare.com/img/categories_v2/food/gastropub_88.png'),
(40, 88, 'nemeckiirestoran', 'Немецкий ресторан', '4bf58dd8d48988d10d941735', 'https://foursquare.com/img/categories_v2/food/german_88.png'),
(41, 88, 'restoranbezglutenovoikyhni', 'Ресторан безглютеновой кухни', '4c2cd86ed066bed06c3c5209', 'https://foursquare.com/img/categories_v2/food/glutenfree_88.png'),
(42, 88, 'grecheskiirestoran', 'Греческий ресторан', '4bf58dd8d48988d10e941735', 'https://foursquare.com/img/categories_v2/food/greek_88.png'),
(43, 91, 'zakysochnaiashot-dogami', 'Закусочная с хот-догами', '4bf58dd8d48988d16f941735', 'https://foursquare.com/img/categories_v2/food/hotdog_88.png'),
(44, 90, 'kafe-morojenoe', 'Кафе-мороженое', '4bf58dd8d48988d1c9941735', 'https://foursquare.com/img/categories_v2/food/icecream_88.png'),
(45, 88, 'indiiskiirestoran', 'Индийский ресторан', '4bf58dd8d48988d10f941735', 'https://foursquare.com/img/categories_v2/food/indian_88.png'),
(46, 88, 'indoneziiskiirestoran', 'Индонезийский ресторан', '4deefc054765f83613cdba6f', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(47, 88, 'italianskiirestoran', 'Итальянский ресторан', '4bf58dd8d48988d110941735', 'https://foursquare.com/img/categories_v2/food/italian_88.png'),
(48, 88, 'iaponskiirestoran', 'Японский ресторан', '4bf58dd8d48988d111941735', 'https://foursquare.com/img/categories_v2/food/japanese_88.png'),
(49, 89, 'sok-bar', 'Сок-бар', '4bf58dd8d48988d112941735', 'https://foursquare.com/img/categories_v2/food/juicebar_88.png'),
(50, 88, 'koreiskiirestoran', 'Корейский ресторан', '4bf58dd8d48988d113941735', 'https://foursquare.com/img/categories_v2/food/korean_88.png'),
(51, 88, 'latinoamerikanskiirestoran', 'Латиноамериканский ресторан', '4bf58dd8d48988d1be941735', 'https://foursquare.com/img/categories_v2/food/latinamerican_88.png'),
(52, 88, 'makaronnyirestoran', 'Макаронный ресторан', '4bf58dd8d48988d1bf941735', 'https://foursquare.com/img/categories_v2/food/macandcheese_88.png'),
(53, 88, 'malaiziiskiirestoran', 'Малайзийский ресторан', '4bf58dd8d48988d156941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(54, 88, 'restoransredizemnomorskoikyhni', 'Ресторан средиземноморской кухни', '4bf58dd8d48988d1c0941735', 'https://foursquare.com/img/categories_v2/food/mediterranean_88.png'),
(55, 88, 'meksikanskiirestoran', 'Мексиканский ресторан', '4bf58dd8d48988d1c1941735', 'https://foursquare.com/img/categories_v2/food/mexican_88.png'),
(56, 88, 'restoranblijnevostochnoikyhni', 'Ресторан ближневосточной кухни', '4bf58dd8d48988d115941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(57, 88, 'restoranmolekyliarnoikyhni', 'Ресторан молекулярной кухни', '4bf58dd8d48988d1c2941735', 'https://foursquare.com/img/categories_v2/food/moleculargastronomy_88.png'),
(58, 88, 'mongolskiirestoran', 'Монгольский ресторан', '4eb1d5724b900d56c88a45fe', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(59, 88, 'marokkanskiirestoran', 'Марокканский ресторан', '4bf58dd8d48988d1c3941735', 'https://foursquare.com/img/categories_v2/food/moroccan_88.png'),
(60, 88, 'restoransovremennoiamerikanskoikyhni', 'Ресторан современной американской кухни', '4bf58dd8d48988d157941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(61, 88, 'peryanskiirestoran', 'Перуанский ресторан', '4eb1bfa43b7b52c0e1adc2e8', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(62, 0, 'picceriia', 'Пиццерия', '4bf58dd8d48988d1ca941735', 'https://foursquare.com/img/categories_v2/food/pizza_88.png'),
(63, 88, 'portygalskiirestoran', 'Португальский ресторан', '4def73e84765ae376e57713a', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(64, 0, 'lapshichnaia', 'Лапшичная', '4bf58dd8d48988d1d1941735', 'https://foursquare.com/img/categories_v2/food/ramen_88.png'),
(65, 88, 'restoran', 'Ресторан', '4bf58dd8d48988d1c4941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(66, 89, 'salat-bar', 'Салат-бар', '4bf58dd8d48988d1bd941735', 'https://foursquare.com/img/categories_v2/food/salad_88.png'),
(67, 89, 'sendvich-bar', 'Сэндвич-бар', '4bf58dd8d48988d1c5941735', 'https://foursquare.com/img/categories_v2/food/sandwiches_88.png'),
(68, 88, 'skandinavskiirestoran', 'Скандинавский ресторан', '4bf58dd8d48988d1c6941735', 'https://foursquare.com/img/categories_v2/food/scandinavian_88.png'),
(69, 88, 'restoranmoreprodyktov', 'Ресторан морепродуктов', '4bf58dd8d48988d1ce941735', 'https://foursquare.com/img/categories_v2/food/seafood_88.png'),
(70, 91, 'zakysochnaia', 'Закусочная', '4bf58dd8d48988d1c7941735', 'https://foursquare.com/img/categories_v2/food/snacks_88.png'),
(71, 88, 'sypnyirestoran', 'Супный ресторан', '4bf58dd8d48988d1dd931735', 'https://foursquare.com/img/categories_v2/food/soup_88.png'),
(72, 88, 'ujnoamerikanskiirestoran', 'Южноамериканский ресторан', '4bf58dd8d48988d1cd941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(73, 88, 'afrikano-amerikanskiirestoran', 'Африкано-американский ресторан', '4bf58dd8d48988d14f941735', 'https://foursquare.com/img/categories_v2/food/southern_88.png'),
(74, 88, 'ispanskiirestoran', 'Испанский ресторан', '4bf58dd8d48988d150941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(75, 0, 'steik-hays', 'Стейк-хаус', '4bf58dd8d48988d1cc941735', 'https://foursquare.com/img/categories_v2/food/steakhouse_88.png'),
(76, 89, 'syshi-bar', 'Суши-бар', '4bf58dd8d48988d1d2941735', 'https://foursquare.com/img/categories_v2/food/sushi_88.png'),
(77, 88, 'shveicarskiirestoran', 'Швейцарский ресторан', '4bf58dd8d48988d158941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(78, 89, 'tako-bar', 'Тако-бар', '4bf58dd8d48988d151941735', 'https://foursquare.com/img/categories_v2/food/taco_88.png'),
(79, 88, 'restorantapas', 'Ресторан тапас', '4bf58dd8d48988d1db931735', 'https://foursquare.com/img/categories_v2/food/tapas_88.png'),
(80, 90, 'chainaia', 'Чайная', '4bf58dd8d48988d1dc931735', 'https://foursquare.com/img/categories_v2/food/tearoom_88.png'),
(81, 88, 'taiskiirestoran', 'Тайский ресторан', '4bf58dd8d48988d149941735', 'https://foursquare.com/img/categories_v2/food/thai_88.png'),
(82, 88, 'tyreckiirestoran', 'Турецкий ресторан', '4f04af1f2fb6e1c99f3db0bb', 'https://foursquare.com/img/categories_v2/food/turkish_88.png'),
(83, 88, 'vegetarianskii-veganskiirestoran', 'Вегетарианский / Веганский ресторан', '4bf58dd8d48988d1d3941735', 'https://foursquare.com/img/categories_v2/food/vegetarian_88.png'),
(84, 88, 'vetnamskiirestoran', 'Вьетнамский ресторан', '4bf58dd8d48988d14a941735', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(85, 0, 'vinodelnia', 'Винодельня', '4bf58dd8d48988d14b941735', 'https://foursquare.com/img/categories_v2/food/winery_88.png'),
(86, 91, 'kyrinyekrylyshki', 'Куриные крылышки', '4bf58dd8d48988d14c941735', 'https://foursquare.com/img/categories_v2/food/wings_88.png'),
(87, 0, 'zamorojennyiiogyrt', 'Замороженный йогурт', '512e7cae91d4cbb4e5efe0af', 'https://foursquare.com/img/categories_v2/food/default_88.png'),
(88, 0, 'restaurants', 'Рестораны', '', '/img/cat/restaurant.png'),
(89, 0, 'pubs', 'Бары/Пабы', '', '/img/cat/pub.png'),
(90, 0, 'kaffe', 'Кафе/чайные', '', '/img/cat/cafe.png'),
(91, 0, 'fastfood', 'Фастфуд/закусочные', '', '/img/cat/fastfood.png');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `u_grp`, `u_url`, `u_email`, `u_pwd`, `u_name`, `u_img`, `u_gender`, `u_createdate`, `u_lastlogin`, `u_lock`, `u_openid`, `u_openidprov`) VALUES
(1, 'usr', 'Ivan_52399351da3d9', 'kronius@yandex.ru', '', 'Иван', 'https://graph.facebook.com/100001022971933/picture', 'hmm', '2013-09-18 14:49:37', '2013-09-18 14:49:37', '0', 'https://www.facebook.com/iboroday', 'http://www.facebook.com/'),
(4, 'usr', 'Ivan_523adb8269432', 'johncomua@gmail.com', '', 'Иван', '/img/def_usr.jpg', 'hmm', '2012-01-19 14:09:54', '2013-09-19 14:09:54', '0', 'https://www.google.com/accounts/o8/id?id=AItOawnwTdVQJvgFD10ZcmD5jzsVQOMLOrFY178', 'https://www.google.com/accounts/o8/ud');

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
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(2, 88),
(2, 89),
(3, 88),
(3, 89),
(4, 88),
(4, 89),
(4, 90),
(5, 88),
(5, 89);

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

