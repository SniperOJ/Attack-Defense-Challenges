<?php
/**
 * UCenter 应用程序开发 Example
 *
 * 用户退出的 Example 代码
 * 使用到的接口函数：
 * uc_user_synlogout()	可选，生成同步退出的代码
 */

setcookie('Example_auth', '', -86400);
//生成同步退出的代码
$ucsynlogout = uc_user_synlogout();
echo '退出成功'.$ucsynlogout.'<br><a href="'.$_SERVER['PHP_SELF'].'">继续</a>';
exit;

?>