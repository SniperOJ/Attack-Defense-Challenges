<?php
$spname=sitename;
$partner = tenpay_bargainor_id;//财付通商户号
$key = tenpay_key;//财付通密钥
$return_url = siteurl."/3/tenpay/payReturnUrl.php";//显示支付结果页面,*替换成payReturnUrl.php所在路径
$notify_url = siteurl."/3/tenpay/payNotifyUrl.php";//支付完成后的回调处理页面,*替换成payNotifyUrl.php所在路径
?>