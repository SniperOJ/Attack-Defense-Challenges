<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择数据表</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
function reverseCheckAll(form)
{
  for (var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
	{
		continue;
	}
	if (e.name != 'chkall')
	{
	   if(e.checked==true)
	   {
       		e.checked = false;
	   }
	   else
	   {
	  		e.checked = true;
	   }
	}
  }
}
function SelectCheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
	  	e.checked = true;
    }
  }
function check()
{
	var ok;
	var oktwo;
	var okthree;
	var formdoaction;
	var saystr;
	formdoaction=document.ebakchangetb.phome.value;
	ok=confirm("确认要执行此操作?");
	if(ok==false)
	{
		return false;
	}
	if(formdoaction=='DoDrop'||formdoaction=='EmptyTable')
	{
		if(formdoaction=='DoDrop')
		{
			saystr='删除数据表';
		}
		else
		{
			saystr='清空数据表';
		}
		oktwo=confirm("再次确认要执行此操作("+saystr+")?");
		if(oktwo==false)
		{
			return false;
		}
		okthree=confirm("最后确认要执行此操作("+saystr+")?");
		if(okthree==false)
		{
			return false;
		}
	}
	else
	{
		oktwo=true;
		okthree=true;
	}
	if(ok&&oktwo&&okthree)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</head>
<body>
<script type="text/JavaScript">if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='后台首页&nbsp;&raquo;&nbsp;工具&nbsp;&raquo;&nbsp;数据库备份 ';</script>

  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="ebakchangetb" method="post" action="phomebak.php" onsubmit="return check();">
    <tr class="header"> 
      <td height="25">备份参数设置：<font color="yellow">【备份文件存储位置：admin/ebak/bdata,压缩文件存储位置：admin/ebak/zip】</font>
        <input name="phome" type="hidden" id="phome" value="DoEbak">        <input name="mydbname" type="hidden" id="mydbname" value="<?=$mydbname?>">        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <!---<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">

          <tr id="showsave" style="display:none">
            <td>&nbsp;</td>
            <td>保存文件名:setsave/ 
              <input name="savename" type="text" id="savename" value="<?=$_GET['savefilename']?>">
              <input name="Submit4" type="submit" id="Submit4" onClick="document.ebakchangetb.phome.value='DoSave';document.ebakchangetb.action='phome.php';" value="保存设置">
              <font color="#666666">(文件名请用英文字母,如：test)</font></td>
          </tr>
		  <tr id="showreptable" style="display:none">
            <td>&nbsp;</td>
            <td> 原字符: 
              <input name="oldtablepre" type="text" id="oldtablepre" size="18">
              新字符:
              <input name="newtablepre" type="text" id="newtablepre" size="18"> 
              <input name="Submit4" type="submit" id="Submit4" onClick="document.ebakchangetb.phome.value='ReplaceTable';document.ebakchangetb.action='phome.php';" value="替换选中表名">
            </td>
          </tr>
        </table>-->
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="22%"><input type="radio" name="baktype" value="0"<?=$dbaktype==0?' checked':''?>> 
              <strong>按文件大小备份</strong> </td>
            <td width="78%" height="23"> 每组备份大小: 
              <input name="filesize" type="text" id="filesize" value="1024" size="6">
              KB <font color="#666666">(1 MB = 1024 KB)</font></td>
          </tr>
          <tr> 
            <td><input type="radio" name="baktype" value="1"<?=$dbaktype==1?' checked':''?>> 
              <strong>按记录数备份</strong></td>
            <td height="23">每组备份 
              <input name="bakline" type="text" id="bakline" value="1000" size="6">
              条记录， 
              <input name="autoauf" type="checkbox" id="autoauf" value="1"<?=$dautoauf==1?' checked':''?>>
              自动识别自增字段<font color="#666666">(此方式效率更高)</font></td>
          </tr>
          <tr> 
            <td>备份数据库结构</td>
            <td height="23"><input name="bakstru" type="checkbox" id="bakstru" value="1"<?=$dbakstru==1?' checked':''?>>
              是 <font color="#666666">(没特殊情况，请选择)</font></td>
          </tr>
		 
          <tr> 
            <td>数据编码</td>
            <td height="23"> <select name="dbchar" id="dbchar">
				<option value="utf8" selected>utf8</option>              
              </select><font color="#666666"> (海洋cms默认使用utf8编码)</td>
          </tr>
          <tr>
            <td>数据存放格式</td>
            <td height="23"><input type="radio" name="bakdatatype" value="0"<?=$dbakdatatype==0?' checked':''?>>
              正常
              <input type="radio" name="bakdatatype" value="1"<?=$dbakdatatype==1?' checked':''?>>
              十六进制方式<font color="#666666">(十六进制备份文件会占用更多的空间)</font></td>
          </tr>
          <tr> 
            <td>存放目录</td>
            <td height="23"> 
              <?=$bakpath?>
              / 
              <input name="mypath" type="text" id="mypath" value="<?=$mypath?>" size="28"> 
              <font color="#666666"> 
              <input type="button" name="Submit2" value="选择目录" onclick="javascript:window.open('ChangePath.php?change=1&toform=ebakchangetb','','width=750,height=500,scrollbars=yes');">
              (目录不存在，系统会自动建立)</font></td>
          </tr>
          <tr> 
            <td>备份选项</td>
            <td height="23">导入方式: 
              <select name="insertf" id="select">
                <option value="replace"<?=$dinsertf=='replace'?' selected':''?>>REPLACE</option>
                <option value="insert"<?=$dinsertf=='insert'?' selected':''?>>INSERT</option>
              </select>
              , 
              <input name="beover" type="checkbox" id="beover" value="1"<?=$dbeover==1?' checked':''?>>
              完整插入，
              <!---<input name="bakstrufour" type="checkbox" id="bakstrufour" value="1"<?=$dbakstrufour==1?' checked':''?>>
              <a title="需要转换数据表编码时选择">转成MYSQL4.0格式</a>,--> 每组备份间隔： 
              <input name="waitbaktime" type="text" id="waitbaktime" value="<?=$dwaitbaktime?>" size="2">
              秒</td>
          </tr>
          <tr> 
            <td valign="top">备份说明<br> <font color="#666666">(系统会生成一个readme.txt)</font></td>
            <td height="23"><textarea name="readme" cols="80" rows="2" id="readme"><?=$dreadme?></textarea></td>
          </tr>
		  <!---
          <tr> 
            <td valign="top">去除自增值的字段列表：<br> <font color="#666666">(格式：<strong>表名.字段名</strong><br>
              多个请用&quot;,&quot;格开)</font></td>
            <td height="23"><textarea name="autofield" cols="80" rows="5" id="autofield"><?=$dautofield?></textarea></td>
          </tr>-->
        </table>
      </td>
    </tr>
    <tr class="header"> 
      <td height="25">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%"><font color="#FFFFFF">选择要备份的表：( <a href="#ebak" onclick="SelectCheckAll(document.ebakchangetb)"><font color="#FFFFFF"><u>全选</u></font></a> 
              | <a href="#ebak" onclick="reverseCheckAll(document.ebakchangetb);"><font color="#FFFFFF"><u>反选</u></font></a> )</font></td>
            <td><!--<div align="right"><font color="#FFFFFF">查询: 
                <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
                <input type="button" name="Submit32" value="显示数据表" onclick="self.location.href='ChangeTable.php?sear=1&mydbname=<?=$mydbname?>&keyboard='+document.ebakchangetb.keyboard.value;">
              </font></div>--></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr bgcolor="#DBEAF5"> 
            <td width="5%" height="23"> <div align="center">选择</div></td>
            <td width="27%" height="23" bgcolor="#DBEAF5"> 
              <div align="center">表名(点击查看字段)</div></td>
            <td width="13%" height="23" bgcolor="#DBEAF5"> 
              <div align="center">类型</div></td>
            <td width="15%" bgcolor="#DBEAF5">
