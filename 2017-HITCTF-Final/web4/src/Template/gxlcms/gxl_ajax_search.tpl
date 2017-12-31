<ul class="serach-ul">
<volist name="ting_list" id="ppting">
   <li>
<a class="list-img" href="{$ppting.ting_readurl}" title="{$ppting.ting_name}"><img  class="scrollLoading" src="{$ppting.ting_picurl}" />
<label class="title">{$ppting.ting_title}</label></if></a>
<div class="info">
<h2><a target="_blank" href="{$ppting.ting_readurl}">{$ppting.ting_name|get_hilight_ex=$search_wd,'font','#f06000'}</a></h2> 
<p class="anchor"><em>作者:</em>{$ppting.ting_author}</p>
<p class="anchor clearfix"><em>主播:</em><notempty name="ppting.ting_anchor">{$ppting.ting_anchor}<else /><span>未知</span></notempty></p>


<p class="plot"><em>介绍:</em>{$ppting.ting_content|msubstr=0,100,'...'}</p>
</div>

</li>
 </volist>
</ul>