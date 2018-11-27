<?php
define('UC_CONNECT','mysql') ;//连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen(),为了效率, 建议采用 mysql
define('UC_DBHOST','localhost') ;//UCenter 数据库主机
define('UC_DBUSER','root') ;//UCenter 数据库用户名
define('UC_DBPW','yourpass001') ;//UCenter 数据库密码
define('UC_DBNAME','ultrax') ;//UCenter 数据库名称
define('UC_DBCHARSET','gbk') ;//UCenter 数据库字符集
define('UC_DBTABLEPRE','`ultrax`.pre_ucenter_') ;//UCenter 数据库表前缀
define('UC_KEY','123456') ;//与 UCenter 的通信密钥, 要与 UCenter 保持一致
define('UC_API','http://bbs.zzcms.net/uc_server') ;// UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET','gbk') ;//UCenter 的字符集
define('UC_IP','') ;//UCenter的IP, 当UC_CONNECT为非mysql方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID','4') ;//当前应用的 ID
//ucexample_2.php 用到的应用程序数据库连接参数
$dbhost = 'localhost';			// 数据库服务器
$dbuser = 'root';			// 数据库用户名
$dbpw = 'root';				// 数据库密码
$dbname = '';			// 数据库名
$pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开
$tablepre = '';   		// 表名前缀, 同一数据库安装多个论坛请修改此处
$dbcharset = '';			// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定
//同步登录 Cookie 设置
$cookiedomain = 'http://localhost:8080'; 			// cookie 作用域
$cookiepath = '/';			// cookie 作用路径
?>