-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-07-20 06:47:04
-- 服务器版本： 5.6.17
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weblearning`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `lessonid` int(11) NOT NULL COMMENT '课程id',
  `content` varchar(200) NOT NULL,
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`commentid`),
  KEY `sid` (`sid`),
  KEY `sid_2` (`sid`),
  KEY `lessonid` (`lessonid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`commentid`, `sid`, `lessonid`, `content`, `createtime`, `updatetime`) VALUES
(2, 3, 1, '可以，不错。', '2018-05-24 00:00:00', '2018-05-24 00:00:00'),
(3, 1, 5, '期待新课程', '2018-06-02 09:20:38', '0000-00-00 00:00:00'),
(4, 1, 1, '很不错！', '2018-06-05 18:09:04', '2018-06-05 18:09:04'),
(5, 1, 4, '很好', '2018-06-06 10:27:59', '2018-06-06 10:27:59'),
(6, 1, 86, '啊啊啊啊啊', '2018-06-06 11:15:07', '2018-06-06 11:15:07');

-- --------------------------------------------------------

--
-- 表的结构 `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `vid` int(11) NOT NULL COMMENT '收藏视频id',
  `lessonid` int(11) NOT NULL COMMENT '收藏视频所属课程id',
  `studentid` int(11) NOT NULL COMMENT '收藏学生用户id',
  `createtime` datetime NOT NULL COMMENT '收藏日期',
  PRIMARY KEY (`fid`),
  KEY `studentid` (`studentid`),
  KEY `lessonid` (`lessonid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `favorite`
--

