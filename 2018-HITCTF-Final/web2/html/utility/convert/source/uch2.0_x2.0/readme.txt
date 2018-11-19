====================================
UCenter Home 2.0 升级至 Discuz! X2.0 说明
====================================

特别警示!!!
由于UCHome与Discuz!部分功能进行了整合性融合，因此UCHome的部分功能，在整合到Discuz! X后将会部分丢失，
其中包括：
由于新增专题功能，原UCH热闹功能将不再支持；
UCH投票、UCH活动将与论坛投票贴、活动贴的形式融合为一体，活动相册、活动群组功能将不再支持；
UCH群组将以新的群组功能存在，原群组相册、群组活动功能将不再支持；
个人资料进行了新的调整，UCH原个人资料中的学校、工作信息将需要重新填写；
UCH的全站实名功能不再支持；

请根据自己建站需求，权衡决定是否将UCHome转换升级到Discuz! X。

I 升级前的准备
---------------
1. 建立程序备份目录，例如 old
2. 将原UCHome所有程序移动到 old 目录中
3. 上传 Discuz! X 产品的upload目录中的程序到UCHome目录
4. 执行安装程序 /install
   安装的时候请指定原UCHome挂接的UCenter Server地址（如果 UCenter版本低于1.6.0，需先升级 UCenter ）

II 升级UCHome数据
---------------
1. 安装完毕，测试Discuz! X可以正常运行以后，上传convert 程序到Discuz! X根目录
2. 执行 /convert
3. 选择相应的程序版本，开始转换
4. 转换过程中不可擅自中断，直到程序自动执行完毕。
5. 转换过程可能需要较长时间，且消耗较多服务器资源，您应当选择服务器空闲的时候执行

III 升级完毕, 还要做的几件事
--------------------------
1. 编辑新Discuz! X的 config/config_global.php 文件，设定好创始人
2. 直接访问新Discuz! X的 admin.php
3. 使用创始人帐号登录，进入后台更新缓存
4. 新系统增加了很多设置项目，包括用户权限、组权限、论坛板块等等，您需要仔细的重新设置一次。
5. 转移旧附件目录到新产品根目录（在转移之前，您的动态、日志、评论、留言等内容中的图片无法正常显示）
   a)进入 old/attachment 目录
   b)将所有文件移动到 新Discuz! X产品 /data/attachment/album/ 目录中
   c)同时，修改一下 Discuz! X的代码
	 让日志内容中的已经插入的图片地址，通过字符串替换，改为最新的图片地址，解决日志内容图片无法显示的问题。
	 方法如下：
	 打开Discuz! X的 ./source/include/space/space_blog.php 程序
	 找到：
	 $blog['message'] = blog_bbcode($blog['message']);
	 在下面增加如下代码：
	 $home_url = 'http://your_home_site_url/'; // 请将此链接地址改为您的 UCHome 站点地址！！！
	 $bbs_url = 'http://your_bbs_site_url/'; // 请将此链接地址改为您的 BBS 站点地址！！！
	 $findarr = array(
		'<img src="attachment/',  //原uchmoe附件图片目录
		'<IMG src="'.$home_url.'attachment/',  // 原UCHome附件图片目录
		$bbs_url.'attachments/month',  // 原论坛附件图片目录
	 );
	 $replacearr = array(
		'<img src="'.$_G['setting']['attachurl'].'album/',
		'<IMG src="'.$_G['setting']['attachurl'].'album/',
		$bbs_url.$_G['setting']['attachurl'].'forum/month',
	 );
	 $blog['message'] = str_replace($findarr, $replacearr, $blog['message']);

	 如果你的UCHome的附件不是存放在默认的 ./attachment 目录，那么
	 修正上面代码的 <img src="attachment/ 中的 attachment 为你自己的附件目录名字
6. 转移旧图片目录到新产品根目录（在转移之前，您的动态、日志、评论、留言等内容中的表情无法正常显示）
   a)将 old/image 目录和目录下的文件 移动到 新Discuz! X产品的根目录中
7. 恢复 space.php URL地址的访问（在恢复之前，您的动态中的站内信息链接将指向无法访问的地址）
   1)将 utility/oldprg/uchome/space.php 文件移动到 新Discuz! X产品的根目录中
8. 删除 convert 程序，以免给您的Discuz! X安装带来隐患
9. 待测试新Discuz! X产品的所有功能均正常后，可以删除 旧的程序备份和数据备份