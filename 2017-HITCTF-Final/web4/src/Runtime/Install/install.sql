
CREATE TABLE IF NOT EXISTS `gxl_admin` (
  `admin_id` smallint(6) unsigned NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_pwd` char(255) NOT NULL,
  `admin_count` smallint(6) NOT NULL,
  `admin_ok` varchar(50) NOT NULL,
  `admin_del` bigint(1) NOT NULL,
  `admin_ip` varchar(40) NOT NULL,
  `admin_email` varchar(40) NOT NULL,
  `admin_logintime` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gxl_admin`
--

INSERT INTO `gxl_admin` (`admin_id`, `admin_name`, `admin_pwd`, `admin_count`, `admin_ok`, `admin_del`, `admin_ip`, `admin_email`, `admin_logintime`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 985, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,1', 0, '127.0.0.1', 'admin@qq.com', 1492353748);

-- --------------------------------------------------------

--
-- 表的结构 `gxl_ads`
--

CREATE TABLE IF NOT EXISTS `gxl_ads` (
  `ads_id` smallint(4) unsigned NOT NULL,
  `ads_name` varchar(50) NOT NULL,
  `ads_content` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gxl_ads`
--

INSERT INTO `gxl_ads` (`ads_id`, `ads_name`, `ads_content`) VALUES
(38, 'ddd', '');

-- --------------------------------------------------------

--
-- 表的结构 `gxl_cm`
--

CREATE TABLE IF NOT EXISTS `gxl_cm` (
  `cm_id` mediumint(8) unsigned NOT NULL,
  `cm_cid` mediumint(9) NOT NULL,
  `cm_sid` tinyint(1) NOT NULL DEFAULT '1',
  `cm_uid` mediumint(9) NOT NULL DEFAULT '1',
  `cm_content` text NOT NULL,
  `cm_up` mediumint(9) NOT NULL DEFAULT '0',
  `cm_down` mediumint(9) NOT NULL DEFAULT '0',
  `cm_ip` varchar(20) NOT NULL,
  `cm_addtime` int(11) NOT NULL,
  `cm_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_collect`
--

CREATE TABLE IF NOT EXISTS `gxl_collect` (
  `collect_id` smallint(6) unsigned NOT NULL,
  `collect_title` varchar(50) NOT NULL,
  `collect_encoding` varchar(10) NOT NULL,
  `collect_player` varchar(50) NOT NULL,
  `collect_savepic` tinyint(4) NOT NULL,
  `collect_order` tinyint(4) NOT NULL,
  `collect_pagetype` tinyint(4) NOT NULL,
  `collect_liststr` text NOT NULL,
  `collect_pagestr` text NOT NULL,
  `collect_pagesid` smallint(6) unsigned NOT NULL,
  `collect_pageeid` smallint(6) unsigned NOT NULL,
  `collect_listurlstr` text NOT NULL,
  `collect_listlink` text NOT NULL,
  `collect_listpicstr` text NOT NULL,
  `collect_cid` text NOT NULL,
  `collect_listname` text NOT NULL,
  `collect_keywords` text NOT NULL,
  `collect_name` text NOT NULL,
  `collect_titlee` text NOT NULL,
  `collect_actor` text NOT NULL,
  `collect_director` text NOT NULL,
  `collect_content` text NOT NULL,
  `collect_pic` text NOT NULL,
  `collect_area` text NOT NULL,
  `collect_language` text NOT NULL,
  `collect_year` text NOT NULL,
  `collect_continu` text NOT NULL,
  `collect_urlstr` text NOT NULL,
  `collect_urlname` text NOT NULL,
  `collect_urllink` text NOT NULL,
  `collect_url` text NOT NULL,
  `collect_replace` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_comment`
--

CREATE TABLE IF NOT EXISTS `gxl_comment` (
  `comment_id` int(10) unsigned NOT NULL,
  `ting_id` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `creat_at` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '评论状态{0:未审核,-1:未通过审核,1:通过审核}',
  `content` varchar(255) DEFAULT NULL,
  `support` mediumint(8) DEFAULT '0' COMMENT '支持数',
  `reply` tinyint(1) DEFAULT '0' COMMENT '是否为回复',
  `oppose` mediumint(8) DEFAULT '0' COMMENT '反对数',
  `pid` int(10) DEFAULT NULL,
  `ispass` int(1) DEFAULT '0' COMMENT '1 通过 0 不通过',
  `rcid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_comment_opinion`
--

CREATE TABLE IF NOT EXISTS `gxl_comment_opinion` (
  `opinion_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) DEFAULT NULL,
  `opinion` int(1) DEFAULT NULL COMMENT '0 反对 1同意',
  `creat_date` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_gb`
--

CREATE TABLE IF NOT EXISTS `gxl_gb` (
  `gb_id` mediumint(8) unsigned NOT NULL,
  `gb_cid` mediumint(8) NOT NULL DEFAULT '0',
  `gb_uid` mediumint(9) NOT NULL DEFAULT '1',
  `gb_content` text NOT NULL,
  `gb_intro` text NOT NULL,
  `gb_addtime` int(11) NOT NULL,
  `gb_ip` varchar(20) NOT NULL,
  `gb_oid` tinyint(1) NOT NULL DEFAULT '0',
  `gb_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_guestbook`
--

CREATE TABLE IF NOT EXISTS `gxl_guestbook` (
  `gb_id` mediumint(8) unsigned NOT NULL,
  `gb_cid` mediumint(8) NOT NULL DEFAULT '0',
  `gb_uid` mediumint(9) NOT NULL DEFAULT '1',
  `nickname` varchar(20) NOT NULL,
  `gb_title` varchar(200) NOT NULL COMMENT '标题',
  `gb_content` text NOT NULL,
  `gb_intro` text NOT NULL,
  `gb_addtime` int(11) NOT NULL,
  `gb_ip` varchar(20) NOT NULL,
  `gb_oid` tinyint(1) NOT NULL DEFAULT '0',
  `gb_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_link`
--

CREATE TABLE IF NOT EXISTS `gxl_link` (
  `link_id` tinyint(4) unsigned NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `link_logo` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `link_order` tinyint(4) NOT NULL,
  `link_type` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_list`
--

CREATE TABLE IF NOT EXISTS `gxl_list` (
  `list_id` smallint(6) unsigned NOT NULL,
  `list_pid` smallint(3) NOT NULL,
  `list_oid` smallint(3) NOT NULL,
  `list_sid` tinyint(1) NOT NULL,
  `list_name` char(20) NOT NULL,
  `list_skin` char(20) NOT NULL,
  `list_skin_detail` varchar(20) NOT NULL DEFAULT 'gxl_ting',
  `list_skin_play` varchar(20) NOT NULL DEFAULT 'gxl_play',
  `list_skin_type` varchar(20) NOT NULL DEFAULT 'gxl_tingtype',
  `list_dir` varchar(90) NOT NULL,
  `list_status` tinyint(1) NOT NULL DEFAULT '1',
  `list_keywords` varchar(255) NOT NULL,
  `list_title` varchar(50) NOT NULL,
  `list_description` varchar(255) NOT NULL,
  `list_jumpurl` varchar(150) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gxl_list`
--

INSERT INTO `gxl_list` (`list_id`, `list_pid`, `list_oid`, `list_sid`, `list_name`, `list_skin`, `list_skin_detail`, `list_skin_play`, `list_skin_type`, `list_dir`, `list_status`, `list_keywords`, `list_title`, `list_description`, `list_jumpurl`) VALUES
(1, 0, 2, 1, '文学名著', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'wenxue', 1, '', '', '', ''),
(2, 0, 1, 1, '有声小说', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'tingbook', 1, '', '', '', 'http://'),
(3, 0, 3, 1, '曲艺戏曲', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'xiqu', 1, '', '', '', 'http://'),
(4, 0, 4, 1, '相声评书', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'zongyi', 1, '', '', '', 'http://'),
(8, 1, 2, 1, '散文随笔', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'sanwen', 1, '', '', '', 'http://'),
(9, 1, 1, 1, '通俗文学', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'tongsu', 1, '', '', '', 'http://'),
(10, 1, 5, 1, '诗词歌赋', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'shici', 1, '', '', '', 'http://'),
(11, 1, 3, 1, '青春文学', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'qingchui', 1, '', '', '', 'http://'),
(12, 1, 4, 1, ' 名家名著', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'mingjia', 1, '', '', '', 'http://'),
(13, 1, 6, 1, ' 外国文学', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'waiguo', 1, '', '', '', 'http://'),
(15, 2, 1, 1, '恐怖惊悚', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'kongbu', 1, '', '', '', 'http://'),
(16, 2, 2, 1, '悬疑探险', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'xuanyi', 1, '', '', '', 'http://'),
(17, 2, 6, 1, '都市传说', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'dushi', 1, '', '', '', 'http://'),
(18, 2, 5, 1, '武侠仙侠', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'wuxia', 1, '', '', '', 'http://'),
(19, 2, 8, 1, '穿越架空', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'chuanyue', 1, '', '', '', 'http://'),
(23, 2, 3, 1, ' 玄幻奇幻', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'xuanhuan', 1, '', '', '', 'http://'),
(24, 2, 4, 1, '历史军事', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'lishi', 1, '', '', '', 'http://'),
(25, 2, 7, 1, ' 网游科幻', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'wangyou', 1, '', '', '', 'http://'),
(26, 1, 7, 1, '国学经典', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'guoxue', 1, '', '', '', 'http://'),
(28, 1, 8, 1, '影视文学', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'yingshi', 1, '', '', '', 'http://'),
(35, 0, 5, 1, '少儿天地', 'gxl_letter', 'gxl_ting', 'gxl_play', 'gxl_tingtype', 'weidianying', 1, '', '', '', 'http://');

-- --------------------------------------------------------

--
-- 表的结构 `gxl_news`
--

CREATE TABLE IF NOT EXISTS `gxl_news` (
  `news_id` mediumint(8) unsigned NOT NULL,
  `news_cid` smallint(6) NOT NULL DEFAULT '0',
  `news_name` varchar(255) NOT NULL,
  `news_keywords` varchar(255) NOT NULL,
  `news_color` char(8) NOT NULL,
  `news_pic` varchar(255) NOT NULL,
  `news_inputer` varchar(50) NOT NULL,
  `news_reurl` varchar(255) NOT NULL,
  `news_remark` text NOT NULL,
  `news_content` text NOT NULL,
  `news_hits` mediumint(8) NOT NULL,
  `news_hits_day` mediumint(8) NOT NULL,
  `news_hits_week` mediumint(8) NOT NULL,
  `news_hits_month` mediumint(8) NOT NULL,
  `news_hits_lasttime` int(11) NOT NULL,
  `news_stars` tinyint(1) NOT NULL,
  `news_status` tinyint(1) NOT NULL DEFAULT '1',
  `news_up` mediumint(8) NOT NULL,
  `news_down` mediumint(8) NOT NULL,
  `news_jumpurl` varchar(255) NOT NULL,
  `news_letter` char(2) NOT NULL,
  `news_addtime` int(8) NOT NULL,
  `news_skin` varchar(30) NOT NULL,
  `news_gold` decimal(3,1) NOT NULL,
  `news_golder` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_slide`
--

CREATE TABLE IF NOT EXISTS `gxl_slide` (
  `slide_id` tinyint(3) unsigned NOT NULL,
  `slide_oid` tinyint(3) NOT NULL,
  `slide_cid` tinyint(3) NOT NULL DEFAULT '1',
  `slide_name` varchar(255) NOT NULL,
  `slide_logo` varchar(255) NOT NULL,
  `slide_pic` varchar(255) NOT NULL,
  `slide_url` varchar(255) NOT NULL,
  `slide_content` varchar(255) NOT NULL,
  `slide_status` tinyint(1) NOT NULL,
  `slide_vid` mediumint(8) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_special`
--

CREATE TABLE IF NOT EXISTS `gxl_special` (
  `special_id` mediumint(8) unsigned NOT NULL,
  `special_banner` varchar(150) NOT NULL,
  `special_logo` varchar(150) NOT NULL,
  `special_name` varchar(150) NOT NULL,
  `special_keywords` varchar(150) NOT NULL,
  `special_description` varchar(255) NOT NULL,
  `special_color` char(8) NOT NULL,
  `special_skin` varchar(50) NOT NULL,
  `special_addtime` int(11) NOT NULL,
  `special_hits` mediumint(8) NOT NULL,
  `special_hits_day` mediumint(8) NOT NULL,
  `special_hits_week` mediumint(8) NOT NULL,
  `special_hits_month` mediumint(8) NOT NULL,
  `special_hits_lasttime` int(11) NOT NULL,
  `special_stars` tinyint(1) NOT NULL DEFAULT '1',
  `special_status` tinyint(1) NOT NULL,
  `special_content` text NOT NULL,
  `special_up` mediumint(8) NOT NULL,
  `special_down` mediumint(8) NOT NULL,
  `special_gold` decimal(3,1) NOT NULL,
  `special_golder` smallint(6) NOT NULL,
  `special_letters` varchar(255) DEFAULT NULL,
  `special_mx` varchar(155) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_tag`
--

CREATE TABLE IF NOT EXISTS `gxl_tag` (
  `tag_id` mediumint(8) NOT NULL,
  `tag_sid` tinyint(1) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `gxl_tag`
--

INSERT INTO `gxl_tag` (`tag_id`, `tag_sid`, `tag_name`) VALUES
(0, 1, '未知');

-- --------------------------------------------------------

--
-- 表的结构 `gxl_ting`
--

CREATE TABLE IF NOT EXISTS `gxl_ting` (
  `ting_id` mediumint(8) unsigned NOT NULL COMMENT '作品id',
  `ting_cid` smallint(5) NOT NULL DEFAULT '0' COMMENT '作品栏目cid',
  `ting_name` varchar(255) NOT NULL DEFAULT '' COMMENT '作品名称',
  `ting_title` varchar(255) NOT NULL DEFAULT '' COMMENT '作品备注',
  `ting_keywords` varchar(255) NOT NULL,
  `ting_color` char(8) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `ting_anchor` varchar(255) NOT NULL COMMENT '主播',
  `ting_author` varchar(255) NOT NULL COMMENT '作者',
  `ting_content` text NOT NULL COMMENT '作品描述',
  `ting_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '作品图片',
  `ting_language` char(10) NOT NULL DEFAULT '' COMMENT '作品语言',
  `ting_addtime` int(11) NOT NULL DEFAULT '0' COMMENT '作品时间',
  `ting_hits` mediumint(8) NOT NULL DEFAULT '0' COMMENT '总点击',
  `ting_hits_day` mediumint(8) NOT NULL DEFAULT '0' COMMENT '日点击',
  `ting_hits_week` mediumint(8) NOT NULL DEFAULT '0' COMMENT '周点击',
  `ting_hits_month` mediumint(8) NOT NULL DEFAULT '0' COMMENT '月点击',
  `ting_hits_lasttime` int(11) NOT NULL,
  `ting_stars` tinyint(1) NOT NULL DEFAULT '0',
  `ting_status` tinyint(1) NOT NULL DEFAULT '1',
  `ting_up` mediumint(8) NOT NULL DEFAULT '0' COMMENT '顶',
  `ting_down` mediumint(8) NOT NULL DEFAULT '0' COMMENT '踩',
  `ting_play` varchar(255) NOT NULL,
  `ting_server` varchar(255) NOT NULL,
  `ting_url` longtext NOT NULL COMMENT '播放地址',
  `ting_inputer` varchar(30) NOT NULL,
  `ting_reurl` varchar(255) NOT NULL,
  `ting_jumpurl` varchar(150) NOT NULL,
  `ting_letter` char(2) NOT NULL,
  `ting_skin` varchar(30) NOT NULL,
  `ting_gold` decimal(3,1) NOT NULL,
  `ting_golder` smallint(6) NOT NULL,
  `ting_length` smallint(3) NOT NULL,
  `reid` int(10) NOT NULL DEFAULT '0',
  `HasGetComment` smallint(10) NOT NULL DEFAULT '0',
  `ting_letters` varchar(255) DEFAULT '0' COMMENT '首字母',
  `ting_total` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='听数据';

-- --------------------------------------------------------

--
-- 表的结构 `gxl_ting_mark`
--

CREATE TABLE IF NOT EXISTS `gxl_ting_mark` (
  `ting_id` int(10) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `F1` int(2) DEFAULT '0',
  `creat_date` int(11) DEFAULT NULL,
  `mark_id` int(10) unsigned NOT NULL,
  `F2` int(2) DEFAULT '0',
  `F3` int(2) DEFAULT '0',
  `F4` int(2) DEFAULT '0',
  `F5` int(2) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `gxl_view`
--

CREATE TABLE IF NOT EXISTS `gxl_view` (
  `view_id` mediumint(8) unsigned NOT NULL,
  `view_did` mediumint(8) NOT NULL,
  `view_uid` mediumint(8) NOT NULL,
  `view_addtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gxl_admin`
--
ALTER TABLE `gxl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `gxl_ads`
--
ALTER TABLE `gxl_ads`
  ADD PRIMARY KEY (`ads_id`);

--
-- Indexes for table `gxl_cm`
--
ALTER TABLE `gxl_cm`
  ADD PRIMARY KEY (`cm_id`);

--
-- Indexes for table `gxl_collect`
--
ALTER TABLE `gxl_collect`
  ADD PRIMARY KEY (`collect_id`);

--
-- Indexes for table `gxl_comment`
--
ALTER TABLE `gxl_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `vod_id` (`ting_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `status` (`status`),
  ADD KEY `ispass` (`ispass`),
  ADD KEY `pid` (`pid`),
  ADD KEY `ip` (`ip`),
  ADD KEY `creat_at` (`creat_at`),
  ADD KEY `rcid` (`rcid`);

--
-- Indexes for table `gxl_comment_opinion`
--
ALTER TABLE `gxl_comment_opinion`
  ADD PRIMARY KEY (`opinion_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `gxl_gb`
--
ALTER TABLE `gxl_gb`
  ADD PRIMARY KEY (`gb_id`);

--
-- Indexes for table `gxl_guestbook`
--
ALTER TABLE `gxl_guestbook`
  ADD PRIMARY KEY (`gb_id`),
  ADD KEY `gb_uid` (`gb_uid`),
  ADD KEY `gb_cid` (`gb_cid`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `gb_addtime` (`gb_addtime`);

--
-- Indexes for table `gxl_link`
--
ALTER TABLE `gxl_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `gxl_list`
--
ALTER TABLE `gxl_list`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `list_oid` (`list_oid`),
  ADD KEY `list_name` (`list_name`),
  ADD KEY `list_dir` (`list_dir`);

--
-- Indexes for table `gxl_news`
--
ALTER TABLE `gxl_news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `news_cid` (`news_cid`),
  ADD KEY `news_up` (`news_up`),
  ADD KEY `news_down` (`news_down`),
  ADD KEY `news_gold` (`news_gold`),
  ADD KEY `news_hits` (`news_hits`,`news_cid`);

--
-- Indexes for table `gxl_slide`
--
ALTER TABLE `gxl_slide`
  ADD PRIMARY KEY (`slide_id`),
  ADD KEY `slide_status` (`slide_status`),
  ADD KEY `slide_oid` (`slide_oid`),
  ADD KEY `slide_cid` (`slide_cid`);

--
-- Indexes for table `gxl_special`
--
ALTER TABLE `gxl_special`
  ADD PRIMARY KEY (`special_id`),
  ADD UNIQUE KEY `special_letters` (`special_letters`);

--
-- Indexes for table `gxl_ting`
--
ALTER TABLE `gxl_ting`
  ADD PRIMARY KEY (`ting_id`),
  ADD KEY `ting_letters` (`ting_letters`),
  ADD KEY `ting_actor` (`ting_anchor`),
  ADD KEY `ting_director` (`ting_author`),
  ADD KEY `ting_up` (`ting_up`),
  ADD KEY `ting_down` (`ting_down`),
  ADD KEY `ting_gold` (`ting_gold`),
  ADD KEY `ting_addtime` (`ting_addtime`,`ting_cid`),
  ADD KEY `ting_hits` (`ting_hits`,`ting_cid`),
  ADD KEY `ting_hits_month` (`ting_hits_month`,`ting_cid`),
  ADD KEY `ting_filmtime` (`ting_cid`),
  ADD KEY `ting_cid` (`ting_cid`,`ting_status`);

--
-- Indexes for table `gxl_ting_mark`
--
ALTER TABLE `gxl_ting_mark`
  ADD PRIMARY KEY (`mark_id`),
  ADD KEY `vod_id` (`ting_id`),
  ADD KEY `mark_id` (`mark_id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `creat_date` (`creat_date`);

--
-- Indexes for table `gxl_view`
--
ALTER TABLE `gxl_view`
  ADD PRIMARY KEY (`view_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gxl_admin`
--
ALTER TABLE `gxl_admin`
  MODIFY `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gxl_ads`
--
ALTER TABLE `gxl_ads`
  MODIFY `ads_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `gxl_cm`
--
ALTER TABLE `gxl_cm`
  MODIFY `cm_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_collect`
--
ALTER TABLE `gxl_collect`
  MODIFY `collect_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_comment`
--
ALTER TABLE `gxl_comment`
  MODIFY `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_comment_opinion`
--
ALTER TABLE `gxl_comment_opinion`
  MODIFY `opinion_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_gb`
--
ALTER TABLE `gxl_gb`
  MODIFY `gb_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_guestbook`
--
ALTER TABLE `gxl_guestbook`
  MODIFY `gb_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_link`
--
ALTER TABLE `gxl_link`
  MODIFY `link_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_list`
--
ALTER TABLE `gxl_list`
  MODIFY `list_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `gxl_news`
--
ALTER TABLE `gxl_news`
  MODIFY `news_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_slide`
--
ALTER TABLE `gxl_slide`
  MODIFY `slide_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `gxl_special`
--
ALTER TABLE `gxl_special`
  MODIFY `special_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `gxl_ting`
--
ALTER TABLE `gxl_ting`
  MODIFY `ting_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '作品id',AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `gxl_ting_mark`
--
ALTER TABLE `gxl_ting_mark`
  MODIFY `mark_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gxl_view`
--
ALTER TABLE `gxl_view`