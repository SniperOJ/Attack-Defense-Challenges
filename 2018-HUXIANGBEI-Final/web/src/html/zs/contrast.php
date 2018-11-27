<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>信息对比</title>
<?php include("../inc/conn.php");?>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/qt.js"></script> 
</head>
<body>
<?php
$id='';
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
	checkid($_POST['id'][$i]);
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if ($id==''){
echo "<script lanage='javascript'>alert('操作失败！至少要选中一条信息。');window.opener=null;window.open('','_self');window.close()</script>";
exit;
} 

$tdwidth=floor(90/$i);//取整,左边占10%

$sql="select * from zzcms_main where id in ($id)" ;
$rs=query($sql);
?>

<table width="100%" height="218" border="0" align="center" cellpadding="5" cellspacing="1" class="bgcolor3">
  <tr> 
    <td width="10%" align="center" bgcolor="#FFFFFF">【产品图片】 </td>
	 <?php while ($row=fetch_array($rs)){?>
    <td bgcolor="#FFFFFF" style="font-weight:bold" width="<?php echo $tdwidth ?>%"><a href="<?php echo $row["img"]?>" target="_blank"><img src="<?php echo getsmallimg($row["img"])?>" alt="<?php echo $row["proname"]?>"  border="0" onload="resizeimg(200,200,this)" ></a></td>
    <?php
	}
	?>
  </tr>
  <tr class="bgcolor1"> 
    <td width="100" align="center">【产品名称】 </td>
    <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td style="font-weight:bold"><?php echo $row["proname"]?></td>
    <?php
	}
	?>
   
  </tr>
  <tr> 
    <td width="100" align="center" bgcolor="#FFFFFF">【主要功能】</td>
       <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td valign="top" bgcolor="#FFFFFF" ><?php echo $row["prouse"]?></td>
   <?php
   }
   ?>
  </tr>
  <tr class="bgcolor1"> 
    <td width="100" align="center">【规格包装】</td>
       <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td><?php echo $row["gg"]?></td>
   <?php
   }
   ?>
  </tr>
  <tr  class="bgcolor1"> 
    <td width="100" align="center"><strong><?php echo channelzs?>区域</strong></td>
        <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td><?php echo $row["city"]?></td>
    <?php
	}
	?>
  </tr>
  <tr> 
    <td width="100" align="center" bgcolor="#FFFFFF"><strong>产品说明</strong></td>
        <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td valign="top" bgcolor="#FFFFFF"><?php //echo $row["sm"]?></td>
   <?php
   }
   ?>
  </tr>
  <tr class="bgcolor1"> 
    <td width="100" align="center"><strong>可提供的支持</strong></td>
        <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td valign="top"><?php echo nl2br($row["zc"])?></td>
    <?php
	}
	?>
  </tr>
  <tr> 
    <td width="100" align="center" bgcolor="#FFFFFF"><strong>对<?php echo channeldl?>商的要求</strong></td>
       <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td valign="top" bgcolor="#FFFFFF"><?php echo nl2br($row["yq"])?></td>
   <?php
   }
   ?>
  </tr>
  <tr class="bgcolor1"> 
    <td width="100" align="center"><strong>备注</strong></td>
        <?php 
	 mysql_data_seek($rs,0);
	while ($row=fetch_array($rs)){?>
    <td><?php echo nl2br($row["other"])?></td>
   <?php
   }
   ?>
  </tr>
</table>

<table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="button" name="Submit" value="关闭本窗口" onClick="javascript:window.close()"></td>
  </tr>
</table>

</body>
</html>
