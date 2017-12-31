<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>2016最新更新的100个电视剧、电影、动漫、综艺节目 - {$sitename}</title>
<meta name="keywords" content="<notempty name="list_keywords">{$list_keywords}<else/>最新{$list_name},{$keywords}</notempty>">
<meta name="description" content="<notempty name="list_description">{$list_description}<else/>{$description}</notempty>">
<include file="gxlcms:include" />
    </head>
    <body>
   <include file="gxlcms:header" />
    <div class="content-box fn-clear">
            <!--面包屑开始-->
        <div class="crumbs">
           <span class="fn-left">您所在的位置：</span>
           <div class="crumbs-all fn-left">
       <a href="{$root}" class="blue">{$sitename}</a> <span>&gt;</span>
                 <a href="javascript:;" class="active-style11">最近更新</a>
           </div>
         </div><!--crumbs-->
 </div>
    <div class="content-box fn-clear"> 
  <div class="new_nav">
  <h1>最近100个更新</h1>
  <div class="lasted-time fn-right">更新时间</div>

   <div class="lasted-type fn-right">分类</div>
  </div> 
  <div class="new_list">
  <ul>
 <php>$ting_hot_tv = gxl_sql_ting('field:ting_id,ting_name,ting_cid,ting_pic,ting_content,ting_anchor,ting_title,ting_color,ting_addtime;limit:100;order:ting_addtime desc'); </php>
<fflist name="ting_hot_tv" id="gxlting">   
<li>
<div class="lasted-title fn-left"><span>∷</span><a href="{$gxlting.ting_readurl}" title="{$gxlting.ting_name}" target="_blank">{$gxlting.ting_name}<i>
<notempty name="gxlting.ting_title">{$gxlting.ting_title}<else/>{$gxlting.ting_continu}</notempty></i></a>
</div>
<div class="lasted-type fn-right">{$gxlting.ting_addtime|gettimenew='Y-m-d H:i:s',###}</div>

<div class="lasted-time fn-right"><a href="{$gxlting.list_url}" title="{$gxlting.list_name}" target="_blank">{$gxlting.list_name}</a></div>
</li>
</fflist>
</ul> 
  
  </div> 
 </div> 
<include file="gxlcms:footer" />
</body>
</html>