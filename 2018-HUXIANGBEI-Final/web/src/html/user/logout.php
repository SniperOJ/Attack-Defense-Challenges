<?php
include("../inc/config.php");
include '../3/ucenter_api/config.inc.php';//集成ucenter
include '../3/ucenter_api/uc_client/client.php';//集成ucenter

setcookie("UserName",'xxx',1,"/");//这里也要加目录参数，否则无法退出
setcookie("PassWord",'xxx',1,"/");//设为1意味着1970年1月1日8点零1秒,否则当客户端时间为过去时间时，退出产生deleted的cookie值
//集成ucenter
if (bbs_set=='Yes'){
setcookie('Example_auth', '', -86400);
$ucsynlogout = uc_user_synlogout();//生成同步退出的代码
echo '同时退出论坛成功'.$ucsynlogout;
}
//end
echo "<script>location.href='".siteurl."'</script>";
?>