-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 04, 2014 at 10:33 PM
-- Server version: 5.5.40-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `planetnd_lunch_no_walk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_msg`
--

CREATE TABLE IF NOT EXISTS `admin_msg` (
  `msg_id` varchar(16) NOT NULL,
  `wechat_id` varchar(32) NOT NULL,
  `msg` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_msg`
--

CREATE TABLE IF NOT EXISTS `customer_msg` (
  `msg_id` varchar(16) NOT NULL,
  `wechat_id` varchar(32) NOT NULL,
  `msg` varchar(128) NOT NULL,
  `responded` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_msg`
--

INSERT INTO `customer_msg` (`msg_id`, `wechat_id`, `msg`, `responded`) VALUES
('54811cbfb4582', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', 'I love u', 1),
('548122700afa2', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', 'Jamal', 0),
('548125785269f', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', 'I want u', 0),
('54812ef9da92f', 'owHwut3QHMJiV6YRrB3C9-eeP7Yg', 'I have money', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE IF NOT EXISTS `meals` (
  `introduction` varchar(128) NOT NULL,
  `price` int(11) NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `week_day` varchar(10) NOT NULL,
  `id` varchar(128) NOT NULL,
  `available` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`introduction`, `price`, `image_path`, `week_day`, `id`, `available`) VALUES
('I am handsome', 213, 'uploads/ichiban.png', 'Wednesday', '5445cf32b37da', 0),
('Saturday''s menu', 72, 'uploads/ichiban.png', 'Saturday', '544692eabc1d0', 0),
('shredded	pork	with	garlic sauce, é±¼é¦™è‚‰ä¸', 7, 'uploads/yu_xiang_rou_si.jpg', 'Sunday', '5446976a6881d', 1),
('Egg and beef', 7, 'uploads/corned-beef-egg-chips-15509363.jpg', 'Friday', '54469d56ab30d', 1),
('Tofu, è±†è…', 9, 'uploads/tofu.jpg', 'Saturday', '5446acd00e829', 1),
('æ²¹ç‚¸é¼»æ¶•è™«', 700, 'uploads/4.jpg', 'Wednesday', '5446b2500f921', 0),
('æµ‹è¯•', 70000, 'uploads/image.jpg', 'Wednesday', '5446b94711a22', 0),
('', 0, 'uploads/ichiban.png', '', '5446b9474483e', 1),
('å¤§ç™½ç—´', 7000, 'uploads/image.jpg', 'Wednesday', '5446cb7b2f345', 0),
('Enter Menu Introduction Here', 7, 'uploads/image.jpg', 'Wednesday', '5446cbf7c28d1', 0),
('Sushi', 8, 'uploads/image.jpg', 'Wednesday', '5446cc701aef7', 1),
('Dabian', 7, 'uploads/5446ccfd9efe9image.jpg', 'Wednesday', '5446ccfd9f051', 0),
('ostupid aaron', 7, 'uploads/5446f4bfd45a2image.jpg', 'Wednesday', '5446f4bfd4602', 0),
('å®«ä¿é¸¡ä¸', 8, 'uploads/W020120710519415371590.jpg', 'Wednesday', '5447026d5a01d', 1),
('pizza', 7, 'uploads/5447146bca8a6d5a3498cfc9e53130b5f815ef44713b7_Jet.jpg', 'Thursday', '5447146bca902', 1),
('Kung Pao Chicken å®«ä¿é¸¡ä¸', 7, 'uploads/544714e96f7d820110705091140525.jpg', 'Thursday', '544714e96f838', 1),
('Mapo beancurd, éº»å©†è±†è…', 7, 'uploads/54471542e9530002564bc712b0dbb8d4607.bmp', 'Thursday', '54471542e9570', 1),
('Test Monday', 7, 'uploads/54471717d32c1ichiban.png', 'Monday', '54471717d331f', 0),
('Beef', 7, 'uploads/1020-303061-recipe_ginger-beef-nd-broccoli.jpg', 'Tuesday', '5447171fea959', 1),
('Test Thursday', 7, 'uploads/5447175a0acd4ichiban.png', 'Thursday', '5447175a0ad3b', 0),
('Test Friday', 7, 'uploads/5447176c69500ichiban.png', 'Friday', '5447176c6963f', 0),
('Sushi', 10, 'uploads/image.jpg', 'Thursday', '54482812ae1be', 1),
('jj', 6, 'uploads/544d4e5ae2f80image.jpg', 'Tuesday', '544d4e5ae2fe5', 0),
('haha', 10, 'uploads/544d4e7d34658image.jpg', 'Monday', '544d4e7d346af', 1),
('é’Ÿé’Ÿé’Ÿ', 1001, 'uploads/54529840556e4image.jpg', 'Friday', '545298405576d', 0),
('Enter Menu Introduction kkk', 8, 'uploads/5469535748b21image.jpg', 'Monday', '5469535748b88', 0),
('Chicken', 7, 'uploads/547fd73ebf207image.jpg', 'Monday', '547fd73ebf25d', 1),
('Tomato and eggs', 5, 'uploads/5480c43f25af7tomato-egg-stir-fry.jpg', 'Friday', '5480c43f25b5a', 1),
('å®«çˆ†èŒ„å­, Kung Pao Eggplants', 6, 'uploads/5480c5852a544170244oeufoe8greref8vl.jpg', 'Friday', '5480c5852a5ea', 1),
('Ma Po Tofu', 4, 'uploads/5480c5b8c6c2b4032933_141015061191_2.jpg', 'Friday', '5480c5b8c6c8a', 1),
('Szechuan Broccoli', 5, 'uploads/5480c6f528c78431430_490834170943891_1796903915_n.jpg', 'Friday', '5480c6f528cbd', 1),
('Hot and Sour Soup', 4, 'uploads/5480c79d3ed77hotandsour.jpg', 'Tuesday', '5480c79d3edd7', 1),
('Orange Chicken', 8, 'uploads/5480c82cd3bd4ornage.JPG', 'Tuesday', '5480c82cd3c33', 1),
('Szechuan Pork', 7, 'uploads/5480c8ddcfafeszchuanpork.jpg', 'Wednesday', '5480c8ddcfb57', 1),
('Donuts', 4, 'uploads/5480c99c293bddd.jpg', 'Monday', '5480c99c2941e', 1),
('Strawberry Pie', 7, 'uploads/5481338c805a1image.jpg', 'Monday', '5481338c805fb', 1),
('Egg and beef', 7, 'uploads/548133bbd54dcimage.jpg', 'Saturday', '548133bbd554b', 1),
('Pizza', 4, 'uploads/548133e1aafccimage.jpg', 'Saturday', '548133e1ab09f', 1),
('Spicy Fish', 11, 'uploads/5481342564594image.jpg', 'Saturday', '54813425645e0', 1),
('Spicy Mutton', 9, 'uploads/5481346f8805bimage.jpg', 'Saturday', '5481346f880bd', 1),
('Ramen', 8, 'uploads/548134bdcbd9fimage.jpg', 'Saturday', '548134bdcbe17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meal_order`
--

CREATE TABLE IF NOT EXISTS `meal_order` (
  `order_id` varchar(32) NOT NULL,
  `wechat_id` varchar(32) NOT NULL,
  `menu_id` varchar(32) NOT NULL,
  `order_num` int(11) NOT NULL,
  `complete` int(11) NOT NULL DEFAULT '0',
  `pickup_location` varchar(16) NOT NULL,
  `order_date` varchar(48) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal_order`
--

INSERT INTO `meal_order` (`order_id`, `wechat_id`, `menu_id`, `order_num`, `complete`, `pickup_location`, `order_date`) VALUES
('5451ab675f20a', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '54482812ae1be', 1, 1, 'MNTL', '1414638439223'),
('547fcdbc4c8c4', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '5447146bca902', 1, 1, 'MNTL', '1417661885728'),
('547fcee1042f1', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '54471542e9570', 4, 1, 'BIF', '1417662178688'),
('547fcf2aacde4', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '54471542e9570', 1, 1, 'RAL', '1417662252492'),
('547fcf6f4dbef', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '544714e96f838', 1, 1, 'RAL', '1417662318953'),
('547fcf7c68201', 'owHwut4dl0iB7rVGk6iMo4ExGnoc', '544714e96f838', 1, 0, 'RAL', '1417662333835'),
('547fd0b286bd0', 'owHwutwfIeEo5jNlFMntQksLcOHo', '54471542e9570', 3, 1, 'RAL', '1417662642408'),
('5480c63840821', 'owHwut2M0EOR041LRAd46Ghs5PQw', '5480c5852a5ea', 1, 1, 'BIF', '1417725495055'),
('5480c998a201f', 'owHwut5Y3Hp92WcD7F1PcVli15Qk', '5480c5852a5ea', 1, 1, 'MNTL', '1417726359321'),
('5480ca7b1605c', 'owHwut3BntJ86quRSV3h-EVF8B5U', '5480c5b8c6c8a', 1, 1, 'MNTL', '1417726590063'),
('5480cb15da26c', 'owHwut3BntJ86quRSV3h-EVF8B5U', '54469d56ab30d', 1, 0, 'MNTL', '1417726744893'),
('5480cb262586d', 'owHwut3BntJ86quRSV3h-EVF8B5U', '5480c43f25b5a', 1, 0, 'MNTL', '1417726761163'),
('5480cb3985be3', 'owHwut3BntJ86quRSV3h-EVF8B5U', '5480c6f528cbd', 10, 0, 'MNTL', '1417726780496'),
('5480d61ce51c4', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c5b8c6c8a', 1, 1, 'MNTL', '1417729566273'),
('5480d6cea96f7', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '54469d56ab30d', 1, 1, 'MNTL', '1417729744029'),
('5480dd74259fe', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c6f528cbd', 1, 1, 'MNTL', '1417731445489'),
('5480e34b31cfb', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '54469d56ab30d', 1, 1, 'MNTL', '1417732940594'),
('5480e502277b1', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c43f25b5a', 1, 1, 'MNTL', '1417733379542'),
('5480f89abb581', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c6f528cbd', 1, 1, 'MNTL', '1417738394779'),
('5480fad800fb7', 'owHwut9EeS6j_hnCi6fSTOsiJ86k', '54469d56ab30d', 1, 0, 'MNTL', '1417738969137'),
('548101fee9312', 'owHwutwfIeEo5jNlFMntQksLcOHo', '54469d56ab30d', 1, 0, 'MNTL', '1417740798944'),
('54812ed328cb4', 'owHwut3QHMJiV6YRrB3C9-eeP7Yg', '5480c6f528cbd', 1, 1, 'MNTL', '1417752274097'),
('54812fafdd318', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c5b8c6c8a', 1, 0, 'MNTL', '1417752497902'),
('548131f8e6309', 'owHwut4vD3-Gf3WvMKKMBS-LFLIk', '5480c5852a5ea', 1, 0, 'MNTL', '1417753082978');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `wechatid` varchar(32) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `first_name` varchar(16) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `pickup_location` varchar(16) NOT NULL,
  `administrator` int(11) NOT NULL DEFAULT '0',
  `money` float NOT NULL,
  PRIMARY KEY (`wechatid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`wechatid`, `last_name`, `first_name`, `phone`, `pickup_location`, `administrator`, `money`) VALUES
('owHwut-151NhA6tCSHHEZq-y_6i4', 'Li', 'Lunan', '2035358586', 'BIF', 1, 0),
('owHwut2M0EOR041LRAd46Ghs5PQw', 'Qian', 'Li', '2177789614', 'BIF', 0, 97),
('owHwut3BntJ86quRSV3h-EVF8B5U', 'wei', 'xin', '2178192211', 'MNTL', 0, 234),
('owHwut3QHMJiV6YRrB3C9-eeP7Yg', 'Lin', 'YuTing', '2178196697', 'MNTL', 0, 245),
('owHwut4dl0iB7rVGk6iMo4ExGnoc', 'Zhong', 'Yicheng', '2178988969', 'RAL', 1, 2923),
('owHwut4UHQq98LgXOcKjuHmLHz3o', 'uu', 'jj', '777778', 'BIF', 0, 0),
('owHwut4vD3-Gf3WvMKKMBS-LFLIk', 'Wang', 'Yiyi', '2176499936', 'MNTL', 1, 157),
('owHwut5Y3Hp92WcD7F1PcVli15Qk', 'Hu', 'Hai', '2177786487', 'MNTL', 0, 194),
('owHwut9EeS6j_hnCi6fSTOsiJ86k', 'Guo', 'Yibo', '2173330000', 'MNTL', 0, -7),
('owHwut9rV-qpscS0L4tyGyBF9Eu4', 'Sun', 'Baijia', '2178980788', 'MNTL', 0, 87),
('owHwutwfIeEo5jNlFMntQksLcOHo', 'Wang', 'jialiang', '2172812119', 'MNTL', 1, 93),
('owHwutwL801jMk-WLTHieLd0af_E', 'Jiang', 'Jing', '2174194008', 'MNTL', 1, 200),
('test', 'test', 'test', '1234', 'MNTL', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
