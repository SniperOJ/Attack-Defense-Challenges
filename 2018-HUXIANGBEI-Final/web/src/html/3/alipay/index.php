<?php
/* *
 * 功能：支付宝即时到账交易接口接口调试入口页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

include("../../inc/config.php");
include("../../inc/function.php");
include("../../inc/stopsqlin.php");

  $curDateTime = date("YmdHis");
  //date_default_timezone_set(PRC);
		$strDate = date("Ymd");
		$strTime = date("His");
		//4位随机数
		$randNum = rand(1000, 9999);
		//10位序列号,可以自行调整。
		$strReq = $strTime . $randNum;
		 /* 商家的定单号 */
  	$mch_vno = $curDateTime . $randNum;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title>支付宝即时到账交易接口接口</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<LINK href="../../user/style/<?php echo siteskin_usercenter?>/style.css" type=text/css rel=stylesheet>
    <style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
    </style>
    </head>
<body>
<div class="content">
<div class="admintitle">支付宝在线冲值</div>
<form name="alipayment" action="alipayapi.php" method="post" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="22%" align="right" class="border">收款方：</td>
      <td width="78%" class="border"><?php echo  sitename ?>
          <input name="WIDseller_email" value="<?php echo alipay_seller_email ?>" type="hidden" size="30" />
          <input name="WIDout_trade_no" value="<?php echo $mch_vno?>" type="hidden" size="30" />
          <input name="WIDsubject" value="支付宝在线冲值" type="hidden" size="30" />
          <input name="WIDbody" value="支付宝在线冲值" type="hidden" size="30" />
          <input name="WIDshow_url" value="<?php echo siteurl?>" type="hidden" size="30" />      </td>
    </tr>
    <tr> 
      <td align="right" class="border2">充值金额：</td>
      <td class="border2"><input name="WIDtotal_fee" type="text" id="WIDtotal_fee" class="biaodan" onKeyUp="if(isNaN(value))execCommand('undo')" size="18" maxlength="50" onafterpaste="if(isNaN(value))execCommand('undo')">
        （格式：500.01）</td>
    </tr>
    <tr> 
      <td colspan="2" class="border2 STYLE1">特别提示：冲值完成后，不要马上关闭页面，等系统跳转到通知页，看到“<strong>冲值完成</strong>”四个字后，再关闭。</td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit" value="下一步" /></td>
    </tr>
  </table>			
</form> 
</div> 
</body>
</html>