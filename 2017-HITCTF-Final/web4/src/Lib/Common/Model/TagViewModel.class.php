<?php
namespace Common\Model;
use Think\Model\ViewModel;
class TagViewModel extends ViewModel {
	//视图定义
	protected $viewFields = array (
		 'Tag'=>array('*','tag_id'=>'ting_tag_id','tag_name'=>'ting_tag_name'),
		 'Ting'=>array('*', '_on'=>'Tag.tag_id = Ting.ting_id'),
	);
}
?>