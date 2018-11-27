DROP TABLE IF EXISTS `zzcms_about`;
CREATE TABLE `zzcms_about` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` longtext,
  `link` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_admin`;
CREATE TABLE `zzcms_admin` (
  `id` int(11) NOT NULL auto_increment,
  `groupid` int(11) default NULL,
  `admin` varchar(255) default NULL,
  `pass` varchar(255) default NULL,
  `logins` int(11) default '0',
  `loginip` varchar(255) default NULL,
  `lastlogintime` datetime default NULL,
  `showloginip` varchar(255) default NULL,
  `showlogintime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_login_times`;
CREATE TABLE `zzcms_login_times` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) default NULL,
  `count` int(11) default '0',
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_admingroup`;
CREATE TABLE `zzcms_admingroup` (
  `id` int(11) NOT NULL auto_increment,
  `groupname` varchar(255) default NULL,
  `config` varchar(1000) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_admingroup` values('1','超级管理员','zs#zsclass#zskeyword#dl#zh#zhclass#zx#zxclass#zxpinglun#zxtag#pp#job#jobclass#special#specialclass#adv#advclass#advtext#userreg#usernoreg#userclass#usergroup#guestbook#licence#badusermessage#fankui#uploadfiles#sendmessage#sendmail#sendsms#announcement#helps#bottomlink#friendlink#siteconfig#label#adminmanage#admingroup');
replace into `zzcms_admingroup` values('2','管理员(演示用)','zs#zskeyword#dl#zh#zx#zxpinglun#zxtag#pp#job#special#userreg#usernoreg#usergroup#guestbook#licence#badusermessage#fankui#sendmessage#sendmail#sendsms');

DROP TABLE IF EXISTS `zzcms_bad`;
CREATE TABLE `zzcms_bad` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `ip` varchar(255) default NULL,
  `dose` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `lockip` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_main`;
CREATE TABLE `zzcms_main` (
  `id` int(4) NOT NULL auto_increment,
  `proname` varchar(255) default NULL,
  `szm` varchar(255) default NULL,
  `prouse` text,
  `procompany` varchar(255) default NULL,
  `sm` text,
  `xuhao` int(4) default NULL,
  `bigclasszm` varchar(255) default NULL,
  `smallclasszm` varchar(255) default NULL,
  `shuxing`  int(4) default NULL,
  `img` varchar(255) default NULL,
  `flv` varchar(255) default NULL,
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `zc` text,
  `yq` text,
  `other` text,
  `shuxing_value` text,
  `sendtime` datetime default NULL,
  `timefororder` varchar(255) default NULL,
  `editor` varchar(255) default NULL,
  `elitestarttime` datetime default NULL,
  `eliteendtime` datetime default NULL,
  `title` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `refresh` int(11) default '0',
  `hit` int(11) default '0',
  `elite` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  `userid` int(11) default '0',
  `comane` varchar(255) default NULL,
  `qq` varchar(255) default NULL,
  `groupid` int(11) default '0',
  `renzheng` tinyint(4) default '0',
  `ppid` int(11) default '0',
  `gjzpm` tinyint(4) default '0',
  `tag` varchar(255) default NULL,
  `skin` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE  `zzcms_main` ADD INDEX (  `province` ,  `city` ,  `xiancheng` ) ;

DROP TABLE IF EXISTS `zzcms_dl`;
CREATE TABLE `zzcms_dl` (
  `id` int(11) NOT NULL auto_increment,
  `classzm` varchar(255) default NULL,
  `cpid` int(11) default '0',
  `cp` varchar(255) default NULL,
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `company` varchar(255) default NULL,
  `companyname` varchar(255) default NULL,
  `dlsname` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `tel` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `editor` varchar(255) default NULL,
  `saver` varchar(255) default NULL,
  `savergroupid` int(11) default '0',
  `ip` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `looked` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  `del` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE  `zzcms_dl` ADD INDEX (  `province` ,  `city` ,  `xiancheng` ) ;

DROP TABLE IF EXISTS `zzcms_baojia`;
CREATE TABLE `zzcms_baojia` (
  `id` int(11) NOT NULL auto_increment,
  `classzm` varchar(255) default NULL,
  `cp` varchar(255) default NULL,
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `price` varchar(50) default NULL,
  `danwei` varchar(50) default NULL,
  `companyname` varchar(255) default NULL,
  `truename` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `tel` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `editor` varchar(255) default NULL,
  `ip` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE  `zzcms_baojia` ADD INDEX (  `province` ,  `city` ,  `xiancheng` ) ;

DROP TABLE IF EXISTS `zzcms_guestbook`;
CREATE TABLE `zzcms_guestbook` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `content` longtext,
  `sendtime` datetime default NULL,
  `linkmen` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `saver` varchar(50) default NULL,
  `looked` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_help`;