INSERT INTO `favorite` (`fid`, `vid`, `lessonid`, `studentid`, `createtime`) VALUES
(1, 1, 1, 1, '2018-04-20 12:00:00'),
(2, 1, 3, 1, '2018-05-02 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE IF NOT EXISTS `lesson` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程id',
  `tid` int(11) NOT NULL COMMENT '课程类型id',
  `teacherId` int(11) NOT NULL COMMENT '上传教师id',
  `lessonname` varchar(50) NOT NULL COMMENT '课程名',
  `intro` varchar(400) NOT NULL COMMENT '视频简介',
  `pic` varchar(100) NOT NULL COMMENT '课程封面',
  `hits` int(11) NOT NULL,
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`lessonid`),
  KEY `tid` (`tid`),
  KEY `teacherId` (`teacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='课程信息表';

--
-- 转存表中的数据 `lesson`
--

INSERT INTO `lesson` (`lessonid`, `tid`, `teacherId`, `lessonname`, `intro`, `pic`, `hits`, `createtime`, `updatetime`) VALUES
(1, 1, 1, 'PHP基础', '非常通俗易懂地向初学者介绍了PHP语言的基本概念、使用方法和注意事项。全书通过丰富的示例，引领读者逐步掌握这门流行的Web开发语言，使读者能够上手亲自编写适用于常用场景的PHP脚本。', '20151010162442_cMECy.jpg', 3096, '2018-04-20 09:00:00', '2018-05-05 20:00:09'),
(3, 1, 1, 'php进阶', 'PHP性能优化\r\n、如果能将类的方法定义成static，就尽量定义成static，它的速度会提升将近4倍。\r\n\r\n2、$row[\'id\']的速度是$row[id]的7倍。\r\n\r\n3、echo比print快，并且使用echo的多重参数（译注：指用逗号而不是句点）代替字符串连接，比如echo $str1,$str2。\r\n\r\n4、在执行for循环之前确定最大循环数，不要每循环一次都计算最大值，最好运用foreach代替。\r\n\r\n5、注销那些不用的变量尤其是大数组，以便释放内存。\r\n', '5aed27c3561a6.jpg', 2016, '2018-05-10 00:00:00', '2018-05-05 11:40:51'),
(4, 1, 1, 'Think PHP入门', 'ThinkPHP是为了简化企业级应用开发和敏捷WEB应用开发而诞生的。最早诞生于2006年初，2007年元旦正式更名为ThinkPHP，并且遵循Apache2开源协议发布。ThinkPHP从诞生以来一直秉承简洁实用的设计原则，在保持出色的性能和至简的代码的同时，也注重易用性。并且拥有众多原创功能和特性，在社区团队的积极参与下，在易用性、扩展性和性能方面不断优化和改进。 [1] \r\nThinkPHP是一个快速、兼容而且简单的轻量级国产PHP开发框架，诞生于2006年初，原名FCS，2007年元旦正式更名为ThinkPHP，遵循Apache2开源协议发布，从Struts结构移植过来并做了改进和完善，同时也借鉴了国外很多优秀的框架和模式，使用面向对象的开发结构和MVC模式，融合了Struts的思想和TagLib（标签库）、RoR的ORM映射和ActiveRecord模式。\r\nThinkPHP可以', '5b169da61ac87.jpg', 2016, '2018-05-26 00:00:00', '2018-06-05 22:26:46'),
(5, 1, 1, 'Think PHP进阶', '作为一个整体开发解决方案，ThinkPHP能够解决应用开发中的大多数需要，因为其自身包含了底层架构、兼容处理、基类库、数据库访问层、模板引擎、缓存机制、插件机制、角色认证、表单处理等常用的组件，并且对于跨版本、跨平台和跨数据库移植都比较方便。并且每个组件都是精心设计和完善的，应用开发过程仅仅需要关注您的业务逻辑。', '73551aa6bdb44b8caf19a0.jpg', 1514, '2018-05-25 00:00:00', '2018-05-25 00:00:00'),
(6, 3, 1, 'IOS基础', 'iOS是由苹果公司开发的移动操作系统 [1]  。苹果公司最早于2007年1月9日的Macworld大会上公布这个系统，最初是设计给iPhone使用的，后来陆续套用到iPod touch、iPad以及Apple TV等产品上。iOS与苹果的Mac OS X操作系统一样，属于类Unix的商业操作系统。原本这个系统名为iPhone OS，因为iPad，iPhone，iPod touch都使用iPhone OS，所以2010WWDC大会上宣布改名为iOS（iOS为美国Cisco公司网络设备操作系统注册商标，苹果改名已获得Cisco公司授权）。', '5b169a365b7dc.jpg', 1000, '2018-05-24 00:00:00', '2018-06-05 22:12:06'),
(83, 12, 1, 'Android基础开发', 'Android是一种基于Linux的自由及开放源代码的操作系统，主要使用于移动设备，如智能手机和平板电脑，由Google公司和开放手机联盟领导及开发。尚未有统一中文名称，中国大陆地区较多人使用“安卓”或“安致”。Android操作系统最初由Andy Rubin开发，主要支持手机。2005年8月由Google收购注资。2007年11月，Google与84家硬件制造商、软件开发商及电信营运商组建开放手机联盟共同研发改良Android系统。随后Google以Apache开源许可证的授权方式，发布了Android的源代码。第一部Android智能手机发布于2008年10月。Android逐渐扩展到平板电脑及其他领域上，如电视、数码相机、游戏机等。2011年第一季度，Android在全球的市场份额首次超过塞班系统，跃居全球第一。 2013年的第四季度，Android平台手机的全球市场份额已经达到78', '5b1134120e1b9.jpg', 7, '2018-06-01 19:54:58', '2018-06-01 19:54:58'),
(84, 12, 1, 'Android进阶课程', 'Android进阶课程', '5b1150cc349c6.jpg', 4, '2018-06-01 21:57:32', '2018-06-01 21:57:32'),
(85, 13, 4, '大数据基础', '大数据（big data），指无法在一定时间范围内用常规软件工具进行捕捉、管理和处理的数据集合，是需要新处理模式才能具有更强的决策力、洞察发现力和流程优化能力的海量、高增长率和多样化的信息资产。 [1] \r\n在维克托·迈尔-舍恩伯格及肯尼斯·库克耶编写的《大数据时代》 [2]  中大数据指不用随机分析法（抽样调查）这样捷径，而采用所有数据进行分析处理。大数据的5V特点（IBM提出）：Volume（大量）、Velocity（高速）、Variety（多样）、Value（低价值密度）、Veracity（真实性）', '5b166c9ba13ea.jpg', 4, '2018-06-05 18:57:31', '2018-06-05 18:57:31'),
(86, 3, 4, 'IOS编程', 'IOS苹果APP开发', '5b166caf5dedb.jpg', 4, '2018-06-05 18:57:51', '2018-06-06 10:27:33'),
(87, 13, 4, '大数据', '大数据（big data），指无法在一定时间范围内用常规软件工具进行捕捉、管理和处理的数据集合，是需要新处理模式才能具有更强的决策力、洞察发现力和流程优化能力的海量、高增长率和多样化的信息资产。 [1] \r\n在维克托·迈尔-舍恩伯格及肯尼斯·库克耶编写的《大数据时代》 [2]  中大数据指不用随机分析法（抽样调查）这样捷径，而采用所有数据进行分析处理。大数据的5V特点（IBM提出）：Volume（大量）、Velocity（高', '5b166cd66bdcb.jpg', 0, '2018-06-05 18:58:30', '2018-06-05 18:58:30'),
(88, 4, 4, '项目实践', '项目执行是指正式开始为完成项目而进行的活动或努力的工作过程。由于项目产品（最终可交付成果）是在这个过程中产生的，所以该过程是项目管理应用领域中最为重要的环节。在这个过程中，项目经理要协调和管理项目中存在的各种技术和组织等方面的问题。项目会议是求同存异的，主要是统一认识和思想，把方向引导到正确的方向，并对项目执行过程中存在的问题进行反思和进行改进建议的讨论，细节问题是具体执行人的工作；要给项目组内成员足够的信任，可能他们的方法和措施比项目经理的更有效。', '5b169d7fa7a7b.jpg', 8, '2018-06-05 21:56:38', '2018-06-05 22:26:07'),
(89, 4, 1, '我的世界', '开发框架发可否把卡', '5b17595cba029.jpg', 4, '2018-06-06 11:47:40', '2018-06-06 11:47:40'),
(90, 12, 1, 'androidhaha', 'aaaaaaaaaaaaa', 'asdad', 111, '2018-07-08 00:00:00', '2018-07-08 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonid` int(11) NOT NULL COMMENT '课程id',
  `vid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `content` varchar(200) NOT NULL COMMENT '问题详情',
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`qid`),
  KEY `studentid` (`studentid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `question`
--

INSERT INTO `question` (`qid`, `lessonid`, `vid`, `studentid`, `content`, `createtime`, `updatetime`) VALUES
(1, 1, 1, 1, '没听懂xx部分，请问>>>>>>>', '2018-05-17 00:00:00', '2018-05-17 00:00:00'),
(2, 1, 1, 1, '?????????', '2018-05-25 00:00:00', '2018-05-26 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `reply`
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE IF NOT EXISTS `reply` (
  `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论回复id',
  `teacherId` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `content` varchar(200) NOT NULL COMMENT '回复评论内容',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `commentid` (`commentid`),
  KEY `teacherId` (`teacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `reply`
--

INSERT INTO `reply` (`rid`, `teacherId`, `commentid`, `content`, `createtime`) VALUES
(1, 1, 2, '感谢观看', '2018-06-06 00:00:00'),
(2, 1, 3, '谢谢', '2018-06-06 19:45:54'),
(3, 1, 4, '感谢您的观看，谢谢支持！', '2018-06-06 19:46:26');

-- --------------------------------------------------------

--
-- 表的结构 `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `scid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonid` int(11) NOT NULL COMMENT '课程id',
  `studentid` int(11) NOT NULL COMMENT '学生id',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`scid`),
  KEY `lessonid` (`lessonid`),
  KEY `studentid` (`studentid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='学生课程表';

--
-- 转存表中的数据 `schedule`
--

INSERT INTO `schedule` (`scid`, `lessonid`, `studentid`, `createtime`) VALUES
(1, 1, 1, '2018-05-01 00:00:00'),
(2, 1, 1, '2018-06-01 23:56:57'),
(4, 5, 1, '2018-06-02 08:02:25'),
(7, 4, 1, '2018-06-06 11:18:19'),
(8, 88, 1, '2018-06-06 11:23:16');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `studentname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(200) NOT NULL COMMENT '密码',
  `bir` date NOT NULL,
  `gender` int(1) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`sid`, `studentname`, `password`, `bir`, `gender`, `pic`, `email`, `createtime`, `updatetime`) VALUES
(1, 'lee', 'e10adc3949ba59abbe56e057f20f883e', '2018-04-14', 1, '5b078b371cb2b.jpg', '46516516aaaa@163.com', '2018-04-20 10:25:25', '2018-06-06 11:34:09'),
(3, '黑盒子', 'e10adc3949ba59abbe56e057f20f883e', '2018-04-10', 1, '5aed84308410b.jpg', '13135131@126.com', '2018-04-13 00:00:00', '2018-05-18 09:19:22');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacherId` int(11) NOT NULL AUTO_INCREMENT COMMENT '教师id',
  `teachername` varchar(50) NOT NULL COMMENT '教师名',
  `password` varchar(200) NOT NULL,
  `gender` int(1) NOT NULL,
  `bir` date NOT NULL,
  `pic` varchar(200) NOT NULL,
  `email` varchar(60) NOT NULL,
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`teacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`teacherId`, `teachername`, `password`, `gender`, `bir`, `pic`, `email`, `createtime`, `updatetime`) VALUES
(1, 'Jam', 'e10adc3949ba59abbe56e057f20f883e', 1, '2018-04-22', 'face-2.jpg', '156131613@163.com', '2018-04-20 09:24:32', '2018-06-08 08:33:14'),
(4, 'Roy', 'e10adc3949ba59abbe56e057f20f883e', 1, '2018-06-09', '5b12109468c38.png', '156131613@163.com', '2018-06-02 11:35:48', '2018-06-02 11:35:48');

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程类型id',
  `typename` varchar(50) NOT NULL COMMENT '课程类型名',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  `updatetime` datetime NOT NULL COMMENT '最近修改时间',
  `delete_time` datetime DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='课程类型表';

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`tid`, `typename`, `createtime`, `updatetime`, `delete_time`) VALUES
(1, 'PHP', '2018-04-18 07:21:08', '2018-04-18 07:23:04', NULL),
(3, 'IOS', '2018-04-18 07:21:08', '2018-04-18 07:23:04', NULL),
(4, '综合实践', '2018-04-18 07:24:06', '2018-04-18 07:30:08', NULL),
(12, 'Android', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(13, '大数据', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `vid` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频id',
  `vname` varchar(50) NOT NULL,
  `lessonid` int(11) NOT NULL COMMENT '课程id',
  `path` varchar(100) NOT NULL COMMENT '视频地址',
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`vid`),
  KEY `lessonid` (`lessonid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `videos`
--

INSERT INTO `videos` (`vid`, `vname`, `lessonid`, `path`, `createtime`, `updatetime`) VALUES
(1, 'PHP基础-第一课', 1, 'videos/8.mp4', '2018-04-20 12:00:00', '2018-05-30 09:24:23'),
(2, 'PHP基础-第二课', 1, 'videos/2.mp4', '2018-05-24 00:00:00', '2018-05-24 00:00:00'),
(3, 'PHP基础-第三课', 1, 'videos/3.mp4', '2018-05-24 00:00:00', '2018-05-24 00:00:00'),
(4, 'PHP基础-第四课', 1, 'videos/cat2.mp4', '2018-05-24 00:00:00', '2018-05-24 00:00:00'),
(5, 'PHP进阶-第一课', 3, 'videos/8.mp4', '2018-05-18 00:00:00', '2018-05-18 00:00:00'),
(6, '一、thinkPHP安装', 4, 'videos/7_2.mp4', '2018-05-26 00:00:00', '2018-05-26 00:00:00'),
(7, 'thinkPHP完成博客', 5, 'videos/fragment+basic.mp4', '2018-05-25 00:00:00', '2018-05-25 00:00:00'),
(10, 'Android环境配置', 83, 'videos/5b1156102c4ad.mp4', '2018-06-01 22:20:00', '2018-06-01 22:20:00'),
(11, 'Android-Toast', 83, 'videos/5b1156cabcc2d.mp4', '2018-06-01 22:23:06', '2018-06-01 22:23:06'),
(13, '二、ThinkPHP基本架构', 4, 'videos/5b12118374cf0.mp4', '2018-06-02 11:39:47', '2018-06-02 11:39:47'),
(14, 'IOS环境搭建', 6, 'videos/5b17ccc0b501f.mp4', '2018-06-06 20:00:00', '2018-06-06 20:00:00');

--
-- 限制导出的表
--

--
-- 限制表 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`lessonid`) REFERENCES `lesson` (`lessonid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`lessonid`) REFERENCES `lesson` (`lessonid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `type` (`tid`),
  ADD CONSTRAINT `lesson_ibfk_2` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`);

--
-- 限制表 `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`commentid`) REFERENCES `comment` (`commentid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`lessonid`) REFERENCES `lesson` (`lessonid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`lessonid`) REFERENCES `lesson` (`lessonid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
