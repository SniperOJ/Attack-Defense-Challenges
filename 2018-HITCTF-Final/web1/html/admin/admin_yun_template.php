<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($action))
{
	$action = '';
}

$id = empty($id) ? 0 : intval($id);


include(duomi_ADMIN.'/html/admin_yun_template.htm');
exit();


?>