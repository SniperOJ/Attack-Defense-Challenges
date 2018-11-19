===============================
SS7 转换到 Discuz！ X1 注意事项
===============================

问题：转换后的图片及附件地址不对？
方案： 步骤如下：
1. 在原 SS7 源码下找到图标 images/base/attachment.gif，放在 Disucuz！ X1 的目录 static/image/filetype/ 下；
2. 找到 source/module/portal/portal_view.php 文件，在代码“$content['content'] = blog_bbcode($content['content']);”后换行添加以下代码：

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


