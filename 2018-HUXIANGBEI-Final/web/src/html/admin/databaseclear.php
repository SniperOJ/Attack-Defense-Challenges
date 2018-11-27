<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function ConfirmClear(){
   if(confirm("初始化数据库后将不能恢复！确定初始化么？"))
     return true;
   else
     return false;	 
}
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
}
</script>
</head>
<body>
<div class="admintitle">初始化数据库</div>
<?php
if (!isset($_POST["action"])) {
?>

      <form name="form1" method="post" action="" onSubmit="return ConfirmClear();">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" value="zzcms_main" id="zzcms_main">
              <label for="zzcms_main">zzcms_main(<?php echo channelzs?>表) </label>
              <input name="table[]" type="checkbox"  value="zzcms_zsclass" id="zzcms_zsclass">
              <label for="zzcms_zsclass"> zzcms_zsclass(<?php echo channelzs?>分类表) </label>
			  <input name="table[]" type="checkbox" id="zzcms_tagzs" value="zzcms_tagzs">
              <label for="zzcms_tagzs"> zzcms_tagzs(<?php echo channelzs?>标签表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_zh" value="zzcms_zh">
              <label for="zzcms_tagzs">zzcms_zh(展会表) </label>
              <input name="table[]" type="checkbox" id="zzcms_zhclass" value="zzcms_zhclass">
              <label for="zzcms_zhclass">zzcms_zhclass(展会分类表)</label></td>
          </tr>
          <tr>
            <td class="border"><input name="table[]" type="checkbox" id="zzcms_pp" value="zzcms_pp">
<label for="zzcms_pp">zzcms_pp(品牌表)</label>
  <input name="table[]" type="checkbox" id="zzcms_ppclass" value="zzcms_ppclass">
<label for="zzcms_ppclass">zzcms_ppclass(品牌类别表)</label></td>
          </tr>
          <tr>
            <td class="border"><input name="table[]" type="checkbox" id="zzcms_job" value="zzcms_job">
<label for="zzcms_job">zzcms_job(招聘表)</label>
  <input name="table[]" type="checkbox" id="zzcms_jobclass" value="zzcms_jobclass">
<label for="zzcms_jobclass">zzcms_jobclass(招聘分类表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_dl" value="zzcms_dl">
              <label for="zzcms_dl">zzcms_dl( <?php echo channeldl?>表) </label>
              <input name="table[]" type="checkbox" id="zzcms_looked_dls" value="zzcms_looked_dls">
              <label for="zzcms_looked_dls">zzcms_looked_dls( <?php echo channeldl?>商查看记录表) </label>
              <input name="table[]" type="checkbox" id="zzcms_looked_dls_number_oneday" value="zzcms_looked_dls_number_oneday">
             <label for="zzcms_looked_dls_number_oneday"> zzcms_looked_dls_number_oneday(记录用户每天查看 <?php echo channeldl?>数的表)</label></td>
          </tr>
          <tr>
            <td class="border">
			<?php 
$str='';		
$sql="select classname,classid,classzm from zzcms_zsclass where parentid='A' order by xuhao";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
while ($row=fetch_array($rs)){
$str=$str."<input name='table[]' type='checkbox' value='zzcms_dl_".$row["classzm"]."' id='zzcms_dl_".$row["classzm"]."'>";
$str=$str."<label for='zzcms_dl_".$row["classzm"]."'>zzcms_dl_".$row["classzm"]."(".channeldl.$row["classname"]."类分表)</label>";	
}
echo $str;
}
			?>			</td>
          </tr>
          <tr>
            <td class="border"><input name="table[]" type="checkbox" id="zzcms_zx" value="zzcms_zx">
                <label for="zzcms_zx">zzcms_zx(资讯表) </label>
                <input name="table[]" type="checkbox" id="zzcms_zxclass" value="zzcms_zxclass">
                <label for="zzcms_zxclass"> zzcms_zxclass(资讯分类表)</label>
                <input name="table[]" type="checkbox" id="zzcms_tagzx" value="zzcms_tagzx">
                <label for="zzcms_tagzx"> zzcms_tagzx(资讯标签表) </label>
                <input name="table[]" type="checkbox" id="zzcms_pinglun" value="zzcms_pinglun">
                <label for="zzcms_pinglun"> zzcms_pinglun(资讯评论表)</label></td>
          </tr>
          <tr>
            <td class="border"><label>
              <input name="table[]" type="checkbox" id="table[]" value="zzcms_ask">
              zzcms_ask(问表) </label>
                <label>
                  <input name="table[]" type="checkbox" id="table[]" value="zzcms_answer">
                  zzcms_answer(答表) </label>
                <label>
                  <input name="table[]" type="checkbox" id="table[]" value="zzcms_askclass">
                  zzcms_askclass(问答分类表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_wangkan" value="zzcms_wangkan">
              <label for="zzcms_wangkan">zzcms_wangkan(网刊表) </label>
              <input name="table[]" type="checkbox" id="zzcms_wangkanclass" value="zzcms_wangkanclass">
             <label for="zzcms_wangkanclass"> zzcms_wangkanclass(网刊分类表)</label>             </td>
          </tr>
          <tr>
            <td class="border"><input name="table[]" type="checkbox" id="zzcms_baojia" value="zzcms_baojia">
                <label for="zzcms_baojia">zzcms_baojia(报价表) </label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_licence" value="zzcms_licence">
             <label for="zzcms_licence"> zzcms_licence(资质表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_link" value="zzcms_link">
              <label for="zzcms_link">zzcms_link(友情链接表)</label>
                <input name="table[]" type="checkbox" id="zzcms_linkclass" value="zzcms_linkclass">
<label for="zzcms_linkclass">zzcms_linkclass(友情链接类别表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_user" value="zzcms_user">
             <label for="zzcms_user"> zzcms_user(注册用户表) </label>
              <input name="table[]" type="checkbox" id="zzcms_userclass" value="zzcms_userclass">
              <label for="zzcms_userclass">zzcms_userclass(用户分类表) </label>
              <input name="table[]" type="checkbox" id="zzcms_usersetting" value="zzcms_usersetting">
              <label for="zzcms_usersetting">zzcms_usersetting(注册用户配置表)</label> 
              <input name="table[]" type="checkbox" id="zzcms_usernoreg" value="zzcms_usernoreg">
              <label for="zzcms_usernoreg">zzcms_usernoreg(未激活帐户的用户表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_guestbook" value="zzcms_guestbook">
              <label for="zzcms_guestbook">zzcms_guestbook(用户留言表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_textadv" value="zzcms_textadv">
              <label for="zzcms_textadv">zzcms_textadv(待审广告表) </label>
              <input name="table[]" type="checkbox" id="zzcms_ad" value="zzcms_ad">
             <label for="zzcms_ad"> zzcms_ad(广告表) </label>
              <input name="table[]" type="checkbox" id="zzcms_adclass" value="zzcms_adclass">
              <label for="zzcms_adclass">zzcms_adclass(广告类别表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_pay" value="zzcms_pay">
             <label for="zzcms_pay"> zzcms_pay(冲值记录表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_usermessage" value="zzcms_usermessage">
             <label for="zzcms_usermessage"> zzcms_usermessage(用户反馈表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_message" value="zzcms_message">
             <label for="zzcms_message"> zzcms_message(站内短消息表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_bad" value="zzcms_bad">
             <label for="zzcms_bad"> zzcms_bad(不良操作记录表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="table[]" type="checkbox" id="zzcms_about" value="zzcms_about">
             <label for="zzcms_about"> zzcms_about(网站介绍表)</label></td>
          </tr>
          <tr> 
            <td class="border"> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
              <label for="chkAll">全选</label>
              <input name="Submit24" type="submit" class="buttons" value="初始化数据库"> 
              <input name="action" type="hidden" id="action" value="clear"> </td>
          </tr>
        </table>
      </form>
<?php
}else{
checkadminisdo("siteconfig");
?>
<div class="border">
<?php
if(!empty($_POST['table'])){
    for($i=0; $i<count($_POST['table']);$i++){
	query("truncate ".trim($_POST['table'][$i])."");
	echo $table[$i]."表已被初始化<br>"; 
    }	
}
?>
</div>
<?php
}
?>
</body>
</html>