<?php
$config = require './Runtime/Conf/config.php';
$array = array(
	'USER_AUTH_KEY'=>'gxlcmsting',// 用户认证SESSION标记
	'NOT_AUTH_ACTION'=>'index,top,left,main',// 默认无需认证操作
	'REQUIRE_AUTH_MODULE'=>'Admin,List,Ting,News,User,Collect,Data,Upload,Link,Ads,Cache,Create,Template,Cm,Gb,Tag,Special,Nav,Side,Pic',// 默认需要认证模型
	'URL_PATHINFO_DEPR'=>'-',
	'TMPL_DETECT_THEME'     =>  false,       // 自动侦测模板主题
    'TMPL_TEMPLATE_SUFFIX'  =>  '.tpl',     // 默认模板文件后缀
	'DEFAULT_C_LAYER'=>  'Action', // 默认的控制器层名称
	'MODULE_ALLOW_LIST'=>array('Admin','Home','Plus'),//项目分组
	'DEFAULT_M_LAYER'=>  'Model', // 默认的模型层名称
	'VIEW_PATH'=>'./Template/',
	'USER_THEME_PATH'=>'./Public/user/',
	'TMPL_FILE_DEPR'=>'_',//模板文件MODULE_NAME与ACTION_NAME之间的分割符，只对项目分组部署有效
	'TMPL_STRIP_SPACE'=> true,// 是否去除模板文件里面的html空格与换行
	'LANG_SWITCH_ON'=>true,// 多语言包功能
	'LANG_AUTO_DETECT'=>false,//是否自动侦测浏览器语言
	'URL_CASE_INSENSITIVE'=>true,//URL是否不区分大小写 默认区分大小写
	'DB_FIELDTYPE_CHECK'=>true, //是否进行字段类型检查
	'DATA_CACHE_SUBDIR'=>true,//哈希子目录动态缓存的方式
	'SHOW_ERROR_MSG'=>true, //关闭错误输出
	'TMPL_ACTION_ERROR'     => './Public/jump/jumpurl.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   => './Public/jump/jumpurl.html', // 默认成功跳转对应的模板文件		
	'DATA_PATH_LEVEL'=>2,
	'URL_MODEL' => '3',
	'LOG_RECORD' => true,
	'play_player' =>array (
		'ting'=>    array('01','云播放'),
	),
	 //'APP_DEBUG'           =>true,    // 是否开启调试模式
   // 'SHOW_RUN_TIME'		=> true,   // 运行时间显示
    //'SHOW_ADV_TIME'		=> true,   // 显示详细的运行时间
   // 'SHOW_DB_TIMES'		=> true,   // 显示数据库查询和写入次数	
);
return array_merge($config,$array);
?>