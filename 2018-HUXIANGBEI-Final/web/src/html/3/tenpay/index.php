<?php
require_once ("classes/RequestHandler.class.php");
include("../../inc/config.php");
require_once ("./tenpay_config.php");
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>财富通在线冲值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="../../user/style/<?php echo siteskin_usercenter?>/style.css" type=text/css rel=stylesheet>
    <style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
    </style>
</HEAD>
<BODY>
<div class="content">
<div class="admintitle">财富通在线冲值</div>
<form action='tenpay.php' method='post' name='directFrm'>    
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="22%" align="right" class="border">收款方</td>
      <td width="78%" class="border"><? echo  $spname ?> <input type="hidden" name="order_no" maxlength="50" size="18" readonly="readonly" value="<?php echo $mch_vno ?>"> 
      
        <input name="product_name" type="hidden" value="财富通在线冲值" size="18" maxlength="50">
        <input name="trade_mode" type="hidden" id="trade_mode" value="1" size="18" maxlength="50">
        <input name="remarkexplain" type="hidden" id="remarkexplain" value="财富通在线冲值" size="18" maxlength="50">       </td>
    </tr>
    <tr> 
      <td align="right" class="border2">充值金额</td>
      <td class="border2"><input type="text" name="order_price" maxlength="50" size="18"  class="biaodan" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
        
        <input type="hidden" name="bank_type_value" value="0"><!--默认支付银行0为财富通-->
       （格式：500.01）</td>
    </tr>
    
    <tr> 
      <td colspan="2" class="border STYLE1">
	  特别提示：冲值完成后，不要马上关闭页面，等系统跳转到通知页，看到“冲值完成”四个字后，再关闭。
	  </td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit" value="下一步"></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>