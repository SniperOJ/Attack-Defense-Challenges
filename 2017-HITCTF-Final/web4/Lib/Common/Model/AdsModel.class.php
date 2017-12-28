<?php 
namespace Common\Model;
use Think\Model\AdvModel;
class AdsModel extends AdvModel {
	protected $_validate=array(
		array('ads_name','require','广告标识必须填写！',1,'',1),
		array('ads_name','','该广告标识已经存在,请重新填写一个广告标识！',1,'unique',1),
	);
	protected $_auto=array(
		array('ads_name','trim',3,'function'),
		array('ads_content','trim',3,'function'),
		array('ads_content','stripslashes',3,'function'),
	);
}
?>