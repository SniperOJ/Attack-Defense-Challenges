<?php
require_once("API/qqConnectAPI.php");
$qc = new QC();
echo $qc->qq_callback();
echo $qc->get_openid();

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
