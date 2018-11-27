<?php
/**
 * UCenter 应用程序开发 Example
 *
 * 设置头像的 Example 代码
 */

echo '
<img src="'.UC_API.'/avatar.php?uid='.$Example_uid.'&size=big">
<img src="'.UC_API.'/avatar.php?uid='.$Example_uid.'&size=middle">
<img src="'.UC_API.'/avatar.php?uid='.$Example_uid.'&size=small">
<br><br>'.uc_avatar($Example_uid);

?>