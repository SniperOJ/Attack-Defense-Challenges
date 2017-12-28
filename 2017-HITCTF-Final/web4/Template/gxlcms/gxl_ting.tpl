<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$ting_name}</title>
<meta name="keywords" content="{$ting_skeywords}">
<meta name="description" content="{$ting_sdescription|h|msubstr=0,100}...">       
<include file="gxlcms:include" />     
</head>
<body>
<include file="gxlcms:header" />
    <div class="content-box fn-clear">
        <div class="content-box-l">                
<!--            <div class="ad960" id="ad1"></div>  -->
       
                
            <div class="film-detail-layout fn-clear"> 
                <div class="film-detail-img">
                    <a href="{$ting_readurl}" class="play_btn" rel="nofollow" target="_blank"> <img src="{$ting_picurl}" alt="{$ting_name}" /><if condition="($list_pid eq $tv_id) OR ($list_id eq $zy_id) OR ($list_id eq $dm_id)"><neq name="ppting.ting_continu" value="0"><i class="updating"></i></neq></if><span class="hide-bg"></span><span class="hide-btn hover"></span>
                    </a>
                </div>
                <input type='hidden' name='_void_id' id='_void_id' value='{$ting_id}'/>
                <div class="film-detail-con">
        
       
                    <i class="film-detail-icon"></i>
                    <div class="fd-box">
                        <div class="fd-box-t fn-clear">
                            <h1>{$ting_name}</h1>
                               <neq name="ting_continu" value="0">
<notempty name="ji">
<div class="ting_z">更新至<font color="#FF3300">{$ji}</font><eq name="list_id" value="$zy_id">期<else/>集</eq><notempty name="ting_total">&nbsp;&nbsp;|&nbsp;&nbsp;共<php>echo preg_replace('/\D/s', '', $ting_total);</php>集</notempty></div></notempty>
</neq>

                        </div>

                    
                          <p class="fd-list">
                         
                            <span>作者：{$ting_author}</span>
                        </p>
                          <p class="fd-list">
                            <span> 主播：{$ting_anchor}</span>
                        </p>

                             <div class="update-last-time">
                     <div id="detail-rating" class="fn-left">
		  <div id="detail-rating" class="fn-clear">
          <div id="rating" class="fn-left"><span class="label">给影片评分：</span>
            <ul class="rating">
              <li class="one current" title="很差" val="1">很差</li>
              <li class="two current" title="较差" val="2">较差</li>
              <li class="three current" title="还行" val="3">还行</li>
              <li class="four" title="推荐" val="4">推荐</li>
              <li class="five" title="力荐" val="5">力荐</li>
            </ul>
            <span id="ratewords">还行</span></div>
        </div>
			</div>
             <div class="ting-info ui-boxb" id="detail-box">
	  <div class="rating-box" id="rating-main" style="display: block;"><div class="rating-total fn-clear"><label class="rating-total-item" id="total">&nbsp;</label><div class="pingfen-total"><strong id="pingfen"></strong><em id="pingfen2"></em></div></div><div class="rating-panle"><div class="rating-bar"><div class="rating-bar-item" id="fenshu">&nbsp;</div></div><ul class="rating-show"><li><span title="力荐" class="starstop star5">力荐</span><div class="power"><div class="power-item" id="pam"></div></div><em id="pa">人</em></li><li><span title="推荐" class="starstop star4">推荐</span><div class="power"><div class="power-item" id="pbm"></div></div><em id="pb">人</em></li><li><span title="还行" class="starstop star3">还行</span><div class="power"><div class="power-item" id="pcm"></div></div><em id="pc">人</em></li><li><span title="较差" class="starstop star2">较差</span><div class="power"><div class="power-item" id="pdm"></div></div><em id="pd">人</em></li><li><span title="很差" class="starstop star1">很差</span><div class="power"><div class="power-item" id="pem"></div></div><em id="pe">人</em></li></ul></div></div>
	  <div class="rating-box" id="rating-kong" style="display: none;"><div class="rating-kong-item"><span class="loadingg">评分加载中...</span></div></div></div>  
                    </div><!--update-last-time-->       
                        <p class="fd-list ting-jj"><span>介绍：{:strip_tags($ting_content)}</span></p>
                                           
