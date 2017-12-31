<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>{$title}</title>

<include file="gxlcms:include" />
    </head>
    <body>
   <include file="gxlcms:header" />
   <php>$ting_list = gxl_sql_ting('wd:'.$search_wd.';limit:5;field:ting_id,ting_cid,ting_name,ting_pic,ting_author,ting_anchor,ting_addtime,ting_content;page:true;order:ting_addtime desc');$page = $ting_list[0]['page'];$pagetop = $ting_list[0]['pagetop'];$pagetop = $ting_list[0]['pagetop'];$prev = $ting_list[0]['prev'];$next = $ting_list[0]['next'];$totalpages = $ting_list[0]['totalpages'];$currentpage = $ting_list[0]['currentpage'];$prevcount = $ting_list[0]['prevcont'];$nextcount = $ting_list[0]['nextcont'];
   </php>
    <div class="content-box fn-clear"> 
   
        <div class="star_list_nav clear"> 
      <ul class="view-mode"><span>搜索<font color="#3eaf0f">{$search_wd}</font>共找到</span>
     <notempty name="ting_list"><a class="on" href="javascript:;" data="type-ting">作品(<em>{$ting_list.0.counts}</em>)部</a></notempty>

    
     </ul>
     <div id="short-page">
    <div class="fch3 fr">全部共有<span class="fch2-num-span" id="counts">{$ting_list.0.counts}</span>个相关内容</div>
    </div>  
  </div>
  <!--排行榜内容-->
  <div class="serach-list" id="contents">
 <ul class="serach-ul">

<volist name="ting_list" id="ting"  key="i">
   <li>
<a class="list-img" href="{$ting.ting_readurl}" title="{$ting.ting_name}"><img  class="scrollLoading" src="{$ting.ting_picurl}" />
<label class="title">{$ting.ting_title}</label></a>
<div class="info">
<h2><a target="_blank" href="{$ting.ting_readurl}">{$ting.ting_name}</a></h2> 
<p class="anchor"><em>作者:</em>{$ting.ting_author}</p>
<p class="anchor clearfix"><em>主播:</em><notempty name="ting.ting_anchor">{$ting.ting_anchor}<else /><span>未知</span></notempty></p>


<p class="plot"><em>介绍:</em>{$ting.ting_content|msubstr=0,100,'...'}</p>
</div>

</li>
 </volist>
</ul>
</ul>
</div>
  <div class="uipages page-layout mt30 clear" id="long-page">{:preg_replace(array('/<em class="prev".*?em>/','/<strong>.*?strong>/','/下一页/','/上一页/'),array('','','下一页&raquo;','&laquo;上一页'),$page)}</div> 

   
 </div> 
<include file="gxlcms:footer" />
<script type="text/javascript">
    var parms = new Array();
    function parseurl(rr){
        var url='{$root}index.php?s=ting-search-wd-{$search_wd|urlencode}{$search_author}<notempty name="type">-type-{$type}</notempty>';
        for(var c in rr){
            if(rr[c]!='0'){
                url=url+"-"+c+"-"+rr[c];
            }
        }
        return url;
    }
    function pagegoo(url){
        $("#contents").html('<div class="load">正在努力搜索中.....</div>');
        $.ajax({
            url:url,
            success:function (r){
                if(r.data.ajaxtxt==''){
                    $("#contents").html('<div class="kong">没有搜索到您想要的结果，请尝试简化您的搜索关键词;或者到留言区求片等待小编为您添加！</div>');
                }else{
                    $("#contents").html(r.data.ajaxtxt);
                }
                $("#long-page").html(r.data.long_page);
                $("#short-page").html(r.data.short_page);
                $("#counts").html(r.data.count);
                $(".uipages a").click(function (e){
                    e.preventDefault();
                    var curdata=$(this).attr('data').split('-');
                    parms[curdata[0]]=curdata[1];
                    var url=parseurl(parms);
                    pagegoo(url);
                });
            },dataType:'json',timeout:2000,error:function(){
                $("#contents").html('<div class="load">服务器繁忙，请刷新页面重试...</div>');
            }
        });
    }
    $('.view-mode a').click(function (e){
                e.preventDefault();
                $(this).addClass('on');
                $(this).siblings().removeClass('on');
                var curdata=$(this).attr('data').split('-');
                parms[curdata[0]]=curdata[1];
                var url=parseurl(parms);
                pagegoo(url);
            }
    );
    $(".uipages a").click(function (e){
        e.preventDefault();
        var curdata=$(this).attr('data').split('-');
        parms[curdata[0]]=curdata[1];
        var url=parseurl(parms);
        pagegoo(url);
        return false;
    });
	if(window.location.href.indexOf('-wd-')>0){
	pagegoo(window.location.href.replace('.html','')+"-1"+"-ajax");
	}

</script>          
</body>
</html>