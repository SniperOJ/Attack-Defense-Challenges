<?php
namespace Home\Action;
use Common\Action\BaseAction;
class TaglistAction extends BaseAction{
	//批量生成影视TAG
    public function index(){
		$currentpage = !empty($_GET['p'])?intval($_GET['p']):1;
		// 检测是否有任务未完成
		if($currentpage == 1){
			$jumpurl = F('_tag/jumpurl_ting');
			if($jumpurl){
				header("Location: ".$jumpurl);
			}
		}
		// 查询数据
		$rs = D('Admin.Ting');$rst = D('Admin.Tag');
		$count = $rs->count('ting_id');
		$totalpages = ceil($count/10);
		$list = $rs->field('ting_id,ting_name,ting_content,ting_keywords,ting_cid')->where('ting_status = 1')->order('ting_id desc')->limit(10)->page($currentpage)->select();	
		foreach($list as $key=>$value){
			$tag = $rst->where('tag_id = '.$value['ting_id'])->find();
			if($tag){
				dump($value['ting_id'].' 已有TAG 跳过');
			}else{
				$keywords = $value['ting_keywords'];
				if($keywords){
					$tag_arr = explode(',',$keywords);
					$tag_arr = array_unique($tag_arr);
					foreach($tag_arr as $value2){			 
						$rst->data(array('tag_id'=>$value['ting_id'],'tag_sid'=>1,'tag_name'=>$value2))->add();
						dump($rst->getLastSql());
					}
					//将tag同步到ting字段方便查询
					$edit = array();
					$edit['ting_id'] = $value['ting_id'];
					$edit['ting_keywords'] = implode(',',$tag_arr);
					$rs->data($edit)->save();
				}
			}
		}
		if($currentpage < $totalpages){
		     echo $keywords;
			F('_tag/jumpurl_ting','?s=plus-taglist-index-p-'.($currentpage+1));
			$this->redirect('Plus-Taglist/index',array('p'=>$currentpage+1), 3,'减小服务器压力，3秒后进行下一次操作~');
		}else{
			F('_tag/jumpurl_ting',NULL);
			dump('完成');
		}
    }
}
?>