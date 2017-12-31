<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

<title>{$list_name}</title>
<meta name="keywords" content="{$list_name}">
<meta name="description" content="{$list_name}">
<include file="gxlcms:include" />
</head>
<body>
<include file="gxlcms:header" />
<div class="content-box fn-clear">
     <div class="all-filtrate-head">
              <div class="fn-left movie-headline7">作品检索</div>
                          <span class="fn-left you-select"></span>
                            <ul class="conbread all-fil-ul1" >
  
                          
                              <notempty name="_GET['letter']">
                            <li>{$_GET['letter']}<i><a href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}">&nbsp;</a></i></li>
                            </notempty>                                                                                          
                            </ul>
                           <a href="{:UU('Home-ting/show',array('id'=>$list_id,'listdir'=>$list_dir,'picm'=>$u_picm),true,false)}" class="conreset anew-filtrate fn-right"><i></i>重新筛选</a>
                       </div>
    <div class="all-type-layout">
        <div class="all-type-nav fn-clear">
            <span><i class="iconfont">&#xe635;</i></span>
            <volist name="list_menu" id="ppting" offset="0" length='5'>
            <a href="{$ppting.list_url}" <eq name="ppting.list_id" value="$list_id">class="on"</eq>>{$ppting.list_name}</a>
            </volist>
        </div>

          <div class="all-type-box fn-clear" style="clear:both">
            <span>分类：</span>
            <div class="all-box all-height">
 <empty name="list_id" value="">
            <a <eq name="list_pid" value="0">class="on"</eq> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'lz'=>$u_lz,'letter'=>$u_letter,'order'=>$u_order,'picm'=>$u_picm),true,false)}" target="_self" data="id-{$list_pid}-lz-0-letter-0">全部</a> 
            <volist name="array_listid" id="gxl_listid"><a <eq name="list_id" value="$gxl_listid.list_id">class="on"</eq> href="{$gxl_listid.list_url}" target="_self" data="id-{$gxl_listid.list_id}">{$gxl_listid.list_name}</a></volist>
            <else />
            <a <eq name="list_lid" value="0">class="on"</eq> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'lz'=>$u_lz,'year'=>$u_year,'letter'=>$u_letter,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}" target="_self" data="id-{$list_pid}">全部</a><php>$array_listid = getlistall($list_pid);</php>
 <volist name="array_listid" id="gxl_listid"><a <eq name="list_id" value="$gxl_listid.list_id">class="on"</eq> href="{$gxl_listid.list_url}" target="_self" data="id-{$gxl_listid.list_id}">{$gxl_listid.list_name}</a></volist>
 </empty>    
             </div>
        </div>

    
       
        <div class="all-type-box fn-clear">
            <span>字母：</span>
            <div class="all-box all-height">
                <a <php>if (!isset($_GET['letter'])){</php>class="on"<php>}</php> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}" target="_self" data="letter-0">全部</a>
               <volist name="s_letter" id="letter">                                                
     <a <eq name="letter" value="$_GET['letter']">class="on"</eq> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'letter'=>$letter,'order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}" target="_self" data='letter-{$letter}'>{$letter}</a></volist>
     <a <eq name="u_letter" value="0,1,2,3,4,5,6,7,8,9">class="on"</eq> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'lz'=>$u_lz,'year'=>$u_year,'letter'=>'0,1,2,3,4,5,6,7,8,9','order'=>$u_order,'area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}" target="_self" data='letter-0,1,2,3,4,5,6,7,8,9'>0-9</a>
                 </div>
        </div>
    </div>
</div>
 	<php>    
	if($_GET[order])
    $s_order=$_GET[order]." DESC";
    else
    $s_order="addtime desc";  
$ting_list=gxl_sql_ting('cid:'.$list_id.';lz:'.$_GET[lz].';letter:'.$_GET[letter].';field:ting_id,ting_cid,ting_name,ting_author,ting_letters,ting_pic,ting_gold,ting_title,ting_anchor,ting_addtime,ting_content;limit:30;page:true;order:ting_'.$s_order.';');$page = $ting_list[0]['page'];$pagetop = $ting_list[0]['pagetop'];$pagetop = $ting_list[0]['pagetop'];$prev = $ting_list[0]['prev'];$next = $ting_list[0]['next'];$totalpages = $ting_list[0]['totalpages'];$currentpage = $ting_list[0]['currentpage'];$prevcount = $ting_list[0]['prevcont'];$nextcount = $ting_list[0]['nextcont'];
	</php>  