CREATE TABLE `zzcms_help` (
  `id` int(11) NOT NULL auto_increment,
  `classid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `elite` tinyint(4) default '0',
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_licence`;
CREATE TABLE `zzcms_licence` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_link`;
CREATE TABLE `zzcms_link` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default '0',
  `sitename` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `content` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `logo` varchar(255) default NULL,
  `elite` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_link`;
CREATE TABLE `zzcms_link` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default '0',
  `sitename` varchar(255) default NULL,
  `url` varchar(255) default NULL,
  `content` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `logo` varchar(255) default NULL,
  `elite` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_linkclass`;
CREATE TABLE `zzcms_linkclass` (
  `bigclassid` int(11) NOT NULL auto_increment,
  `bigclassname` varchar(255) default NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bigclassid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_linkclass` values('1','合作网站','0');
replace into `zzcms_linkclass` values('2','友链网站','0');

DROP TABLE IF EXISTS `zzcms_looked_dls`;
CREATE TABLE `zzcms_looked_dls` (
  `id` int(11) NOT NULL auto_increment,
  `dlsid` int(11) default NULL,
  `username` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_looked_dls_number_oneday`;
CREATE TABLE `zzcms_looked_dls_number_oneday` (
  `id` int(11) NOT NULL auto_increment,
  `looked_dls_number_oneday` int(11) default NULL,
  `username` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zsclass_shuxing`;
CREATE TABLE `zzcms_zsclass_shuxing` (
  `bigclassid` int(11) NOT NULL auto_increment,
  `bigclassname` varchar(255) default NULL,
  `xuhao` int(11) default '0',
  PRIMARY KEY  (`bigclassid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_pp`;
CREATE TABLE `zzcms_pp` (
  `id` int(11) NOT NULL auto_increment,
  `ppname` varchar(255) default NULL,
  `bigclasszm` varchar(255) default NULL,
  `smallclasszm` varchar(255) default NULL,
  `sm` longtext,
  `img` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `editor` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `userid` int(11) default '0',
  `hit` int(11) default '0',
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_jobclass`;
CREATE TABLE `zzcms_jobclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(255) default NULL,
  `parentid` int(11) default '0',
  `xuhao` int(11) default '0',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_job`;
CREATE TABLE `zzcms_job` (
  `id` int(11) NOT NULL auto_increment, 
  `bigclassid` int(11) default '0',
  `bigclassname` varchar(255) default NULL,
  `smallclassid` int(11) default '0',
  `smallclassname` varchar(255) default NULL,
  `jobname` varchar(255) default NULL,
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `sm` varchar(1000) default NULL,
  `editor` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `userid` int(11) default '0',
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_message`;
CREATE TABLE `zzcms_message` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `sendtime` datetime default NULL,
  `sendto` varchar(50) NOT NULL,
  `looked` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `zzcms_ad`;
CREATE TABLE `zzcms_ad` (
  `id` int(11) NOT NULL auto_increment,
  `xuhao` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `titlecolor` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassname` varchar(50) default NULL,
  `username` varchar(50) default NULL,
  `nextuser` varchar(50) default NULL,
  `elite` tinyint(4) NOT NULL default '0',
  `img` varchar(255) default NULL,
  `imgwidth` int(11) default NULL,
  `imgheight` int(11) default NULL,
  `starttime` datetime default NULL,
  `endtime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_adclass`;
CREATE TABLE `zzcms_adclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(255) NOT NULL,
  `parentid` varchar(255) NOT NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_adclass` values('1','对联广告右侧','首页','0');
replace into `zzcms_adclass` values('2','对联广告左侧','首页','0');
replace into `zzcms_adclass` values('3','漂浮广告','首页','0');
replace into `zzcms_adclass` values('4','首页顶部','首页','0');
replace into `zzcms_adclass` values('5','品牌招商','首页','0');
replace into `zzcms_adclass` values('6','banner','首页','0');
replace into `zzcms_adclass` values('7','轮显广告','展会页','0');
replace into `zzcms_adclass` values('8','第二行','首页','0');
replace into `zzcms_adclass` values('9','轮显广告','首页','0');
replace into `zzcms_adclass` values('10','第一行','首页','0');
replace into `zzcms_adclass` values('11','B','首页','0');
replace into `zzcms_adclass` values('12','A','首页','0');
replace into `zzcms_adclass` values('13','首页','A','0');

DROP TABLE IF EXISTS `zzcms_pay`;
CREATE TABLE `zzcms_pay` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `dowhat` varchar(255) default NULL,
  `RMB` varchar(255) default '0',
  `mark` varchar(255) default NULL,
  `sendtime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_pinglun`;
CREATE TABLE `zzcms_pinglun` (
  `id` int(11) NOT NULL auto_increment,
  `about` int(11) default '0',
  `content` varchar(255) default NULL,
  `face` varchar(50) default NULL,
  `username` varchar(50) default NULL,
  `ip` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_tagzx`;
CREATE TABLE `zzcms_tagzx` (
  `id` int(11) NOT NULL auto_increment,
  `xuhao` int(11) default '0',
  `keyword` varchar(50) default NULL,
  `url` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_tagzs`;
CREATE TABLE `zzcms_tagzs` (
  `id` int(11) NOT NULL auto_increment,
  `keyword` varchar(50) default NULL,
  `url` varchar(255) default NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_textadv`;
CREATE TABLE `zzcms_textadv` (
  `id` int(11) NOT NULL auto_increment,
  `adv` varchar(255) default NULL,
  `company` varchar(255) NOT NULL,
  `advlink` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `username` varchar(50) default NULL,
  `gxsj` datetime default NULL,
  `newsid` int(11) NOT NULL default '0',
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `adv` (`adv`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_user`;
CREATE TABLE `zzcms_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passwordtrue` varchar(255) default NULL,
  `qqid` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `sex` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `content` longtext,
  `bigclassid` int(11) default '0',
  `smallclassid` int(11) default '0',
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `img` varchar(255) default NULL,
  `flv` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `somane` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `mobile` varchar(255) default NULL,
  `fox` varchar(255) default NULL,
  `qq` varchar(255) default NULL,
  `regdate` datetime default NULL,
  `loginip` varchar(255) default NULL,
  `logins` int(11) NOT NULL default '0',
  `homepage` varchar(255) default NULL,
  `lastlogintime` datetime default NULL,
  `lockuser` tinyint(4) NOT NULL default '0',
  `groupid` int(11) NOT NULL default '1',
  `totleRMB` int(11) NOT NULL default '0',
  `startdate` datetime default NULL,
  `enddate` datetime default NULL,
  `showloginip` varchar(255) default NULL,
  `showlogintime` datetime default NULL,
  `elite` tinyint(4) NOT NULL default '0',
  `renzheng` tinyint(4) NOT NULL default '0',
  `usersf` varchar(255) default NULL,
  `passed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_usergroup`;
CREATE TABLE `zzcms_usergroup` (
  `id` int(11) NOT NULL auto_increment,
  `groupid` int(11) NOT NULL default '1',
  `groupname` varchar(255) NOT NULL,
  `grouppic` varchar(255) NOT NULL,
  `RMB` int(11) NOT NULL default '0',
  `config` varchar(1000) NOT NULL default '0',
  `looked_dls_number_oneday` int(11) NOT NULL default '0',
  `refresh_number` int(11) NOT NULL default '0',
  `addinfo_number` int(11) NOT NULL default '0',
  `addinfototle_number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_usergroup` values('1','1','普通会员','/image/level1.gif','0','showad_inzt','10','1','50','100');
replace into `zzcms_usergroup` values('2','2','vip会员','/image/level2.gif','1999','look_dls_data#look_dls_liuyan','100','3','100','500');
replace into `zzcms_usergroup` values('3','3','高级会员','/image/level3.gif','2999','look_dls_data#look_dls_liuyan','999','999','999','999');

DROP TABLE IF EXISTS `zzcms_userclass`;
CREATE TABLE `zzcms_userclass` (
  `classid` int(11) NOT NULL auto_increment,
  `parentid` int(11) default '0',
  `classname` varchar(255) NOT NULL,
  `xuhao` int(11) NOT NULL default '0',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_userclass` values('1','0','生产单位','0');
replace into `zzcms_userclass` values('2','0','经销单位','0');
replace into `zzcms_userclass` values('4','0','展会承办单位','0');
replace into `zzcms_userclass` values('5','0','其它相关行业','0');

DROP TABLE IF EXISTS `zzcms_usermessage`;
CREATE TABLE `zzcms_usermessage` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `sendtime` datetime default NULL,
  `editor` varchar(50) default NULL,
  `reply` varchar(1000) default NULL,
  `replytime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_usernoreg`;
CREATE TABLE `zzcms_usernoreg` (
  `id` int(11) NOT NULL auto_increment,
  `usersf` varchar(50) default NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) default NULL,
  `comane` varchar(255) default NULL,
  `kind` int(11) NOT NULL default '0',
  `somane` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `checkcode` varchar(255) default NULL,
  `regdate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_usersetting`;
CREATE TABLE `zzcms_usersetting` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `skin` varchar(255) default '1',
  `skin_mobile` varchar(50) default '1',
  `tongji` varchar(255) default NULL,
  `baidu_map` varchar(255) default NULL,
  `mobile` varchar(255) default NULL,
  `daohang` varchar(255) default NULL,
  `bannerbg` varchar(255) default NULL,
  `bannerheight` int(11) NOT NULL default '160',
  `swf` varchar(255) default NULL,
  `comanestyle` varchar(255) default NULL,
  `comanecolor` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zh`;
CREATE TABLE `zzcms_zh` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `timestart` datetime default NULL,
  `timeend` datetime default NULL,
  `content` longtext,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  `elite` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zhclass`;
CREATE TABLE `zzcms_zhclass` (
  `bigclassid` int(11) NOT NULL auto_increment,
  `bigclassname` varchar(50) default NULL,
  `xuhao` int(11) default '0',
  PRIMARY KEY  (`bigclassid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_wangkan`;
CREATE TABLE `zzcms_wangkan` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  `elite` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_wangkanclass`;
CREATE TABLE `zzcms_wangkanclass` (
  `bigclassid` int(11) NOT NULL auto_increment,
  `bigclassname` varchar(50) default NULL,
  `xuhao` int(11) default '0',
  PRIMARY KEY  (`bigclassid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zsclass`;
CREATE TABLE `zzcms_zsclass` (
  `classid` int(11) NOT NULL auto_increment,
  `parentid` varchar(255) NOT NULL default 'A',
  `classname` varchar(255) NOT NULL,
  `classzm` varchar(255) default NULL,
  `img` varchar(255) NOT NULL default '0',
  `xuhao` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  `isshow` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zx`;
CREATE TABLE `zzcms_zx` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassid` int(11) default NULL,
  `smallclassname` varchar(50) default NULL,
  `title` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `laiyuan` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  `elite` tinyint(4) default '0',
  `groupid` int(11) default '1',
  `jifen` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_zxclass`;
CREATE TABLE `zzcms_zxclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(50) default NULL,
  `parentid` int(11) default '0',
  `xuhao` int(11) default '0',
  `isshowforuser` tinyint(4) default '1',
  `isshowininfo` tinyint(4) default '1',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  `skin` varchar(50) default NULL,
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_zxclass` values('1','公司新闻','0','0','1','1','','','','');
replace into `zzcms_zxclass` values('2','大类二','0','0','1','1','','','','');
replace into `zzcms_zxclass` values('3','大类三','0','0','1','1','','','','');
replace into `zzcms_zxclass` values('4','大类四','0','0','1','1','','','','');

DROP TABLE IF EXISTS `zzcms_ask`;
CREATE TABLE `zzcms_ask` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassid` int(11) default NULL,
  `smallclassname` varchar(50) default NULL,
  `title` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `jifen` int(11) default '0',
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `elite` tinyint(4) default '0',
  `typeid` int(11) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_asklass`;
CREATE TABLE `zzcms_askclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(50) default NULL,
  `parentid` int(11) default '0',
  `xuhao` int(11) default '0',
  `isshowforuser` tinyint(4) default '1',
  `isshowininfo` tinyint(4) default '1',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_answer`;
CREATE TABLE `zzcms_answer` (
  `id` int(11) NOT NULL auto_increment,
  `about` int(11) default '0',
  `content` longtext,
  `face` varchar(50) default NULL,
  `editor` varchar(50) default NULL,
  `ip` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `caina` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_special`;
CREATE TABLE `zzcms_special` (
  `id` int(11) NOT NULL auto_increment,
  `bigclassid` int(11) default NULL,
  `bigclassname` varchar(50) default NULL,
  `smallclassid` int(11) default NULL,
  `smallclassname` varchar(50) default NULL,
  `title` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `laiyuan` varchar(255) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `content` longtext,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `passed` tinyint(4) default '0',
  `elite` tinyint(4) default '0',
  `groupid` int(11) default '1',
  `jifen` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_specialclass`;
CREATE TABLE `zzcms_specialclass` (
  `classid` int(11) NOT NULL auto_increment,
  `classname` varchar(50) default NULL,
  `parentid` int(11) default '0',
  `xuhao` int(11) default '0',
  `isshowforuser` tinyint(4) default '1',
  `isshowininfo` tinyint(4) default '1',
  `title` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `discription` varchar(255) default NULL,
  PRIMARY KEY  (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
replace into `zzcms_specialclass` values('1','2015广西药交会','0','0','1','1','','','');
replace into `zzcms_specialclass` values('2','访谈','1','0','1','1','','','');
replace into `zzcms_specialclass` values('3','名企直击','1','0','1','1','','','');
replace into `zzcms_specialclass` values('4','展会现场','1','0','1','1','','','');
replace into `zzcms_specialclass` values('5','展会简介','1','0','1','1','','','');
replace into `zzcms_specialclass` values('6','大背景图','1','0','1','1','','','');

DROP TABLE IF EXISTS `zzcms_msg`;
CREATE TABLE `zzcms_msg` (
  `id` int(11) NOT NULL auto_increment,
  `content` varchar(1000) NOT NULL,
  `elite` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_userdomain`;
CREATE TABLE `zzcms_userdomain` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `domain` varchar(255) default NULL,
  `passed` tinyint(4) default '0',
  `del` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `zzcms_ztad`;
CREATE TABLE `zzcms_ztad` (
  `id` int(11) NOT NULL auto_increment,
  `classname` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `img` varchar(255) default NULL,
  `editor` varchar(50) default NULL,
  `passed` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8