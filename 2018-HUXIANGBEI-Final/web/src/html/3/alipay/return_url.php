<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
include("../../inc/conn.php");
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];
	$total_fee=$_GET['total_fee'];


    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		
	echo "验证成功<br />".$trade_no."<br>".$total_fee;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	$sql="select * from zzcms_pay where mark='".$trade_no."' and username='".@$_COOKIE['UserName']."'";
	$rs=query($sql);	
	$row=num_rows($rs);
	if (!$row){//如果没有记录则写入
	$jf=$total_fee*jifen_bilu;
	query("update zzcms_user set totleRMB=totleRMB+".$jf." where username='".@$_COOKIE['UserName']."'");//写入冲值金额到用户表
	query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".@$_COOKIE['UserName']."','支付宝在线充值','$total_fee','$trade_no','".date('Y-m-d H:i:s')."')");//写入冲值记录
	echo "充值成功";
	}else{
	echo "已有此记录,请联系网站客服核对实际冲值情况。";
	}
}else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
        <title>支付宝即时到账交易接口</title>
	</head>
    <body>
    </body>
</html>