-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 16, 2014 at 06:29 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pizza_inn`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE IF NOT EXISTS `billing_details` (
  `billing_id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `Street_Address` varchar(100) NOT NULL,
  `P_O_Box_No` varchar(15) NOT NULL,
  `City` text NOT NULL,
  `Mobile_No` varchar(15) NOT NULL,
  `Landline_No` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`billing_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `billing_details`
--

INSERT INTO `billing_details` (`billing_id`, `member_id`, `Street_Address`, `P_O_Box_No`, `City`, `Mobile_No`, `Landline_No`) VALUES
(1, 2, 'Langata,OtiendeEstateBlock25', '4200', 'Nairobi', '0717983432', '0228932435'),
(2, 3, 'WestLands,UnknownEstateBlock3', '4289-00100', 'Nairobi', '0717983432', '0228932435'),
(3, 8, 'Buruburu,UN road,Block23', '9323-00100', 'Nairobi', '0725893892', '022893489'),
(4, 5, 'Kileleshwa,GreenCourt,BlockC', '23543-00200', 'Nairobi', '0756644365', '022898989'),
(5, 4, 'SouthB,CornerHostels', '32545-00100', 'Nairobi', '0759324354', '022567385'),
(6, 11, 'SouthC,SameerB.Park', '7843-00100', 'Nairobi', '0725938432', ''),
(7, 12, 'FoodPlaza,Root', '1111-00200', 'Nairobi', '0700888999', '0220888999'),
(8, 15, 'Rossford Gardens,\r\nOld Traford', 'R14 8E9', 'Manchester', '+448948934855', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE IF NOT EXISTS `cart_details` (
  `cart_id` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `food_id` int(15) NOT NULL,
  `quantity_id` int(15) NOT NULL,
  `total` float NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`cart_id`, `member_id`, `food_id`, `quantity_id`, `total`, `flag`) VALUES
(5, 12, 19, 2, 699.99, 0),
(6, 11, 20, 2, 659.99, 1),
(7, 11, 22, 2, 599.99, 0),
(8, 11, 21, 6, 3649.95, 1),
(9, 5, 22, 2, 599.99, 0),
(10, 5, 17, 5, 2199.96, 0),
(11, 5, 19, 4, 2099.97, 0),
(12, 12, 18, 5, 1999.96, 0),
(13, 12, 21, 3, 1459.98, 1),
(14, 12, 23, 3, 1700, 1),
(15, 12, 26, 11, 1999.5, 0),
(16, 15, 23, 8, 5950, 1),
(17, 15, 22, 10, 5399.91, 1),
(18, 15, 23, 5, 3400, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(15) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Pizza'),
(2, 'Burger'),
(3, 'Fries'),
(4, 'Chicken'),
(5, 'Meat'),
(6, 'Fish'),
(7, 'Rice'),
(8, 'Veggies'),
(9, 'Fruits'),
(10, 'Breakfast'),
(11, 'Lunch'),
(12, 'Supper'),
(13, 'Disert'),
(14, 'Specials');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `content_id` int(1) NOT NULL DEFAULT '1',
  `display_name` varchar(55) NOT NULL DEFAULT 'undefined',
  `home_title` varchar(100) NOT NULL DEFAULT 'undefined',
  `home_subtitle` varchar(1000) NOT NULL DEFAULT 'undefined',
  `about_description` varchar(2500) NOT NULL DEFAULT 'undefined',
  `about_mission` varchar(2500) NOT NULL DEFAULT 'undefined',
  `about_vision` varchar(2500) NOT NULL DEFAULT 'undefined',
  `contacts` varchar(250) NOT NULL DEFAULT 'undefined',
  `contact_location` varchar(45) NOT NULL DEFAULT 'undefined',
  `specials_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `myaccount_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `myprofile_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `inbox_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `tables_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `partyhalls_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `rating_description` varchar(1000) NOT NULL DEFAULT 'undefined',
  `others_address` varchar(1000) NOT NULL DEFAULT 'undefined',
  `others_loggedout` varchar(1000) NOT NULL DEFAULT 'undefined',
  `others_accessdenied` varchar(1000) NOT NULL DEFAULT 'undefined',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`content_id`, `display_name`, `home_title`, `home_subtitle`, `about_description`, `about_mission`, `about_vision`, `contacts`, `contact_location`, `specials_description`, `myaccount_description`, `myprofile_description`, `inbox_description`, `tables_description`, `partyhalls_description`, `rating_description`, `others_address`, `others_loggedout`, `others_accessdenied`) VALUES
(1, 'Original Restaurant', 'Welcome to Food Plaza Restaurant Online Ordering System!', 'Order your food today from the Food Zone and it will be delivered at your door step. Jump in to our weekly special deals in the Special Deals menu. Register an account with us to enjoy fast ordering, delivery, and convenient payment of your food. Start now by logging in below or registering if you don''t have an account with us:', '<p>Food Plaza is a multinational restaurant food chain and delivery service with an aim of providing nutritious food to all our current and esteemed customers in Kenya and the world. This is achieved through quality services that surpases customers'' satisfaction.\r\n\r\n<p>Along with our business philosophy, we aim to be a convenient way of delivering food right at your door step with no extra shipping cost incurred. Yes we are here to serve you and to meet your stomach needs.', '<p>To provide affordable, quality, and nutritious food to all our customers and esteemed customers.', '<p>To become the world''s most respected brand in delivering quality food to all our customers and esteeemed customers.', 'Food Plaza Restaurant<br>\r\nP.O. Box: 45640-00100<br>\r\nMombasa Road<br>\r\nNairobi<br>\r\nKenya<br>\r\nLandline: +2540204534/5<br><br>', 'pizza-inn-map4-mombasa-road.png', '<p>Check out our special deals below. These are for a limited time only. Make your decision now.', '<p>Here you can view order history and delete old orders from your account. Invoices can be viewed from the order history. You can also make table reservations in your account. For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>Here you can change your password and also add a billing or delivery address. The delivery address will be used to bill your food orders as well as providing us with details on where to deliver your food. For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>Here you can ... For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>Here you can ... For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>Here you can ... For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>Here you can ... For more information <a href="contactus.php">Click Here</a> to contact us.', '<p>We have found out that you don''t have a billing address in your account. Please add a billing address in the form below. It is the same address that will be used to deliver your food orders. Please note that ONLY correct street/physical addresses should be used in order to ensure smooth delivery of your food orders. For more information <a href="contactus.php">Click Here</a> to contact us.', '<p><a href="login-register.php">Click Here</a> to Login again', '<p>You don''t have access to this page. <a href="login-register.php">Click Here</a> to login first or register for free. The registration won''t take long:-)');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `currency_id` int(5) NOT NULL AUTO_INCREMENT,
  `currency_symbol` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_symbol`, `flag`) VALUES
