<?php
namespace Plus\Action;
use Common\Action\HomeAction;
class SearchAction extends HomeAction{
	public function ting(){
		$wd = trim($_GET['q']);
		$where = array();
		$search['ting_name'] = array('like','%'.$wd.'%');
		$search['ting_actor']   = array('like','%'.$wd.'%');
		$search['ting_director']= array('like','%'.$wd.'%');
		$search['ting_letters']= array('like',$wd.'%');	
		$search['_logic'] = 'or';
		$where['_complex'] = $search;	
		$rs = D('Ting');
		//搜索跳转
        $list = $rs->field('ting_name,ting_id,ting_cid,ting_jumpurl,ting_title')->where($where)->limit(10)->order('ting_hits_month desc')->select();
		$count = $rs->where($where)->count('ting_id');
		if($list){
			$lists['info']   =   "ok";
            $lists['status'] =   1;
			foreach($list as $key=>$val){
			   $lists['data'][$key]['ting_name'] =$val['ting_name'].'<em>/</em>'.$val['ting_title'] ;
	           $lists['data'][$key]['ting_url'] = gxl_data_url('ting',$val['ting_id'],$val['ting_cid'],$val['ting_name'],1,"",$val['ting_letters']);
			}
			$this->ajaxReturn($lists);
		}else{
			$lists['info']   =   "ok";
            $lists['status'] =   0;
			$this->ajaxReturn($lists);
		}
	}
}
?>