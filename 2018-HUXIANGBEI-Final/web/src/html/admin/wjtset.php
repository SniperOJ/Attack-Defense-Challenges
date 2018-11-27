<?php
error_reporting(0); //加新参数后配置文件中，不用加同名空参数了
include("admin.php");
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (isset($_POST["action"])){
$action=$_POST["action"];
}else{
$action="";
}
?>
<div class="admintitle">文件头设置</div>
<?php
if ($action=="saveconfig") {
checkadminisdo("siteconfig");
saveconfig();
}else{
showconfig();
}
function showconfig(){
?>
<form method="POST" action="?" id="form1" name="form1">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="30%" align="right" class="border">首页</td>
      <td width="70%" class="border">title<br> <input name="sitetitle" type="text" id="sitetitle2" value="<?php echo sitetitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="sitekeyword" type="text" id="sitekeyword4" value="<?php echo sitekeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="sitedescription" type="text" id="sitedescription" value="<?php echo sitedescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channelzs?>列表页</td>
      <td class="border"> title<br> <input name="zslisttitle" type="text" id="zslisttitle2" value="<?php echo zslisttitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zslistkeyword" type="text" id="zslistkeyword2" value="<?php echo zslistkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zslistdescription" type="text" id="zslistdescription2" value="<?php echo zslistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channelzs?>信息页</td>
      <td class="border"> title<br> <input name="zsshowtitle" type="text" id="zsshowtitle2" value="<?php echo zsshowtitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zsshowkeyword" type="text" id="zsshowkeyword2" value="<?php echo zsshowkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zsshowdescription" type="text" id="zsshowdescription2" value="<?php echo zsshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>列表页</td>
      <td class="border">title<br> <input name="dllisttitle" type="text" id="dllisttitle2" value="<?php echo dllisttitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="dllistkeyword" type="text" id="dllistkeyword2" value="<?php echo dllistkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="dllistdescription" type="text" id="dllistdescription2" value="<?php echo dllistdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>信息页</td>
      <td class="border">title<br> <input name="dlshowtitle" type="text" id="dlshowtitle2" value="<?php echo dlshowtitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="dlshowkeyword" type="text" id="dlshowkeyword2" value="<?php echo dlshowkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="dlshowdescription" type="text" id="dlshowdescription2" value="<?php echo dlshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">展会列表页</td>
      <td class="border">title<br> <input name="zhlisttitle" type="text" id="zhlisttitle2" value="<?php echo zhlisttitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zhlistkeyword" type="text" id="zhlistkeyword2" value="<?php echo zhlistkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zhlistdescription" type="text" id="zhlistdescription2" value="<?php echo zhlistdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">展会信息页</td>
      <td class="border">title<br> <input name="zhshowtitle" type="text" id="zhshowtitle2" value="<?php echo zhshowtitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zhshowkeyword" type="text" id="zhshowkeyword2" value="<?php echo zhshowkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zhshowdescription" type="text" id="zhshowdescription2" value="<?php echo zhshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">资讯列表页</td>
      <td class="border">title<br> <input name="zxlisttitle" type="text" id="zxlisttitle2" value="<?php echo zxlisttitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zxlistkeyword" type="text" id="zxlistkeyword2" value="<?php echo zxlistkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zxlistdescription" type="text" id="zxlistdescription2" value="<?php echo zxlistdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">资讯信息页</td>
      <td class="border">title<br> <input name="zxshowtitle" type="text" id="zxshowtitle2" value="<?php echo zxshowtitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="zxshowkeyword" type="text" id="zxshowkeyword2" value="<?php echo zxshowkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="zxshowdescription" type="text" id="zxshowdescription2" value="<?php echo zxshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">专题列表页</td>
      <td class="border">title<br>
          <input name="ztlisttitle" type="text" id="ztlisttitle" value="<?php echo ztlisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="ztlistkeyword" type="text" id="ztlistkeyword" value="<?php echo ztlistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="ztlistdescription" type="text" id="ztlistdescription" value="<?php echo ztlistdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">专题信息页</td>
      <td class="border">title<br>
          <input name="ztshowtitle" type="text" id="ztshowtitle" value="<?php echo ztshowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="ztshowkeyword" type="text" id="ztshowkeyword" value="<?php echo ztshowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="ztshowdescription" type="text" id="ztshowdescription" value="<?php echo ztshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">企业列表页</td>
      <td class="border">title<br> <input name="companylisttitle" type="text" id="companylisttitle2" value="<?php echo companylisttitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="companylistkeyword" type="text" id="companylistkeyword2" value="<?php echo companylistkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="companylistdescription" type="text" id="companylistdescription2" value="<?php echo companylistdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">企业信息页</td>
      <td class="border">title<br> <input name="companyshowtitle" type="text" id="companyshowtitle2" value="<?php echo companyshowtitle?>" size="50" maxlength="255"> 
        <br>
        keywords<br> <input name="companyshowkeyword" type="text" id="companyshowkeyword2" value="<?php echo companyshowkeyword?>" size="50" maxlength="255"> 
        <br>
        description<br> <input name="companyshowdescription" type="text" id="companyshowdescription2" value="<?php echo companyshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">品牌列表页</td>
      <td class="border"> title<br>
          <input name="pplisttitle" type="text" value="<?php echo pplisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="pplistkeyword" type="text"  value="<?php echo pplistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="pplistdescription" type="text"  value="<?php echo pplistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">品牌信息页</td>
      <td class="border"> title<br>
          <input name="ppshowtitle" type="text"  value="<?php echo ppshowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="ppshowkeyword" type="text"  value="<?php echo ppshowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="ppshowdescription" type="text"  value="<?php echo ppshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">招聘列表页</td>
      <td class="border"> title<br>
          <input name="joblisttitle" type="text" value="<?php echo joblisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="joblistkeyword" type="text"  value="<?php echo joblistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="joblistdescription" type="text"  value="<?php echo joblistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">招聘信息页</td>
      <td class="border"> title<br>
          <input name="jobshowtitle" type="text"  value="<?php echo jobshowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="jobshowkeyword" type="text"  value="<?php echo jobshowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="jobshowdescription" type="text"  value="<?php echo jobshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">报价列表页</td>
      <td class="border"> title<br>
          <input name="baojialisttitle" type="text" value="<?php echo baojialisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="baojialistkeyword" type="text"  value="<?php echo baojialistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="baojialistdescription" type="text"  value="<?php echo baojialistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">报价信息页</td>
      <td class="border"> title<br>
          <input name="baojiashowtitle" type="text"  value="<?php echo baojiashowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="baojiashowkeyword" type="text"  value="<?php echo baojiashowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="baojiashowdescription" type="text"  value="<?php echo baojiashowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">网刊列表页</td>
      <td class="border"> title<br>
          <input name="wangkanlisttitle" type="text" value="<?php echo wangkanlisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="wangkanlistkeyword" type="text"  value="<?php echo wangkanlistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="wangkanlistdescription" type="text"  value="<?php echo wangkanlistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">网刊信息页</td>
      <td class="border"> title<br>
          <input name="wangkanshowtitle" type="text"  value="<?php echo wangkanshowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="wangkanshowkeyword" type="text"  value="<?php echo wangkanshowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="wangkanshowdescription" type="text"  value="<?php echo wangkanshowdescription?>" size="50" maxlength="255">      </td>
    </tr>
    <tr>
      <td align="right" class="border">问答列表页</td>
      <td class="border"> title<br>
          <input name="asklisttitle" type="text" value="<?php echo asklisttitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="asklistkeyword" type="text"  value="<?php echo asklistkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="asklistdescription" type="text"  value="<?php echo asklistdescription?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">问答信息页</td>
      <td class="border"> title<br>
          <input name="askshowtitle" type="text"  value="<?php echo askshowtitle?>" size="50" maxlength="255">
          <br>
        keywords<br>
        <input name="askshowkeyword" type="text"  value="<?php echo askshowkeyword?>" size="50" maxlength="255">
        <br>
        description<br>
        <input name="askshowdescription" type="text"  value="<?php echo askshowdescription?>" size="50" maxlength="255">
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input name="submit" type="submit" class="buttons" value=" 保存设置 " > 
        <input name="action" type="hidden" id="action" value="saveconfig"></td>
    </tr>
  </table>
<?php
}
?>
</form>
</body>
</html>
<?php
function SaveConfig(){
	$fpath="../inc/wjt.php";
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	$fcontent="<" . "?php\r\n";	
	$fcontent=$fcontent. "define('sitetitle','". trim($_POST['sitetitle'])."') ;//SiteKeywords\n";
	$fcontent=$fcontent. "define('sitekeyword','". trim($_POST['sitekeyword'])."') ;//SiteKeywords\n";
	$fcontent=$fcontent. "define('sitedescription','". trim($_POST['sitedescription'])."') ;//sitedescription\n";
	$fcontent=$fcontent. "define('zslisttitle','". trim($_POST['zslisttitle'])."') ;//zslisttitle\n";
	$fcontent=$fcontent. "define('zslistkeyword','". trim($_POST['zslistkeyword'])."') ;//zslistkeyword\n";
	$fcontent=$fcontent. "define('zslistdescription','". trim($_POST['zslistdescription'])."') ;//zslistdescription\n";
	$fcontent=$fcontent. "define('zsshowtitle','". trim($_POST['zsshowtitle'])."') ;//zsshowtitle\n";
	$fcontent=$fcontent. "define('zsshowkeyword','". trim($_POST['zsshowkeyword'])."') ;//zsshowkeyword\n";
	$fcontent=$fcontent. "define('zsshowdescription','". trim($_POST['zsshowdescription'])."') ;//zsshowdescription\n";
	$fcontent=$fcontent. "define('dllisttitle','". trim($_POST['dllisttitle'])."') ;//dllisttitle\n";
	$fcontent=$fcontent. "define('dllistkeyword','". trim($_POST['dllistkeyword'])."') ;//dllistkeyword\n";
	$fcontent=$fcontent. "define('dllistdescription','". trim($_POST['dllistdescription'])."') ;//dllistdescription\n";
	$fcontent=$fcontent. "define('dlshowtitle','". trim($_POST['dlshowtitle'])."') ;//dlshowtitle\n";
	$fcontent=$fcontent. "define('dlshowkeyword','". trim($_POST['dlshowkeyword'])."') ;//dlshowkeyword\n";
	$fcontent=$fcontent. "define('dlshowdescription','". trim($_POST['dlshowdescription'])."') ;//dlshowdescription\n";
	$fcontent=$fcontent. "define('zhlisttitle','". trim($_POST['zhlisttitle'])."') ;//zhlisttitle\n";
	$fcontent=$fcontent. "define('zhlistkeyword','". trim($_POST['zhlistkeyword'])."') ;//zhlistkeyword\n";
	$fcontent=$fcontent. "define('zhlistdescription','". trim($_POST['zhlistdescription'])."') ;//zhlistdescription\n";
	$fcontent=$fcontent. "define('zhshowtitle','". trim($_POST['zhshowtitle'])."') ;//zhshowtitle\n";
	$fcontent=$fcontent. "define('zhshowkeyword','". trim($_POST['zhshowkeyword'])."') ;//zhshowkeyword\n";
	$fcontent=$fcontent. "define('zhshowdescription','". trim($_POST['zhshowdescription'])."') ;//zhshowdescription\n";
	$fcontent=$fcontent. "define('zxlisttitle','". trim($_POST['zxlisttitle'])."') ;//zxlisttitle\n";
	$fcontent=$fcontent. "define('zxlistkeyword','". trim($_POST['zxlistkeyword'])."') ;//zxlistkeyword\n";
	$fcontent=$fcontent. "define('zxlistdescription','". trim($_POST['zxlistdescription'])."') ;//zxlistdescription\n";
	$fcontent=$fcontent. "define('zxshowtitle','". trim($_POST['zxshowtitle'])."') ;//zxshowtitle\n";
	$fcontent=$fcontent. "define('zxshowkeyword','". trim($_POST['zxshowkeyword'])."') ;//zxshowkeyword\n";
	$fcontent=$fcontent. "define('zxshowdescription','". trim($_POST['zxshowdescription'])."') ;//zxshowdescription\n";
	$fcontent=$fcontent. "define('ztlisttitle','". trim($_POST['ztlisttitle'])."') ;//ztlisttitle\n";
	$fcontent=$fcontent. "define('ztlistkeyword','". trim($_POST['ztlistkeyword'])."') ;//ztlistkeyword\n";
	$fcontent=$fcontent. "define('ztlistdescription','". trim($_POST['ztlistdescription'])."') ;//ztlistdescription\n";
	$fcontent=$fcontent. "define('ztshowtitle','". trim($_POST['ztshowtitle'])."') ;//ztshowtitle\n";
	$fcontent=$fcontent. "define('ztshowkeyword','". trim($_POST['ztshowkeyword'])."') ;//ztshowkeyword\n";
	$fcontent=$fcontent. "define('ztshowdescription','". trim($_POST['ztshowdescription'])."') ;//ztshowdescription\n";
	$fcontent=$fcontent. "define('companylisttitle','". trim($_POST['companylisttitle'])."') ;//companylisttitle\n";
	$fcontent=$fcontent. "define('companylistkeyword','". trim($_POST['companylistkeyword'])."') ;//companylistkeyword\n";
	$fcontent=$fcontent. "define('companylistdescription','". trim($_POST['companylistdescription'])."') ;//companylistdescription\n";
	$fcontent=$fcontent. "define('companyshowtitle','". trim($_POST['companyshowtitle'])."') ;//companyshowtitle\n";
	$fcontent=$fcontent. "define('companyshowkeyword','". trim($_POST['companyshowkeyword'])."') ;//companyshowkeyword\n";
	$fcontent=$fcontent. "define('companyshowdescription','". trim($_POST['companyshowdescription'])."') ;//companyshowdescription\n";
	
	$fcontent=$fcontent. "define('pplisttitle','". trim($_POST['pplisttitle'])."') ;//pplisttitle\n";
	$fcontent=$fcontent. "define('pplistkeyword','". trim($_POST['pplistkeyword'])."') ;//pplistkeyword\n";
	$fcontent=$fcontent. "define('pplistdescription','". trim($_POST['pplistdescription'])."') ;//pplistdescription\n";
	$fcontent=$fcontent. "define('ppshowtitle','". trim($_POST['ppshowtitle'])."') ;//ppshowtitle\n";
	$fcontent=$fcontent. "define('ppshowkeyword','". trim($_POST['ppshowkeyword'])."') ;//ppshowkeyword\n";
	$fcontent=$fcontent. "define('ppshowdescription','". trim($_POST['ppshowdescription'])."') ;//ppshowdescription\n";
	
	$fcontent=$fcontent. "define('joblisttitle','". trim($_POST['joblisttitle'])."') ;//joblisttitle\n";
	$fcontent=$fcontent. "define('joblistkeyword','". trim($_POST['joblistkeyword'])."') ;//joblistkeyword\n";
	$fcontent=$fcontent. "define('joblistdescription','". trim($_POST['joblistdescription'])."') ;//joblistdescription\n";
	$fcontent=$fcontent. "define('jobshowtitle','". trim($_POST['jobshowtitle'])."') ;//jobshowtitle\n";
	$fcontent=$fcontent. "define('jobshowkeyword','". trim($_POST['jobshowkeyword'])."') ;//jobshowkeyword\n";
	$fcontent=$fcontent. "define('jobshowdescription','". trim($_POST['jobshowdescription'])."') ;//jobshowdescription\n";
	
	$fcontent=$fcontent. "define('baojialisttitle','". trim($_POST['baojialisttitle'])."') ;//baojialisttitle\n";
	$fcontent=$fcontent. "define('baojialistkeyword','". trim($_POST['baojialistkeyword'])."') ;//baojialistkeyword\n";
	$fcontent=$fcontent. "define('baojialistdescription','". trim($_POST['baojialistdescription'])."') ;//baojialistdescription\n";
	$fcontent=$fcontent. "define('baojiashowtitle','". trim($_POST['baojiashowtitle'])."') ;//baojiashowtitle\n";
	$fcontent=$fcontent. "define('baojiashowkeyword','". trim($_POST['baojiashowkeyword'])."') ;//baojiashowkeyword\n";
	$fcontent=$fcontent. "define('baojiashowdescription','". trim($_POST['baojiashowdescription'])."') ;//baojiashowdescription\n";
	
	$fcontent=$fcontent. "define('wangkanlisttitle','". trim($_POST['wangkanlisttitle'])."') ;//wangkanlisttitle\n";
	$fcontent=$fcontent. "define('wangkanlistkeyword','". trim($_POST['wangkanlistkeyword'])."') ;//wangkanlistkeyword\n";
	$fcontent=$fcontent. "define('wangkanlistdescription','". trim($_POST['wangkanlistdescription'])."') ;//wangkanlistdescription\n";
	$fcontent=$fcontent. "define('wangkanshowtitle','". trim($_POST['wangkanshowtitle'])."') ;//wangkanshowtitle\n";
	$fcontent=$fcontent. "define('wangkanshowkeyword','". trim($_POST['wangkanshowkeyword'])."') ;//wangkanshowkeyword\n";
	$fcontent=$fcontent. "define('wangkanshowdescription','". trim($_POST['wangkanshowdescription'])."') ;//wangkanshowdescription\n";
	
	$fcontent=$fcontent. "define('asklisttitle','". trim($_POST['asklisttitle'])."') ;//asklisttitle\n";
	$fcontent=$fcontent. "define('asklistkeyword','". trim($_POST['asklistkeyword'])."') ;//asklistkeyword\n";
	$fcontent=$fcontent. "define('asklistdescription','". trim($_POST['asklistdescription'])."') ;//asklistdescription\n";
	$fcontent=$fcontent. "define('askshowtitle','". trim($_POST['askshowtitle'])."') ;//askshowtitle\n";
	$fcontent=$fcontent. "define('askshowkeyword','". trim($_POST['askshowkeyword'])."') ;//askshowkeyword\n";
	$fcontent=$fcontent. "define('askshowdescription','". trim($_POST['askshowdescription'])."') ;//askshowdescription\n";
	
	$fcontent=$fcontent. "?" . ">";
	fputs($fp,$fcontent);//把替换后的内容写入文件
	fclose($fp);
	echo  "<script>alert('设置成功');location.href='?'</script>";
}
?>