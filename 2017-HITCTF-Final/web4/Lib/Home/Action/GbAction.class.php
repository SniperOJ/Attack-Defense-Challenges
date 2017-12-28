<?php
namespace Home\Action;
use Common\Action\HomeAction;
class GbAction extends HomeAction{
    //留言列表
    public function show(){
			    $_GET=I('get.','','strip_tags,htmlspecialchars');
		$_userid = cookie('_userid');
			if(!empty($_userid)){
			$_userid = cookie_decode($_userid);
			$rs = D("User");
			$member = $rs->getMember(array('userid'=>$_userid));
			//存在用户
			if($member){
					$this->assign("username",$member['username']);
					$this->assign("nickname",$member['nickname']);
					$this->assign("userid",$member['userid']);
					//需要缓存
					$menus = get_menus(1);
					$this->assign("menus",$menus) ;
				}
			}
		$rs = D('GbView');
		$page = intval(I('get.p','1','strip_tags,htmlspecialchars'));
		$limit = intval(C('user_gbnum'));
		if (C('user_check')) {
			$where['gb_status'] = array('eq',1);
		}
		// 组合分页信息
		$count = $rs->where($where)->count('gb_id');
		$totalpages = ceil($count/$limit);
		if($page > $totalpages){
			$page = $totalpages;
		}
		$pageurl = UU('Home-gb/show',array('p'=>'{!page!}'),true,false);
		$pages = '共'.$count.'篇留言&nbsp;当前:'.$page.'/'.$totalpages.'页&nbsp;'.getpage($page,$totalpages,C('home_pagenum'),$pageurl,'pagego(\''.$pageurl.'\','.$totalpages.')');
		// 查询数据
		$list = $rs->where($where)->limit($limit)->order('gb_oid desc,gb_addtime desc')->page($page)->select();
		foreach($list as $key=>$val){
			$list[$key]['gb_floor'] = $count-(($page-1) * $limit + $key);
		}
		// 是否报错	
		$tingid = intval(I('get.id','','strip_tags,htmlspecialchars'));
		if($tingid){
			$rs = M("Ting");
			$array = $rs->field('ting_id,ting_name,ting_actor')->where('ting_status = 1 and ting_id='.$tingid)->find();
			if($array){
				$this->assign('gb_content','作品ID'.$array['ting_id'].'点播出现错误！名称：'.$array['ting_name'].' 主演：'.$array['ting_actor']);
			}
		}
		$this->assign('gb_list',$list);	
		$this->assign('gb_count',$count);
		$this->assign('gb_pages',$pages);
		$this->assign('ting_id',$tingid);
		$this->display('gxl_guestbook');
    }
	// 添加留言
    public function insert(){
		$rs = D("Gb");
		C('TOKEN_ON',false);//关闭令牌验证
		if($rs->create()){
			if (false !== $rs->add()) {
				$cookie = 'gbook-'.intval(I('get.cid','','strip_tags,htmlspecialchars'));
				setcookie($cookie, 'true', time()+intval(C('user_second')));
				if (C('user_check')) {
					$this->success('留言成功，我们会尽快审核您的留言！');
				}else{
					$this->success('恭喜您，留言成功！');
				}
			}else{
				$this->error('留言失败，请重试！');
			}
		}else{
		    $this->error($rs->getError());
		}
    }	
}
?>