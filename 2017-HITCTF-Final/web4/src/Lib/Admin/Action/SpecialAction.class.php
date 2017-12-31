<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class SpecialAction extends BaseAction{	
	// 显示专题
    public function show(){
		//获取地址栏参数
		$admin['cid']= $_REQUEST['cid'];
		$admin['continu'] = $_REQUEST['continu'];
		$admin['status'] = intval($_REQUEST['status']);
		$admin['player'] = trim($_REQUEST['player']);
		$admin['stars'] = intval($_REQUEST['stars']);
		$admin['type'] = !empty($_GET['type'])?$_GET['type']:C('admin_order_type');
		$admin['order'] = !empty($_GET['order'])?$_GET['order']:'desc';
		$admin['orders'] = 'special_'.$admin["type"].' '.$admin['order'];
		$admin['p'] = '';
		//生成查询参数
		$limit = C('url_num_admin');
		$order = 'special_'.$admin["type"].' '.$admin['order'];
		//组合分页信息
		$rs = D("Special");
		$count = $rs->count('special_id');
		$totalpages = ceil($count/$limit);
		$currentpage = !empty($_GET['p'])?intval($_GET['p']):1;
		$currentpage = get_maxpage($currentpage,$totalpages);
		$pageurl = U('Admin-Special/Show',$admin,false,false)."-p-{!page!}".C('url_html_suffix');
		$admin['p'] = $currentpage;
		$pages = '共'.$count.'篇专题&nbsp;当前:'.$currentpage.'/'.$totalpages.'页&nbsp;'.getpage($currentpage,$totalpages,8,$pageurl,'pagego(\''.$pageurl.'\','.$totalpages.')');
		$admin['pages'] = $pages;
		//查询数据	
		$list = $rs->where($where)->page($currentpage)->limit($limit)->order($order)->select();
		foreach($list as $key=>$val){
			$list[$key]['special_url'] = gxl_data_url('special',$list[$key]['special_id'],0,$list[$key]['special_name'],1,'',$list[$key]['special_letters']);
			$list[$key]['special_starsarr'] = admin_star_arr($list[$key]['special_stars']);	
		}
		//组合专题收录统计
		$rs = D("Topic");
		$list_topic = $rs->select();
		foreach($list_topic as $key=>$value){
			$array_topic[$value['topic_sid'].'-'.$value['topic_tid']][$key] = $value['topic_tid'];
		}
		$this->assign($admin);
		$this->assign('list',$list);
		$this->assign('array_count',$array_topic);
		$this->display('./Public/admin/special_show.html');
    }
	// 添加与编辑专题
    public function add(){
		$where = array();
		$where['special_id'] = intval($_GET['id']);
		if ($where['special_id']) {
			$rs = D("Special");
			$array = $rs->where($where)->find();
			if (C('admin_time_edit')){
				$array['checktime'] = 'checked';
			}	
			$array['templatetitle'] = '编辑';
			$array['special_starsarr'] = admin_star_arr($array['special_stars']);
			//
			$rs = D('Topic');
			unset($where);
			$where['topic_tid'] = $array['special_id'];
			$where['topic_sid'] = 1;
			$array['countting'] = $rs->where($where)->count();
			//
			$where['topic_sid'] = 2;
			$array['countnews'] = $rs->where($where)->count();
		}else{
			$array['special_starsarr'] = admin_star_arr(1);
			$array['special_addtime'] = time();
			$array['checktime'] = 'checked';
			$array['templatetitle'] = '添加';
			$array['countting'] = 0;
			$array['countnews'] = 0;		
		}
		$this->assign($array);
		$this->display('./Public/admin/special_add.html');
    }
	// 添加专题并写入数据库
	public function insert(){
		$rs = D("Special");
		// 新增加拼音
		$_POST['special_letters'] = specialletters($_POST['special_name']);
		// 新增加拼音
		if ($rs->create()) {
			if ( false !==  $rs->add() ) {
				redirect('?s=Admin-Special-Show');
			}else{
				$this->error('添加专题失败');
			}
		}else{
		    $this->error($rs->getError());
		}		
	}	
	// 更新专题
	public function update(){
		$rs = D("Special");
		if ($rs->create()) {
			if ($rs->save() === false) {
				$this->error("更新专题失败！");
			}
		}else{
			$this->error($rs->getError());
		}
	}
	public function _after_update(){
		//更新数据缓存
		if(C('data_cache_special')){
			S('data_cache_special_'.intval($_POST['special_id']),NULL);
		}
		//删除静态缓存
		if(C('html_cache_on')){
			//删除缓存
			$id = md5(gxl_data_url('special',$_POST['special_id'],0,$_POST['special_name'],1,'',getsppinyin($_POST['special_id']))).C('html_file_suffix');
			//删除缓存
			@unlink(HTML_PATH.'/Special_read/'.$id);
			
		}
		redirect('?s=Admin-Special-Show');
	}	
	// 隐藏与显示专题
    public function status(){
		$where['special_id'] = intval($_GET['id']);
		$rs = D("Special");
		if(intval($_GET['sid'])){
			$rs->where($where)->setField('special_status',1);
		}else{
			$rs->where($where)->setField('special_status',0);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }
	// 删除专题
    public function del(){
		$this->delfile(intval($_GET['id']));
		redirect($_SERVER['HTTP_REFERER']);
    }
	// 删除专题all
    public function delall(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要删除的专题！');
		}	
		$array = $_POST['ids'];
		foreach($array as $val){
			$this->delfile($val);
		}
		redirect($_SERVER['HTTP_REFERER']);
    }
	// 删除静态文件与图片
    public function delfile($id){
		$where['special_id'] = $id;
		$rs = D("Special");
		$rs->where($where)->delete();
    }
	// 展示影视列表
    public function ajax(){
		$data = array(); $where = array();
		$did = intval($_GET['did']);
		$tid = intval($_GET['tid']);
		$sid = !empty($_GET['sid'])?$_GET['sid']:1;
		$type = trim($_GET['type']);//AJAX操作模块 add/del/up/down
		$lastdid = intval($_GET['lastdid']);//需要处理排序的下一个ID
		//执行添加或删除操作
		if($did && $tid){
			$rs = D("Topic");
			if($type == 'add'){
				//查询是否已添加
				$rsid = $rs->where('topic_sid = '.$sid.' and topic_did = '.$did.' and topic_tid = '.$tid)->getField('topic_did');
				if(!$rsid){
					$count = $rs->where('topic_sid = '.$sid.' and topic_tid = '.$tid)->max('topic_oid');
					$data['topic_did'] = $did;
					$data['topic_tid'] = $tid;
					$data['topic_sid'] = $sid;
					$data['topic_oid'] = $count+1;
					$rs->data($data)->add();
				}
			}elseif($type == 'del'){
				$where['topic_did'] = $did;
				$where['topic_tid'] = $tid;
				$where['topic_sid'] = $sid;
				$rs->where($where)->delete();
			}elseif($type == 'up'){
				$where['topic_did'] = $did;
				$where['topic_tid'] = $tid;
				$where['topic_sid'] = $sid;
				$rs->where($where)->setInc('topic_oid');
				//上一个ID的排序减1
				$where['topic_did'] = $lastdid;
				$rs->where($where)->setDec('topic_oid');
			}elseif($type == 'down'){
				$where['topic_did'] = $did;
				$where['topic_tid'] = $tid;
				$where['topic_sid'] = $sid;
				$rs->where($where)->setDec('topic_oid');
				//上一个ID的排序加1
				$where['topic_did'] = $lastdid;
				$rs->where($where)->setInc('topic_oid');				
			}
		}
		if($tid && $sid == 1){
			$this->showting($did,$tid);
		}elseif($tid && $sid == 2){
			$this->shownews($did,$tid);
		}else{
			echo('请先创建专辑！');
		}
    }
	// 展示该专题已收录的影视列表
	public function showting($did,$tid){
		$where = array();
		$where['topic_sid'] = 1;
		$where['topic_tid'] = $tid;
		$rs = D('Topic');
		$maxoid = $rs->where($where)->max('topic_oid');
		$minoid = $rs->where($where)->min('topic_oid');
		//
		$rs = D('TopictingView');
		$list = $rs->field('ting_id,ting_name,ting_actor,topic_oid')->where($where)->order('topic_oid desc,topic_did desc')->select();
		if(!$list){
			echo('该专题暂未收录任何数据！');
		}else{
			$this->assign('max_oid',$maxoid);
			$this->assign('min_oid',$minoid);
			$this->assign('list_ting',$list);
			$this->assign('count',count($list));
			$this->display('./Public/admin/special_ting_ids.html');
		}		
	}
	// 展示该专题已收录的资讯列表
	public function shownews($did,$tid){
		$where = array();
		$where['topic_sid'] = 2;
		$where['topic_tid'] = $tid;
		$rs = D('Topic');
		$maxoid = $rs->where($where)->max('topic_oid');
		$minoid = $rs->where($where)->min('topic_oid');
		//
		$rs = D('TopicnewsView');
		$list = $rs->field('news_id,news_name,topic_oid')->where($where)->order('topic_oid desc,topic_did desc')->select();
		if(!$list){
			echo('该专题暂未收录任何数据！');
		}else{
			$this->assign('max_oid',$maxoid);
			$this->assign('min_oid',$minoid);
			$this->assign('list_news',$list);
			$this->assign('count',count($list));
			$this->display('./Public/admin/special_news_ids.html');
		}
	}
	// Ajax设置星级
    public function ajaxstars(){
		$where['special_id'] = intval($_GET['id']);
		$data['special_stars'] = intval($_GET['stars']);
		$rs = D("Special");
		$rs->where($where)->save($data);
		echo('ok');
    }	
}
?>