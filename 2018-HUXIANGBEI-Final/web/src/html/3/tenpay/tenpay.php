<?php
//---------------------------------------------------------
//财付通即时到帐支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------
include("../../inc/config.php");
include("../../inc/function.php");
include("../../inc/stopsqlin.php");
require_once ("tenpay_config.php");
require_once ("classes/RequestHandler.class.php");

/* 获取提交的订单号 */
$out_trade_no = $_REQUEST["order_no"];
/* 获取提交的商品名称 */
$product_name = $_REQUEST["product_name"];
/* 获取提交的商品价格 */
$order_price = $_REQUEST["order_price"];
/* 获取提交的备注信息 */
$remarkexplain = $_REQUEST["remarkexplain"];
/* 接口类型 */
$trade_mode=$_REQUEST["trade_mode"];
/* 支付银行 */
$bank_type_value=$_POST["bank_type_value"];


$strDate = date("Ymd");
$strTime = date("His");

/* 商品价格（包含运费），以分为单位 */
$total_fee = $order_price*100;

/* 商品名称 */
$desc = $product_name;
//$desc = "商品：".$product_name.",备注:".$remarkexplain;
/* 创建支付请求对象 */
$reqHandler = new RequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);
$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

//----------------------------------------
//设置支付参数 
//----------------------------------------
$reqHandler->setParameter("partner", $partner);
$reqHandler->setParameter("out_trade_no", $out_trade_no);
$reqHandler->setParameter("total_fee", $total_fee);  //总金额
$reqHandler->setParameter("return_url", $return_url);
$reqHandler->setParameter("notify_url", $notify_url);
$reqHandler->setParameter("body", $desc);
$reqHandler->setParameter("bank_type", $bank_type_value);  	  //银行类型，默认为财付通
//用户ip
$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
$reqHandler->setParameter("fee_type", "1");               //币种
$reqHandler->setParameter("subject",$desc);          //商品名称，（中介交易时必填）
//系统可选参数
$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
$reqHandler->setParameter("input_charset", "utf-8");   	  //字符集
$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号

//业务可选参数
$reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
$reqHandler->setParameter("product_fee", "");        	  //商品费用
$reqHandler->setParameter("transport_fee", "0");      	  //物流费用
$reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
$reqHandler->setParameter("time_expire", "");             //订单失效时间
$reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
$reqHandler->setParameter("goods_tag", "");               //商品标记
$reqHandler->setParameter("trade_mode",$trade_mode);              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））

$reqHandler->setParameter("transport_desc","");              //物流说明
$reqHandler->setParameter("trans_type","1");              //交易类型
$reqHandler->setParameter("agentid","");                  //平台ID
$reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
$reqHandler->setParameter("seller_id","");                //卖家的商户号



//请求的URL
$reqUrl = $reqHandler->getRequestURL();

//获取debug信息,建议把请求和debug信息写入日志，方便定位问题
/**/
$debugInfo = $reqHandler->getDebugInfo();
//echo "<br/>" . $reqUrl . "<br/>";
//echo "<br/>" . $debugInfo . "<br/>";


?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
</head>
<body>
<br/>
<?
echo "<script>location.href='".$reqUrl."'</script>";//不用点下面的链接直接支付
?>
<a href="<?php echo $reqUrl ?>" target="_blank">财付通支付</a>
<form action="<?php echo $reqHandler->getGateUrl() ?>" method="post" target="_blank">
<?php
$params = $reqHandler->getAllParameters();
foreach($params as $k => $v) {
	echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
}
?>
<input type="submit" value="财付通支付">
</form>
</body>
</html>