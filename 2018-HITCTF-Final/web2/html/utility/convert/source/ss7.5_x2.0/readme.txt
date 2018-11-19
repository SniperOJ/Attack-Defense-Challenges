====================================
SupeSite 7.5 升级至 Discuz! X2.0 说明
====================================

特别警示!!!
Discuz! X2.0中并未具备SupeSite 7.5中的全部功能，
此转换程序，仅转换SupeSite 7.5中的资讯分类、资讯文章数据到 Discuz! X2.0产品的文章系统中。
其他数据将不进行转换。
因此，数据转换后，Discuz! X2.0产品存在原有SupeSite功能丢失和数据丢失问题，请自行权衡决定是否转换升级。


I 升级前的准备
---------------
1. 建立程序备份目录，例如 old
2. 将原SupeSite所有程序移动到 old 目录中
3. 上传 Discuz! X2.0 产品的upload目录中的程序到SupeSite目录
4. 执行安装程序 /install
   安装的时候请指定原SupeSite挂接的UCenter Server地址（如果 UCenter版本低于1.6.0，需先升级 UCenter ）

II 升级SupeSite数据
---------------
1. 安装完毕，测试Discuz! X2.0可以正常运行以后，上传convert 程序到Discuz! X2.0根目录
2. 执行 /convert
3. 选择相应的程序版本，开始转换
4. 转换过程中不可擅自中断，直到程序自动执行完毕。
5. 转换过程可能需要较长时间，且消耗较多服务器资源，您应当选择服务器空闲的时候执行

III 升级完毕, 还要做的几件事
--------------------------
1. 编辑新Discuz! X2.0的 config/config_global.php 文件，设定好创始人
2. 直接访问新Discuz! X2.0的 admin.php
3. 使用创始人帐号登录，进入后台更新缓存
4. 新系统增加了很多设置项目，包括用户权限、组权限、论坛板块等等，您需要仔细的重新设置一次。
5. 转移旧附件目录到新产品根目录（在转移之前，您的资讯内容中的图片无法正常显示）
   a)将 old/attachments 目录和目录下的文件 全部移动到 新Discuz! X2.0产品的/data/attachment/portal/目录中
   b) 在原 SS7 源码下找到图标 images/base/attachment.gif，放在 Disucuz！ X2.0 的目录 static/image/filetype/ 下；
   c) 找到 source/module/portal/portal_view.php 文件，在代码“$content['content'] = blog_bbcode($content['content']);”后换行添加以下代码：

	$ss_url = 'http://your_ss_site_url/'; // 请将此链接地址改为您的 SS 站点地址！！！
	$findarr = array(
		$ss_url.'batch.download.php?aid=', // 附件下载地址
		$ss_url.'attachments/',  // 附件图片目录
		$ss_url.'images/base/attachment.gif'  // 附件下载图标
	);
	$replacearr = array(
		'porta.php?mod=attachment&id=',
		$_G['setting']['attachurl'].'/portal/',
		STATICURL.'image/filetype/attachment.gif'
	);
	$content['content'] = str_replace($findarr, $replacearr, $content['content']);

6. 转移旧图片目录到新产品根目录（在转移之前，您的资讯内容中的表情无法正常显示）
   a)将 old/images 目录和目录下的文件 移动到 新Discuz! X2.0产品的根目录中
7. 删除 convert 程序，以免给您的Discuz! X2.0安装带来隐患。