<div align="center">编码</div></td>
            <td width="15%" height="23"> 
              <div align="center">记录数</div></td>
            <td width="14%" height="23"> 
              <div align="center">大小</div></td>
            <td width="11%" height="23"> 
              <div align="center">碎片</div></td>
          </tr>
          <?php
		  $tbchecked=' checked';
		  if($dtblist)
		  {
		  	$check=1;
		  }
		  $totaldatasize=0;//总数据大小
		  $tablenum=0;//总表数
		  $datasize=0;//数据大小
		  $rownum=0;//总记录数
		  while($r=$empire->fetch($sql))
		  {
		  	$rownum+=$r[Rows];
		  	$tablenum++;
		  	$datasize=$r[Data_length]+$r[Index_length];
		  	$totaldatasize+=$r[Data_length]+$r[Index_length]+$r[Data_free];
			if($check==1)
			{
				if(strstr($dtblist,','.$r[Name].','))
				{
					$tbchecked=' checked';
				}
				else
				{
					$tbchecked='';
				}
			}
			$collation=$r[Collation]?$r[Collation]:'---';
		  ?>
          <tr id=tb<?=$r[Name]?>> 
            <td height="23"> <div align="center"> 
                <input name="tablename[]" type="checkbox" id="tablename[]" value="<?=$r[Name]?>" onclick="if(this.checked){tb<?=$r[Name]?>.style.backgroundColor='#F1F7FC';}else{tb<?=$r[Name]?>.style.backgroundColor='#ffffff';}"<?=$tbchecked?>>
              </div></td>
            <td height="23"> <div align="left"><a href="#ebak" onclick="window.open('ListField.php?mydbname=<?=$mydbname?>&mytbname=<?=$r[Name]?>','','width=660,height=500,scrollbars=yes');" title="点击查看表字段列表"> 
                <?=$r[Name]?>
                </a></div></td>
            <td height="23"> <div align="center">
                <?=$r[Type]?$r[Type]:$r[Engine]?>
              </div></td>
            <td><div align="center">
				<?=$collation?>
              </div></td>
            <td height="23"> <div align="right">
                <?=$r[Rows]?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($datasize)?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($r[Data_free])?>
              </div></td>
          </tr>
          <?
		  }
		  ?>
          <tr bgcolor="#DBEAF5"> 
            <td height="23"> <div align="center">
                <input type=checkbox name=chkall value=on onclick="CheckAll(this.form)"<?=$check==0?' checked':''?>>
              </div></td>
            <td height="23"> <div align="center"> 
                <?=$tablenum?>
              </div></td>
            <td height="23"> <div align="center">---</div></td>
            <td><div align="center">---</div></td>
            <td height="23"> <div align="center">
                <?=$rownum?>
              </div></td>
            <td height="23" colspan="2"> <div align="center">
                <?=Ebak_ChangeSize($totaldatasize)?>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr class="header"> 
      <td height="25">
