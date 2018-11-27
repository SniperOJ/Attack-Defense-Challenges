<?php
set_time_limit(1800) ;
include("../inc/conn.php");
require_once '../3/phpexcelreader/reader.php';
// Excel文件($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
// 设置输入编码 UTF-8/GB2312/CP936等等
$data->setOutputEncoding('UTF-8'); 
/***
* 如果服务器不支持 iconv 添加下面的代码使用 mb_convert_encoding 编码
* $data->setUTFEncoder('mb');

* 默认情况下行和列的计数从1开始
* 如果要修改起始数值，添加：
* $data->setRowColOffset(0);

*  设置工作模式
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - 最大兼容模式
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - 列的格式设置（仅适用于数字字段）
**/
$f="../dl_excel/".$_REQUEST['filename'];
$data->read($f);
error_reporting(E_ALL ^ E_NOTICE);
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {//行数
query("insert into zzcms_dl(dlsname,tel,email,cp,city,content,sendtime)values('".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."','".$data->sheets[0]['cells'][$i][7]."','".date('Y-m-d H:i:s',strtotime($data->sheets[0]['cells'][$i][8]))."')");//转换成时间戳后，有空的时间，也能导入，否则时间为空的行不能导入
}
echo "完成";
?>