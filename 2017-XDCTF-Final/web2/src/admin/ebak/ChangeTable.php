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

$link=db_connect();
$empire=new mysqlquery();

//CheckFormVarNum
function Ebak_CheckFormVarNum($tbnum){
	if($tbnum<960)
	{
		return 0;
	}
	if(function_exists('ini_get'))
	{
		$val=@ini_get('max_input_vars');
	}
	else
	{
		$val=@get_cfg_var('max_input_vars');
	}
	if(!$val)
	{
		return 0;
	}
	if($val-$tbnum>40)
	{
		return 0;
	}
	return $val;
}

$mydbname=RepPostVar($_GET['mydbname']);
if(empty($mydbname))
{
	printerror("NotChangeDb","history.go(-1)");
}
//选择数据库
$udb=$empire->query("use `".$mydbname."`");
//存放目录
ini_set('date.timezone','Asia/Shanghai');
$mypath=$mydbname."_".date("Ymd")."_".make_password(6);
if($phpsafemod)
{
	$mypath="safemod";
}
//导入设置
$loadfile=RepPostVar($_GET['savefilename']);
if(strstr($loadfile,'.')||strstr($loadfile,'/')||strstr($loadfile,"\\"))
{
	$loadfile='';
}
if(empty($loadfile))
{
	$loadfile='def';
}
$loadfile='setsave/'.$loadfile;
@include($loadfile);
if($dmypath)
{
	$mypath=$dmypath;
}
//查询
$keyboard=RepPostVar($_GET['keyboard']);
if(empty($keyboard))
{
	$keyboard=$dkeyboard;
	if(empty($keyboard))
	{
		$keyboard=$baktbpre;
	}
}
$and="";
if($keyboard)
{
	$and=" LIKE '%$keyboard%'";
}
$sql=$empire->query("SHOW TABLE STATUS".$and);
require LoadAdminTemp('eChangeTable.php');
db_close();
$empire=null;
?>