<div class="content-box-b2 fn-clear">
    <div class="type-list-layout">
    <div class="listtype_nav fn-clear">
        <div class="type-nav">
            <a <php>if($_GET[order]=="") echo "class='on'"; else if($_GET[order]=="addtime") echo "class='on'"; else echo ""</php>  href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'mcid'=>$u_mcid,'letter'=>$u_letter,'lz'=>$u_lz,'year'=>$u_year,'order'=>'addtime','area'=>urlencode($u_area),'picm'=>$u_picm),true,false)}" data="order-addtime">最新{$list_name}</a>
          <a <php>if($_GET[order]=="hits") {echo "class='on'";}else{echo "";} </php> href="{:UU('Home-ting/type',array('id'=>$list_id,'listdir'=>$list_dir,'letter'=>$u_letter,order=>'hits','picm'=>$u_picm),true,false)}" data="order-hits">最热{$list_name}</a>
        </div>
        <notempty name="ting_list">
                         <div class="fch3 fr">
                           全部共有 <span class="fch2-num-span" id="counts">{$ting_list.0.counts}</span> 部
                         </div>
          </div>
          </notempty> 
        <div id="J-type-con">
            <div class="box-b2-l6 fn-clear" style="display: block">
            <notempty name="ting_list">
                <ul class="fn-clear" id="contents">
                 <volist name="ting_list" id="ppting">
                    <li>
                            <a href="{$ppting.ting_readurl}" target="_blank" title="{$ppting.ting_name}" class="l6"><img class="loading" src="{$apicss}v256/images/pic.png" data-original="{$ppting.ting_picurl}"  alt="{$ppting.ting_name}"/><i class="box-img-bg"></i>                            
                                <i class="box-img-txt"><notempty name="ppting.ting_continu">第<php>echo preg_replace('/\D/s', '', $ppting['ting_continu']);</php>集<else />{$ppting.ting_title}</notempty></i><i class="bg"></i><em class="icon-play"></em></a>
                            <div class="box-b2-dub">
                                <div class="box-b2-nt box-b2-w">
                                    <p class="box-b2-n"><a href="{$ppting.ting_readurl}" target="_blank" title="{$ppting.ting_name}">{$ppting.ting_name}</a></p>
                                    <p class="box-b2-t">{$ppting.ting_anchor|msubstr=0,12,'...'}</p>
                                </div>
                                <span class="box-b2-score">{$ppting.ting_gold}分</span>
                            </div>
                        </li>
                        </volist>
                          </ul>
                      <else /><div class="kong">抱歉，没有找到相关内容！</div></notempty>        
                <div class="uipages page-layout mt30 clear" id="long-page">{:preg_replace(array('/<em class="prev".*?em>/','/<strong>.*?strong>/','/下一页/','/上一页/'),array('','','下一页&raquo;','&laquo;上一页'),$page)}</div>
            </div>
        </div>
    </div>
</div></div>
<!--<div class="ad960 mt30" id="ad2"></div>-->
<include file="gxlcms:footer" />
<script type="text/javascript">
window.onerror=function(){
	return true;
}
Root='{$root}';
var windowurl='';
var windowuall='';
if(window.location.href.indexOf('show')>0){
  windowurl=window.location.href;
}
var parms='<php> echo $_GET[p]; </php>';
var pid='{$list_pid}';
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
parms=eval("({'id':'<php> echo $list_id; </php>','lz':'<php> echo $_GET[lz]; </php>','area':'<php> echo urlencode($_GET[area]); </php>','year':'<php> echo $_GET[year]; </php>','letter':'<php> echo $_GET[letter]; </php>','order':'addtime','picm':'1','p':'1'})");
$('.conreset').click(function(e){
parms=eval("({'id':'<empty name="list_pid" value=""><php> echo $list_id; </php><else /><php> echo $list_pid; </php></empty>','order':'addtime','picm':'1','p':'1','mcid':'0','lz':'0','year':'0','area':'0','letter':'0'})");
var hrf =Root + 'index.php?s=Showlist-show-id-<empty name="list_pid" value="">{$list_id}<else />{$list_pid}</empty>-picm-1.html';
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