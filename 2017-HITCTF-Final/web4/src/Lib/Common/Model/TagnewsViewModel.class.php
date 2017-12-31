<?php
namespace Common\Model;
use Think\Model\ViewModel;
class TagnewsViewModel extends ViewModel {
	//视图定义
	protected $viewFields = array (
		 'Tag'=>array('*','tag_id'=>'news_tag_id','tag_name'=>'news_tag_name'),
		 'News'=>array('*', '_on'=>'Tag.tag_id = News.news_id'),
	);
}
?>