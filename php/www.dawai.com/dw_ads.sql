/*
Navicat MySQL Data Transfer

Source Server         : 测试
Source Server Version : 50545
Source Host           : 218.60.94.27:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50545
File Encoding         : 65001

Date: 2018-03-26 10:05:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dw_ads
-- ----------------------------
DROP TABLE IF EXISTS `dw_ads`;
CREATE TABLE `dw_ads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '幻灯ID',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面ID',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '点击链接',
  `start_time` varchar(25) NOT NULL DEFAULT '0000-00-00' COMMENT '开始时间',
  `end_time` varchar(25) NOT NULL DEFAULT '0000-00-00' COMMENT '结束时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `category` tinyint(2) DEFAULT NULL COMMENT '分类 1轮播 2直播 3导航',
  `content` text COMMENT '序列化内容',
  `flag` varchar(20) DEFAULT NULL COMMENT '标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='幻灯切换表';

-- ----------------------------
-- Records of dw_ads
-- ----------------------------
INSERT INTO `dw_ads` VALUES ('2', 'test1', '23', 'http://www.dawai.com/', '2017-08-15', '2017-08-15', '0', '0', '1', 'a:8:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:5:\"test1\";s:5:\"cover\";s:2:\"23\";s:9:\"cover_wap\";s:0:\"\";s:10:\"start_time\";s:10:\"2017-08-15\";s:8:\"end_time\";s:10:\"2017-08-15\";s:3:\"url\";s:21:\"http://www.dawai.com/\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('3', 'test2', '24', '', '2017-08-15', '2017-08-15', '0', '0', '1', null, null);
INSERT INTO `dw_ads` VALUES ('4', '托福在线95-100+ 提高课程', '51', 'www.jiemo.net', '2017-08-15', '2018-02-08', '0', '1', '1', 'a:8:{s:2:\"id\";s:1:\"4\";s:5:\"title\";s:32:\"托福在线95-100+ 提高课程\";s:5:\"cover\";s:2:\"51\";s:9:\"cover_wap\";s:2:\"74\";s:10:\"start_time\";s:10:\"2017-08-15\";s:8:\"end_time\";s:10:\"2018-02-08\";s:3:\"url\";s:13:\"www.jiemo.net\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('5', '雅思词汇加强课', '71', '', '2017-08-15', '2017-08-15', '0', '1', '2', 'a:7:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:21:\"雅思词汇加强课\";s:5:\"cover\";s:2:\"71\";s:9:\"cover_wap\";s:2:\"71\";s:9:\"lesson_id\";s:1:\"1\";s:10:\"zhibo_time\";s:12:\"敬请期待\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('6', '托福课程', '72', '', '2017-08-15', '2017-08-15', '0', '1', '2', 'a:7:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:12:\"托福课程\";s:5:\"cover\";s:2:\"72\";s:9:\"cover_wap\";s:2:\"72\";s:9:\"lesson_id\";s:1:\"4\";s:10:\"zhibo_time\";s:12:\"敬请期待\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('7', 'test2', '25', '', '2017-08-15', '2017-08-15', '0', '0', '2', 'a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:5:\"test2\";s:5:\"cover\";s:2:\"25\";s:9:\"lesson_id\";s:1:\"1\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('8', '雅思在线拔高班（7分+）', '34', 'www.jiemo.net', '2017-08-17', '2018-05-31', '0', '1', '1', 'a:8:{s:2:\"id\";s:1:\"8\";s:5:\"title\";s:32:\"雅思在线拔高班（7分+）\";s:5:\"cover\";s:2:\"34\";s:9:\"cover_wap\";s:0:\"\";s:10:\"start_time\";s:10:\"2017-08-17\";s:8:\"end_time\";s:10:\"2018-05-31\";s:3:\"url\";s:13:\"www.jiemo.net\";s:4:\"sort\";s:1:\"0\";}', null);
INSERT INTO `dw_ads` VALUES ('9', '雅思在线提高班（5.5分）', '35', '', '2017-08-15', '2017-08-15', '0', '1', '2', 'a:8:{s:2:\"id\";s:1:\"9\";s:5:\"title\";s:33:\"雅思在线提高班（5.5分）\";s:5:\"cover\";s:2:\"35\";s:9:\"cover_wap\";s:0:\"\";s:9:\"lesson_id\";s:2:\"10\";s:10:\"zhibo_time\";s:12:\"敬请期待\";s:4:\"flag\";s:3:\"123\";s:4:\"sort\";s:1:\"0\";}', '123');
INSERT INTO `dw_ads` VALUES ('10', '雅思在线VIP全科1v1', '49', 'www.jiemo.net', '2017-08-15', '2017-08-15', '0', '1', '1', 'a:8:{s:2:\"id\";s:2:\"10\";s:5:\"title\";s:24:\"雅思在线VIP全科1v1\";s:5:\"cover\";s:2:\"49\";s:9:\"cover_wap\";s:2:\"73\";s:10:\"start_time\";s:10:\"0000-00-00\";s:8:\"end_time\";s:10:\"0000-00-00\";s:3:\"url\";s:13:\"www.jiemo.net\";s:4:\"sort\";s:1:\"0\";}', null);

-- ----------------------------
-- Table structure for dw_click_counter
-- ----------------------------
DROP TABLE IF EXISTS `dw_click_counter`;
CREATE TABLE `dw_click_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL COMMENT '点击分类',
  `data_id` int(11) DEFAULT NULL COMMENT '数据id',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mix` (`category`,`data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='点击计数';

-- ----------------------------
-- Records of dw_click_counter
-- ----------------------------
INSERT INTO `dw_click_counter` VALUES ('4', '课程', '1', '1503372713', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('5', '课程', '25', '1503394575', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('6', '课程', '25', '1503394606', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('7', '课程', '25', '1503394911', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('8', '课程', '25', '1503394935', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('9', '课程', '28', '1503453433', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('10', '课程', '10', '1503476736', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('11', '课程', '12', '1503479048', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('12', '课程', '13', '1503482418', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('13', '课程', '11', '1503482829', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('14', '课程', '2', '1503631105', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('15', '课程', '19', '1503631443', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('16', '课程', '30', '1504686764', '127.0.0.1', null);
INSERT INTO `dw_click_counter` VALUES ('17', '课程', '23', '1504686870', '127.0.0.1', null);

-- ----------------------------
-- Table structure for dw_course_feature
-- ----------------------------
DROP TABLE IF EXISTS `dw_course_feature`;
CREATE TABLE `dw_course_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `sort` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='课程特色';

-- ----------------------------
-- Records of dw_course_feature
-- ----------------------------
INSERT INTO `dw_course_feature` VALUES ('1', 'test1', 'test1', '1', '0');
INSERT INTO `dw_course_feature` VALUES ('2', 'test2', 'test2', '1', '0');
INSERT INTO `dw_course_feature` VALUES ('3', '免费试听', '444', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('4', '互动直播', '由名师实时直播，亲自授课答疑。直播课上您可以直接与老师进行互动，也可在课后反复观看视频回放。', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('5', '录播精讲', '所有直播课内容，将以录播礼包的形式赠送给线上学员，以供备考及随时复习使用。', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('6', '口语陪练', '严格按照雅思口语考试要求，对您进行实时1对1口语陪练，并在每次练习后提供详尽的改进建议以及录音。需预约购买30min/￥100', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('7', '作文批改', '在线提交作文，由专业的作文指导教师进行批改和优化指导。', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('8', '“浸泡式” 督导', '由专业教师在课后通过微信，督促和监督学生的课后学习情况，并对学习中出现的问题进行指导。（确认作业，考察知识点，考察词汇，讲解共性问题，提供学习建议，固定时间讲解。）', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('9', '内部讲义', '线上课程的全部学习资料、测试用试卷、全真考试辅导资料等将以实体形式邮寄到学员手中用以完成学习。海量学习资料电子版也将发送到学员邮箱。（纸质版）', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('10', '在线团练群', '寻找志同道合的小伙伴，建立互助小组，共同进步，互相激励，早日与考试分手！', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('11', '免费重听', '完成课程学习后参加考试，如果没有考取目标分数，可以申请免费重新学习课程。', '0', '1');
INSERT INTO `dw_course_feature` VALUES ('12', '电子讲义', '海量学习资料电子版将发送到学员邮箱。', '0', '1');

-- ----------------------------
-- Table structure for dw_course_lesson
-- ----------------------------
DROP TABLE IF EXISTS `dw_course_lesson`;
CREATE TABLE `dw_course_lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_1` varchar(255) DEFAULT NULL COMMENT '封面',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `lesson_flag` varchar(20) DEFAULT '0' COMMENT '可试学 1是',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `cost` int(11) DEFAULT '0' COMMENT '课程价格',
  `prime_cost` int(11) DEFAULT '0' COMMENT '原价',
  `feature` varchar(80) DEFAULT NULL COMMENT '特色',
  `category` varchar(80) DEFAULT NULL COMMENT '分类 1 英语 2日语 ',
  `lesson_type` varchar(80) DEFAULT NULL COMMENT '授课方式  2线上直播  3 线下录播',
  `end_time` varchar(20) DEFAULT NULL COMMENT '有效时间',
  `total_hour` varchar(20) DEFAULT NULL COMMENT '课时总数',
  `suit_people` text COMMENT '适合人群',
  `coures_content` text COMMENT '课程简介',
  `study_target` text COMMENT '学习目标',
  `book_1` int(11) DEFAULT NULL COMMENT '教材图片',
  `book_description` varchar(255) DEFAULT NULL COMMENT '教材描述',
  `teacher` varchar(80) DEFAULT NULL COMMENT '授课老师',
  `is_new` tinyint(2) DEFAULT '0' COMMENT '最新',
  `is_hot` tinyint(2) DEFAULT '0' COMMENT '最热',
  `create_time` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0' COMMENT '状态',
  `sort` tinyint(3) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='课程内容';

-- ----------------------------
-- Records of dw_course_lesson
-- ----------------------------
INSERT INTO `dw_course_lesson` VALUES ('1', '57', '雅思词汇加强课（4000+词汇基础班）', '0', '认知词汇+高级学术词汇', '0', '0', '3,,5,,,,9,10,11,', '1,11', '1,2', '0', '20', '需要提高词汇量的同学，词汇量达到7000+  <br>\r\n111', '                                                                                <p class=\"MsoNormal\">\r\n	<span>录播词汇加强课是针对以上各门课程的辅课，俗话说</span>“无砖，楼难砌，无词，言无力”大外雅思在线团队根据学生同学此项痛点，精心锻造此项课程。学生根据自身水平，有三项类别可选，囊扩考试所用的基础词汇加学术词汇，为你屠雅事半功倍。\r\n</p>                                                            ', '                                                                                认知词汇+高级学术词汇<br />\r\n核心词汇的学习<br />\r\n成簇词的学习<br />\r\n词汇造句练习<br />                                                            ', '0', '独家内部纸质版讲义', ',4,,,,', '0', '0', null, '1', '1');
INSERT INTO `dw_course_lesson` VALUES ('2', '48', ' 托福在线 60-80 提高课程', '0', '认识托福考试评分原则和标准，并理解各分数段的达标条件；', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', '2,3', '0', '40', '语法知识和词汇基础较为薄弱；过往托福考试成绩低于 75 分。', '<p class=\"MsoNormal\">\r\n	<span>托福在线</span>60-80 <span>提高课程是大外在线托福教研团队根据多年经验推出的托福培训课程，由</span><span>40</span><span>小时国内名师方法课</span><span>+60</span><span>小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>托福在线</span>60-80 <span>提高课面向语法知识和词汇基础较为薄弱；过往托福考试成绩低于 </span><span>75 </span><span>分的学员。</span>\r\n</p>', '认识托福考试评分原则和标准，并理解各分数段的达标条件；<br />\r\n熟练掌握托福基础词汇和必备语法知识；<br />\r\n系统掌握高效的英语提升方法；<br />\r\n了解并熟练应用各科核心技巧。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,8', '0', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('3', '50', '托福在线 81-95 提高课程', '0', '熟练掌握托福达标词汇并完善语法知识', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', '2,3', '0', '40', '具备托福考试需要的基本词汇量，语法知识完备；过往托福考试成绩 75-80 分。', '托福在线81-95 提高课程是大外在线托福教研团队根据多年经验推出的托福培训课程，由40小时国内名师方法课+60小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。&nbsp;<br />\r\n托福在线81-95 提高课面向具备托福考试需要的基本词汇量，语法知识完备；过往托福考试成绩 75-80 分的学员。<br />', '充分认识目标分数与自身能力之间的差距；<br />\r\n熟练掌握托福达标词汇并完善语法知识；<br />\r\n熟练掌握高效的英语提升方法；<br />\r\n了解并熟练应用各科高分技巧。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,8', '0', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('4', '52', '托福在线 95-100+ 提高课程', '0', '精准应用各科高分技巧', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', '2,3', '0', '40', '具备托福考试需要熟练掌握的 7500 词汇，语法知识完备；过往托福考试成绩 81-90 分', '<p class=\"MsoNormal\">\r\n	<span>托福在线</span>95-100+ <span>提高课程是大外在线托福教研团队根据多年经验推出的托福培训课程，由</span><span>40</span><span>小时国内名师方法课</span><span>+60</span><span>小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>托福在线</span>95-100+ <span>提高课面向具备托福考试需要熟练掌握的 </span><span>7500 </span><span>词汇，语法知识完备；过往托福考试成绩 </span><span>81-90 </span><span>分的学员。</span>\r\n</p>', '充分认识并理解托福高分标准；<br />\r\n熟练掌握完备的托福词汇知识和语法知识；<br />\r\n精准应用各科高分技巧；<br />\r\n提高英语知识以外的学术能力水平。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('5', '53', '托福在线 “四对一”快速通关课程', '0', '充分认识并理解托福考试规则和分数段要求', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', null, '0', '40', '仅需要了解考试内容及形式，并掌握应试技巧的同学。', '<p class=\"MsoNormal\">\r\n	<span>托福在线</span>“四对一”快速通关课程是大外在线托福教研团队根据多年经验推出的托福培训课程，由<span>40</span><span>小时国内名师方法课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>托福在线</span>“四对一”快速通关课主要面向仅需要了解考试内容及形式，并掌握应试技巧的同学。\r\n</p>', '充分认识并理解托福考试规则和分数段要求；<br />\r\n掌握正确的英语能力提升方法；<br />\r\n熟练把握托福各科的题型特征和答题技巧。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('6', '54', '托福在线VIP单科 1v1', '0', '口语，听力，阅读，写作四科 单科起报（四门最多）', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', '2', '0', '0', '需要短期内快速提高托福单科成绩的同学。', '                <p class=\"MsoNormal\">\r\n	<span>托福在线</span>VIP<span>单科</span>1v1<span>是大外在线托福教研团队根据多年经验推出的托福培训课程，由国内名师主讲，单科起报。改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。</span> \r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>托福在线</span>VIP<span>单科</span><span>1v1</span><span>主要面向仅需要短期内快速提高托福思单科成绩的同学。</span>\r\n</p>            ', '                <p>\r\n	口语，听力，阅读，写作四科<br />\r\n单科起报（四门最多）<br />\r\n线上40h课程中的单科内容，<br />\r\n老师1对1针对学生痛点来解决问题，<br />\r\n课上学生有问题及时反馈解决。\r\n</p>            ', '0', '独家内部纸质版讲义', ',4,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('7', '55', '托福在线VIP全科 1v1', '0', '线上40h课程中的单科内容， 老师1对1针对学生痛点来解决问题', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,12', '2', '0', '40', '需要短期内快速提高托福全科成绩的同学。', '                                <p class=\"MsoNormal\">\r\n	<span>托福在线</span>VIP<span>全科</span><span>1v1</span><span>是大外在线托福教研团队根据多年经验推出的托福培训课程，由国内名师主讲的全科方法课。改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>托福在线</span>VIP<span>单科</span><span>1v1</span><span>主要面向需要短期内快速提高托福全科成绩的同学。</span>\r\n</p>                        ', '                                <p>\r\n	口语，听力，阅读，写作四科<br />\r\n四门必报<br />\r\n线上40h课程中的单科内容，<br />\r\n老师1对1针对学生痛点来解决问题，<br />\r\n课上学生有问题及时反馈解决。<br />\r\n</p>                        ', '0', '独家内部纸质版讲义', ',4,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('8', '61', '托福词汇加强课 （6000+词汇基础班）', '0', '认知词汇+高级学术词汇', '0', '0', '3,,5,,,,9,10,11,', '1,12', '1', '0', '20', '需要提高词汇量的同学，词汇量达到8500+ ', '                                <p class=\"MsoNormal\">\r\n	<span>录播词汇加强课是针对以上各门课程的辅课，俗话说</span>“无砖，楼难砌，无词，言无力”大外托福在线团队根据学生同学此项痛点，精心锻造此项课程。学生根据自身水平，有三项类别可选，囊扩考试所用的基础词汇加学术词汇，为你屠雅事半功倍。\r\n</p>                        ', '                                认知词汇+高级学术词汇<br />\r\n核心词汇的学习<br />\r\n成簇词的学习<br />\r\n词汇造句练习<br />                        ', '0', '独家内部纸质版讲义', ',4,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('9', '62', '产品定义及课前要求', '0', '从产品入门到精通的全方位学习课程  BAT资深产品总监亲身参与课程研发及教授 ', '0', '0', '3,4,5,,,8,,10,11,', '3,31', '2', '0', '60', '1、 社科、商业、计算机专业学生最低要求； 2、 想要成为产品经理和从事相关工作', '                                产品经理的前世今生<br />\r\n传统行业与产品经理的关系与区别<br />\r\n产品经理的工作职责、能力模型及产品思维（以某一线大厂内部考核体系为例）<br />\r\n产品经理典型任务、常用工具及文档规范<br />\r\n练习：规划你自己的产品经理发展路径<br />\r\n产品经理面试标准与方法<br />                        ', '                                从产品入门到精通的全方位学习课程 <br />\r\nBAT资深产品总监亲身参与课程研发及教授 <br />\r\n理论学习+实战演练 <br />\r\n洞察用户需求 · 修炼产品功力 · 打造极致用户体验<br />                        ', '0', '', ',,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('10', '28', ' 雅思在线提高班 （5.5分）', '0', '熟练掌握雅思基础词汇和必备语法知识，系统掌握高效的英语提升方法', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,11', '2,3', '0', '40', '', '                <p>\r\n	雅思在线提高班（5.5分）是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由40小时国内名师方法课+60小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n雅思在线提高班（5.5分）主要面向英语基础较为薄弱；过往雅思成绩低于5.5分的学员。<br />            ', '                <p>\r\n	口语：5-6分 听力：6分 阅读：6分 写作：5-6分                          \r\n</p>\r\n<p>\r\n	认识雅思考试评分原则和标准，并理解各分数段的达标条件；\r\n</p>\r\n<p>\r\n	熟练掌握雅思基础词汇和必备语法知识；\r\n</p>\r\n<p>\r\n	系统掌握高效的英语提升方法；\r\n</p>\r\n了解并熟练应用各科核心技巧。<br />            ', '0', '独家内部纸质版讲义', '3,4,5,6,,', '1', '1', null, '1', '2');
INSERT INTO `dw_course_lesson` VALUES ('11', '60', '雅思在线通关班 （6-6.5分）', '0', '熟练掌握雅思达标词汇并完善语法知识', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,11', '2,3', '0', '40', '熟练掌握4000+词汇，语法知识完备；过往雅思成绩不低于5.5分。', '                                <p class=\"MsoNormal\">\r\n	雅思在线通关班（<span>6-6.5</span>分）是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由<span>40</span>小时国内名师方法课<span>+60</span>小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	雅思在线通关班（<span>6-6.5</span>分）主要面向熟练掌握<span>4000+</span>词汇，语法知识完备；过往雅思成绩不低于<span>5.5</span>分的学员。<span></span>\r\n</p>                        ', '                                <p>\r\n	充分认识目标分数与自身能力之间的差距；\r\n</p>\r\n<p>\r\n	熟练掌握雅思达标词汇并完善语法知识；\r\n</p>\r\n<p>\r\n	熟练掌握高效的英语提升方法；\r\n</p>\r\n了解并熟练应用各科高分技巧。<br />                        ', '0', '独家纸质版讲义', '3,4,5,6,,', '1', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('12', '37', 'N1考前冲刺辅导班', '0', '熟练掌握N1核心词汇和必备文法知识；系统掌握高效的日语N1提升方法', '0', '0', '3,4,5,,,,,10,11,12', '2,21', '1,2', '0', '170', '具有日语N2级水平，打算备战能力考N1级的学员。', '                本课程是专门为有N2的日语基础，并且想快速达到N1水平学员开设的考前冲刺精品课！课程从词汇、语法、听力、阅读四大方面进行考级解析，及专项高分的解题技巧，由授课经验丰富的老师，带你高效解决日语N1难题。            ', '                1.掌握8000-10000单词，200条中高级语法；<br />\r\n2.提高词汇、文法、会话阅读、听力等日语技能；<br />\r\n3.顺利通过N1能力考试或JTEST等其他考试；<br />\r\n4.应对日语能力考N1级，达到高级日语水平。<br />            ', '0', '电子版讲义', ',,,,7,8', '1', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('13', '38', '雅思在线拔高班 （7分+）', '0', '熟练掌握雅思基础词汇和必备语法知识', '0', '0', '3,4,5,6,7,8,9,10,11', '1,11', '2,3', '0', '40', '熟练掌握5000+词http://dufl.jiemo.net/admin.php/course/lesson/index.html汇，语法知识完备；过往雅思成绩不低于6分。', '<p class=\"MsoNormal\">\r\n	<span>雅思在线拔高班（</span>7<span>分</span><span>+</span><span>）是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由</span><span>40</span><span>小时国内名师方法课</span><span>+60</span><span>小时线下能力提高课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>雅思在线拔高班（</span>7<span>分</span><span>+</span><span>）主要面向熟练掌握</span><span>5000+</span><span>词汇，语法知识完备；过往雅思成绩不低于</span><span>6</span><span>分的学员。</span>\r\n</p>', '充分认识并理解雅思高分标准；<br />\r\n熟练掌握完备的雅思词汇知识和语法知识；<br />\r\n精准应用各科高分技巧；<br />\r\n提高英语知识以外的学术能力水平。<br />', '0', '独家内部纸质版讲义', '3,4,5,6', '1', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('14', '29', '雅思在线方法强化班 （四合一）', '0', '熟练把握雅思各科的题型特征和答题技巧。', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,11', '2,3', '0', '40', '仅需要了解考试内容及形式，并掌握应试技巧的同学。', '<p class=\"MsoNormal\">\r\n	<span>雅思在线方法强化班（四合一）是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由</span>40<span>小时国内名师方法课组成，改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	雅思在线方法强化班（四合一）主要面向仅需要了解考试内容及形式，并掌握应试技巧的同学。\r\n</p>', '充分认识并理解雅思考试规则和分数段要求；<br />\r\n掌握正确的英语能力提升方法；<br />\r\n熟练把握雅思各科的题型特征和答题技巧。<br />', '0', '充分认识并理解雅思考试规则和分数段要求； 掌握正确的英语能力提升方法； 熟练把握雅思各科的题型特征和答题技巧。', '3,4,5,6,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('15', '41', '零基础N1直达班', '0', '熟练掌握N1核心词汇和必备文法知识；系统掌握高效的日语N1提升方法', '0', '0', '3,4,5,,,,,10,11,12', '2,21', '1,2', '0', '510', '1、日语零基础或稍有基础，想要系统学习日语的同学； 2、希望顺利通过N1考试的同学； 3、爱好日语、喜欢动漫、日剧、日本音乐，想独立看懂、听懂日语的同学； 4、想去日本旅游、留学、工作，希望可以用日语交流沟通的同学； 5、想进入日企工作，或者已经在日企希望通过提高日语水平获得升职加薪的同学； 6、具备一定日语基础，不准备考试但是希望日语综合能力进一步提高的同学。', '本课程是专门为零日语基础，并且想快速达到N1水平学员开设直达班！课程从词汇、语法、听力、阅读四大方面进行考级解析，及专项高分的解题技巧，由授课经验丰富的老师，带你高效全面提升日语能力。', '1、提升日语综合能力，听说读写能力得到全面提升，零基础直达日语高级水平；<br />\r\n2、掌握8000-10000单词，800条语法，能够熟练使用日语，具备N1应试技巧，顺利通过日语能力考试N1级别；<br />\r\n3、对日本文化的认识和理解更加深入，适应赴日旅行和留学的需要；<br />\r\n4、学完之后具备学习JTEST（A-D）或日语口译笔译课程的基础。<br />', '0', '电子版讲义', ',,,,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('16', '42', '雅思在线VIP单科 1v1', '0', '口语，听力，阅读，写作四科 单科起报（四门最多）', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,11', '2', '0', '0', '需要短期内快速提高雅思单科成绩的同学。', '<p class=\"MsoNormal\">\r\n	<span>雅思在线</span>VIP<span>单科</span><span>1v1</span><span>是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由国内名师主讲，单科起报。改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>雅思在线</span>VIP<span>单科</span><span>1v1</span><span>主要面向仅需要短期内快速提高雅思单科成绩的同学。</span>\r\n</p>', '口语，听力，阅读，写作四科<br />\r\n单科起报（四门最多）<br />\r\n线上40h课程中的单科内容，<br />\r\n老师1对1针对学生痛点来解决问题，<br />\r\n课上学生有问题及时反馈解决。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,8', '0', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('17', '43', 'N2考前冲刺辅导班', '0', '熟练掌握N2核心词汇和必备文法知识；系统掌握高效的日语N2提升方法；', '0', '0', '3,4,5,,,,,10,11,12', '2,22', '1,2', '1', '101', '（1） 具备日语国际能力考试N3水平或相当于N3水平的学员。 （2） 完成新标准日本语中级（上）学习的学员。 （3） 希望了解N2考试题型、考试技巧、以及考试准备和复习计划的学员。 （4） 有去日企工作或到日本定居、留学打算和计划的学员', '本课程是专门为有一定的日语基础，并且想快速达到N2水平学员开设的考前冲刺精品课！课程从词汇、语法、听力、阅读四大方面进行考级解析，及专项高分的解题技巧，由授课经验丰富的老师，带你高效解决日语N2难题。', '（1）词汇：全面精讲N2核心词汇，答题技巧及窍门，以及多种发音特征，边学边练、稳固扎实。<br />\r\n（2）语法：全解析N2文法200、N3文法语法考点，特定的考级文法突破秘诀，综合提高N2应试与应用能力全面、系统的进行讲解，以点带面全方位复习巩固。<br />\r\n（3）听力：教授答题技巧，结合真题、模拟题，各个类型题逐个击破！<br />\r\n（4）阅读：在阅读考试文章中，培养日式思维，纠正历年考试中的常见错误思维，避免进入误区，并传授解题技巧与应试对策，快速，精准！<br />', '0', '电子版讲义', ',,,,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('18', '44', '雅思在线VIP全科 1v1', '0', '线上40h课程中的单科内容， 老师1对1针对学生痛点来解决问题', '0', '0', '3,4,5,6,7,8,9,10,11,', '1,11', '2', '0', '40', '需要短期内快速提高雅思全科成绩的同学。', '<p class=\"MsoNormal\">\r\n	<span>雅思在线</span>VIP<span>全科</span><span>1v1</span><span>是大外在线雅思教研团队根据多年经验推出的雅思培训课程，由国内名师主讲的全科方法课。改变了以往单纯学习应试技巧，不管能力是否提高的培训模式，真正做到先提能力再提分数。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>雅思在线</span>VIP<span>单科</span><span>1v1</span><span>主要面向需要短期内快速提高雅思全科成绩的同学。</span>\r\n</p>', '口语，听力，阅读，写作四科<br />\r\n四门必报<br />\r\n线上40h课程中的单科内容，<br />\r\n老师1对1针对学生痛点来解决问题，<br />\r\n课上学生有问题及时反馈解决。<br />', '0', '独家内部纸质版讲义', '3,4,5,6,7,', '0', '1', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('19', '45', '零基础N2直达班', '0', '零基础至N2水平一步到位，帮助提高听说读写能力全面提升', '0', '0', '3,4,5,,,,,10,11,12', '2,22', '1,2', '1', '340', '1. 日语零基础，想要系统学习日语的同学； 2. 希望顺利通过考试的同学； 3. 爱好日语、喜欢动漫、日剧、日本音乐的同学； 4. 想去日本旅游、留学、工作，希望可以用日语交流的同学； 5. 想进入日企工作，或者已经在日企希望通过提高日语水平获得升职加薪的同学。', '本课程是专门为零日语基础，并且想快速达到N2水平学员开设直达班！课程从词汇、语法、听力、阅读四大方面进行考级解析，及专项高分的解题技巧，由授课经验丰富的老师，带你高效全面提升日语能力。', '1. 提升日语综合能力，听说读写能力得到全面提升，从零基础直达日语中级水平；<br />\r\n2. 掌握4000-7000单词，200条中级语法，能够熟练使用日语进行交流，具备N2应试技巧，顺利通过日语能力考试新二级、JTEST等其他考试；<br />\r\n3. 加深对日本文化的了解，适应出国旅游、留学等需要。<br />', '0', '电子版讲义+纸质版教辅材料', ',,,,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('20', '46', '考研日语强化班', '0', '分项精讲，紧扣真题，提高备考效率，提升考试成绩', '0', '0', '3,4,5,,,,,10,11,12', '2,23', '1,2', '1', '90', '1、准备参考203公共日语全国统一考试的考生； 2、准备参加二外考研日语自主出题考试的考生； 3、进行一定程度的考研备考复习，但心理没底的考试，想通过强化进一步提高的学生； 4、学完日语中级，如标日中级，新编日语第四册，具有日本语能力测试N2级水平的学生', '<p>\r\n	该课程结合历年考试的要求，对考点进行提炼分类和汇总。全面梳理日语中高级语法体系；对精选的历年考题的讲解和练习，归纳考研日语必备的词汇和句型；传授解题技巧，提高日语阅读能力，并具备日语文章书写及日汉长句互译能力。&nbsp;\r\n</p>\r\n系统的复习、指导和练习，使学员日语成绩在原有基础上大程度地获得提高，达到或超出考研日语的要求，同时提升日语的综合能力。\"<br />', '<p>\r\n	1、强化语法、阅读、写作等方面的技能；\r\n</p>\r\n<p>\r\n	2、以真题为准绳，熟悉考试题型，掌握考试技巧；\r\n</p>\r\n3、掌握考研公共日语考试必备知识，顺利通过考研日语考试。<br />', '0', '电子版讲义', ',,,,7,8', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('21', '68', '大外在线法语零基础兴趣班（0-A1）', '0', '课程从发音入门开始，逐步学习日常交流技巧，初步理解法语文字、掌握基本礼节用语、基本句型及1500个左右词汇。', '0', '0', '3,4,5,,,,,10,11,', '5,51', '2,3', '0', '120', '1、 对法语有兴趣的业余爱好者 2、 有意将法语作为第二外语的学员 3、 偶尔在生活或工作中使用法语人群 4、计划到法语区旅游的学员', '                <p class=\"MsoNormal\">\r\n	<span>课程从发音入门开始，逐步学习日常交流技巧，初步理解</span><span>法语</span><span>文字、掌握基本礼节用语、基本句型及</span>1500<span>个左右词汇</span><span>。</span><span>能够</span><span>实操日常交流使用</span><span>频率较高的惯用语。能够阅读简单的文章，进行简单的会话交流</span><span>。</span><span>以家庭，学校，购物，住房，文化，体育等实际生活场景为主要内容，全面培养听力理解和会话表达能力，并融会贯通相关的语法内容，能根据具体的场景，礼貌地表达自己的思想。</span>\r\n</p>            ', '                <p class=\"MsoNormal\">\r\n	1<span>、</span><span>掌握</span><span>约</span>600<span>个单词及</span><span>一些基本的句法</span><span>、</span><span>语法及</span><span>日常的口语表达</span><span>，</span><span>并达到法语</span>A1<span>的水平；</span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	2<span>、</span><span>能介绍自己及他人并能针对个人背景资料，例如住在哪里、认识的人、以及拥有的事物等主题做出问答</span>；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	3<span>、</span><span>能在</span><span>对方说话速度语速缓慢、用词清晰并随时提供协助的前提下，做简单的互动与交流</span>；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	4<span>、</span><span>能理解并使用熟悉的日常表达法、基本词汇以求满足具体的需求。</span>\r\n</p>            ', '0', '', ',,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('22', '69', '大外在线法语留学强化班（0-B2）', '0', '课程从发音入门开始，从听说读写四方面，由浅入深学习法语语法', '0', '0', '3,4,5,,,,,10,11,', '5,51', '2', '0', '270', '1、 社科、商业专业学生最低要求 2、 在法从事一般类型工作的务工人员 3、想考取法语B2等级的学员', '                <p class=\"MsoNormal\">\r\n	<span>课程从发音入门开始，</span><span>从听说读写四方面，由浅入深学习法语语法，学习运用法语的词法，现在、过去、将来等</span>16<span>种时态及</span><span>5</span><span>大语态；通过课文学习</span><span>能够阅读</span><span>各类专业</span><span>文章</span><span>；</span><span>通过听力和口语练习，听懂生活和学术词汇，并</span><span>进行</span><span>熟练</span><span>的</span><span>生活和学术</span><span>会话交流</span><span>；</span><span>能够书写专业的文章及论文。</span>\r\n</p>            ', '                <p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	1、<span>能达到</span>7000-8000<span>的词汇量；</span>\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	2、扎实地掌握法语语法，能理解复杂文章的关键内容；\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	3<span>、</span>能听懂较长的报告会和演讲。\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	4<span>、能用熟练的口语表达自己的观点并阐述论据</span>，<span>与以</span>法语<span>为母语</span>者<span>做互动时保持一定流畅度</span>\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	5<span>、</span><span>能针对广泛的主题拟写清楚详细的文章，并能针对各种题目进行讨论，分析利弊。</span>\r\n</p>            ', '0', '', ',,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('23', '70', '大外在线法语留学全程班（0-B2）', '0', '法语入门、中级提高、听力专项训练、口语专项训练、应试训练、面试解决方案等六大模块', '0', '0', '3,4,5,,,,,10,11,', '5,51', '2,3', '0', '500', '1、 社科、商业专业学生最低要求； 2、 在法从事一般类型工作的务工人员。 3、想考取法语B2等级者', '                <p class=\"MsoNormal\">\r\n	<span>法语入门、中级提高、听力专项训练、口语专项训练、应试训练、面试解决方案等六大模块；由多年致力法语留学考试（</span>TCF/TEF/CELA<span>）的中、外教共同担纲，采用中、法文双轨教材制度，为每一位有意愿留学法语国家的学员奉上全方位的语言能力养成方案</span><span>,</span><span>务求在有限的学习时间之内，实现语言能力与考试成绩双达标。</span>\r\n</p>            ', '                <p class=\"MsoNormal\" align=\"justify\" style=\"text-align:justify;\">\r\n	1<span>、</span><span>能达到</span>7000-8000<span>的词汇量；</span>\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"text-align:justify;\">\r\n	2<span>、</span>扎实地掌握法语语法，能理解复杂文章的关键内容；\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	3<span>、</span>能听懂较长的报告会和演讲。\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	4<span>、能用熟练的口语表达自己的观点并阐述论据</span>，<span>与以</span>法语<span>为母语</span>者<span>做互动时保持一定流畅度</span>\r\n</p>\r\n<p class=\"MsoNormal\" align=\"justify\" style=\"margin-left:0.0000pt;text-indent:0.0000pt;text-align:justify;\">\r\n	5<span>、</span><span>能针对广泛的主题拟写清楚详细的文章，并能针对各种题目进行讨论，分析利弊。</span>\r\n</p>            ', '0', '', ',,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('24', '63', 'Axure基础教程', '0', 'Axure是一款制作交互原型的软件，用它可以制作网页原型，手机App原型。这本教程从0开始，教大家制作一个非常完整，交互内容非常丰富的网页原型。', '0', '0', null, ',', null, '0', '60', '网页/APP设计、产品经理教程', '                Axure是一款制作交互原型的软件，用它可以制作网页原型，手机App原型。这本教程从0开始，教大家制作一个非常完整，交互内容非常丰富的网页原型。学完本教程，基本就能吃透这款软件，自己就能举一反三，制作各式各样地原型了。            ', '                学习Axure RP非常必要。而秒秒学推出的《交互原型设计：Axure RP》绝对是你学习Axure RP 的启蒙教程。这门教程，将用11个章节对Axure软件进行系统、全面的学习。而全新的交互式软件培训功能，能模拟Axure软件互动操作，理论+实战双结合，让您轻松享受交互式学习的乐趣。现在就让我们一起打开《交互原型设计：Axure RP》，迈入界面与交互设计的大门吧！            ', '0', '', null, '0', '0', null, '1', '4');
INSERT INTO `dw_course_lesson` VALUES ('25', '64', 'Xmind基础教程', '0', 'XMind作为国内使用广泛的思维导图软件，拥有强大的功能、优秀的用户体验和操作简单的特点，正在为200万用户提供更高的生产力及创造力。', '0', '0', '3,4,5,,,8,,10,11,', '3,31', '2', '0', '80', '1.互联网从业者 2.追求高效工作方式', '                思维导图被广泛应用在学习还有办公领域，它所呈现的是每个人不同的思维体系，每个人对同一件事情都有着不一样的看法。思维导图就能将你想事情的过程非常清晰的展现在你面前。<br />\r\n<div>\r\n	<br />\r\n</div>            ', '                头脑风暴是一个产生创意的好方法。XMind的头脑风暴模式主要由两部分组成：全屏的编辑器和计时器。<br />\r\n全屏编辑器同时还拥有全部的编辑功能，虽然没有菜单和工具栏，我们可以使用快捷键+右键菜单来添加联系、外框、概要、标签、图标等等可视化信息。<br />\r\n计时器使用得当可以很好的帮助我们提高工作效率，思想的火花跳跃不停。<br />            ', '0', '', ',,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('26', '65', '墨刀基础教程', '0', '墨刀是一个原型设计工具，可以快速构建移动应用原型与线框图，支持云端保存和实时手机预览。', '0', '0', null, ',', null, '0', '60', '产品新人，交互设计师', '                墨刀是一个原型设计工具，可以快速构建移动应用原型与线框图，支持云端保存和实时手机预览。今天主要是做一个墨刀的基础使用教程，就不重点介绍和对比各原型工具的优缺点了（有空的话我会单独做一篇原型工具的对比分析）。希望这篇教程可以帮助墨刀的初学者快速上手该软件。            ', '                “墨刀”总的来说操作是非常方便的，如果有其他的原型工具基础，用起来可能更好上手。本身支持手机预览功能，更加方便于移动产品的创建和展示。本人也推荐app的产品或设计师使用墨刀来快速创建原型，可以加快自己的制作和展现的时间。            ', '0', '', null, '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('27', '66', '大学英语四级考试强化课程', '0', '大学英语四级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的四级应试技巧强化课程。', '0', '0', '3,4,5,,7,8,9,10,11,', '4,41', '1,2', '0', '16', '报名参加大学英语四/六级考试的大学生', '                <p class=\"MsoNormal\">\r\n	<span>大学英语四级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的四级应试技巧强化课程。该课程由拥有多年英语四</span><span>级考试培训经验的一线教师担纲，通过在线视频直播或录播的形式让学生能够随时随地了解并掌握英语四</span><span>考试的规则和技巧，从而迅速大幅度提升考试通过概率。 </span>\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	<span>需要特别指出的是，为了能够保障课程效果，在课程开始学习课程之前，四级学生应当熟练掌握高中程度的英语词汇量（</span>3500<span>）</span>\r\n</p>            ', '                <p class=\"MsoNormal\">\r\n	了解大学英语四级考试规则和考试形式；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握正确的英语听力训练方法；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	提高英语快速阅读能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握三类体裁的作文写作能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	熟练掌握和应用英语高级语法和词汇；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握快速解题技巧。\r\n</p>            ', '0', '独家内部纸质版讲义', ',4,,,,', '0', '0', null, '1', '0');
INSERT INTO `dw_course_lesson` VALUES ('28', '67', '大学英语六级考试强化课程', '0', '大学英语六级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的六级应试技巧强化课程。', '0', '0', '3,4,5,,7,8,9,10,11,', '4,42', '1,2', '0', '16', '报名参加大学英语六级考试的大学生', '大学英语六级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的六级应试技巧强化课程。该课程由拥有多年英语六级考试培训经验的一线教师担纲，通过在线视频直播或录播的形式让学生能够随时随地了解并掌握英语六考试的规则和技巧，从而迅速大幅度提升考试通过概率。 <br />\r\n需要特别指出的是，为了能够保障课程效果，在课程开始学习课程之前，六级学生应当熟练掌握四级程度的英语词汇量（4500）<br />', '<p class=\"MsoNormal\">\r\n	了解大学英语六级考试规则和考试形式；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握正确的英语听力训练方法；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	提高英语快速阅读能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握三类体裁的作文写作能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	熟练掌握和应用英语高级语法和词汇；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握快速解题技巧。\r\n</p>', '0', '', ',4,,,,', '0', '0', null, '1', '2');
INSERT INTO `dw_course_lesson` VALUES ('29', '67', '大学英语六级考试词汇强化课程', '0', '大学英语六级考试词汇强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的六级词汇应试技巧强化课程。', '0', '0', '3,4,5,,7,8,9,10,11,', '4,42', '1,2', '0', '60', '报名参加大学英语六级考试的大学生', '<span>大学英语六级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的六级应试技巧词汇强化课程。</span><br />\r\n<span>需要特别指出的是，为了能够保障课程效果，在课程开始学习课程之前，六级学生应当熟练掌握四级程度的英语词汇量（4500）</span>', '<p class=\"MsoNormal\">\r\n	了解大学英语六级考试规则和考试形式；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握正确的英语听力训练方法；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	提高英语快速阅读能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握三类体裁的作文写作能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	熟练掌握和应用英语高级语法和词汇；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握快速解题技巧。\r\n</p>', '0', '', ',4,,,,', '0', '0', null, '1', '1');
INSERT INTO `dw_course_lesson` VALUES ('30', '66', '大学英语四级考试词汇强化课程', '0', '大学英语四级考试词汇强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的四级词汇应试技巧强化课程。', '0', '0', '3,4,5,,7,8,9,10,11,', '4,41', '1,2', '0', '60', '报名参加大学英语四级考试的大学生', '<span>大学英语四级考试强化课程是大外在线雅思教研团队根据多年经验推出的短期有针对性的四级应试技巧词汇强化课程。</span><br />\r\n<span>需要特别指出的是，为了能够保障课程效果，在课程开始学习课程之前，<span>四级学生应当熟练掌握高中程度的英语词汇量（</span><span>3500</span><span>）</span></span>', '<p class=\"MsoNormal\">\r\n	了解大学英语四级考试规则和考试形式；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握正确的英语听力训练方法；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	提高英语快速阅读能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握三类体裁的作文写作能力；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	熟练掌握和应用英语高级语法和词汇；\r\n</p>\r\n<p class=\"MsoNormal\">\r\n	掌握快速解题技巧。\r\n</p>', '0', '', ',4,,,,', '0', '1', null, '1', '3');

-- ----------------------------
-- Table structure for dw_course_lesson_schedule
-- ----------------------------
DROP TABLE IF EXISTS `dw_course_lesson_schedule`;
CREATE TABLE `dw_course_lesson_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) DEFAULT '0' COMMENT '课程id',
  `category` tinyint(2) DEFAULT '0' COMMENT '课程安排类型,2线上课程，3线下课程',
  `pid` int(11) DEFAULT '0' COMMENT '父id',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `teacher` varchar(40) DEFAULT NULL COMMENT '老师',
  `hour` varchar(20) DEFAULT NULL COMMENT '课时',
  `study_time` varchar(80) DEFAULT NULL COMMENT '建议时长',
  `sort` int(3) DEFAULT NULL,
  `status` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=557 DEFAULT CHARSET=utf8 COMMENT='课程安排';

-- ----------------------------
-- Records of dw_course_lesson_schedule
-- ----------------------------
INSERT INTO `dw_course_lesson_schedule` VALUES ('4', '7', '2', '0', '下线录播1', null, '100', '3-8', null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('5', '7', '2', '4', '下线录播1子分类1', null, null, '', null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('6', '7', '2', '4', '下线录播1子分类2', null, null, '', null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('17', '10', '2', '0', '雅思听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('18', '10', '2', '17', '听力技巧应用解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('19', '10', '2', '17', '高效听力训练法', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('26', '17', '2', '0', '文法、词汇', null, '45', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('27', '17', '2', '26', '（1）词汇题型分类和出题倾向', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('28', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('29', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('30', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('31', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('32', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('33', '17', '2', '26', '（7）句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('34', '17', '2', '0', '听力专项', null, '17', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('35', '17', '2', '34', '（3）听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('36', '17', '2', '34', '（3）听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('37', '17', '2', '34', '（3）听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('38', '17', '2', '0', '读解/文法专项', null, '17', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('39', '17', '2', '38', '（1）高频接续词 副词精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('40', '17', '2', '38', '（3）解构长难句', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('41', '17', '2', '38', '（3）解构长难句', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('42', '17', '2', '0', '真题讲解', null, '21', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('43', '17', '2', '42', '（4）读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('44', '17', '2', '42', '（4）读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('45', '17', '2', '42', '（4）读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('46', '17', '2', '42', '（4）读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('47', '19', '2', '0', '五十音', null, '13', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('48', '19', '2', '47', '熟悉日语基本的发音规则', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('49', '19', '2', '47', '熟悉日语基本的发音规则', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('50', '19', '2', '0', '标日初级', null, '110', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('51', '19', '2', '50', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('52', '19', '2', '50', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('53', '19', '2', '50', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('54', '19', '2', '0', '标日中级', null, '115', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('55', '19', '2', '54', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('56', '19', '2', '54', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('57', '19', '2', '54', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('58', '19', '2', '0', '冲刺阶段', null, '101', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('59', '19', '2', '58', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('60', '19', '2', '58', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('61', '19', '2', '58', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('62', '19', '2', '58', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('63', '20', '2', '0', '备考专项', null, '60', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('64', '20', '2', '63', '分项精讲，从考研的知识点梳理到知识点强化运用，掌握解题技巧，提升应试能力从容应对考试', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('65', '20', '2', '0', '考研真题', null, '30', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('66', '20', '2', '65', '熟悉考试题型，抓住解题要点，掌握考试技巧，查漏补缺，提高综合运用能力及考研日语的应试能力', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('67', '12', '2', '0', '标高上', null, '48', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('68', '12', '2', '67', '帮助全面提高理解、阅读、写作等技能', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('69', '12', '2', '67', '帮助全面提高理解、阅读、写作等技能', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('70', '12', '2', '0', '文法、词汇', null, '43', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('71', '12', '2', '70', '句子结构分析1', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('72', '12', '2', '70', '句子结构分析2', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('73', '12', '2', '70', '句子结构分析3', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('74', '12', '2', '70', '句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('75', '12', '2', '70', '句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('76', '12', '2', '70', '句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('77', '12', '2', '70', '句子结构分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('78', '12', '2', '0', '听力专项', null, '20', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('79', '12', '2', '78', '听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('80', '12', '2', '78', '听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('81', '12', '2', '78', '听力单项解题技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('82', '12', '2', '0', '读解/文法专项', null, '16', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('83', '12', '2', '82', '解构长难句', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('84', '12', '2', '82', '解构长难句', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('85', '12', '2', '82', '解构长难句', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('86', '12', '2', '0', '真题讲解', null, '43', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('87', '12', '2', '86', '历年高频词汇讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('88', '12', '2', '86', '读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('89', '12', '2', '86', '读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('90', '12', '2', '86', '读解 文法强化训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('91', '15', '2', '0', '五十音', null, '13', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('92', '15', '2', '91', '熟悉日语基本的发音规则', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('93', '15', '2', '91', '熟悉日语基本的发音规则', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('94', '15', '2', '0', '标日初级', null, '110', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('95', '15', '2', '94', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('96', '15', '2', '94', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('97', '15', '2', '94', '帮助学员在学到更多实用日语的同时掌握考试技巧', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('98', '15', '2', '0', '标日中级', null, '115', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('99', '15', '2', '98', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('100', '15', '2', '98', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('101', '15', '2', '98', '达到新日语能力考N2考试水平', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('102', '15', '2', '0', 'N2阶段', null, '101', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('103', '15', '2', '102', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('104', '15', '2', '102', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('105', '15', '2', '102', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('106', '15', '2', '102', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('107', '15', '2', '0', '标日高上', null, '48', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('108', '15', '2', '107', '帮助全面提高理解、阅读、写作等技能', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('109', '15', '2', '107', '帮助全面提高理解、阅读、写作等技能', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('110', '15', '2', '0', 'N1冲刺阶段', null, '122', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('111', '15', '2', '110', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('112', '15', '2', '110', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('113', '15', '2', '110', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('114', '15', '2', '110', '真题讲解 ：历年真题讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('115', '10', '2', '17', '拼写、数字、单词填空精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('116', '10', '2', '17', '拼写、数字、单词填空精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('117', '10', '2', '17', '拼写、数字、单词填空精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('118', '10', '2', '0', '雅思阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('119', '10', '2', '118', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('120', '10', '2', '118', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('121', '10', '2', '118', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('122', '10', '2', '118', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('123', '10', '2', '0', '雅思写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('124', '10', '2', '123', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('125', '10', '2', '123', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('126', '10', '2', '123', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('127', '10', '2', '123', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('128', '10', '2', '0', '雅思口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('129', '10', '2', '128', 'Part1-Part2 真题库精解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('130', '10', '2', '128', 'Part1-Part2 真题库精解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('131', '10', '2', '128', 'Part1-Part2 真题库精解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('132', '10', '2', '0', '雅思口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('133', '10', '2', '0', '雅思听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('134', '10', '2', '0', '雅思阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('135', '10', '2', '0', '雅思写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('136', '10', '2', '132', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('137', '10', '2', '132', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('138', '10', '2', '132', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('139', '10', '2', '132', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('140', '10', '2', '133', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('141', '10', '2', '133', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('142', '10', '2', '133', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('143', '10', '2', '133', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('144', '10', '2', '133', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('145', '10', '2', '134', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('146', '10', '2', '134', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('147', '10', '2', '134', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('148', '10', '2', '134', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('149', '10', '2', '134', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('150', '10', '2', '135', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('151', '10', '2', '135', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('152', '10', '2', '135', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('153', '10', '2', '135', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('154', '10', '2', '135', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('155', '11', '2', '0', '雅思口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('156', '11', '2', '0', '雅思听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('157', '11', '2', '0', '雅思阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('158', '11', '2', '0', '雅思写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('159', '11', '2', '155', 'Part3 经典题目解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('160', '11', '2', '155', 'Part3 经典题目解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('161', '11', '2', '155', 'Part3 经典题目解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('162', '11', '2', '155', 'Part3 经典题目解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('163', '11', '2', '155', 'Part3 经典题目解析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('164', '11', '2', '156', '高效听力训练法', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('165', '11', '2', '156', '高效听力训练法', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('166', '11', '2', '156', '高效听力训练法', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('167', '11', '2', '156', '高效听力训练法', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('168', '11', '2', '157', '同义词替换，一词多义精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('169', '11', '2', '157', '同义词替换，一词多义精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('170', '11', '2', '157', '同义词替换，一词多义精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('171', '11', '2', '157', '同义词替换，一词多义精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('172', '11', '2', '158', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('173', '11', '2', '158', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('174', '11', '2', '158', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('175', '11', '2', '158', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('176', '11', '2', '0', '雅思口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('177', '11', '2', '0', '雅思听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('178', '11', '2', '0', '雅思阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('179', '11', '2', '0', '雅思写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('180', '11', '2', '176', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('181', '11', '2', '176', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('182', '11', '2', '176', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('183', '11', '2', '176', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('184', '11', '2', '177', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('185', '11', '2', '177', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('186', '11', '2', '177', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('187', '11', '2', '177', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('188', '11', '2', '177', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('189', '11', '2', '178', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('190', '11', '2', '178', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('191', '11', '2', '178', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('192', '11', '2', '178', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('193', '11', '2', '178', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('194', '11', '2', '179', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('195', '11', '2', '179', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('196', '11', '2', '179', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('197', '11', '2', '179', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('198', '11', '2', '179', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('199', '13', '2', '0', '雅思口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('200', '13', '2', '0', '雅思听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('201', '13', '2', '0', '雅思阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('202', '13', '2', '0', '雅思写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('203', '13', '2', '199', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('204', '13', '2', '199', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('205', '13', '2', '199', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('206', '13', '2', '199', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('207', '13', '2', '199', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('208', '13', '2', '200', '考生易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('209', '13', '2', '200', '考生易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('210', '13', '2', '200', '考生易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('211', '13', '2', '200', '考生易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('212', '13', '2', '201', '高阶英语同义结构替换以真题应用练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('213', '13', '2', '201', '高阶英语同义结构替换以真题应用练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('214', '13', '2', '201', '高阶英语同义结构替换以真题应用练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('215', '13', '2', '201', '高阶英语同义结构替换以真题应用练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('216', '13', '2', '202', '雅思写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('217', '13', '2', '202', '雅思写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('218', '13', '2', '202', '雅思写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('219', '13', '2', '202', '雅思写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('220', '13', '2', '0', '雅思口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('221', '13', '2', '220', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('222', '13', '2', '220', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('223', '13', '2', '220', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('224', '13', '2', '220', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('225', '13', '2', '0', '雅思听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('226', '13', '2', '225', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('227', '13', '2', '225', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('228', '13', '2', '225', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('229', '13', '2', '225', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('230', '13', '2', '225', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('231', '13', '2', '0', '雅思阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('232', '13', '2', '231', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('233', '13', '2', '231', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('234', '13', '2', '231', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('235', '13', '2', '231', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('236', '13', '2', '231', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('237', '13', '2', '0', '雅思写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('238', '13', '2', '237', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('239', '13', '2', '237', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('240', '13', '2', '237', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('241', '13', '2', '237', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('242', '13', '2', '237', '大作文分类素材讲解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('243', '14', '2', '0', '雅思口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('244', '14', '2', '243', '口语训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('245', '14', '2', '243', '口语训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('246', '14', '2', '243', '口语训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('247', '14', '2', '243', '口语训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('248', '14', '2', '0', '雅思听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('249', '14', '2', '248', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('250', '14', '2', '248', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('251', '14', '2', '248', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('252', '14', '2', '248', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('253', '14', '2', '0', '雅思阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('254', '14', '2', '253', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('255', '14', '2', '253', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('256', '14', '2', '253', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('257', '14', '2', '0', '雅思写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('258', '14', '2', '257', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('259', '14', '2', '257', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('260', '14', '2', '257', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('261', '16', '2', '0', '口语、听力、阅读、写作单科起报', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('262', '16', '2', '261', '老师1对1针对学生痛点来解决问题， 课上学生有问题及时反馈解决。', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('263', '18', '2', '0', '口语、听力、阅读、写作四科', null, '40', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('264', '18', '2', '263', '老师1对1针对学生痛点来解决问题， 课上学生有问题及时反馈解决。', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('269', '2', '2', '0', '托福口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('270', '2', '2', '269', '综合口语部分（Question3-6）训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('271', '2', '2', '269', '综合口语部分（Question3-6）训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('272', '2', '2', '269', '综合口语部分（Question3-6）训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('273', '2', '2', '269', '综合口语部分（Question3-6）训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('274', '2', '2', '0', '托福听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('275', '2', '2', '274', '三类八种题型解答训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('276', '2', '2', '274', '三类八种题型解答训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('277', '2', '2', '274', '三类八种题型解答训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('278', '2', '2', '274', '三类八种题型解答训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('279', '2', '2', '274', '三类八种题型解答训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('280', '2', '2', '0', '托福阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('281', '2', '2', '280', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('282', '2', '2', '280', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('283', '2', '2', '280', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('284', '2', '2', '280', '核心阅读词汇标记', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('285', '2', '2', '0', '托福写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('286', '2', '2', '285', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('287', '2', '2', '285', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('288', '2', '2', '285', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('289', '2', '2', '285', '复合结构写作训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('290', '2', '2', '0', '托福口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('291', '2', '2', '290', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('292', '2', '2', '290', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('293', '2', '2', '290', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('294', '2', '2', '290', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('295', '2', '2', '0', '托福听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('296', '2', '2', '295', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('297', '2', '2', '295', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('298', '2', '2', '295', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('299', '2', '2', '295', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('300', '2', '2', '295', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('301', '2', '2', '0', '托福阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('302', '2', '2', '301', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('303', '2', '2', '301', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('304', '2', '2', '301', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('305', '2', '2', '301', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('306', '2', '2', '301', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('307', '2', '2', '0', '托福写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('308', '2', '2', '307', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('309', '2', '2', '307', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('310', '2', '2', '307', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('311', '2', '2', '307', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('312', '2', '2', '307', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('313', '3', '2', '0', '托福口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('314', '3', '2', '313', '综合口语部分（Question3-6）训练与精练', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('315', '3', '2', '313', '综合口语部分（Question3-6）训练与精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('316', '3', '2', '313', '综合口语部分（Question3-6）训练与精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('317', '3', '2', '313', '综合口语部分（Question3-6）训练与精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('318', '3', '2', '313', '综合口语部分（Question3-6）训练与精练', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('319', '3', '2', '0', '托福听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('320', '3', '2', '319', '三类八种题型训练及精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('321', '3', '2', '319', '三类八种题型训练及精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('322', '3', '2', '319', '三类八种题型训练及精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('323', '3', '2', '319', '三类八种题型训练及精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('324', '3', '2', '319', '三类八种题型训练及精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('325', '3', '2', '0', '托福阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('326', '3', '2', '325', '学术词汇与复杂句式精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('327', '3', '2', '325', '学术词汇与复杂句式精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('328', '3', '2', '325', '学术词汇与复杂句式精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('329', '3', '2', '325', '学术词汇与复杂句式精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('330', '3', '2', '0', '托福写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('331', '3', '2', '330', '思路整合与逻辑架构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('332', '3', '2', '330', '思路整合与逻辑架构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('333', '3', '2', '330', '思路整合与逻辑架构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('334', '3', '2', '330', '思路整合与逻辑架构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('335', '3', '2', '330', '思路整合与逻辑架构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('336', '3', '2', '0', '托福口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('337', '3', '2', '336', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('338', '3', '2', '336', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('339', '3', '2', '336', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('340', '3', '2', '336', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('341', '3', '2', '0', '托福听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('342', '3', '2', '341', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('343', '3', '2', '341', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('344', '3', '2', '341', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('345', '3', '2', '341', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('346', '3', '2', '341', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('347', '3', '2', '0', '托福阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('348', '3', '2', '347', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('349', '3', '2', '347', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('350', '3', '2', '347', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('351', '3', '2', '347', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('352', '3', '2', '347', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('353', '3', '2', '0', '托福写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('354', '3', '2', '353', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('355', '3', '2', '353', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('356', '3', '2', '353', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('357', '3', '2', '353', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('358', '3', '2', '353', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('359', '4', '2', '0', '托福口语', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('360', '4', '2', '359', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('361', '4', '2', '359', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('362', '4', '2', '359', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('363', '4', '2', '359', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('364', '4', '2', '359', '思维及逻辑构建训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('365', '4', '2', '0', '托福听力', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('366', '4', '2', '365', '难题易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('367', '4', '2', '365', '难题易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('368', '4', '2', '365', '难题易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('369', '4', '2', '365', '难题易错题专项突破训练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('370', '4', '2', '0', '托福阅读', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('371', '4', '2', '370', '阅读关键难句梳理', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('372', '4', '2', '370', '阅读关键难句梳理', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('373', '4', '2', '370', '阅读关键难句梳理', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('374', '4', '2', '370', '阅读关键难句梳理', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('375', '4', '2', '0', '托福写作', null, '10', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('376', '4', '2', '375', '写作观点，构思及逻辑训练提升', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('377', '4', '2', '375', '写作观点，构思及逻辑训练提升', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('378', '4', '2', '375', '写作观点，构思及逻辑训练提升', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('379', '4', '2', '375', '写作观点，构思及逻辑训练提升', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('380', '4', '2', '0', '托福口语', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('381', '4', '2', '380', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('382', '4', '2', '380', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('383', '4', '2', '380', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('384', '4', '2', '380', '词汇短语素材集锦', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('385', '4', '2', '0', '托福听力', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('386', '4', '2', '385', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('387', '4', '2', '385', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('388', '4', '2', '385', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('389', '4', '2', '385', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('390', '4', '2', '385', '听力理解速记练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('391', '4', '2', '0', '托福阅读', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('392', '4', '2', '391', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('393', '4', '2', '391', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('394', '4', '2', '391', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('395', '4', '2', '391', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('396', '4', '2', '391', '真题模拟', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('397', '4', '2', '0', '托福写作', null, '15', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('398', '4', '2', '397', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('399', '4', '2', '397', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('400', '4', '2', '397', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('401', '4', '2', '397', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('402', '4', '2', '397', '真题精讲', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('403', '5', '2', '0', '托福口语', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('404', '5', '2', '403', '口语训练实操方法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('405', '5', '2', '403', '口语训练实操方法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('406', '5', '2', '403', '口语训练实操方法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('407', '5', '2', '403', '口语训练实操方法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('408', '5', '2', '0', '托福听力', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('409', '5', '2', '408', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('410', '5', '2', '408', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('411', '5', '2', '408', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('412', '5', '2', '408', '高效听力训练法介绍', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('413', '5', '2', '0', '托福阅读', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('414', '5', '2', '413', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('415', '5', '2', '413', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('416', '5', '2', '413', '同义词替换汇总及应用', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('417', '5', '2', '0', '托福写作', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('418', '5', '2', '417', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('419', '5', '2', '417', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('420', '5', '2', '417', '高分词汇及写作观点汇总与分析', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('421', '6', '2', '0', '口语，听力，阅读，写作单科起报', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('422', '6', '2', '421', '老师1对1针对学生痛点来解决问题， 课上学生有问题及时反馈解决', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('423', '7', '2', '0', '口语，听力，阅读，写作四科', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('424', '7', '2', '423', '老师1对1针对学生痛点来解决问题， 课上学生有问题及时反馈解决。', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('425', '8', '2', '0', '认知词汇+基础学术词汇', null, '20', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('426', '8', '2', '425', '词汇造句练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('427', '8', '2', '425', '词汇造句练习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('428', '8', '2', '425', '词汇造句练习', null, '20', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('433', '27', '2', '0', '写作', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('434', '27', '2', '433', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('435', '27', '2', '433', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('436', '27', '2', '433', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('437', '27', '2', '433', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('438', '27', '2', '0', '听力', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('439', '27', '2', '438', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('440', '27', '2', '438', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('441', '27', '2', '438', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('442', '27', '2', '0', '阅读', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('443', '27', '2', '442', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('444', '27', '2', '442', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('445', '27', '2', '442', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('446', '27', '2', '442', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('447', '27', '2', '0', '翻译', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('448', '27', '2', '447', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('449', '27', '2', '447', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('450', '27', '2', '447', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('451', '27', '2', '447', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('452', '28', '2', '0', '写作', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('453', '28', '2', '0', '听力', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('454', '28', '2', '0', '阅读', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('455', '28', '2', '0', '翻译', null, '4', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('456', '28', '2', '452', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('457', '28', '2', '452', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('458', '28', '2', '452', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('459', '28', '2', '452', '真题详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('460', '28', '2', '453', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('461', '28', '2', '453', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('462', '28', '2', '453', '听力应试技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('463', '28', '2', '454', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('464', '28', '2', '454', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('465', '28', '2', '454', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('466', '28', '2', '454', '解题技巧详解', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('467', '28', '2', '455', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('468', '28', '2', '455', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('469', '28', '2', '455', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('470', '28', '2', '455', '历年真题精练', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('471', '21', '2', '0', '导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('472', '21', '2', '471', '字母', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('473', '21', '2', '471', '语音+对话', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('474', '21', '2', '0', '语音训练及自然拼读U1', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('475', '21', '2', '0', '语音训练及自然拼读U2', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('476', '21', '2', '0', '语音训练及自然拼读U3', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('477', '21', '2', '0', '语音训练及自然拼读U4', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('478', '21', '2', '0', '主题词法学习U5', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('479', '22', '2', '0', 'A1', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('480', '22', '2', '479', '主题词法学习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('481', '22', '2', '479', '主题词法学习', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('482', '22', '2', '0', 'A2', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('483', '22', '2', '482', '语法专项', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('484', '22', '2', '0', 'B1', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('485', '22', '2', '0', 'B2', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('486', '22', '2', '485', '高级综合', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('487', '23', '2', '0', '导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('488', '23', '2', '487', '字母', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('489', '23', '2', '487', '语音+对话', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('490', '23', '2', '0', '语法专项', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('491', '23', '2', '0', '主题词法学习', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('492', '23', '2', '0', '语音训练及自然拼读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('493', '9', '2', '0', '产品导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('494', '9', '2', '493', '产品初识', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('495', '9', '2', '493', '产品结构', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('496', '9', '2', '0', '产品分类', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('497', '9', '2', '0', '产品入门', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('498', '24', '2', '0', 'Axure导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('499', '24', '2', '498', '初识Axure', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('500', '24', '2', '498', 'Axure界面', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('501', '24', '2', '0', 'Axure图标', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('502', '24', '2', '0', 'Axure交互', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('503', '25', '2', '0', 'Xmind导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('504', '25', '2', '503', 'Xmind初识', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('505', '25', '2', '503', 'Xmind导图', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('506', '25', '2', '0', 'Xmind进阶', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('507', '25', '2', '0', 'Xmind高阶', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('508', '26', '2', '0', '墨刀导读', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('509', '26', '2', '508', '墨刀初识', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('510', '26', '2', '508', '墨刀界面', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('511', '26', '2', '0', '墨刀应用', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('512', '26', '2', '0', '墨刀交互', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('513', '30', '2', '0', 'sfsdfs', null, '12', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('519', '1', '2', '0', '3', null, '66', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('520', '1', '2', '0', '6', null, '64', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('521', '1', '2', '0', '45', null, '5', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('522', '1', '2', '0', '465', null, '444', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('530', null, null, '519', '555', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('531', null, null, '519', '222', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('532', null, null, '519', '111', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('533', null, null, '519', '1', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('534', null, null, '519', '7', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('535', null, null, '519', '5', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('536', null, null, '519', '123', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('537', null, null, '520', '234', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('538', null, null, '520', '222', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('539', null, null, '520', '333', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('540', null, null, '521', '6', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('541', null, null, '521', '33', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('542', null, null, '521', '77', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('543', null, null, '522', '34534', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('544', null, null, '522', '111', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('553', '1', '2', '0', 'rrr', null, '3', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('554', '30', '2', '0', '', null, '0', null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('555', '0', '0', '554', '5555', null, null, null, null, null);
INSERT INTO `dw_course_lesson_schedule` VALUES ('556', '0', '0', '513', '3333', null, null, null, null, null);

-- ----------------------------
-- Table structure for dw_sign
-- ----------------------------
DROP TABLE IF EXISTS `dw_sign`;
CREATE TABLE `dw_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '称呼',
  `tel` varchar(20) DEFAULT NULL COMMENT '描述',
  `weixin` varchar(20) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL COMMENT '课程id',
  `lesson_title` varchar(255) DEFAULT NULL COMMENT '课程名称',
  `category_id` varchar(20) DEFAULT NULL COMMENT '课程分类',
  `category_title` varchar(255) DEFAULT NULL COMMENT '课程分类名称',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `remark_2` varchar(20) DEFAULT NULL COMMENT '备注2',
  `sort` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='学生报名';

-- ----------------------------
-- Records of dw_sign
-- ----------------------------
INSERT INTO `dw_sign` VALUES ('1', 'test1', null, null, null, null, null, null, null, null, '123441', '沟通中', '0', '0');
INSERT INTO `dw_sign` VALUES ('2', '222', null, null, null, null, null, null, null, null, '222222', null, '0', '0');
INSERT INTO `dw_sign` VALUES ('3', '23', '234234', '234', '234', '21', null, null, null, null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('4', 'dsa', 'asd', 'asd', 'asd', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('5', 'asd', '2145', 'dsa', 'das', '20', '考研日语强化班', '2,23', '日语课程,考研日语', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('6', 'asd', 'sadasdasd', 'asd', 'dsa', '4', '托福在线 95-100+ 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('7', 'dsadsa', 'sadasdsad', 'dasd', 'dasd', '3', '托福在线 81-95 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('8', 'dsadsa', '12', 'dsadsa', 'dssad', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('9', '123', '123123', '546', '456', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('10', '123', '1231', '546', '456', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('11', 'dsad', '11', 'asd', 'sda', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', null, null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('12', 'asdsa', '1', 'sda', 'sad', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', null, '1', null, '0', '0');
INSERT INTO `dw_sign` VALUES ('13', 'ZCXZC', '18840832357', 'ZXCXZC', 'ASDASD', '13', '雅思在线拔高班 （7分+）', '1,11', '留学英语,雅思', '1503482630', null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('14', 'sdfsdf', '15711477179', 'fdsf', 'fsdf', '19', '零基础N2直达班', '2,22', '日语课程,N2课程', '1503631617', null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('15', 'asfsdf', '15711477179', 'sdfsdfds', '', '2', ' 托福在线 60-80 提高课程', '1,12', '留学英语,托福', '1503631748', null, null, '0', '0');
INSERT INTO `dw_sign` VALUES ('16', 'fasdsadasf', '15711477179', 'sdfsdf', '', '12', 'N1考前冲刺辅导班', '2,21', '日语课程,N1课程', '1503632439', '6', null, '0', '0');

-- ----------------------------
-- Table structure for dw_teacher
-- ----------------------------
DROP TABLE IF EXISTS `dw_teacher`;
CREATE TABLE `dw_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `sort` int(3) DEFAULT '0' COMMENT '排序',
  `status` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='授课老师';

-- ----------------------------
-- Records of dw_teacher
-- ----------------------------
INSERT INTO `dw_teacher` VALUES ('1', 'test2', 'test21', '23', '0', '0');
INSERT INTO `dw_teacher` VALUES ('2', 'test3', 'asdasd', '26', '2', '0');
INSERT INTO `dw_teacher` VALUES ('3', '钱桂明', '雅思阅读 主讲师\r\nTESOL国际教师\r\n具备全球英语教学资格\r\n美国蓝思（LEXILE）认证\r\n高级阅读指导师\r\n10年雅思阅读教学经', '30', '0', '1');
INSERT INTO `dw_teacher` VALUES ('4', '孙涛', '雅思阅读 主讲师\r\nTESOL国际教师\r\n具备全球英语教学资格\r\n美国蓝思（LEXILE）认证\r\n高级阅读指导师\r\n10年雅思阅读教学经', '31', '0', '1');
INSERT INTO `dw_teacher` VALUES ('5', '张茂浚', '雅思听力 主讲师\r\n雅思听力9分\r\n北京外国语大学毕业\r\n前新东方资深听力讲师\r\n10年以上外语教学经验', '32', '0', '1');
INSERT INTO `dw_teacher` VALUES ('6', '卢雅桢', '雅思口语 主讲师\r\n英语专业八级\r\nTESOL国际教师资格认证\r\n具备全球英语教学资格\r\n美国蓝思（LEXILE）认证', '33', '0', '1');
INSERT INTO `dw_teacher` VALUES ('7', '智勇', '国内知名的日语教学专家  ，超8年的授课经验，多次命中能力考真题。\r\n留日海归，日语硕士 ，专业八级 ，与多家日系企业合作内训，经验丰富，（松下，三菱电机，通世泰，精工等）。\r\n超六年的N2，N1以及JTEST  A-D考前辅导。对考级试题的信息整理透彻，全面。', '39', '0', '1');
INSERT INTO `dw_teacher` VALUES ('8', '菲菲', '毕业于大连外国语大学。曾在某知名培训学校任职多年，有丰富的实体教学 经验。\r\n另外，于2016年获得某大型网校明星教师称号。擅长教授基础日语，N2.N1以及J-test的考前辅导。\r\n授课风格轻松诙谐,通俗易懂,用最脑洞大开的方式,让你快快乐乐学日语。\r\n考试轻轻松松能过关。用最简单的方法高效学习日语~！', '40', '0', '1');

-- ----------------------------
-- Table structure for dw_tel_code
-- ----------------------------
DROP TABLE IF EXISTS `dw_tel_code`;
CREATE TABLE `dw_tel_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(80) DEFAULT NULL COMMENT '手机号',
  `code` varchar(80) DEFAULT NULL COMMENT '验证码',
  `create_time` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='手机验证码';

-- ----------------------------
-- Records of dw_tel_code
-- ----------------------------
INSERT INTO `dw_tel_code` VALUES ('1', '15711477179', '123456', '1503474683', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('2', '15711477179', 'JOCO6A', '1503481038', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('3', '15711477179', 'KY25IX', '1503481069', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('4', '15711477179', 'NJ32CI', '1503482446', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('5', '18840832357', 'FLV02T', '1503482522', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('6', '18840832357', 'YS7C01', '1503482616', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('7', '18840832357', 'CDMQED', '1503482972', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('8', '15711477179', '2442', '1503631540', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('9', '15711477179', '8248', '1503631733', '127.0.0.1');
INSERT INTO `dw_tel_code` VALUES ('10', '15711477179', '7612', '1503632425', '127.0.0.1');

-- ----------------------------
-- Table structure for nf_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_access`;
CREATE TABLE `nf_admin_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户组',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员与用户组对应关系表';

-- ----------------------------
-- Records of nf_admin_access
-- ----------------------------
INSERT INTO `nf_admin_access` VALUES ('1', '1', '1', '1438651748', '1438651748', '0', '1');
INSERT INTO `nf_admin_access` VALUES ('2', '2', '2', '1500343055', '1500346218', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_addon
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_addon`;
CREATE TABLE `nf_admin_addon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) DEFAULT NULL COMMENT '插件名或标识',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text NOT NULL COMMENT '插件描述',
  `config` text COMMENT '配置',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `adminlist` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '插件类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of nf_admin_addon
-- ----------------------------
INSERT INTO `nf_admin_addon` VALUES ('2', 'Link', '友情链接插件', '友情链接插件', 'null', '零云', '1.0.0', '1', '0', '1484561441', '1484561441', '0', '1');
INSERT INTO `nf_admin_addon` VALUES ('3', 'RocketToTop', '小火箭返回顶部', '小火箭返回顶部', '{\"status\":\"1\"}', '零云', '1.0.0', '0', '0', '1484561441', '1484561441', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_config`;
CREATE TABLE `nf_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) DEFAULT NULL COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of nf_admin_config
-- ----------------------------
INSERT INTO `nf_admin_config` VALUES ('1', '站点开关', 'TOGGLE_WEB_SITE', '1', '1', 'toggle', '0:关闭\r\n1:开启', '站点关闭后将不能访问', '1378898976', '1406992386', '1', '1');
INSERT INTO `nf_admin_config` VALUES ('2', '网站标题', 'WEB_SITE_TITLE', '大外', '1', 'text', '', '网站标题前台显示标题', '1378898976', '1501652737', '2', '1');
INSERT INTO `nf_admin_config` VALUES ('3', '网站口号', 'WEB_SITE_SLOGAN', '', '1', 'text', '', '网站口号、宣传标语、一句话介绍', '1434081649', '1434081649', '3', '1');
INSERT INTO `nf_admin_config` VALUES ('4', '网站LOGO', 'WEB_SITE_LOGO', '', '1', 'picture', '', '网站LOGO', '1407003397', '1407004692', '4', '1');
INSERT INTO `nf_admin_config` VALUES ('5', '网站反色LOGO', 'WEB_SITE_LOGO_INVERSE', '', '1', 'picture', '', '匹配深色背景上的LOGO', '1476700797', '1476700797', '5', '1');
INSERT INTO `nf_admin_config` VALUES ('6', '网站描述', 'WEB_SITE_DESCRIPTION', '', '1', 'textarea', '', '网站搜索引擎描述', '1378898976', '1501652700', '6', '1');
INSERT INTO `nf_admin_config` VALUES ('7', '网站关键字', 'WEB_SITE_KEYWORD', '', '1', 'textarea', '', '网站搜索引擎关键字', '1378898976', '1381390100', '7', '1');
INSERT INTO `nf_admin_config` VALUES ('8', '版权信息', 'WEB_SITE_COPYRIGHT', 'Copyright © 大外 All rights reserved', '1', 'text', '', '设置在网站底部显示的版权信息', '1406991855', '1501654997', '8', '1');
INSERT INTO `nf_admin_config` VALUES ('9', '网站备案号', 'WEB_SITE_ICP', '', '1', 'text', '', '设置在网站底部显示的备案号', '1378900335', '1415983236', '9', '1');
INSERT INTO `nf_admin_config` VALUES ('10', '站点统计', 'WEB_SITE_STATISTICS', '', '1', 'textarea', '', '支持百度、Google、cnzz等所有Javascript的统计代码', '1378900335', '1415983236', '10', '1');
INSERT INTO `nf_admin_config` VALUES ('11', '公司名称', 'COMPANY_TITLE', '', '3', 'text', '', '', '1481014715', '1481014715', '1', '1');
INSERT INTO `nf_admin_config` VALUES ('12', '公司地址', 'COMPANY_ADDRESS', '', '3', 'text', '', '', '1481014768', '1481014768', '2', '1');
INSERT INTO `nf_admin_config` VALUES ('13', '公司邮箱', 'COMPANY_EMAIL', '', '3', 'text', '', '', '1481014914', '1481014914', '3', '1');
INSERT INTO `nf_admin_config` VALUES ('14', '公司电话', 'COMPANY_PHONE', '', '3', 'text', '', '', '1481014961', '1481014961', '4', '1');
INSERT INTO `nf_admin_config` VALUES ('15', '公司QQ', 'COMPANY_QQ', '', '3', 'text', '', '', '1481015016', '1481015016', '5', '1');
INSERT INTO `nf_admin_config` VALUES ('16', '公司QQ群', 'COMPANY_QQQUN', '', '3', 'text', '', '', '1481015198', '1481015198', '6', '1');
INSERT INTO `nf_admin_config` VALUES ('17', '网站二维码', 'QR_CODE', '', '3', 'picture', '', '', '1481009623', '1481009623', '7', '1');
INSERT INTO `nf_admin_config` VALUES ('18', 'IOS二维码', 'QR_IOS', '', '3', 'picture', '', '', '1481009623', '1481009623', '8', '1');
INSERT INTO `nf_admin_config` VALUES ('19', '安卓二维码', 'QR_ANDROID', '', '3', 'picture', '', '', '1481009921', '1481009921', '9', '1');
INSERT INTO `nf_admin_config` VALUES ('20', '微信二维码', 'QR_WEIXIN', '', '3', 'picture', '', '', '1481009959', '1481009959', '10', '1');
INSERT INTO `nf_admin_config` VALUES ('21', '文件上传大小', 'UPLOAD_FILE_SIZE', '2', '5', 'num', '', '文件上传大小单位：MB', '1428681031', '1428681031', '1', '1');
INSERT INTO `nf_admin_config` VALUES ('22', '图片上传大小', 'UPLOAD_IMAGE_SIZE', '0.5', '5', 'num', '', '图片上传大小单位：MB', '1428681071', '1428681071', '2', '1');
INSERT INTO `nf_admin_config` VALUES ('23', '后台多标签', 'ADMIN_TABS', '0', '5', 'toggle', '0:关闭\r\n1:开启', '', '1453445526', '1453445526', '3', '1');
INSERT INTO `nf_admin_config` VALUES ('24', '分页数量', 'ADMIN_PAGE_ROWS', '10', '5', 'num', '', '分页时每页的记录数', '1434019462', '1434019481', '4', '1');
INSERT INTO `nf_admin_config` VALUES ('25', '后台主题', 'ADMIN_THEME', 'admin', '5', 'select', 'admin:默认主题\r\naliyun:阿里云风格', '后台界面主题', '1436678171', '1436690570', '5', '1');
INSERT INTO `nf_admin_config` VALUES ('26', '导航分组', 'NAV_GROUP_LIST', 'top:顶部导航\r\nmain:主导航\r\nbottom:底部导航\r\nwap_bottom:Wap底部导航', '5', 'array', '', '导航分组', '1458382037', '1458382061', '6', '1');
INSERT INTO `nf_admin_config` VALUES ('27', '配置分组', 'CONFIG_GROUP_LIST', '1:基本\r\n3:扩展\r\n5:系统\r\n7:部署', '5', 'array', '', '配置分组', '1379228036', '1426930700', '7', '1');
INSERT INTO `nf_admin_config` VALUES ('28', '开发模式', 'DEVELOP_MODE', '1', '7', 'toggle', '1:开启\r\n0:关闭', '开发模式下会显示菜单管理、配置管理、数据字典等开发者工具', '1432393583', '1432393583', '1', '1');
INSERT INTO `nf_admin_config` VALUES ('29', '页面Trace', 'APP_TRACE', '0', '7', 'toggle', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '2', '1');

-- ----------------------------
-- Table structure for nf_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_group`;
CREATE TABLE `nf_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '图标',
  `menu_auth` text NOT NULL COMMENT '权限列表',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='部门信息表';

-- ----------------------------
-- Records of nf_admin_group
-- ----------------------------
INSERT INTO `nf_admin_group` VALUES ('1', '0', '超级管理员', '', '', '1426881003', '1427552428', '0', '1');
INSERT INTO `nf_admin_group` VALUES ('2', '0', 'admin1', '', '{\"Admin\":[\"1\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\"],\"Course\":[\"10000\",\"11000\",\"11010\",\"11011\",\"11020\",\"11021\",\"11022\",\"11023\",\"11030\",\"11031\",\"11032\",\"11033\"],\"Ads\":[\"10000\",\"11000\",\"11010\",\"11011\",\"11012\",\"11013\",\"11020\",\"11021\",\"11022\",\"11023\"],\"Sign\":[\"10000\",\"11000\",\"11010\"]}', '1500262145', '1502932614', '0', '1');
INSERT INTO `nf_admin_group` VALUES ('3', '0', 'user1', '', 'null', '1501039750', '1501039750', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_hook
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_hook`;
CREATE TABLE `nf_admin_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) DEFAULT NULL COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='钩子表';

-- ----------------------------
-- Records of nf_admin_hook
-- ----------------------------
INSERT INTO `nf_admin_hook` VALUES ('1', 'AdminIndex', '后台首页小工具', '后台首页小工具', '1', '1446522155', '1446522155', '1');
INSERT INTO `nf_admin_hook` VALUES ('2', 'FormBuilderExtend', 'FormBuilder类型扩展Builder', '', '1', '1447831268', '1447831268', '1');
INSERT INTO `nf_admin_hook` VALUES ('3', 'UploadFile', '上传文件钩子', '', '1', '1407681961', '1407681961', '1');
INSERT INTO `nf_admin_hook` VALUES ('4', 'PageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '', '1', '1407681961', '1407681961', '1');
INSERT INTO `nf_admin_hook` VALUES ('5', 'PageFooter', '页面footer钩子，一般用于加载插件CSS文件和代码', 'RocketToTop', '1', '1407681961', '1407681961', '1');
INSERT INTO `nf_admin_hook` VALUES ('6', 'CommonHook', '通用钩子，自定义用途，一般用来定制特殊功能', '', '1', '1456147822', '1456147822', '1');

-- ----------------------------
-- Table structure for nf_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_module`;
CREATE TABLE `nf_admin_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) DEFAULT NULL COMMENT '名称',
  `title` varchar(63) NOT NULL DEFAULT '' COMMENT '标题',
  `logo` varchar(63) NOT NULL DEFAULT '' COMMENT '图片图标',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '字体图标',
  `icon_color` varchar(7) NOT NULL DEFAULT '' COMMENT '字体图标颜色',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(31) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(7) NOT NULL DEFAULT '' COMMENT '版本',
  `user_nav` text NOT NULL COMMENT '个人中心导航',
  `config` text NOT NULL COMMENT '配置',
  `admin_menu` text NOT NULL COMMENT '菜单节点',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许卸载',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='模块功能表';

-- ----------------------------
-- Records of nf_admin_module
-- ----------------------------
INSERT INTO `nf_admin_module` VALUES ('1', 'Admin', '系统', '', 'fa fa-cog', '#3CA6F1', '核心系统', 'Neconano', '2.0.0', '', '', '{\"1\":{\"pid\":\"0\",\"title\":\"\\u7cfb\\u7edf\",\"icon\":\"fa fa-cog\",\"level\":\"system\",\"id\":\"1\"},\"2\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u529f\\u80fd\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"icon\":\"fa fa-wrench\",\"url\":\"Admin\\/Config\\/group\",\"id\":\"3\"},\"4\":{\"pid\":\"3\",\"title\":\"\\u4fee\\u6539\\u8bbe\\u7f6e\",\"url\":\"Admin\\/Config\\/groupSave\",\"id\":\"4\"},\"17\":{\"pid\":\"2\",\"title\":\"\\u4e0a\\u4f20\\u7ba1\\u7406\",\"icon\":\"fa fa-upload\",\"url\":\"Admin\\/Upload\\/index\",\"id\":\"17\"},\"18\":{\"pid\":\"17\",\"title\":\"\\u4e0a\\u4f20\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/upload\",\"id\":\"18\"},\"19\":{\"pid\":\"17\",\"title\":\"\\u5220\\u9664\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/delete\",\"id\":\"19\"},\"20\":{\"pid\":\"17\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Upload\\/setStatus\",\"id\":\"20\"},\"21\":{\"pid\":\"17\",\"title\":\"\\u4e0b\\u8f7d\\u8fdc\\u7a0b\\u56fe\\u7247\",\"url\":\"Admin\\/Upload\\/downremoteimg\",\"id\":\"21\"},\"22\":{\"pid\":\"17\",\"title\":\"\\u6587\\u4ef6\\u6d4f\\u89c8\",\"url\":\"Admin\\/Upload\\/fileManager\",\"id\":\"22\"},\"23\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u6743\\u9650\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"23\"},\"24\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"fa fa-user\",\"url\":\"Admin\\/User\\/index\",\"id\":\"24\"},\"25\":{\"pid\":\"24\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/User\\/add\",\"id\":\"25\"},\"26\":{\"pid\":\"24\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/User\\/edit\",\"id\":\"26\"},\"27\":{\"pid\":\"24\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/User\\/setStatus\",\"id\":\"27\"},\"28\":{\"pid\":\"23\",\"title\":\"\\u7ba1\\u7406\\u5458\\u7ba1\\u7406\",\"icon\":\"fa fa-lock\",\"url\":\"Admin\\/Access\\/index\",\"id\":\"28\"},\"29\":{\"pid\":\"28\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Access\\/add\",\"id\":\"29\"},\"30\":{\"pid\":\"28\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Access\\/edit\",\"id\":\"30\"},\"31\":{\"pid\":\"28\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Access\\/setStatus\",\"id\":\"31\"},\"32\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ec4\\u7ba1\\u7406\",\"icon\":\"fa fa-sitemap\",\"url\":\"Admin\\/Group\\/index\",\"id\":\"32\"},\"33\":{\"pid\":\"32\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Group\\/add\",\"id\":\"33\"},\"34\":{\"pid\":\"32\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Group\\/edit\",\"id\":\"34\"},\"35\":{\"pid\":\"32\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Group\\/setStatus\",\"id\":\"35\"},\"36\":{\"pid\":\"1\",\"title\":\"\\u6269\\u5c55\\u4e2d\\u5fc3\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"36\"},\"44\":{\"pid\":\"36\",\"title\":\"\\u529f\\u80fd\\u6a21\\u5757\",\"icon\":\"fa fa-th-large\",\"url\":\"Admin\\/Module\\/index\",\"id\":\"44\"},\"45\":{\"pid\":\"44\",\"title\":\"\\u5b89\\u88c5\",\"url\":\"Admin\\/Module\\/install\",\"id\":\"45\"},\"46\":{\"pid\":\"44\",\"title\":\"\\u5378\\u8f7d\",\"url\":\"Admin\\/Module\\/uninstall\",\"id\":\"46\"},\"47\":{\"pid\":\"44\",\"title\":\"\\u66f4\\u65b0\\u4fe1\\u606f\",\"url\":\"Admin\\/Module\\/updateInfo\",\"id\":\"47\"},\"48\":{\"pid\":\"44\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Module\\/setStatus\",\"id\":\"48\"}}', '1', '1438651748', '1502792440', '0', '1');
INSERT INTO `nf_admin_module` VALUES ('5', 'Course', '课程', '', 'fa', '#3CA6F1', '课程', 'Neconano', '1.0.0', '', '', '{\"10000\":{\"pid\":\"0\",\"title\":\"\\u8bfe\\u7a0b\",\"icon\":\"fa fa-play-circle-o\",\"id\":\"10000\"},\"11000\":{\"pid\":\"10000\",\"title\":\"\\u8bfe\\u7a0b\\u7ba1\\u7406\",\"icon\":\"fa fa-play-circle-o\",\"id\":\"11000\"},\"11010\":{\"pid\":\"11000\",\"title\":\"\\u8bfe\\u7a0b\\u5217\\u8868\",\"icon\":\"fa\",\"url\":\"course\\/lesson\\/index\",\"id\":\"11010\"},\"11011\":{\"pid\":\"11010\",\"title\":\"\\u65b0\\u589e\",\"icon\":\"fa\",\"url\":\"course\\/lesson\\/add\",\"id\":\"11011\"},\"11012\":{\"pid\":\"11010\",\"title\":\"\\u7f16\\u8f91\",\"icon\":\"fa\",\"url\":\"course\\/lesson\\/edit\",\"id\":\"11012\"},\"11013\":{\"pid\":\"11010\",\"title\":\"\\u8bfe\\u7a0b\\u5b89\\u6392\",\"icon\":\"fa\",\"url\":\"course\\/lesson\\/schedule_manage\",\"id\":\"11013\"},\"11020\":{\"pid\":\"11000\",\"title\":\"\\u7279\\u8272\\u7ba1\\u7406\",\"icon\":\"fa\",\"url\":\"course\\/feature\\/index\",\"id\":\"11020\"},\"11021\":{\"pid\":\"11020\",\"title\":\"\\u65b0\\u589e\",\"icon\":\"fa\",\"url\":\"course\\/feature\\/add\",\"id\":\"11021\"},\"11022\":{\"pid\":\"11020\",\"title\":\"\\u7f16\\u8f91\",\"icon\":\"fa\",\"url\":\"course\\/feature\\/edit\",\"id\":\"11022\"},\"11023\":{\"pid\":\"11020\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"icon\":\"fa\",\"url\":\"course\\/feature\\/setStatus\",\"id\":\"11023\"},\"11030\":{\"pid\":\"11000\",\"title\":\"\\u6559\\u5e08\\u7ba1\\u7406\",\"icon\":\"fa\",\"url\":\"course\\/teacher\\/index\",\"id\":\"11030\"},\"11031\":{\"pid\":\"11030\",\"title\":\"\\u65b0\\u589e\",\"icon\":\"fa\",\"url\":\"course\\/teacher\\/add\",\"id\":\"11031\"},\"11032\":{\"pid\":\"11030\",\"title\":\"\\u7f16\\u8f91\",\"icon\":\"fa\",\"url\":\"course\\/teacher\\/edit\",\"id\":\"11032\"},\"11033\":{\"pid\":\"11030\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"icon\":\"fa\",\"url\":\"course\\/teacher\\/setStatus\",\"id\":\"11033\"}}', '0', '1502446210', '1503285375', '0', '1');
INSERT INTO `nf_admin_module` VALUES ('6', 'Ads', '广告', '', 'fa', '#3CA6F1', '广告', 'Neconano', '1.0.0', '', '', '{\"10000\":{\"pid\":\"0\",\"title\":\"\\u5e7f\\u544a\",\"icon\":\"fa fa-barcode\",\"id\":\"10000\"},\"11000\":{\"pid\":\"10000\",\"title\":\"\\u5e7f\\u544a\\u7ba1\\u7406\",\"icon\":\"fa fa-barcode\",\"id\":\"11000\"},\"11010\":{\"pid\":\"11000\",\"title\":\"\\u8f6e\\u64ad\\u7ba1\\u7406\",\"icon\":\"fa\",\"url\":\"ads\\/ads\\/index\",\"id\":\"11010\"},\"11011\":{\"pid\":\"11010\",\"title\":\"\\u65b0\\u589e\",\"icon\":\"fa\",\"url\":\"ads\\/ads\\/add\",\"id\":\"11011\"},\"11012\":{\"pid\":\"11010\",\"title\":\"\\u7f16\\u8f91\",\"icon\":\"fa\",\"url\":\"ads\\/ads\\/edit\",\"id\":\"11012\"},\"11013\":{\"pid\":\"11010\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"icon\":\"fa\",\"url\":\"ads\\/ads\\/setStatus\",\"id\":\"11013\"},\"11020\":{\"pid\":\"11000\",\"title\":\"\\u76f4\\u64ad\\u7ba1\\u7406\",\"icon\":\"fa\",\"url\":\"ads\\/zhibo\\/index\",\"id\":\"11020\"},\"11021\":{\"pid\":\"11020\",\"title\":\"\\u65b0\\u589e\",\"icon\":\"fa\",\"url\":\"ads\\/zhibo\\/add\",\"id\":\"11021\"},\"11022\":{\"pid\":\"11020\",\"title\":\"\\u7f16\\u8f91\",\"icon\":\"fa\",\"url\":\"ads\\/zhibo\\/edit\",\"id\":\"11022\"},\"11023\":{\"pid\":\"11020\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"icon\":\"fa\",\"url\":\"ads\\/zhibo\\/setStatus\",\"id\":\"11023\"}}', '0', '1502677632', '1503285367', '0', '1');
INSERT INTO `nf_admin_module` VALUES ('7', 'Sign', '报名', '', 'fa', '#3CA6F1', '报名', 'Neconano', '1.0.0', '', '', '{\"10000\":{\"pid\":\"0\",\"title\":\"\\u62a5\\u540d\",\"icon\":\"fa fa-pencil\",\"id\":\"10000\"},\"11000\":{\"pid\":\"10000\",\"title\":\"\\u62a5\\u540d\\u7ba1\\u7406\",\"icon\":\"fa fa-pencil\",\"id\":\"11000\"},\"11010\":{\"pid\":\"11000\",\"title\":\"\\u62a5\\u540d\\u5217\\u8868\",\"icon\":\"fa\",\"url\":\"sign\\/baoming\\/index\",\"id\":\"11010\"}}', '0', '1502677641', '1503285457', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_nav`;
CREATE TABLE `nf_admin_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group` varchar(11) NOT NULL DEFAULT '' COMMENT '分组',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '导航标题',
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT '导航类型',
  `value` text COMMENT '导航值',
  `target` varchar(11) NOT NULL DEFAULT '' COMMENT '打开方式',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `lists_template` varchar(63) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `detail_template` varchar(63) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='前台导航表';

-- ----------------------------
-- Records of nf_admin_nav
-- ----------------------------
INSERT INTO `nf_admin_nav` VALUES ('1', 'bottom', '0', '关于', 'page', '', '', '', '', '', '1449742225', '1449742255', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('2', 'bottom', '1', '关于我们', 'page', '', '', '', '', '', '1449742312', '1449742312', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('4', 'bottom', '1', '服务产品', 'page', '', '', '', '', '', '1449742597', '1449742651', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('5', 'bottom', '1', '商务合作', 'page', '', '', '', '', '', '1449742664', '1449742664', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('6', 'bottom', '1', '加入我们', 'page', '', '', '', '', '', '1449742678', '1449742697', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('7', 'bottom', '0', '帮助', 'page', '', '', '', '', '', '1449742688', '1449742688', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('8', 'bottom', '7', '用户协议', 'page', '', '', '', '', '', '1449742706', '1449742706', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('9', 'bottom', '7', '意见反馈', 'page', '', '', '', '', '', '1449742716', '1449742716', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('10', 'bottom', '7', '常见问题', 'page', '', '', '', '', '', '1449742728', '1449742728', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('11', 'bottom', '0', '联系方式', 'page', '', '', '', '', '', '1449742742', '1449742742', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('12', 'bottom', '11', '联系我们', 'page', '', '', '', '', '', '1449742752', '1449742752', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('13', 'bottom', '11', '新浪微博', 'page', '', '', '', '', '', '1449742802', '1449742802', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('14', 'main', '0', '首页', 'link', '/', '', '', '', '', '1457084559', '1501663004', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('15', 'main', '0', '产品中心', 'post', null, '', '', 'lists', 'detail', '1457084559', '1501664592', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('16', 'main', '0', 'cms栏目', 'module', 'Cms', '', '', '', '', '1457084572', '1501723817', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('20', 'wap_bottom', '0', '首页', 'link', '', '', 'fa-home', '', '', '1458382401', '1458382401', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('21', 'wap_bottom', '0', '消息', 'module', 'Im', '', 'fa-commenting-o', '', '', '1458382603', '1461381689', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('22', 'wap_bottom', '0', '钱包', 'module', 'Wallet', '', 'fa-wallet', '', '', '1458382637', '1461381704', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('23', 'wap_bottom', '0', '我的', 'module', 'User', '', 'fa-user', '', '', '1458382814', '1461207462', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('24', 'top', '0', '用户界面', 'module', 'Home', '', 'fa fa-cog', '', '', '1500429936', '1500429936', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('25', 'top', '0', 'CMS门户', 'module', 'Cms', '', 'fa fa-cog', '', '', '1501571982', '1501571982', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('26', 'top', '0', '用户中心', 'module', 'User', '', 'fa fa-cog', '', '', '1501741207', '1501741207', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('27', 'top', '0', '课程模块', 'module', 'Course', '', 'fa fa-cog', '', '', '1502446211', '1502446211', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('28', 'top', '0', '广告', 'module', 'Ads', '', 'fa', '', '', '1502677632', '1502677632', '0', '1');
INSERT INTO `nf_admin_nav` VALUES ('29', 'top', '0', '报名', 'module', 'Sign', '', 'fa', '', '', '1502677641', '1502677641', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_post
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_post`;
CREATE TABLE `nf_admin_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `abstract` varchar(255) DEFAULT '' COMMENT '摘要',
  `content` text COMMENT '内容',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章列表';

-- ----------------------------
-- Records of nf_admin_post
-- ----------------------------
INSERT INTO `nf_admin_post` VALUES ('1', '15', 'NecoFramework测试', '0', '', '<span style=\"color:#777777;white-space:normal;\">追求简单、高效、卓越。可轻松实现支持多终端的WEB产品快速搭建、部署、上线。系统功能采用模块化、组件化、插件化等开放化低耦合设计</span>', '16', '1501664267', '1501664267', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_session
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_session`;
CREATE TABLE `nf_admin_session` (
  `session_id` varchar(255) NOT NULL,
  `session_data` blob,
  `uid` int(11) unsigned DEFAULT NULL COMMENT '用户ID',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='session存储表';

-- ----------------------------
-- Records of nf_admin_session
-- ----------------------------
INSERT INTO `nf_admin_session` VALUES ('dw_admin_0hriqm9qdgcv16rdp5geqjgop2', 0x64775F61646D696E5F7C613A323A7B733A393A22757365725F61757468223B613A353A7B733A333A22756964223B733A313A2231223B733A383A22757365726E616D65223B733A353A2261646D696E223B733A383A226E69636B6E616D65223B733A31353A22E8B685E7BAA7E7AEA1E79086E59198223B733A363A22617661746172223B733A313A2230223B733A31303A226176617461725F75726C223B733A33383A222F7075626C69632F6E662F686F6D652F696D672F64656661756C742F6176617461722E706E67223B7D733A31343A22757365725F617574685F7369676E223B733A34303A2263326630373465326432643434353036303265303264396434326135336337396566363732366136223B7D, '1', '1521773371');
INSERT INTO `nf_admin_session` VALUES ('dw_home_0hriqm9qdgcv16rdp5geqjgop2', '', null, '1521773289');

-- ----------------------------
-- Table structure for nf_admin_slider
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_slider`;
CREATE TABLE `nf_admin_slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '幻灯ID',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面ID',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '点击链接',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='幻灯切换表';

-- ----------------------------
-- Records of nf_admin_slider
-- ----------------------------

-- ----------------------------
-- Table structure for nf_admin_upload
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_upload`;
CREATE TABLE `nf_admin_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) DEFAULT '' COMMENT '文件链接',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) DEFAULT '' COMMENT '文件sha1编码',
  `location` varchar(15) NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='文件上传表';

-- ----------------------------
-- Records of nf_admin_upload
-- ----------------------------
INSERT INTO `nf_admin_upload` VALUES ('13', '1', 'logo.png', '/image/2017-07-19/596f1376d678f.png', '', 'png', '6639', '055e21ae49485911f19e829ccf035574', 'eaf41884caf07eb909522cb85408bfe0dbec0ee3', 'Local', '0', '1500451702', '1500451702', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('16', '3', 'user.jpg', '/image/2017-08-03/598299a1b9d6b.jpg', '', 'jpg', '17500', 'c952126967ef573531a39d9021d35e4c', 'c551d0829cbb807b76c2ebc276a148a5d56657b8', 'Local', '0', '1501731233', '1501731233', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('19', '3', '391837041043.jpeg', '/image/2017-08-03/5982bcffc66b6.jpeg', '', 'jpeg', '5412', '854865a69a70af1c7724e408cbccd346', 'e8d7d3a3105c9ca189809864fa05fa9f43bf36e7', 'Local', '0', '1501740287', '1501740287', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('20', '1', '94c224569129d207bd421a371dbd2f9f.png', '/image/2017-08-14/59915cc529098.png', '', 'png', '82622', 'f5d137cbb36aa2e256f83183e437a602', '75e372d5b40ff8e1a08c439bc4bd7189b5fe4b6a', 'Local', '0', '1502698693', '1502698693', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('21', '1', '1大外在线后台-课程.png', '/image/2017-08-14/59915f40f25e4.png', '', 'png', '53780', 'eecfd835058d0cf2b96835b98fdb926d', '52ec9ccf6968c1e0a4058ea494f47e1b0efa325a', 'Local', '0', '1502699329', '1502699329', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('22', '1', '课程安排.png', '/image/2017-08-15/59928864d96d3.png', '', 'png', '65572', '18850ab826faf483d4e8c98225df880f', 'b23e266beddba2b67f65b1390881f4cf474f9017', 'Local', '0', '1502775396', '1502775396', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('23', '1', 'user.jpg', '/image/2017-08-15/59929db54c3f6.jpg', '', 'jpg', '13214', 'd6afbd593b098eabc3612913ecf1900f', '7b4fb7d1a68d3d433d8cd0291c8aef432240cba8', 'Local', '0', '1502780853', '1502780853', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('24', '1', 'school.png', '/image/2017-08-15/5992a8a263782.png', '', 'png', '4861', 'c1f642b44d81fef44086edd28b83c77a', '43c08a77c97156478ff917d0b473d6b05a3b8d9e', 'Local', '0', '1502783650', '1502783650', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('25', '1', 'banner1.png', '/image/2017-08-15/5992c18fa3177.png', '', 'png', '395206', 'c286de8dd610efc5746ca7c72fa494d2', 'bfa33232e3faf1924ee87a38596a802a7e2b175d', 'Local', '0', '1502790031', '1502790031', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('26', '1', '详情页.png', '/image/2017-08-15/5992d53895525.png', '', 'png', '166476', '8366d4a9d5342e32bfa68115032bf9aa', '4b41972535642fecbf4acae5b434f471fbad53ae', 'Local', '0', '1502795064', '1502795064', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('27', '1', 'banner.png', '/image/2017-08-17/59953bb47aa8f.png', '', 'png', '31019', 'ae38fb79a6f38a26c48b4cda91d74221', '2b69acc9da1d3d7c666d0b3ce92d5ecab2145cd5', 'Local', '0', '1502952372', '1502952372', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('28', '1', '雅思在线提高班（5.5分）.png', '/image/2017-08-17/5995993eb5832.png', '', 'png', '170750', 'db8d7513c11e83b1dec0cbcabb7fbd78', '630b2e093a6f544f04357a3691bfd7e594d974af', 'Local', '0', '1502976318', '1502976318', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('29', '1', '雅思在线方法强化班（四合一）.png', '/image/2017-08-17/599599d0c0031.png', '', 'png', '177398', 'e16fc2e0afed7c231e41ff97d55022e2', 'ac60e382dc0e362c0a5cf8fc3f0211963b3399e4', 'Local', '0', '1502976464', '1502976464', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('30', '1', '钱桂明.png', '/image/2017-08-17/5995a07e7d216.png', '', 'png', '63203', 'd70cef8744ff335db7669f4d66637bd2', '57b59817f8c4d534d77e8a100ab79378b5211f1d', 'Local', '0', '1502978174', '1502978174', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('31', '1', '孙涛.png', '/image/2017-08-17/5995a09e46d5e.png', '', 'png', '70646', '63d2d36d59538aa49cee0e8719af8822', '5ee5bf1374680e36bd671ed75e3bfaf1db940194', 'Local', '0', '1502978206', '1502978206', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('32', '1', '张茂浚.png', '/image/2017-08-17/5995a0b915d64.png', '', 'png', '71385', '43063c1b69abb029e3d9a91a15bce195', 'dff6323acf2c7f5b81460fd3dac4520e9cd257e9', 'Local', '0', '1502978233', '1502978233', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('33', '1', '卢雅桢.png', '/image/2017-08-17/5995a0d6c1d68.png', '', 'png', '68964', 'e95002a06c08f717977fb25939d2ab88', '662160a1a347dfff2a2654468b49f1671350cbee', 'Local', '0', '1502978262', '1502978262', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('34', '1', 'banner-1.png', '/image/2017-08-17/5995a3e1b2800.png', '', 'png', '260624', 'f947f2af196852979542b660f456de93', '6a7b0a1a7d1b6719a98798f9a22c027e8c7b43f8', 'Local', '0', '1502979041', '1502979041', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('35', '1', '直播图.png', '/image/2017-08-17/5995a529789a5.png', '', 'png', '177698', '166be6c18d40e5b50dd8e33981e2d4c8', '95a1182b9a58deacecf601c59b737c249f8a15c1', 'Local', '0', '1502979369', '1502979369', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('36', '1', '雅思在线通关班（6-6.5分）.png', '/image/2017-08-18/59964b43d8238.png', '', 'png', '216074', '09f0a1d3f196cf3b081e9be1da012956', '8237c66eb1f97a9869dc0944d258366e5b9a738f', 'Local', '0', '1503021891', '1503021891', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('37', '1', 'N1考前冲刺辅导班.png', '/image/2017-08-18/5996550135517.png', '', 'png', '64618', 'a1023e65d316a42e3b51d2554ad0f91f', '5c43bd9f14d0685fd0c412436f011e5d62eb1117', 'Local', '0', '1503024385', '1503024385', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('38', '1', '雅思在线拔高班（7分+）.png', '/image/2017-08-18/5996560ce3020.png', '', 'png', '200235', '2687aa237b61830f65758e047886e210', '7cdc57bd855c5785f8959c2dc13b43908b3bf14c', 'Local', '0', '1503024652', '1503024652', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('39', '1', '智勇.jpg', '/image/2017-08-18/59965708cd0ca.jpg', '', 'jpg', '17392', 'a27a1c31d590322e18fa412e762163d1', '74c391455aa43a774e14da5c580e1775a81bc65c', 'Local', '0', '1503024904', '1503024904', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('40', '1', '菲菲.jpg', '/image/2017-08-18/59965717a1c60.jpg', '', 'jpg', '99689', 'e460578ec8abd2caa28e875443168749', 'c63a6e78cd2f033341c163ac28068871575aab43', 'Local', '0', '1503024919', '1503024919', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('41', '1', '零基础N1直达班.png', '/image/2017-08-18/599657d98db2f.png', '', 'png', '247968', 'b4809166b2082d5a0bd5dfdbc25ecead', '77dfda0016f760f22dbbd9d2b7b39e1b6cec5b32', 'Local', '0', '1503025113', '1503025113', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('42', '1', '雅思在线VIP单科1v1.png', '/image/2017-08-18/599658aed91fe.png', '', 'png', '37040', 'd56fb2a9f889f96e09e551ef2fc6e51c', 'd0323d2929844b13006ee555216b89cebeb27633', 'Local', '0', '1503025326', '1503025326', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('43', '1', 'N2考前冲刺辅导班.png', '/image/2017-08-18/59965908f1b78.png', '', 'png', '245327', '20453e157f176c1c10514142fc11a169', '6d0fb53be703ee77f659dd4e0d47f0973725a20f', 'Local', '0', '1503025416', '1503025416', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('44', '1', '雅思在线VIP全科1v1.png', '/image/2017-08-18/5996593382fc9.png', '', 'png', '190380', 'f4c577968c4a1ac46b2e6405be878037', '424cfc5a1350a46165c1191fbe4b6d0f03d45e50', 'Local', '0', '1503025459', '1503025459', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('45', '1', '零基础N2直达班.png', '/image/2017-08-18/59965b0917bc4.png', '', 'png', '166875', '88df8e9ca51f230dd49d52ab9bd98698', 'ea7a4904caa25b8f87c4be0e1272974b5e757ab6', 'Local', '0', '1503025929', '1503025929', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('46', '1', '考研日语强化班.png', '/image/2017-08-18/59965dcd2f27f.png', '', 'png', '150485', '1c44391917ba0c7ee0f9de0bbc767cd2', '201edb535d763151a81951dff93d652a3f6c44ab', 'Local', '0', '1503026637', '1503026637', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('47', '1', '雅思词汇加强课（7500+词汇高级班）.png', '/image/2017-08-18/599660648c988.png', '', 'png', '138990', '33bdb739701dad5d8b1bfb8ecc189f03', '7a192dcd5df4d6c31fbe6e227e7d527287438924', 'Local', '0', '1503027300', '1503027300', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('48', '1', '托福在线60-80-提高课程.png', '/image/2017-08-18/5996627b7b3f8.png', '', 'png', '164027', '05f994b30d91055977077e0663f49a5e', '399097ec2bb5f7d0dd055f9cd29b7fab8430454c', 'Local', '0', '1503027835', '1503027835', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('49', '1', 'banner--3.png', '/image/2017-08-18/599663388e2b6.png', '', 'png', '420295', '3fe7b564914e0e8d7a6b99d5b8aaed51', '0ed43bf9dd92e5732ea55bb8b00d30ddb75b3781', 'Local', '0', '1503028024', '1503028024', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('50', '1', '托福在线81-95-提高课程.png', '/image/2017-08-18/5996636a035ea.png', '', 'png', '67535', 'c9c437d4a1d73f6f11b4dd8a18a87b2f', '5fdd8177d59dfbaff57c54fdfb536bea77f6fc80', 'Local', '0', '1503028074', '1503028074', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('51', '1', '大外后台_8.11.png', '/image/2017-08-18/5996637994f89.png', '', 'png', '138236', '8d0141f2d99abd24189b47f266e7b804', '8e5d11da7d2a96de97689161fa1344392491c43e', 'Local', '0', '1503028089', '1503028089', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('52', '1', '托福在线95-100+-提高课程.png', '/image/2017-08-18/599663da84142.png', '', 'png', '179374', 'c8a43afbf4c3fb68750918481e5c07c0', '5fa8f19c09eb7e1d524e048324ed5dbdb555371d', 'Local', '0', '1503028186', '1503028186', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('53', '1', '托福在线“四对一”快速通关课程.png', '/image/2017-08-18/59967958893f3.png', '', 'png', '163162', 'a2085eb73e34a40a72664af5bd8ad0fc', '6ab1f07936f1698e7260d59bab335e3b5ccc9997', 'Local', '0', '1503033688', '1503033688', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('54', '1', '福在线VIP单科1v1.png', '/image/2017-08-18/59967c6d2e437.png', '', 'png', '263147', 'b8aad5f795ab29ab9a68fb39531838a0', '6bf4c4ccf12e99f6300f05cb4d5e8dbfe6984092', 'Local', '0', '1503034477', '1503034477', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('55', '1', '福在线VIP全科1v1.png', '/image/2017-08-18/59967d2c88a45.png', '', 'png', '168953', 'bba4a0ad1ca24c91bc6610771f09d547', '863c6cc3c3edb228fbd5bd1559aa3c7d809e9a73', 'Local', '0', '1503034668', '1503034668', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('56', '1', '托福词汇加强课-（8000+词汇高级班）.png', '/image/2017-08-18/59967e1ac61d0.png', '', 'png', '497325', '5a0172e412def962f68390aff3298a74', '58be6fe69ee85ea504b9a0975dd5107a26874aee', 'Local', '0', '1503034906', '1503034906', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('57', '1', '雅思词汇加强课（4000+词汇基础班）.png', '/image/2017-08-18/59967f0cc3727.png', '', 'png', '203114', '5ed9c7bb67e101efe485eb53a65c12db', '7be3f83be65e4f8b918c7615a73427b6224e7e69', 'Local', '0', '1503035148', '1503035148', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('58', '1', '语法突破班（入门初级）.png', '/image/2017-08-18/59967f6d0bdbd.png', '', 'png', '169593', 'ff7b8e4a1df1b3ba298621488fe3c105', 'a8c834c847f67a2e9074ccb4a52589a4f0f7eb9b', 'Local', '0', '1503035245', '1503035245', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('59', '1', '语法突破班（通关高级）.png', '/image/2017-08-18/599680f205050.png', '', 'png', '126265', 'e2ad44582c7c9656bb0cd378b812cee5', 'a7c7f2853abfc1040007d3dd62e8286b6e92990e', 'Local', '0', '1503035634', '1503035634', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('60', '1', '雅思在线通关班（6-6.5分）.png', '/image/2017-08-18/5996823180a18.png', '', 'png', '209131', '2795abfed12c42206b29d76ede272de1', '54bf378851c4ab9b27c7eb98fe264299165a2a44', 'Local', '0', '1503035953', '1503035953', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('61', '1', '托福词汇加强课-（6000+词汇基础班）.png', '/image/2017-08-18/599687eecf1de.png', '', 'png', '229630', 'cc41f9cb677da9b5b7f7358907788428', '7ff59171b5ca103a29dbbec261a5a6cd8098aa3e', 'Local', '0', '1503037422', '1503037422', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('62', '1', '产品定义及课前要求.png', '/image/2017-08-18/59968c2ea8604.png', '', 'png', '433350', '2d0c7c793eb3b9ce9b9ffc53ae359c46', '38ea22cb5cf7f2cabf48865eda56664e9cb245f5', 'Local', '0', '1503038510', '1503038510', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('63', '1', 'Axure基础教程.png', '/image/2017-08-18/59968c40dfe87.png', '', 'png', '87898', '202815c659e49c0c25dec425bebe7577', 'da8d274efd8925261bf25328070a69984ef1210d', 'Local', '0', '1503038528', '1503038528', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('64', '1', 'Xmind基础教程.png', '/image/2017-08-18/59968c48e01f9.png', '', 'png', '64780', 'e844c4ff4a82fd96abc981f10904c364', '7ec4921d0e208b968df4488a028c58f4b0c90c2d', 'Local', '0', '1503038536', '1503038536', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('65', '1', '墨刀基础教程.png', '/image/2017-08-18/59968c5302fff.png', '', 'png', '178117', '8e1f0b8e60937dcc97b11359ab0cad46', '8ee95035d12d4ca8b1bdd0176791736a9dba0923', 'Local', '0', '1503038547', '1503038547', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('66', '1', '大学英语四级强化课程.png', '/image/2017-08-18/59968c6c013e0.png', '', 'png', '139245', 'cc8fbe5a9c6859ae4f90740ac65fc10e', 'ab3219c1de311be8daf6ccf97e22d827437ba9c7', 'Local', '0', '1503038572', '1503038572', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('67', '1', '大学英语六级强化课程.png', '/image/2017-08-18/59968c74b116a.png', '', 'png', '323275', '27643166e4e85975c42b379f45058314', 'eb34eea30d7198b751a1ebff25de46881aa90cf6', 'Local', '0', '1503038580', '1503038580', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('68', '1', '法语零基础兴趣班（0-A1）.png', '/image/2017-08-18/59968c96d7edd.png', '', 'png', '176196', '8ee1204dd991c71959dbf7ce3c6629fa', '8d8fdfb92f28b362594a4c4a722a5409ee7c8f50', 'Local', '0', '1503038614', '1503038614', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('69', '1', '法语留学强化班（0-B2）.png', '/image/2017-08-18/59968ca447cdc.png', '', 'png', '65901', '989cf357ddadbf7cf663e0ece753570b', '69b0428596804fcd9b13846c09cf538e0db8afbe', 'Local', '0', '1503038628', '1503038628', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('70', '1', '法语留学全程班（0-B2）.png', '/image/2017-08-18/59968ca8ef4e7.png', '', 'png', '181067', '48980359a3bd42f83d238f3d0601727d', 'e5cdc6eb1b4a0db8092291ccb5a33aca9edbfe98', 'Local', '0', '1503038632', '1503038632', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('71', '1', '直66576播图.png', '/image/2017-08-18/59968f4ac8835.png', '', 'png', '91736', '9287e2625a72125daee4f4758ba447e5', '5ea9371912de6eb7c4a7f6b0637d5f634b7e17b3', 'Local', '0', '1503039306', '1503039306', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('72', '1', '直播图1.png', '/image/2017-08-18/59968f9d234b5.png', '', 'png', '58774', '638f1293be4a038e44e510e6fe939225', '30976ca1f0542af84edeadbbfd0b07c6c505e49e', 'Local', '0', '1503039389', '1503039389', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('73', '1', '手机banner--3.png', '/image/2017-08-18/5996933a40dbd.png', '', 'png', '208053', '0770a974dcefcdecaf3e39bf2eed1bae', 'ebcb9d2629dcc6ce5f75b069c3d35b6f30618f92', 'Local', '0', '1503040314', '1503040314', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('74', '1', '手机er--2.png', '/image/2017-08-18/599693513b60f.png', '', 'png', '78970', '8caeae632303bb9dc827da05feadeca1', '46817ee58aeaa6c8809c3cd0b5e6df4da59694ae', 'Local', '0', '1503040337', '1503040337', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('75', '1', '手机er-1.png', '/image/2017-08-18/5996935bd80b7.png', '', 'png', '183182', '879c50ac557f3d2dfb00f0645f7a1956', '6658329a433dc07199e3a71ef1e7ae23f3c45807', 'Local', '0', '1503040347', '1503040347', '0', '1');
INSERT INTO `nf_admin_upload` VALUES ('76', '1', '55E5CB14@AB7BA26(06-30-13-23-40).jpg', '/image/2017-08-21/599a8874b0a42.jpg', '', 'jpg', '63302', '6bb1e71e72247e808ca75332b00e926c', '5599f5ce0986103e223a597e313f54fa6f10989a', 'Local', '0', '1503299700', '1503299700', '0', '1');

-- ----------------------------
-- Table structure for nf_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `nf_admin_user`;
CREATE TABLE `nf_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `user_type` int(11) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `nickname` varchar(63) DEFAULT NULL COMMENT '昵称',
  `username` varchar(31) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(63) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(63) NOT NULL DEFAULT '' COMMENT '邮箱',
  `email_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `mobile_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `reg_ip` bigint(20) DEFAULT '0' COMMENT '注册IP',
  `reg_type` varchar(15) NOT NULL DEFAULT '' COMMENT '注册方式',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户账号表';

-- ----------------------------
-- Records of nf_admin_user
-- ----------------------------
INSERT INTO `nf_admin_user` VALUES ('1', '1', '超级管理员', 'admin', '56c9ae1897ac07e2d9d6808ed223fca2', '', '0', '', '0', '0', '0', '0.00', '0', '', '1438651748', '1502444541', '1');
INSERT INTO `nf_admin_user` VALUES ('2', '1', 'admin1', 'admin1', '56c9ae1897ac07e2d9d6808ed223fca2', '', '0', '', '0', '13', '0', '0.00', null, 'admin', '1500020222', '1502932518', '1');
INSERT INTO `nf_admin_user` VALUES ('3', '1', null, 'user1', '51e2d3e619bd5c20ced6608262853f87', '', '0', '', '0', '19', '0', '0.00', null, 'admin', '1501039731', '1501039731', '1');
INSERT INTO `nf_admin_user` VALUES ('4', '1', 'user2', 'user2', 'cd96d3886ebac6f855d8d833e950f63d', '', '0', '', '0', '', '0', '0.00', null, 'username', '1501755040', '1501755040', '1');
INSERT INTO `nf_admin_user` VALUES ('5', '1', 'user3', 'user3', 'cd96d3886ebac6f855d8d833e950f63d', '', '0', '', '0', '', '0', '0.00', null, 'username', '1501755199', '1501755199', '1');
INSERT INTO `nf_admin_user` VALUES ('6', '1', 'user4', 'user4', 'cd96d3886ebac6f855d8d833e950f63d', '', '0', '', '0', '', '0', '0.00', null, 'username', '1501755301', '1501755301', '-1');

-- ----------------------------
-- Table structure for nf_user_attribute
-- ----------------------------
DROP TABLE IF EXISTS `nf_user_attribute`;
CREATE TABLE `nf_user_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `user_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '文档模型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户模块：用户属性字段表';

-- ----------------------------
-- Records of nf_user_attribute
-- ----------------------------
INSERT INTO `nf_user_attribute` VALUES ('1', 'gender', '性别', 'tinyint(3)  NOT NULL ', 'radio', '0', '性别', '1', '1:男\n-1:女\r\n0:保密\r\n', '1', '1438651748', '1438651748', '1');
INSERT INTO `nf_user_attribute` VALUES ('2', 'city', '所在城市', 'varchar(15) NOT NULL', 'text', '', '常住城市', '1', '', '1', '1442026468', '1442123810', '1');
INSERT INTO `nf_user_attribute` VALUES ('3', 'summary', '签名', 'varchar(127) NOT NULL', 'text', '', '签名', '1', '', '1', '1438651748', '1501742715', '1');

-- ----------------------------
-- Table structure for nf_user_message
-- ----------------------------
DROP TABLE IF EXISTS `nf_user_message`;
CREATE TABLE `nf_user_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息父ID',
  `title` varchar(1024) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` text COMMENT '消息内容',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0系统消息,1评论消息,2私信消息',
  `to_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收用户ID',
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '私信消息发信用户ID',
  `is_read` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户消息表';

-- ----------------------------
-- Records of nf_user_message
-- ----------------------------

-- ----------------------------
-- Table structure for nf_user_person
-- ----------------------------
DROP TABLE IF EXISTS `nf_user_person`;
CREATE TABLE `nf_user_person` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `gender` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别',
  `summary` varchar(127) NOT NULL COMMENT '签名',
  `city` varchar(15) NOT NULL COMMENT '所在城市',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户模块：个人类型扩展信息表';

-- ----------------------------
-- Records of nf_user_person
-- ----------------------------

-- ----------------------------
-- Table structure for nf_user_type
-- ----------------------------
DROP TABLE IF EXISTS `nf_user_type`;
CREATE TABLE `nf_user_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '标题',
  `list_field` varchar(127) NOT NULL DEFAULT '' COMMENT '搜索字段',
  `home_template` varchar(127) NOT NULL DEFAULT '' COMMENT '主页模版',
  `center_template` varchar(127) NOT NULL DEFAULT '' COMMENT '个人中心模板',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户模块：用户类型表';

-- ----------------------------
-- Records of nf_user_type
-- ----------------------------
INSERT INTO `nf_user_type` VALUES ('1', 'person', '个人', '1', '', '', '1438651748', '1501742681', '0', '1');
