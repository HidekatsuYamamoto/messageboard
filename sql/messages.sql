-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2014 年 8 月 17 日 23:44
-- サーバのバージョン: 5.5.38-0ubuntu0.14.04.1
-- PHP のバージョン: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `messageboard`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(4) NOT NULL COMMENT 'This is automatically created when you execute the statement of insert of SQL.',
  `creation_date` datetime NOT NULL,
  `body_text` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `author` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `pictureInfo` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`message_id`),
  UNIQUE KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- テーブルのデータのダンプ `messages`
--

INSERT INTO `messages` (`message_id`, `creation_date`, `body_text`, `author`, `pictureInfo`) VALUES
(1408281713, '2014-08-17 22:21:53', '超活発なネズミ', 'アビー', './pictures/map.jpg'),
(1408281886, '2014-08-17 22:24:46', '電気で作られた竜巻のようだ', '不審者', './pictures/map.jpg'),
(1408281931, '2014-08-17 22:25:31', 'Ashley Tisdale', 'コナー', './pictures/map.jpg'),
(1408282116, '2014-08-17 22:28:36', 'something is wrong with me.', '深呼吸', './pictures/map.jpg'),
(1408282515, '2014-08-17 22:35:15', 'Side by Side', 'BRP', './pictures/map.jpg'),
(1408284034, '2014-08-17 23:00:34', 'Don''t do that.', 'G-Rex', './pictures/map.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
