<?php
$alipay_config['partner']		=alipay_partner;
$alipay_config['key']			=alipay_key;
$alipay_config['sign_type']    = strtoupper('MD5');//签名方式 不需修改
$alipay_config['input_charset']= strtolower('utf-8');//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['cacert']    = getcwd().'\\cacert.pem';//ca证书路径地址，用于curl中ssl校验//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['transport']    = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
?>