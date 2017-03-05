-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 03 月 05 日 03:06
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sfcbbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `sfc_content`
--

CREATE TABLE IF NOT EXISTS `sfc_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL COMMENT '所属子版块id',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publish_time` datetime NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL DEFAULT '55' COMMENT '点击次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='帖子表' AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `sfc_content`
--

INSERT INTO `sfc_content` (`id`, `module_id`, `title`, `content`, `publish_time`, `member_id`, `click`) VALUES
(1, 2, '勇士输给了火箭', '火箭立了，双加时险胜勇士，叼叼叼', '2016-12-03 21:36:12', 8, 15),
(17, 7, '哈登得分突破13000', '大胡子前途无量！', '2017-03-04 22:46:05', 11, 55),
(3, 6, '永远的1号', '玫瑰绽放，永远的罗斯！', '2016-12-04 11:36:41', 3, 3),
(4, 1, '周琦', '能很快的适应NBA的节奏吗？', '2016-12-04 11:38:31', 3, 0),
(5, 2, '库里', '小学生', '2016-12-04 11:39:01', 3, 17),
(6, 4, '国足加油', '虽然总在输球，但还是不能放弃', '2016-12-04 15:36:26', 3, 2),
(7, 5, '说说孙悦', '最有效率的拿戒指球员，哎，不说了！', '2016-12-04 16:04:00', 3, 55),
(8, 6, '险遭翻盘', '今天的比赛相当刺激啊！还是罗斯叼', '2016-12-05 21:27:37', 3, 57),
(9, 9, '五连胜', '这是属于威少的荣誉', '2016-12-05 21:29:29', 3, 55),
(10, 8, '保罗', '最稳重的运球技术！关键的三分球', '2016-12-05 21:30:07', 3, 55),
(11, 2, '汤普森 三节60分', '神了，最后一节队友都不让他上了！哈哈哈！', '2016-12-06 19:54:44', 9, 59),
(12, 2, '一山难容二虎', '杜兰特的到来\r\n限制了库里的得分次数，库里是否会选择离开勇士呢???', '2017-03-01 20:59:32', 3, 147);

-- --------------------------------------------------------

--
-- 表的结构 `sfc_father_module`
--

