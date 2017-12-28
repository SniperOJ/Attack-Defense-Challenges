<?php 
namespace Common\Model;
use Think\Model\RelationModel;
class SpecialModel extends RelationModel {
	protected $_validate=array(
		array('special_name','require','专题名称必须填写！',1),
	);
	protected $_auto=array(
		array('special_addtime','m_addtime',3,'callback'),
	);	
	public function m_addtime(){
		if ($_POST['checktime']) {
			return time();
		}else{
			return strtotime($_POST['special_addtime']);
		}
	}
	//关联定义
	protected $_link = array(
		'Topic'=>array(
			'mapping_type' => HAS_MANY,
			'class_name'=> 'Topic',
			'mapping_name'=>'Topic',//数据对像映射名称
			'foreign_key' => 'topic_tid',
			'parent_key' => 'special_id',
			//'mapping_fields' => 'topic_id,topic_sid,topic_did',
			//'condition' => 'special_sid = 1',
			//'mapping_limit' => 5,
			'mapping_order' => 'topic_oid desc',
		),
	);
}
?>