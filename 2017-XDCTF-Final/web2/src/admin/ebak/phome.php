<?php
error_reporting(0);
session_start();
$ini = ini_get_all();
//print_r($ini);
$short_open_tag=$ini['short_open_tag']['global_value'];
if($short_open_tag !=1){echo '必须开启PHP短标签设置才可以正常使用！<br>修改php.ini文件 ，找到 short_open_tag = Off 这一行，将 Off 修改为 On，保存并重启web环境。';}

function CheckPurview()
{
	if($GLOBALS['cuserLogin']->getUserRank()<>1)
	{
		ShowMsg("对不起，你没有权限执行此操作！<br/><br/><a href='javascript:history.go(-1);'>点击此返回上一页&gt;&gt;</a>",'javascript:;');
		exit();
	}
}

class userLogin
{
	var $userName = '';
	var $userPwd = '';
	var $userID = '';
	var $adminDir = '';
	var $groupid = '';
	var $keepUserIDTag = "sea_admin_id";
	var $keepgroupidTag = "sea_group_id";
	var $keepUserNameTag = "sea_admin_name";

	//php5构造函数
	function __construct($admindir='')
	{
		global $admin_path;
		if(isset($_SESSION[$this->keepUserIDTag]))
		{
			$this->userID = $_SESSION[$this->keepUserIDTag];
			$this->groupid = $_SESSION[$this->keepgroupidTag];
			$this->userName = $_SESSION[$this->keepUserNameTag];
		}

		if($admindir!='')
		{
			$this->adminDir = $admindir;
		}
		else
		{
			$this->adminDir = $admin_path;
		}
	}

	function userLogin($admindir='')
	{
		$this->__construct($admindir);
	}

	//检验用户是否正确
	function checkUser($username,$userpwd)
	{
		global $dsql;

		//只允许用户名和密码用0-9,a-z,A-Z,'@','_','.','-'这些字符
		$this->userName = m_ereg_replace("[^0-9a-zA-Z_@!\.-]",'',$username);
		$this->userPwd = m_ereg_replace("[^0-9a-zA-Z_@!\.-]",'',$userpwd);
		$pwd = substr(md5($this->userPwd),5,20);
		$dsql->SetQuery("Select * From `sea_admin` where name like '".$this->userName."' and state='1' limit 0,1");
		$dsql->Execute();
		$row = $dsql->GetObject();
		if(!isset($row->password))
		{
			return -1;
		}
		else if($pwd!=$row->password)
		{
			return -2;
		}
		else
		{
			$loginip = GetIP();
			$this->userID = $row->id;
			$this->groupid = $row->groupid;
			$this->userName = $row->name;
			$inquery = "update `sea_admin` set loginip='$loginip',logintime='".time()."' where id='".$row->id."'";
			$dsql->ExecuteNoneQuery($inquery);
			return 1;
		}
	}

	//保持用户的会话状态
	//成功返回 1 ，失败返回 -1
	function keepUser()
	{
		if($this->userID!=""&&$this->groupid!="")
		{
			global $admincachefile;

			$_SESSION[$this->keepUserIDTag] = $this->userID;
			$_SESSION[$this->keepgroupidTag] = $this->groupid;
			$_SESSION[$this->keepUserNameTag] = $this->userName;

			$fp = fopen($admincachefile,'w');
			fwrite($fp,'<'.'?php $admin_path ='." '{$this->adminDir}'; ?".'>');
			fclose($fp);
			return 1;
		}
		else
		{
			return -1;
		}
	}

	//结束用户的会话状态
	function exitUser()
	{
		$_SESSION[$this->keepUserIDTag] = '';
		$_SESSION[$this->keepgroupidTag] = '';
		$_SESSION[$this->keepUserNameTag] = '';
	}


	//获得用户的权限值
	function getgroupid()
	{
		if($this->groupid!='')
		{
			return $this->groupid;
		}
		else
		{
			return -1;
		}
	}

	function getUserRank()
	{
		return $this->getgroupid();
	}

	//获得用户的ID
	function getUserID()
	{
		if($this->userID!='')
		{
			return $this->userID;
		}
		else
		{
			return -1;
		}
	}

	//获得用户名
	function getUserName()
	{
		if($this->userName!='')
		{
			return $this->userName;
		}
		else
		{
			return -1;
		}
	}
}
require('../../data/common.inc.php');
$cuserLogin = new userLogin();
$hashstr=md5($cfg_dbpwd.$cfg_dbname.$cfg_dbuser);//构造session安全码
if($cuserLogin->getUserID()==-1 OR $_SESSION['hashstr'] !== $hashstr)
{
	exit('ERROR! LOGIN PLEASE!');
}

