<?php
if(@$step==4){
if ($_POST['token'] != $_SESSION['token'] || $_POST['token']=='' ){    
echo "非法提交".$_POST['token']."<br>".$_SESSION['token'];
exit();
//}else{
//unset($_SESSION['token']);
}
?>
<script type="text/javascript">
function check() {
//创建正则表达式
var re=/^[A-Za-z0-9\\-_-]*$/;

	if (document.myform.db_host.value==''){
		alert('请填写数据库服务器');
		document.myform.db_host.focus();
		return false;
	}

	if (document.myform.db_user.value==''){
		alert('请填写数据库用户名');
		document.myform.db_user.focus();
		return false;
	}

	if (document.myform.db_name.value==''){
		alert('请填写数据库名');
		document.myform.db_name.focus();
		return false;
	}
	if(document.myform.db_name.value.search(re)==-1)  
	{
    alert("数据库名只能用字母或数字！");
	document.myform.db_name.focus();
	return false;
  	}

	if (document.myform.url.value==''){
		alert('请填写当前网站访问地址');
		document.myform.url.focus();
		return false;
	}
	if (document.myform.admin.value==''){
		alert('请填写管理员帐号');
		document.myform.admin.focus();
		return false;
	}
	if (document.myform.adminpwd.value==''){
		alert('请填写管理员帐号');
		document.myform.adminpwd.focus();
		return false;
	}
	if (document.myform.adminpwd.value!=document.myform.adminpwd2.value){
	alert ("两次密码输入不一致，请重新输入。");
	document.myform.adminpwd.value='';
	document.myform.adminpwd2.value='';
	document.myform.adminpwd.focus();
	return false;
	}  

	document.getElementById("tip").style.display = '';
	document.getElementById("button_b").disabled = true;
	document.getElementById("button_n").disabled = true;
	return true;
}
</script>
<div class="body">
<form action="index.php" method="post" id="myform" name="myform" onsubmit="return check();">
<input type="hidden" name="step" value="5"/>
<input name="token" type="hidden"  value="<?php echo $_POST['token']?>"/>
    <table width="100%" cellpadding="3" cellspacing="1">
      <tr> 
        <td width="31%" align="right"><strong>填写数据库信息</strong></td>
        <td width="69%" align="left">&nbsp; </td>
      </tr>
      <tr> 
        <td align="right">数据库服务器</td>
        <td width="69%" align="left"><input name="db_host" type="text" id="db_host" value="localhost" style="width:150px"/>
          通常为localhost或服务器IP地址</td>
      </tr>
      <tr> 
        <td align="right">数据库用户名</td>
        <td align="left"> <input name="db_user" type="text" id="db_user" value="root" style="width:150px"/></td>
      </tr>
      <tr> 
        <td align="right">数据库密码</td>
        <td align="left"> <input name="db_pass" type="text" id="db_pass2" value="" style="width:150px"/></td>
      </tr>
      <tr> 
        <td align="right">数据库名</td>
        <td align="left"> <input name="db_name" type="text" id="db_name2" value="" style="width:150px" /></td>
      </tr>
      <tr> 
        <td align="right">网站访问地址</td>
        <td align="left"> <input name="url" type="text" id="url" value="http://<?php echo $_SERVER['HTTP_HOST'];?>" style="width:150px"/></td>
      </tr>
      <tr> 
        <td align="right"><strong>填写管理员信息</strong></td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr> 
        <td align="right">管理员账号</td>
        <td align="left"><input name="admin" type="text" id="admin" value="admin" style="width:150px"/></td>
      </tr>
      <tr> 
        <td align="right"> 管理员密码</td>
        <td align="left"><input name="adminpwd" type="password" id="adminpwd" value="" style="width:150px"/></td>
      </tr>
      <tr> 
        <td align="right"> 重复密码</td>
        <td align="left"><input name="adminpwd2" type="password" id="adminpwd2" value="" style="width:150px"/></td>
      </tr>
      <tr> 
        <td colspan="2"><span id="tip" style="color:blue;display:none;"> 安装正在进行，请稍候...</span></td>
      </tr>
    </table>

      <input type="button" value="上一步" class="btn" id="button_b" onclick="history.back(-1);"/>
      <input type="submit" value="下一步" class="btn" id="button_n"/>
&nbsp;&nbsp;
      <input type="button" value="取消" class="btn" onclick="if(confirm('您确定要退出安装向导吗？')) window.close();"/>
</form>
</div>
<?php
}
?>