CREATE TABLE IF NOT EXISTS `sfc_father_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '父板块id',
  `module_name` varchar(66) NOT NULL COMMENT '父板块名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='父板块信息表' AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `sfc_father_module`
--

INSERT INTO `sfc_father_module` (`id`, `module_name`, `sort`) VALUES
(2, 'CBA', 1),
(7, 'NBA', 2),
(10, '亚冠联赛', 4),
(12, '足球', 5);

-- --------------------------------------------------------

--
-- 表的结构 `sfc_manage`
--

CREATE TABLE IF NOT EXISTS `sfc_manage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `pw` varchar(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sfc_manage`
--

INSERT INTO `sfc_manage` (`id`, `name`, `pw`, `create_time`, `level`) VALUES
(3, 'admin_1', '25f9e794323b453885f5181f1b624d0b', '2017-03-05 11:01:50', 0),
(2, 'admin_2', '25f9e794323b453885f5181f1b624d0b', '2017-03-05 10:45:17', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sfc_member`
--

CREATE TABLE IF NOT EXISTS `sfc_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `pw` varchar(32) NOT NULL,
  `photo` varchar(255) NOT NULL COMMENT '头像',
  `register_time` datetime NOT NULL,
  `last_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `sfc_member`
--

INSERT INTO `sfc_member` (`id`, `name`, `pw`, `photo`, `register_time`, `last_time`) VALUES
(3, '刘敬雄', '21c40da8f1d5bc099b11cb7a34196e31', 'uploads/2017/03/04/55582758bad264c63fd346667486.jpg', '2016-12-02 20:20:43', '0000-00-00 00:00:00'),
(4, '何际珍', '51f6f8fe03a390d3de50ad49913d4b66', '', '2016-12-02 21:45:15', '0000-00-00 00:00:00'),
(7, 'ljx123459', 'e10adc3949ba59abbe56e057f20f883e', '', '2016-12-02 22:07:04', '0000-00-00 00:00:00'),
(8, 'admin', '0192023a7bbd73250516f069df18b500', '', '2016-12-02 22:10:35', '0000-00-00 00:00:00'),
(9, 'admin2', '0192023a7bbd73250516f069df18b500', '', '2016-12-02 22:18:07', '0000-00-00 00:00:00'),
(10, 'Mr.liu', '25f9e794323b453885f5181f1b624d0b', '', '2017-03-02 20:02:29', '0000-00-00 00:00:00'),
(11, '莫斯科相信眼泪', '25f9e794323b453885f5181f1b624d0b', 'uploads/2017/03/04/19355558bad3506c6c5829435841.png', '2017-03-02 21:37:26', '0000-00-00 00:00:00'),
(12, '宇宙无敌超级兵', '25f9e794323b453885f5181f1b624d0b', '', '2017-03-02 21:39:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `sfc_reply`
--

CREATE TABLE IF NOT EXISTS `sfc_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL COMMENT '回复内容所属帖子',
  `quote_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复帖子下的回复',
  `content` text NOT NULL,
  `reply_time` datetime NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `sfc_reply`
--

INSERT INTO `sfc_reply` (`id`, `content_id`, `quote_id`, `content`, `reply_time`, `member_id`) VALUES
(1, 12, 0, '杜兰特伤退了，水花兄弟回来吧！', '2017-03-02 19:05:28', 3),
(2, 12, 0, '库里应该不会离开，如果离开去七六人吧，哈哈！^.^', '2017-03-02 19:30:33', 3),
(3, 5, 0, '小学生也是变态准啊', '2017-03-02 19:42:38', 3),
(4, 5, 0, '小学生也是变态准啊', '2017-03-02 19:52:03', 3),
(5, 12, 0, '全明星的一个传球，杜兰特和韦斯特布鲁克，醉了！！！', '2017-03-02 20:00:44', 3),
(6, 12, 5, '激情无限啊，哈哈', '2017-03-02 21:21:47', 10),
(7, 12, 2, '应该不会离开，库里就是为勇士而生', '2017-03-02 21:29:20', 10),
(8, 8, 0, '还是公牛的罗斯叼！！！', '2017-03-02 21:29:56', 10),
(9, 11, 0, '其实汤普森才是勇士稳定的最重要的人!!!!\r\n', '2017-03-02 21:40:18', 12),
(10, 11, 9, '终于找到知音了', '2017-03-02 21:41:11', 11),
(11, 3, 0, '出了艾弗森，也就是罗斯了！', '2017-03-03 18:46:52', 12);

-- --------------------------------------------------------

--
-- 表的结构 `sfc_son_module`
--

CREATE TABLE IF NOT EXISTS `sfc_son_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `father_module_id` int(10) unsigned NOT NULL,
  `module_name` varchar(66) NOT NULL,
  `info` varchar(255) NOT NULL COMMENT '简介',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属会员id',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `sfc_son_module`
--

INSERT INTO `sfc_son_module` (`id`, `father_module_id`, `module_name`, `info`, `member_id`, `sort`) VALUES
(1, 2, '新疆队', '夺冠', 0, 1),
(2, 7, '勇士队', '卫冕冠军', 0, 4),
(4, 12, '广州恒大', '国足雄起', 0, 6),
(5, 2, '北京队', '最爱马布里的style', 0, 2),
(6, 7, '纽约尼克斯', '玫瑰绽放，永远的罗斯', 0, 3),
(7, 7, '火箭队', '哈登666', 0, 5),
(8, 7, '快船', '船长起航', 0, 7),
(9, 7, '雷霆', '威少的巅峰时刻', 0, 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
