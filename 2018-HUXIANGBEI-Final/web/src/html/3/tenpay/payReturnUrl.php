<?php
include("../../inc/conn.php");
//---------------------------------------------------------
//财付通即时到帐支付页面回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once ("./classes/ResponseHandler.class.php");
require_once ("./classes/function.php");
require_once ("tenpay_config.php");
log_result("进入前台回调页面");
/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//通知id
	$notify_id = $resHandler->getParameter("notify_id");
	//商户订单号
	$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
	$discount = $resHandler->getParameter("discount");
	//支付结果
	$trade_state = $resHandler->getParameter("trade_state");
	//交易模式,1即时到账
	$trade_mode = $resHandler->getParameter("trade_mode");

	
	if("1" == $trade_mode ) {
		if( "0" == $trade_state){ 
		
				$sql="select * from zzcms_pay where mark='".$transaction_id."' and username='".@$_COOKIE['UserName']."'";
				$rs=query($sql);	
				$row=num_rows($rs);
				if (!$row){//如果没有记录刚写入
				$total_fee_yuan=$total_fee/100;
				$jifen=$total_fee_yuan*jifen_bilu;
				query("update zzcms_user set totleRMB=totleRMB+".$jifen." where username='".@$_COOKIE['UserName']."'");//写入冲值金额到用户表
				query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".@$_COOKIE['UserName']."','财富通在线充值','$total_fee_yuan','$transaction_id','".date('Y-m-d H:i:s')."')");//写入冲值记录
					echo "充值成功";
				}
				
			//echo "<br/>" . "即时到帐支付成功" . "<br/>";
	
		} else {
			//当做不成功处理
			echo "<br/>" . "即时到帐支付失败" . "<br/>";
		}
	}elseif( "2" == $trade_mode  ) {
		if( "0" == $trade_state) {
			echo "<br/>" . "中介担保支付成功" . "<br/>";
		
		} else {
			//当做不成功处理
			echo "<br/>" . "中介担保支付失败" . "<br/>";
		}
	}
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
	echo $resHandler->getDebugInfo() . "<br>";
}
?>