require('class/connect.php');
require('class/functions.php');
require LoadLang('f.php');
$phome=$_GET['phome'];
if(empty($phome))
{$phome=$_POST['phome'];}
//登陆
if($phome=="login"||$phome=="ChangeLanguage")
{}
else
{
			
}
if($phome=="SetDb"||$phome=="DoRep"||$phome=="DoOpi"||$phome=="DoDrop"||$phome=="DropDb"||$phome=="CreateDb"||$phome=="EmptyTable"||$phome=="DoSave"||$phome=="DoDelSave"||$phome=="DelBakpath"||$phome=="DelZip"||$phome=="DoExecSql"||$phome=="DoTranExecSql"||$phome=="RepPathFiletext"||$phome=='ReplaceTable'||$phome=='CheckConnectDbServer'||$phome=='ChangeDbServer')
{
	include("class/combakfun.php");
}
if($phome=="SetDb"||$phome=="login"||$phome=="exit"||$phome=="ChangeLanguage"||$phome=="ChangeDbServer"||$phome=='CheckConnectDbServer')
{}
else
{
	$link=db_connect();
	$empire=new mysqlquery();
}
if($phome=="SetDb")//参数设置
{
	Ebak_SetDb($_POST);
}
elseif($phome=="DoRep")//修复表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Rep($tablename,$mydbname);
}
elseif($phome=="DoOpi")//忧化表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Opi($tablename,$mydbname);
}
elseif($phome=="DoDrop")//删除表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_Drop($tablename,$mydbname);
}
elseif($phome=="ReplaceTable")//替换表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	$oldpre=$_POST['oldtablepre'];
	$newpre=$_POST['newtablepre'];
	Ebak_ReplaceTable($tablename,$oldpre,$newpre,$mydbname);
}
elseif($phome=="DropDb")//删除数据库
{
	$mydbname=$_GET['mydbname'];
	Ebak_DropDb($mydbname);
}
elseif($phome=="CreateDb")//建立数据库
{
	$mydbname=$_POST['mydbname'];
	$mydbchar=$_POST['mydbchar'];
	Ebak_CreatDb($mydbname,$mydbchar);
}
elseif($phome=="EmptyTable")//清空表
{
	$tablename=$_POST['tablename'];
	$mydbname=$_POST['mydbname'];
	Ebak_EmptyTable($tablename,$mydbname);
}
elseif($phome=="exit")//退出系统
{
	LoginOut();
}
elseif($phome=="login")//登陆
{
	$lusername=$_POST['lusername'];
	$lpassword=$_POST['lpassword'];
	$key=$_POST['key'];
	login($lusername,$lpassword,$key,$lifetime);
}
elseif($phome=="DelBakpath")//删除备份目录
{
	$path=$_GET['path'];
	Ebak_DelBakpath($path);
}
elseif($phome=="DelZip")//删除压缩包
{
	$f=$_GET['f'];
	Ebak_DelZip($f);
}
elseif($phome=="DoZip")//压缩目录
{
	$p=$_GET['p'];
	Ebak_Dozip($p);
}
elseif($phome=="DoExecSql")//执行sql
{
	Ebak_DoExecSql($_POST);
}
elseif($phome=="DoTranExecSql")//上传执行sql
{
	$file=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
	Ebak_DoTranExecSql($file,$file_name,$file_type,$file_size,$_POST);
}
elseif($phome=="DoSave")//保存设置
{
	Ebak_SaveSeting($_POST);
}
elseif($phome=="DoDelSave")//删除设置
{
	Ebak_DelSeting($_GET);
}
elseif($phome=="SetGotoBak")//设置转向
{
	$savename=$_GET['savename'];
	Ebak_SetGotoBak($savename);
}
elseif($phome=="PathGotoRedata")//目录转向
{
	$mypath=$_GET['mypath'];
	Ebak_PathGotoRedata($mypath);
}
elseif($phome=="ChangeLanguage")//选择语言
{
	Ebak_ChangeLanguage($_GET);
}
elseif($phome=="RepPathFiletext")//替换目录文件
{
	Ebak_RepPathFiletext($_POST);
}
elseif($phome=="ChangeDbServer")//选择数据库服务器
{
	Ebak_ChangeDbServer($_GET);
}
elseif($phome=="CheckConnectDbServer")//测试数据库
{
	Ebak_CheckConnectDbServer($_POST);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
?>