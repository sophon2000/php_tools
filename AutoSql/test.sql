-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-07-14 11:10:02
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `ts_test`
--

DROP TABLE IF EXISTS `ts_test`;
CREATE TABLE IF NOT EXISTS `ts_test` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告ID，主键',
  `title` varchar(255) DEFAULT NULL COMMENT '广告标题',
  `place` tinyint(1) NOT NULL DEFAULT '0' COMMENT '广告位置：0-中部；1-头部；2-左下；3-右下；4-底部；5-右上；',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效；0-无效；1-有效；',
  `is_closable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关闭，目前没有使用。',
  `ctime` int(11) DEFAULT NULL COMMENT '创建时间',
  `mtime` int(11) DEFAULT NULL COMMENT '更新时间',
  `display_order` smallint(2) NOT NULL DEFAULT '0' COMMENT '排序值',
  `display_type` tinyint(1) unsigned DEFAULT '1' COMMENT '广告类型：1 - HTML；2 - 代码；3 - 轮播',
  `content` text COMMENT '广告位内容',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位表' AUTO_INCREMENT=16 ;

--
-- 插入之前先把表清空（truncate） `ts_test`
--

TRUNCATE TABLE `ts_test`;
--
-- 转存表中的数据 `ts_test`
--

INSERT INTO `ts_test` (`ad_id`, `title`, `place`, `is_active`, `is_closable`, `ctime`, `mtime`, `display_order`, `display_type`, `content`) VALUES (11, '首页顶部广告位', 15, 1, 0, 1419321107, 1431012885, 2, 3, 'a:5:{i:0;a:2:{s:6:"banner";s:5:"43064";s:9:"bannerurl";s:86:"http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2242";}i:1;a:2:{s:6:"banner";s:5:"42025";s:9:"bannerurl";s:86:"http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2206";}i:2;a:2:{s:6:"banner";s:5:"43152";s:9:"bannerurl";s:86:"http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2254";}i:3;a:2:{s:6:"banner";s:5:"42377";s:9:"bannerurl";s:86:"http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2192";}i:4;a:2:{s:6:"banner";s:5:"42034";s:9:"bannerurl";s:86:"http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2206";}}');
INSERT INTO `ts_test` (`ad_id`, `title`, `place`, `is_active`, `is_closable`, `ctime`, `mtime`, `display_order`, `display_type`, `content`) VALUES (10, '微吧首页右下', 12, 1, 0, 1419057837, 1428431626, 1, 1, '<a href="http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2155"><a href="http://demo.thinksns.com/ts4/index.php?app=weiba&mod=Index&act=postDetail&post_id=2155"><img src="http://demo.thinksns.com/ts4/data/upload/2015/0408/00/5524010a3f84c.png" alt="" /></a></a><br />');
INSERT INTO `ts_test` (`ad_id`, `title`, `place`, `is_active`, `is_closable`, `ctime`, `mtime`, `display_order`, `display_type`, `content`) VALUES (14, '朋友圈右下', 3, 1, 0, 1425633186, 1432723620, 3, 1, '<p>\r\n	<a href="http://demo.thinksns.com/ts4/index.php?app=public&mod=Profile&act=index&uid=32307"></a><a href="http://demo.thinksns.com/ts4/index.php?app=public&mod=Profile&act=index&uid=32307"><img src="http://demo.thinksns.com/ts4/data/upload/2015/0527/18/5565a0a1de7ce.png" alt="" /></a> \r\n</p>');