<div align="center" id="go">
          <input type="submit" name="Submit" value="开始备份" onclick="document.ebakchangetb.phome.value='DoEbak';document.ebakchangetb.action='phomebak.php';">
          &nbsp;&nbsp; &nbsp;&nbsp;
          <input type="submit" name="Submit2" value="修复数据表" onclick="document.ebakchangetb.phome.value='DoRep';document.ebakchangetb.action='phome.php';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="优化数据表" onclick="document.ebakchangetb.phome.value='DoOpi';document.ebakchangetb.action='phome.php';">
        &nbsp;&nbsp; &nbsp;&nbsp;  
		</div></td>
    </tr>
	</form>
  </table>
<br>
<?php
$ckmaxinputnum=Ebak_CheckFormVarNum($tablenum);
if($ckmaxinputnum)
{
?>
	<script>
	document.getElementById("ckmaxinputnum").innerHTML="<font color=red><?=$ckmaxinputnum?></font>";
	checkmaxinput.style.display="";
	</script>
<?php
}
?>
<?php
echo "<div align=center>";
echo "</div><div class=\"bottom2\"><table width=\"100%\" cellspacing=\"5\"><tr><td align=\"center\">该功能基于帝国备份王核心</td></tr><tr><td align=\"center\"><a target=\"_blank\" href=\"http://www.seacms.net/\">Powered By Seacms</a></td></tr></table></div>\n</body>\n</html>";
?>
</body>
</html>