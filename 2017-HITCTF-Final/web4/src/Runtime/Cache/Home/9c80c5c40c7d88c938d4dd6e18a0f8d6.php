<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

<title><?php echo ($list_name); ?></title>
<meta name="keywords" content="<?php echo ($list_name); ?>">
<meta name="description" content="<?php echo ($list_name); ?>">
<script language="javascript"><!-- 
window.onerror=function(){return true;} 
// --></script>
<link href="<?php echo ($apicss); ?>v256/css/base.css" type="text/css" rel="stylesheet">  
<script type="text/javascript"> <?php if(!empty($mobile_status)): ?>var Siteurl='<?php echo rtrim($murl,'/');?>'; var Mvodurl='<?php echo rtrim($murl,'/'); echo ($thisurl); ?>'; <?php else: ?>var Siteurl='<?php echo ($siteurl); ?>'; var Mvodurl='<?php echo rtrim($siteurl,'/'); echo ($thisurl); ?>';<?php endif; ?> Root='<?php echo ($root); ?>';var Sid='<?php echo ($sid); ?>';var Cid='<?php echo ($list_id); ?>';<?php if($sid == 1): ?>var Id='<?php echo ($ting_id); ?>';<?php else: ?>var Id='<?php echo ($news_id); ?>';<?php endif; ?></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/scrollbar.js"></script>

<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/lazyload.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/v256.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/playclass.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/jquery.base.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/js.js"></script>
<?php if(!empty($mobile_status)): ?><link rel="canonical" href="<?php echo rtrim($siteurl,'/'); echo ($thisurl); ?>"/>
<meta name="mobile-agent" content="format=xhtml;url=<?php echo rtrim($murl,'/'); echo ($thisurl); ?>" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="Cache-Control" content="no-transform" />
<script src="<?php echo ($apicss); ?>v256/js/uaredirectforpc.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("<?php echo rtrim($murl,'/'); echo ($thisurl); ?>");</script><?php endif; ?>
<?php $cattvlist = getlistmcat($tv_id); ?>
<?php $catmovlist = getlistmcat($mov_id); ?>
<?php $catdmlist = getlistmcat($dm_id); ?>
<?php $catzylist = getlistmcat($zy_id); ?>
<?php $catweilist = getlistmcat($wei_id); ?>
<?php $array_listtvid = getlistall($tv_id); ?>
<?php $array_listmovid = getlistall($mov_id); ?>

<?php $listarray = getlistmcat($list_id); ?>
</head>
<body>
                <div class="top-layout" id="J-fixtop">
            <div class="top-wrap fn-clear">
                <h1><a href="<?php echo ($siteurl); ?>"><?php echo ($sitename); ?></a></h1>  
                <div class="search-wrap">
                    <form method="post" action="<?php echo str_replace('-wd--p-1','',UU('Home-ting/search','',true,false));?>">
                        <div class="search-l">
                            <i class="iconfont">&#xe601;</i>
                            <input autocomplete="off" id="wd" name="wd" type="text" value="输入作品名或主播。" onfocus="if(this.value=='输入作品名或主播。'){this.value='';}" onblur="if(this.value==''){this.value='输入作品名或主播。';};" autocomplete="off" class="search-text1">
                        </div>
                        <input type="submit" value="搜 索" class="search-btn" id="btn"></form>
                            <div class="search-list">
      <div class="search-list-left fn-left">
        <ul class="search-list-ul" id="search-list-ul">

        </ul>
      </div>
      
      <div class="search-list-right fn-right">
        <div class="slr-inner" id="slr-inner">
        </div>
      </div>
    <div class="search-list-right"></div>
    </div><!--search-list-->
                </div>
               
            </div>
        </div>
        <div class="navgation-layout">
            <div class="navgation-wrap fn-clear">
                <div class="navgation-left">
                    <a href="<?php echo ($siteurl); ?>" <?php if(($list_id) == ""): if( $sid['sid'] > ''): else: ?>class="on"<?php endif; endif; ?>><i class="iconfont"></i><em>首页</em></a>
                    <?php if(is_array($list_menu)): $i = 0; $__LIST__ = $list_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppvod): $mod = ($i % 2 );++$i; if(($ppvod["list_pid"]) == "0"): ?><a href="<?php echo ($ppvod["list_url"]); ?>"  <?php if(($sid["sid"]) == "story"): else: if(($ppvod["list_id"]) == $list_id): ?>class="on"<?php endif; if(($ppvod["list_id"]) == $list_pid): ?>class="on"<?php endif; endif; ?>><i class="iconfont"></i><em><?php echo ($ppvod["list_name"]); ?></em></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                 </div>
               
            </div>
            <div class="navgation-shodw"></div>
        </div>
