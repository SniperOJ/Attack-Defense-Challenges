<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<TITLE>管理员后台</TITLE>
<style type="text/css">
body { margin:0px; background:#337ABB url("image/manage_top_bg.gif"); font-size:12px;font-family: Arial, Helvetica, sans-serif,宋体,simsun; }
div { margin:0px; padding:0px; }
#tabs {
  width:100%;
  line-height:14px;
  }
#tabs ul {
  margin:0;
  padding:14px 10px 0 0px;
  list-style:none;
  }
#tabs li {
  float:left;
  margin:0 0px;
  padding:0;
  }
#tabs a {
  float:left;
  background:url("image/manage_tableft6.gif") no-repeat left top;
  margin:0;
  padding:0 0 0 4px;
  text-decoration:none;
  }
#tabs a span {
  float:left;
  display:block;
  background:url("image/manage_tabright6.gif") no-repeat right top;
  padding:8px 8px 6px 6px;
  color:#E9F4FF;
  }
#tabs a span {float:none;}
/* End IE5-Mac hack */
#tabs a:hover span {
  color:#fff;
  }
#tabs a:hover {
  background-position:0% -42px;
  }
#tabs a:hover span {
  background-position:100% -42px;
  color:#222;
  }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" align="center"><img src="image/manage_admin.gif" /></td>
    <td><div id="tabs">
		<ul>
			<li><a href="siteconfig.php" onmouseover="parent.frmleft.disp(7);" target="frmright"><span>网站设置</span></a></li>
			<li><a href="zs_manage.php" onmouseover="parent.frmleft.disp(1);" target="frmright"><span>信息</span></a></li>			
			<li><a href="zsclassmanage.php" onmouseover="parent.frmleft.disp(2);" target="frmright"><span>类别</span></a></li>
			<li><a href="ad_manage.php" onmouseover="parent.frmleft.disp(3);" target="frmright"><span>广告</span></a></li>
			<li><a href="usermanage.php" onmouseover="parent.frmleft.disp(4);" target="frmright"><span>用户</span></a></li>
			<li><a href="uploadfile_nouse.php" onmouseover="parent.frmleft.disp(5);" target="frmright"><span>文件</span></a></li>
			<li><a href="databaseclear.php" onmouseover="parent.frmleft.disp(8);" target="frmright"><span>数据库</span></a></li>
			<li><a href="javascript:void(0)" onmouseover="parent.frmleft.disp(9);" target="frmright"><span>标签</span></a></li>
			<li><a href="template.php" onmouseover="parent.frmleft.disp(10);" target="frmright"><span>模板</span></a></li>
			<li><a href="cachedel.php" onmouseover="parent.frmleft.disp(11);" target="frmright"><span>清缓存</span></a></li>
			<li><a href="message_add.php" onmouseover="parent.frmleft.disp(6);" target="frmright"><span>发消息</span></a></li>
		</ul>
	</div></td>
  </tr>
</table>
</body>
</html>