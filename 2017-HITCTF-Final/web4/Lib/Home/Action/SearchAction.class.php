<?php
namespace Home\Action;
use Common\Action\HomeAction;
class SearchAction extends HomeAction{

	public function ajaxsearch(){
		$wd = I('get.wd','','strip_tags,htmlspecialchars');
		if(isset($wd)){
			$where['ting_status'] = array('eq',1);
			$search['ting_name']   = array('like','%'.$wd.'%');
			$search['ting_actor']   = array('like','%'.$wd.'%');
			$search['ting_director']= array('like','%'.$wd.'%');
			$search['ting_letters']= array('like','%'.$wd.'%');	
			$search['_logic'] = 'or';
			$where['_complex']= $search;
			$rs = M('Ting');
			$count = $rs->where($where)->count();
			$list = $rs->where($where)->field('ting_id,ting_cid,ting_name,ting_title,ting_letters')->limit(10)->select();
			
			if($count<= 0){
				$r = "<ul><li><a>未匹配到相关记录</a></li></ul>";
			}else{
				$r = "<ul>";
				foreach($list as $row){
					$r .= '<li><a href="'.gxl_data_url('ting',$row['ting_id'],$row['ting_cid'],$row['ting_name'],1,"",$row['ting_letters']).'"  title="'.$row['ting_name'].'" target="_blank">'.get_hilight($row['ting_name'],$wd).'<em>/</em>'.$row['ting_title'].'</a></li>';
				}
				$r.='<li><a class="tj" href="'.UU('Home-ting/search',array('wd'=>urlencode(trim($wd))),true,false).'" target="_blank">共找到<span>'.$count.'</span>条与<span>"'.$wd.'"</span> 的相关结果,点击查看全部相关信息。</a></li>';
				$r.='</ul>';
				
				
			}
			echo $r;			
		}
	}
}
?>