<div class="content-box fn-clear">
     <div class="all-filtrate-head">
              <div class="fn-left movie-headline7">作品检索</div>
                          <span class="fn-left you-select"></span>
                            <ul class="conbread all-fil-ul1" >
  
                          
                              <?php if(!empty($_GET['letter'])): ?><li><?php echo ($_GET['letter']); ?><i><a href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>">&nbsp;</a></i></li><?php endif; ?>                                                                                          
                            </ul>
                           <a href="<?php echo UU('Home-ting/show',array('id'=>$list_id,'listdir'=>$list_dir,'picm'=>$u_picm),true,false);?>" class="conreset anew-filtrate fn-right"><i></i>重新筛选</a>
                       </div>
    <div class="all-type-layout">
        <div class="all-type-nav fn-clear">
            <span><i class="iconfont">&#xe635;</i></span>
            <?php if(is_array($list_menu)): $i = 0; $__LIST__ = array_slice($list_menu,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><a href="<?php echo ($ppting["list_url"]); ?>" <?php if(($ppting["list_id"]) == $list_id): ?>class="on"<?php endif; ?>><?php echo ($ppting["list_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

          <div class="all-type-box fn-clear" style="clear:both">
            <span>分类：</span>
            <div class="all-box all-height">
 <?php if(empty($list_id)): ?><a <?php if(($list_pid) == "0"): ?>class="on"<?php endif; ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'lz'=>$u_lz,'letter'=>$u_letter,'order'=>$u_order,'picm'=>$u_picm),true,false);?>" target="_self" data="id-<?php echo ($list_pid); ?>-lz-0-letter-0">全部</a> 
            <?php if(is_array($array_listid)): $i = 0; $__LIST__ = $array_listid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i;?><a <?php if(($list_id) == $gxl_listid["list_id"]): ?>class="on"<?php endif; ?> href="<?php echo ($gxl_listid["list_url"]); ?>" target="_self" data="id-<?php echo ($gxl_listid["list_id"]); ?>"><?php echo ($gxl_listid["list_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
            <a <?php if(($list_lid) == "0"): ?>class="on"<?php endif; ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'lz'=>$u_lz,'year'=>$u_year,'letter'=>$u_letter,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>" target="_self" data="id-<?php echo ($list_pid); ?>">全部</a><?php $array_listid = getlistall($list_pid); ?>
 <?php if(is_array($array_listid)): $i = 0; $__LIST__ = $array_listid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gxl_listid): $mod = ($i % 2 );++$i;?><a <?php if(($list_id) == $gxl_listid["list_id"]): ?>class="on"<?php endif; ?> href="<?php echo ($gxl_listid["list_url"]); ?>" target="_self" data="id-<?php echo ($gxl_listid["list_id"]); ?>"><?php echo ($gxl_listid["list_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; endif; ?>    
             </div>
        </div>

    
       
        <div class="all-type-box fn-clear">
            <span>字母：</span>
            <div class="all-box all-height">
                <a <?php if (!isset($_GET['letter'])){ ?>class="on"<?php } ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>" target="_self" data="letter-0">全部</a>
               <?php if(is_array($s_letter)): $i = 0; $__LIST__ = $s_letter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$letter): $mod = ($i % 2 );++$i;?><a <?php if(($letter) == $_GET['letter']): ?>class="on"<?php endif; ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'letter'=>$letter,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>" target="_self" data='letter-<?php echo ($letter); ?>'><?php echo ($letter); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
     <a <?php if(($u_letter) == "0,1,2,3,4,5,6,7,8,9"): ?>class="on"<?php endif; ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'letter'=>'0,1,2,3,4,5,6,7,8,9','order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>" target="_self" data='letter-0,1,2,3,4,5,6,7,8,9'>0-9</a>
                 </div>
        </div>
    </div>
</div>
 	<?php if($_GET[order]) $s_order=$_GET[order]." DESC"; else $s_order="addtime desc"; $ting_list=gxl_sql_ting('cid:'.$list_id.';lz:'.$_GET[lz].';letter:'.$_GET[letter].';field:ting_id,ting_cid,ting_name,ting_author,ting_letters,ting_pic,ting_gold,ting_title,ting_anchor,ting_addtime,ting_content;limit:30;page:true;order:ting_'.$s_order.';');$page = $ting_list[0]['page'];$pagetop = $ting_list[0]['pagetop'];$pagetop = $ting_list[0]['pagetop'];$prev = $ting_list[0]['prev'];$next = $ting_list[0]['next'];$totalpages = $ting_list[0]['totalpages'];$currentpage = $ting_list[0]['currentpage'];$prevcount = $ting_list[0]['prevcont'];$nextcount = $ting_list[0]['nextcont']; ?>  
<div class="content-box-b2 fn-clear">
    <div class="type-list-layout">
    <div class="listtype_nav fn-clear">
        <div class="type-nav">
            <a <?php if($_GET[order]=="") echo "class='on'"; else if($_GET[order]=="addtime") echo "class='on'"; else echo "" ?>  href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'letter'=>$u_letter,'lz'=>$u_lz,'year'=>$u_year,'order'=>'addtime','area'=>urlencode($u_area),'picm'=>$u_picm),true,false);?>" data="order-addtime">最新<?php echo ($list_name); ?></a>
          <a <?php if($_GET[order]=="hits") {echo "class='on'";}else{echo "";} ?> href="<?php echo UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'letter'=>$u_letter,order=>'hits','picm'=>$u_picm),true,false);?>" data="order-hits">最热<?php echo ($list_name); ?></a>
        </div>
        <?php if(!empty($ting_list)): ?><div class="fch3 fr">
                           全部共有 <span class="fch2-num-span" id="counts"><?php echo ($ting_list["0"]["counts"]); ?></span> 部
                         </div>
          </div><?php endif; ?> 
        <div id="J-type-con">
            <div class="box-b2-l6 fn-clear" style="display: block">
            <?php if(!empty($ting_list)): ?><ul class="fn-clear" id="contents">
                 <?php if(is_array($ting_list)): $i = 0; $__LIST__ = $ting_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo ($ppting["ting_readurl"]); ?>" target="_blank" title="<?php echo ($ppting["ting_name"]); ?>" class="l6"><img class="loading" src="<?php echo ($apicss); ?>v256/images/pic.png" data-original="<?php echo ($ppting["ting_picurl"]); ?>"  alt="<?php echo ($ppting["ting_name"]); ?>"/><i class="box-img-bg"></i>                            
                                <i class="box-img-txt"><?php if(!empty($ppting["ting_continu"])): ?>第<?php echo preg_replace('/\D/s', '', $ppting['ting_continu']); ?>集<?php else: echo ($ppting["ting_title"]); endif; ?></i><i class="bg"></i><em class="icon-play"></em></a>
                            <div class="box-b2-dub">
                                <div class="box-b2-nt box-b2-w">
                                    <p class="box-b2-n"><a href="<?php echo ($ppting["ting_readurl"]); ?>" target="_blank" title="<?php echo ($ppting["ting_name"]); ?>"><?php echo ($ppting["ting_name"]); ?></a></p>
                                    <p class="box-b2-t"><?php echo (msubstr($ppting["ting_anchor"],0,12,'...')); ?></p>
                                </div>
                                <span class="box-b2-score"><?php echo ($ppting["ting_gold"]); ?>分</span>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                          </ul>
                      <?php else: ?><div class="kong">抱歉，没有找到相关内容！</div><?php endif; ?>        
                <div class="uipages page-layout mt30 clear" id="long-page"><?php echo preg_replace(array('/<em class="prev".*?em>/','/<strong>.*?strong>/','/下一页/','/上一页/'),array('','','下一页&raquo;','&laquo;上一页'),$page);?></div>
            </div>
        </div>
    </div>
</div></div>
<!--<div class="ad960 mt30" id="ad2"></div>-->
<div class="foot">        
    
    <div class="foot-layout">
    <div class="foot-wrap">
       
<p class="foot-p2"><?php echo ($copyright); ?></p>
<p class="foot-p2">若本站收集的节目无意侵犯了贵司版权，请给<a href="mailto:<?php echo ($email); ?>"><?php echo ($email); ?></a>邮箱地址来信，我们将在第一时间删除相应资源</p>
<p class="foot-p2">Copyright &#169; 2015-2018 www.gxlcms.com.All Rights Reserved .</p>
    </div>
</div>
    </div>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/read.js"></script>
<script type="text/javascript" src="<?php echo ($apicss); ?>v256/js/foot_js.js"></script>   
    

<script type="text/javascript">
window.onerror=function(){
	return true;
}
Root='<?php echo ($root); ?>';
var windowurl='';
var windowuall='';
if(window.location.href.indexOf('show')>0){
  windowurl=window.location.href;
}
var parms='<?php echo $_GET[p]; ?>';
var pid='<?php echo ($list_pid); ?>';
$('.all-type-box a').click(function (e){
if($(this).attr('data').indexOf('mcid')==0){
$("#curlist").html("&raquo;"+$(this).html());
}
	var constr='';
	var curobj=$(this);
	if(parms!=undefined&&parms!=null)
     {
		
		var curdata=$(this).attr('data').split('-');
		parms[curdata[0]]=curdata[1];
		url=parseurl(parms);
		curobj.siblings().removeClass('on');
		curobj.addClass('on');
	    pagegooo(url);
	   $('.all-type-box a').each(function(e){
	     if( $(this).attr('class')=='on')
		  {
	       if($(this).html() == '全部')
	       constr+=' ';
	       else
	     constr +='<li>'+$(this).html()+'<i>&nbsp;</i></li>';
	     }
    	});//index  bread
	if(constr !='')
	$('.conbread').html(constr);
   }
return false;
});
function pagegooo(url){ 
url=url+".html";
   if(($('#contents li').length > 3)) $("html,body").animate({scrollTop:$("#contents").offset().top - 93},500);
	$("#contents").html('<div class="load">努力加载中……</div>');
	$.get(url, function(data,status) {
	 var value=jQuery('#contents', data).html();
      if(value=='') {
	  value=  '<div class="kong">抱歉，没有找到相关内容！</div>';
	  }  
	 $("#contents").html(value);
	 $("#short-page").html(jQuery('#short-page', data).html())
	 $("#long-page").html(jQuery('#long-page', data).html())
	 $("#totalpages").html(jQuery('#totalpages', data).html())
	 $("#currentpage").html(jQuery('#currentpage', data).html())
     $("#counts").html(jQuery('#counts', data).html())	 
     $(".uipages a").click(function (e){
                        e.preventDefault();
                        var curdata=$(this).attr('data').split('-');
                        parms[curdata[0]]=curdata[1];
                        var url=parseurl(parms);
                        pagegooo(url);
                        return false;
                    });
	});
}
$(function(){
parms=eval("({'id':'<?php echo $list_id; ?>','lz':'<?php echo $_GET[lz]; ?>','area':'<?php echo urlencode($_GET[area]); ?>','year':'<?php echo $_GET[year]; ?>','letter':'<?php echo $_GET[letter]; ?>','order':'addtime','picm':'1','p':'1'})");
$('.conreset').click(function(e){
parms=eval("({'id':'<?php if(empty($list_pid)): echo $list_id; else: echo $list_pid; endif; ?>','order':'addtime','picm':'1','p':'1','mcid':'0','lz':'0','year':'0','area':'0','letter':'0'})");
var hrf =Root + 'index.php?s=Showlist-show-id-<?php if(empty($list_pid)): echo ($list_id); else: echo ($list_pid); endif; ?>-picm-1.html';
hrf = hrf.substring(0,hrf.indexOf(".html"));
pagegooo(hrf);
$(".uipages a").click(
	function (e){
	pagegooo($(this).attr('href'));
	return false;
	}
	);
   var constrf='';
    $('.all-type-box a').each(function(e){
        if($(this).html() != '全部' && $(this).attr('class')=='active-style2' ){
            constrf +='<li>'+$(this).html()+'<i>&nbsp;</i></li>';
        }
    });
if(constrf !=''){
        $('.conbread').html(constrf);
    }
    $('.all-type-box a').each(function(e){
	$(this).removeClass('on');
	 if($(this).html() == '全部'){
	  $(this).attr('class','on');
	  $('#curlist').html("全部");
	  $('.conbread').html('');
	   }
	});
	return false;
 });
});
function parseurl(rr){
  var url=Root + 'index.php?s=Showlist-show';
  for(var c in rr){
     if(rr[c]!='0'){
    url=url+"-"+c+"-"+rr[c];
	}
  }
  return url;
}
$(function(){
    $('.uipages a').click(function (e){
                e.preventDefault();
                $(this).addClass('current');
				$(this).addClass('on');
                $(this).siblings().removeClass('current');
				$(this).siblings().removeClass('on');
                var curdata=$(this).attr('data').split('-');
                parms[curdata[0]]=curdata[1];
                var url=parseurl(parms);
                pagegooo(url);
            }
);
	    $('.type-nav  a').click(function (e){
                e.preventDefault();
                var curdata=$(this).attr('data').split('-');
                parms[curdata[0]]=curdata[1];
                var url=parseurl(parms);
                pagegooo(url);
            }
);
	 $('.type-nav  a').click(function (e){
               e.preventDefault();
               var constr='';
               var curobj=$(this);
               var url = curobj.attr('href');
                curobj.parent().siblings()
				$(this).siblings().removeClass('on');
                curobj.addClass('on');
   var url='';
		if(parms!=undefined&&parms!=null){
			var curdata=$(this).attr('data').split('-');
			parms[curdata[0]]=curdata[1];
			if(curdata[1]=='1'){
				$("#contents").removeClass('list_module_list');
				$("#contents").addClass('list_module_img');
			}else{
				$("#contents").addClass('list_module_list');
				$("#contents").removeClass('list_module_img');
		}
		}
}
);
});
conbread();
function  conbread(){
	var atag = $('.all-type-box a');
	var constr="";
$.each(atag, function(i,val){      
       var data = val.data;
	   if(windowurl.indexOf(data)!=-1){
	   	     constr +='<em>'+val.innerHTML+'</em>';
			 $(this).attr('class','on');
	   }
  }); 
  $('.conbread').html(constr);
}
</script> 
<script>v256.typeList.init();</script>
</body>
</html>