(1, 'Tshs.', 0),
(2, 'Kshs.', 1),
(3, 'US$', 0),
(4, '£', 0),
(5, '€', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_details`
--

CREATE TABLE IF NOT EXISTS `food_details` (
  `food_id` int(15) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(45) NOT NULL,
  `food_description` text NOT NULL,
  `food_price` float NOT NULL,
  `food_photo` varchar(45) NOT NULL,
  `food_category` int(15) NOT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `food_details`
--

INSERT INTO `food_details` (`food_id`, `food_name`, `food_description`, `food_price`, `food_photo`, `food_category`) VALUES
(17, 'SUPER MEAT PIZZA', 'Its another super meat pizza!', 549.99, 'meat.png', 1),
(18, 'SUPER VEGGIE PIZZA', 'Its another super veggie pizza!', 499.99, 'veggie.png', 1),
(19, 'PEPPERONI PIZZA', 'Its another pepperoni pizza!', 699.99, 'pepperoni.png', 1),
(20, 'SUPER SUPREME PIZZA', 'Its another super supreme pizza!', 659.99, 'supersupreme.png', 1),
(21, 'ULTIMATE CHEESE PIZZA', 'Its another ultimate cheese pizza!', 729.99, 'ultimatecheese.png', 1),
(22, 'SUPREME PIZZA', 'Its another supreme pizza!', 599.99, 'supremepizza.png', 1),
(23, 'PEPPERONI COMBO', 'It is a mixture of veggies, meat, and cheese', 850, 'pepperoni.png', 14);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `question_id` int(5) NOT NULL,
  `answer` varchar(45) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`, `question_id`, `answer`) VALUES