<!--                        <div class="fd-play-box fn-clear">
                            <div id="ad7" class="fn-left"></div>
                        </div>-->
            </div>
        </div>
 </div>
                  
           
            <div class="lv-box-layout">
                      <div class="lv-nav fn-clear">
                        <ul>
     <fflist name="ting_playlist" id="ppting" offset="0" length='10'>
     <neq name="ppting.playname" value="down">
     <notin name="ppting.playname" value="$hideplayer">
                            <li <eq name="i" value="1">class="on"</eq> id="{$ppting.serverurl}{$ppting.playname}-pl">
                         <a  class="gico-site gico-{$ppting.playname} play_btn" href="javascript:;"  rel="nofollow"><em>{:str_replace(array('听','作品'),'',$ppting['playername'])}</em> </a> </li>
                  </notin></neq></fflist>              
                              </ul>
                          
                    </div>
                    <div class="lv-box-list">
                     <volist name="ting_playlist" id="ppting" offset="0" length='10'>
                      <neq name="ppting.playname" value="down">
                       <notin name="ppting.playname" value="$hideplayer"> 
                             <div id="{$ppting.playname}-pl-list" <gt name="i" value="1">style="display:none"<else/>style="display:block"</gt> class="lv-list fn-clear">
                                <div class="lv-bf-list">
                              <php>$countjii=count($ppting['son'])-1;</php>
                              <volist name="ppting['son']" id="gxlson" key="iii">
                  <a  target="_blank" href="{$gxlson.playurl}" title="{$gxlson.playname}">{$gxlson.playname|msubstr=0,10}<eq name="iii" value="1">{$ting_addtime|gettimetingnew='m-d',###}</eq></a>
        </volist>

               </div>
                 </div>                   
               </notin></neq>
               </volist> 

             </div>

                </div>            

 

         
   
 <php>$ting_gold=gxl_sql_ting('cid:'.$list_id.';limit:7;field:ting_id,ting_name,ting_cid,ting_letters,ting_title,ting_gold,ting_pic,ting_gold,ting_anchor,ting_addtime;order:ting_id desc');</php> 
      <notempty name="ting_gold">      
         <div class="box-model zhuyan-layout mt15">
        <div class="box-model-tit fn-clear">
            <h2>猜你喜欢</h2>
            <div class="box-model-more"><a href="{$list_url}">更多<i class="iconfont">&#xe60b;</i></a></div>
        </div>
        <div class="film-model-layout">
            <div class="box-x2-l6 fn-clear" style="display: block;">
                <ul>
                
                
                            <volist name="ting_gold" id="ppting">
                                <li>
                                        <a href="{$ppting.ting_readurl}" class="l6">
                                            <img src="{$ppting.ting_picurl}" alt="{$ppting.ting_name}" title="{$ppting.ting_name}" /><i class="play-bg"></i>
                                        </a>
                                        <div class="box-x2-dub">
                                            <p class="box-x2-n">
                                                <a href="{$ppting.ting_readurl}" title="{$ppting.ting_name}">{$ppting.ting_name}</a>
                                            </p>
                                            <p class="box-x2-r">{$ppting.ting_anchor}</p>
                                        </div>
                                    </li>
                                   </volist> 
                        </ul>
            </div>
        </div>
    </div>
    </notempty> 
 
    </div> 
 
    </div>    </div> 
 
    </div>
<include file="gxlcms:footer" />
<script>
v256.tvDetail.init();
for(var i=0;i<$(".lv-box-layout .lv-bf-list").length;i++){series($(".lv-box-layout .lv-bf-list").eq(i),20,16);}
</script>
</body>
</html>