<?php
namespace Home\Action;
use Common\Action\HomeAction;
class NewsAction extends HomeAction{
    //资讯搜索
    public function search(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = gxl_param_url();
		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';
		C('jumpurl',UU('Home-news/search',$JumpUrl,true,false));	
		C('currentpage',$Url['page']);
		//变量赋值
		$search = $this->Lable_Search($Url,'news');
		$this->assign($search);
		$this->display($search['search_skin']);
    }
    //资讯列表
    public function show(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = gxl_param_url();
		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';	
		C('jumpurl',UU('Home-news/show',$JumpUrl,true,false));
		C('currentpage',$Url['page']);
		//变量赋值
		$List = list_search(F('_ppting/list'),'list_id='.$Url['id']);
		$channel = $this->Lable_News_List($Url,$List[0]);		
		$this->assign($channel);
		$this->display($channel['list_skin']);
    }
	//资讯内容页
    public function read(){
		$id = intval(I('get.id','','strip_tags,htmlspecialchars'));
		$array_detail = $this->get_cache_detail( $id );
		if($array_detail){
			$this->assign($array_detail['show']);
			$this->assign($array_detail['read']);
			$this->display($array_detail['read']['news_skin_detail']);
		}else{
			$this->assign("jumpUrl",C('site_path'));
			$this->error('此条资讯已经删除！');
		}
    }
	// 从数据库获取数据
	private function get_cache_detail($news_id){
		if(!$news_id){ return false; }
		//优先读取缓存数据
		if(C('data_cache_news')){
			$array_detail = S('data_cache_news_'.$news_id);
			if($array_detail){
				return $array_detail;
			}
		}
		//未中缓存则从数据库读取
		$where = array();
		$where['news_id'] = $news_id;
		$where['news_status'] = array('eq',1);
		$rs = D("News");
		$array = $rs->where($where)->relation('Tag')->find();
		//print_r($array);die();
		if($array){
			//解析标签
			$array_detail = $this->Lable_News_Read($array);
			//print_r($array_detail);die();
			if( C('data_cache_news') ){
				S('data_cache_news_'.$news_id, $array_detail, intval(C('data_cache_news')));
			}
			return $array_detail;
		}
		return false;
	}				
}
?>