(2, 'MacDonald', 'Ngowi', 'marlaw', '4409eae53c2e26a65cfc24b3a2359eb9', 0, ''),
(3, 'Michael', 'Mka', 'mcbcrue16@yahoo.com', '57f842286171094855e51fc3a541c1e2', 0, ''),
(4, 'Susan', 'Sanjeki', 'susansanjeki@gmail.com', 'b5c0b187fe309af0f4d35982fd961d7e', 0, ''),
(5, 'Joshua', 'Mleli', 'fdhlmll422@gmail.com', 'd1133275ee2118be63a577af759fc052', 0, ''),
(6, 'Alvin', 'Kahama', 'alvinkahama@gmail.com', '5541c7b5a06c39b267a5efae6628e003', 0, ''),
(7, 'shiko', 'waithera', 'shiwait@yahoo.com', '348a448a51d1e0f0f5eee42337d12adc', 0, ''),
(8, 'Justine', 'Odero', 'justineodero@gmail.com', 'b55050b2f605b7cf0d48346ff3d432d3', 0, ''),
(9, 'Edward', 'Ombui', 'eombui@anu.ac.ke', '1a1dc91c907325c69271ddf0c944bc72', 0, ''),
(10, 'MacDonald', 'Ngowi', 'mcbcrue08@gmail.com', '7a303911fd1cf9f344122f5bbe0b7de1', 0, ''),
(11, 'Kimani', 'Kahiga', 'kahiga@gmail.com', '547da2b03f947606f1d06a8dec093e64', 0, ''),
(12, 'root', 'root', 'root@foodplaza.co.ke', '7b24afc8bc80e548d66c4e7ff72171c5', 0, ''),
(14, 'Hilary', 'Ngowi', 'hilaryngowi@foodplaza.co.ke', 'eeafbf4d9b3957b139da7b7f2e7f2d4a', 5, '2aef3a00febc862d2354224aac9e1032'),
(15, 'test', 'test', 'test@rs.co.uk', '098f6bcd4621d373cade4e832627b4f6', 5, 'd432eb18017c004fd305969713a17aa8');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `message_from` varchar(25) NOT NULL,
  `message_email` varchar(45) NOT NULL,
  `message_date` date NOT NULL,
  `message_time` time NOT NULL,
  `message_subject` text NOT NULL,
  `message_text` text NOT NULL,
  `message_flag` int(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_from`, `message_email`, `message_date`, `message_time`, `message_subject`, `message_text`, `message_flag`) VALUES
(3, 'administrator', '', '2013-05-02', '13:06:56', 'Welcome!', 'Welcome to Food Plaza Online Ordering System. It is our hope that you find our site convenient to use. Please don''t hesitate to contact us in case of any query.', 0),
(4, 'administrator', '', '2014-07-15', '10:38:22', 'test', 'test', 0),
(5, 'test, test', 'test@test.co.ke', '2014-07-15', '11:28:06', 'TEST', 'test test test test', 1),
(6, 'Ngowi, MacDonald', 'mcbcrue08@gmail.com', '2014-07-15', '11:45:52', 'WHAT IS THE CORRECT FORMAT FOR A DELIVERY ADDRESS?', 'Hi!\r\n\r\nPlease refer to the subject above. I''m requesting the correct format for a delivery address so that to avoid confusions in delivering my food orders.\r\n\r\nThanks in advance.\r\n\r\nBest Regards, MacDonald', 1),
(7, 'demo, demo', 'demo@demo.co.uk', '2014-07-15', '11:53:10', 'DEMO', 'demo demo demo demo demo demo demo demo demo demo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE IF NOT EXISTS `orders_details` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `billing_id` int(10) NOT NULL,
  `cart_id` int(15) NOT NULL,
  `delivery_date` date NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `time_stamp` time NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`order_id`, `member_id`, `billing_id`, `cart_id`, `delivery_date`, `StaffID`, `flag`, `time_stamp`) VALUES
(12, 11, 6, 8, '2013-05-03', 2, 1, '17:31:15'),
(13, 11, 6, 6, '2013-05-03', 0, 0, '17:33:41'),
(14, 12, 7, 13, '2013-05-04', 0, 0, '12:43:03'),
(15, 12, 7, 14, '2013-05-06', 0, 0, '15:24:46'),
(16, 15, 8, 16, '2014-06-21', 0, 0, '21:45:45'),
(17, 15, 8, 17, '2014-07-09', 0, 0, '09:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `partyhalls`
--

CREATE TABLE IF NOT EXISTS `partyhalls` (
  `partyhall_id` int(5) NOT NULL AUTO_INCREMENT,
  `partyhall_name` varchar(45) NOT NULL,
  PRIMARY KEY (`partyhall_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `partyhalls`
--

INSERT INTO `partyhalls` (`partyhall_id`, `partyhall_name`) VALUES
(1, 'North'),
(2, 'South'),
(3, 'East'),
(4, 'West');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_admin`
--

CREATE TABLE IF NOT EXISTS `pizza_admin` (
  `Admin_ID` int(45) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pizza_admin`
--

INSERT INTO `pizza_admin` (`Admin_ID`, `Username`, `Password`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(4, 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4');

-- --------------------------------------------------------

--
-- Table structure for table `polls_details`
--

CREATE TABLE IF NOT EXISTS `polls_details` (
  `poll_id` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `food_id` int(15) NOT NULL,
  `rate_id` int(5) NOT NULL,
  PRIMARY KEY (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `polls_details`
--

INSERT INTO `polls_details` (`poll_id`, `member_id`, `food_id`, `rate_id`) VALUES
(8, 12, 19, 4),
(9, 5, 22, 1),
(10, 5, 18, 4),
(11, 5, 17, 1),
(13, 12, 22, 1),
(18, 12, 17, 5),
(17, 5, 19, 1),
(19, 11, 17, 1),
(20, 11, 18, 5),
(21, 11, 19, 6),
(22, 11, 22, 5),
(23, 11, 21, 1),
(24, 11, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE IF NOT EXISTS `quantities` (
  `quantity_id` int(5) NOT NULL AUTO_INCREMENT,
  `quantity_value` int(5) NOT NULL,
  PRIMARY KEY (`quantity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`quantity_id`, `quantity_value`) VALUES
(2, 1),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 7),
(9, 8),
(10, 9),
(11, 10),
(12, 11),
(13, 12),
(14, 13),
(15, 14),
(16, 15),
(17, 16),
(18, 17),
(19, 18),
(20, 19),
(21, 20),
(22, 21),
(23, 22),
(24, 23),
(25, 24),
(26, 25),
(27, 26),
(28, 27),
(29, 28),
(30, 29),
(31, 30);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(5) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`) VALUES
(2, 'What is the nickname of your second son?'),
(3, 'What is the name of your pet?'),
(4, 'Where did you spend your honeymoon?'),
(5, 'What is the name of your first love?'),
(6, 'What is the last name of your family doctor?'),
(7, 'What year did you got married?');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `rate_id` int(5) NOT NULL AUTO_INCREMENT,
  `rate_name` varchar(15) NOT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rate_id`, `rate_name`) VALUES
(1, 'Excellent'),
(4, 'Good'),
(5, 'Average'),
(6, 'Bad'),
(7, 'Worse');

-- --------------------------------------------------------

--
-- Table structure for table `reservations_details`
--

CREATE TABLE IF NOT EXISTS `reservations_details` (
  `ReservationID` int(15) NOT NULL AUTO_INCREMENT,
  `member_id` int(15) NOT NULL,
  `table_id` int(5) NOT NULL,
  `partyhall_id` int(5) NOT NULL,
  `Reserve_Date` date NOT NULL,
  `Reserve_Time` time NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `table_flag` int(1) NOT NULL,
  `partyhall_flag` int(1) NOT NULL,
  PRIMARY KEY (`ReservationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `reservations_details`
--

INSERT INTO `reservations_details` (`ReservationID`, `member_id`, `table_id`, `partyhall_id`, `Reserve_Date`, `Reserve_Time`, `StaffID`, `flag`, `table_flag`, `partyhall_flag`) VALUES
(6, 12, 4, 0, '2013-05-06', '20:00:00', 2, 1, 1, 0),
(7, 11, 5, 0, '2013-05-17', '19:00:00', 0, 0, 1, 0),
(8, 11, 11, 0, '2013-05-20', '19:30:00', 1, 1, 1, 0),
(9, 11, 5, 0, '2013-05-31', '20:30:00', 0, 0, 1, 0),
(10, 11, 0, 2, '2013-06-08', '18:00:00', 3, 1, 0, 1),
(11, 11, 0, 4, '2013-08-03', '17:00:00', 0, 0, 0, 1),
(15, 12, 0, 4, '2013-06-07', '20:00:00', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE IF NOT EXISTS `specials` (
  `special_id` int(15) NOT NULL AUTO_INCREMENT,
  `special_name` varchar(25) NOT NULL,
  `special_description` text NOT NULL,
  `special_price` float NOT NULL,
  `special_start_date` date NOT NULL,
  `special_end_date` date NOT NULL,
  `special_photo` varchar(45) NOT NULL,
  PRIMARY KEY (`special_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`special_id`, `special_name`, `special_description`, `special_price`, `special_start_date`, `special_end_date`, `special_photo`) VALUES
(6, 'PEPPERONI COMBO', 'It is a mixture of veggies, meat, and cheese', 850, '2013-05-06', '2013-05-11', 'pepperoni.png');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `StaffID` int(15) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `Street_Address` text NOT NULL,
  `Mobile_Tel` varchar(20) NOT NULL,
  PRIMARY KEY (`StaffID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `firstname`, `lastname`, `Street_Address`, `Mobile_Tel`) VALUES
(1, 'Kirk', 'Kahiga', 'SouthC,MombasaRoad,NewYorkCourt', '0725674323'),
(2, 'Samson', 'Kimani', 'Highlands,Kileleshwa', '0734547576'),
(3, 'Terry', 'Mkonyi', 'NgongRoad,RuahaCourt', '02239454643');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `table_id` int(5) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(45) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`) VALUES
(1, 'Morogoro'),
(2, 'Mwanza'),
(3, 'Tabora'),
(4, 'Kilimanjaro'),
(5, 'Dodoma'),
(6, 'Arusha'),
(7, 'Singida'),
(8, 'Ruvuma'),
(9, 'Rukwa'),
(10, 'Tanga'),
(11, 'Kagera'),
(12, 'Mara');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `template_id` int(1) NOT NULL DEFAULT '1',
  `site_logo` varchar(45) NOT NULL DEFAULT 'default',
  `site_background` varchar(45) NOT NULL DEFAULT 'default',
  `site_header` varchar(45) NOT NULL DEFAULT 'default',
  `site_center` varchar(45) NOT NULL DEFAULT 'default',
  `site_footer` varchar(45) NOT NULL DEFAULT 'default',
  `site_background_color` varchar(15) NOT NULL,
  `site_center_color` varchar(15) NOT NULL,
  `site_footer_color` varchar(15) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`template_id`, `site_logo`, `site_background`, `site_header`, `site_center`, `site_footer`, `site_background_color`, `site_center_color`, `site_footer_color`) VALUES
(1, '', '', '', '', '', '#000000', '#000000', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `timezone_id` int(5) NOT NULL AUTO_INCREMENT,
  `timezone_reference` varchar(45) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`timezone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`timezone_id`, `timezone_reference`, `flag`) VALUES
(1, 'Africa/Dar_es_Salaam', 0),
(2, 'Africa/Nairobi', 0),
(3, 'GMT/London', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'mcbcrue08@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
