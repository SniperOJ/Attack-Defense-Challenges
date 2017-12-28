<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($ac))
{
	$ac = '';
}


include(sea_ADMIN.'/templets/admin_memberslist.htm');
exit();
