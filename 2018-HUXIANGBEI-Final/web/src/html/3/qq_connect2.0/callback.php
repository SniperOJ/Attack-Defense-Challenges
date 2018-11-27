<?php
require_once("API/qqConnectAPI.php");
$qc = new QC();
$qc->qq_callback();//必须得输出，否则出错
//echo $qc->get_openid();
?>
<form action="addqqid.php" method='post' name='gotopage' target='_self' >
 <input type='hidden' name='qqid' value='<?php echo $qc->get_openid();?>' />
</form>
<SCRIPT>
function gotopage(){
document.gotopage.submit();
}
</SCRIPT>
<body onLoad='gotopage()'>