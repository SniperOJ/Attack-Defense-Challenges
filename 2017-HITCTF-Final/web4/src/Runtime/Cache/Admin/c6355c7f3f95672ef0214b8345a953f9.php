<?php if (!defined('THINK_PATH')) exit();?><link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<body class="body" style="margin:0px;padding:0px;text-align:left">
<form action="?s=Admin-Upload-Upload" method="post" enctype="multipart/form-data" name="myform" id="myform">
<input name="sid" type="hidden" value="<?php echo (htmlspecialchars($_GET['sid'])); ?>"/>
<input name="fileback" type="hidden" value="<?php echo (htmlspecialchars($_GET['fileback'])); ?>"/>
<input type="file" name="upthumb" id="upthumb" style="height:23px;width:200px"> <input height="26" type="submit" value="上 传" class="submit"/>
</form>
</body>