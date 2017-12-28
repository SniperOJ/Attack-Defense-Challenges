<?php 
namespace Common\Model;
use Think\Model\AdvModel;
class ListModel extends AdvModel {
	//自动验证
	protected $_validate=array(
		array('list_name','require','必须填写分类标题！',1),
		array('list_oid','number','必须填写排序ID！',1),
		array('list_dir','','分类别名已经存在,请重新设定！',1,'unique',1),
	);
	//自动完成
	protected $_auto=array(
		array('list_dir','listdir',3,'callback'),
	);
	//处理英文名
	public function listdir(){
		if (empty($_POST['list_dir'])) {
		    return gxl_pinyin(trim($_POST['list_name']));
		}else{
		    return trim($_POST['list_dir']);
		}
	}	
}
?>