<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>选择数据库</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function DoDrop(dbname)
{
	var ok;
	var oktwo;
	var okthree;
	ok=confirm("确认要删除此数据库?");
	if(ok==false)
	{
		return false;
	}
	oktwo=confirm("再次确认要删除此数据库?");
	if(oktwo==false)
	{
		return false;
	}
	okthree=confirm("最后确认要删除此数据库?");
	if(okthree==false)
	{
		return false;
	}
	if(ok&&oktwo&&okthree)
	{
		self.location.href='phome.php?phome=DropDb&mydbname='+dbname;
	}
}
</script>
</head>

<body>
</body>
</html>