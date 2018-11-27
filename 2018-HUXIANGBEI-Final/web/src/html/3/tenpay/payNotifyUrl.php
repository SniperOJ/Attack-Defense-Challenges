<?php
include("../../inc/conn.php");
//---------------------------------------------------------
//财付通即时到帐支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------

require ("classes/ResponseHandler.class.php");
require ("classes/RequestHandler.class.php");
require ("classes/client/ClientResponseHandler.class.php");
require ("classes/client/TenpayHttpClient.class.php");
require ("./classes/function.php");
require_once ("./tenpay_config.php");

		log_result("进入后台回调页面");
	/* 创建支付应答对象 */
		$resHandler = new ResponseHandler();
		$resHandler->setKey($key);
	//判断签名
		if($resHandler->isTenpaySign()) {
	//通知id
		$notify_id = $resHandler->getParameter("notify_id");
	//通过通知ID查询，确保通知来至财付通
	//创建查询请求
		$queryReq = new RequestHandler();
		$queryReq->init();
		$queryReq->setKey($key);
		$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
		$queryReq->setParameter("partner", $partner);
		$queryReq->setParameter("notify_id", $notify_id);
	//通信对象
		$httpClient = new TenpayHttpClient();
		$httpClient->setTimeOut(5);
	//设置请求内容
		$httpClient->setReqContent($queryReq->getRequestURL());
	//后台调用
		if($httpClient->call()) {
	//设置结果参数
			$queryRes = new ClientResponseHandler();
			$queryRes->setContent($httpClient->getResContent());
			$queryRes->setKey($key);
		if($resHandler->getParameter("trade_mode") == "1"){
	//判断签名及结果（即时到帐）
	//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
				log_result("即时到帐验签ID成功");
	//取结果参数做业务处理
				$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
				$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
				$total_fee = $resHandler->getParameter("total_fee");
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
				$discount = $resHandler->getParameter("discount");
				//------------------------------
				//处理业务开始
				//------------------------------
				//处理数据库逻辑
				//注意交易单不要重复处理
				//注意判断返回金额
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
				
				//------------------------------
				//处理业务完毕
				//------------------------------
				log_result("即时到帐后台回调成功");
				echo "success";
			} else {
	//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
	//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
			   log_result("即时到帐后台回调失败");
			   echo "fail";
			}
		}elseif ($resHandler->getParameter("trade_mode") == "2")
	    {
    //判断签名及结果（中介担保）
	//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" ) 
		{
				log_result("中介担保验签ID成功");
	//取结果参数做业务处理
				$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
				$transaction_id = $resHandler->getParameter("transaction_id");
					
				//------------------------------
				//处理业务开始
				//------------------------------
				
				//处理数据库逻辑
				//注意交易单不要重复处理
				//注意判断返回金额
	
			log_result("中介担保后台回调，trade_state=".$resHandler->getParameter("trade_state"));
				switch ($resHandler->getParameter("trade_state")) {
						case "0":	//付款成功
						
							break;
						case "1":	//交易创建
						
							break;
						case "2":	//收获地址填写完毕
						
							break;
						case "4":	//卖家发货成功
						
							break;
						case "5":	//买家收货确认，交易成功
						
							break;
						case "6":	//交易关闭，未完成超时关闭
						
							break;
						case "7":	//修改交易价格成功
						
							break;
						case "8":	//买家发起退款
						
							break;
						case "9":	//退款成功
						
							break;
						case "10":	//退款关闭			
							
							break;
						default:
							//nothing to do
							break;
					}
					
				
				//------------------------------
				//处理业务完毕
				//------------------------------
				echo "success";
			} else
			
		     {
	//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
	//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->             										       getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
			   log_result("中介担保后台回调失败");
				echo "fail";
			 }
		  }
		
		
		
	//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
	/*
		echo "<br>------------------------------------------------------<br>";
		echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
		echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
		echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
		*/
	}else
	 {
	//通信失败
		echo "fail";
	//后台调用通信失败,写日志，方便定位问题
	echo "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
	 } 
	
	
   } else 
     {
    echo "<br/>" . "认证签名失败" . "<br/>";
    echo $resHandler->getDebugInfo() . "<br>";
}
?>