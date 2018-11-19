<?php
/**
 * 登录
 *
 * @version        $Id: admin_ads.php 1 8:26 2015年7月12日Z 海东青 $
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__).'/../duomiphp/common.php');
require_once(duomi_INC."/check.admin.php");
if(empty($dopost))
{
	$dopost = '';
}
//检测安装目录安全性
if( is_dir(dirname(__FILE__).'/../install') )
{
	if(!file_exists(dirname(__FILE__).'/../install/install_lock.txt') )
	{
  	$fp = fopen(dirname(__FILE__).'/../install/install_lock.txt', 'w') or die('安装目录无写入权限，无法进行写入锁定文件，请安装完毕删除安装目录！');
  	fwrite($fp,'ok');
  	fclose($fp);
	}
	//为了防止未知安全性问题，强制禁用安装程序的文件
	if( file_exists("../install/index.php") ) {
		@rename("../install/index.php", "../install/index.php.bak");
	}
}
//检测后台目录是否更名
$cururl = GetCurUrl();
if(m_eregi('/admin/login',$cururl))
{
	$redmsg = '<div style="color:#ff0000;font-size:14px;background:#fff;padding:5px 0">后台默认路径/admin建议及时修改，修改后会更安全！</div>';
}
else
{
	$redmsg = '';
}

//登录检测
$admindirs = explode('/',str_replace("\\",'/',dirname(__FILE__)));
$admindir = $admindirs[count($admindirs)-1];
if($dopost=='login')
{
	$validate = empty($validate) ? '' : strtolower(trim($validate));
	$svali = strtolower(GetCkVdValue());
	if($validate=='' || $validate != $svali)
	{
		ResetVdValue();
		ShowMsg('验证码不正确!','-1');
		exit();
	}
	else
	{
		$cuserLogin = new userLogin($admindir);
		if(!empty($userid) && !empty($pwd))
		{
			$res = $cuserLogin->checkUser($userid,$pwd);

			//success
			if($res==1)
			{
				$cuserLogin->keepUser();
				if(!empty($gotopage))
				{
					ShowMsg('成功登录，正在转向管理管理主页！',$gotopage);
					exit();
				}
				else
				{
					ShowMsg('成功登录，正在转向管理管理主页！',"index.php");
					exit();
				}
			}

			//error
			else if($res==-1)
			{
				ShowMsg('你的用户名不存在!','-1');
				exit();
			}
			else
			{
				ShowMsg('你的密码错误!','-1');
				exit();
			}
		}

		//password empty
		else
		{
			ShowMsg('用户和密码没填写完整!','-1');
				exit();
		}
	}
}
include('html/login.htm');
?>