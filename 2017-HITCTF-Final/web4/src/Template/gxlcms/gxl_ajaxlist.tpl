 	<php>    
	if($_GET[order])
    $s_order=$_GET[order]." DESC";
    else
    $s_order="addtime desc";  
$ting_list=gxl_sql_ting('cid:'.$list_id.';letter:'.$_GET[letter].';field:ting_id,ting_cid,ting_name,ting_pic,ting_gold,ting_title,ting_addtime,ting_content;limit:30;page:true;order:ting_'.$s_order.';');$page = $ting_list[0]['page'];$pagetop = $ting_list[0]['pagetop'];$pagetop = $ting_list[0]['pagetop'];$prev = $ting_list[0]['prev'];$next = $ting_list[0]['next'];$totalpages = $ting_list[0]['totalpages'];$currentpage = $ting_list[0]['currentpage'];$prevcount = $ting_list[0]['prevcont'];$nextcount = $ting_list[0]['nextcont'];
	</php> 
                         <div class="fch3 fr">
                           全部共有 <span class="fch2-num-span" id="counts">{$ting_list.0.counts}</span> 部
                         </div>
          </div>
          
                     <div id="J-type-con">
            <div class="box-b2-l6 fn-clear" style="display: block">
                <ul class="fn-clear" id="contents">
                <notempty name="ting_list">
                 <volist name="ting_list" id="gxlting">
                    <li><a href="{$gxlting.ting_readurl}" target="_blank" title="{$gxlting.ting_name}" class="l6"><img class="loading" src="{$gxlting.ting_picurl}"  alt="{$gxlting.ting_name}"/><i class="box-img-bg"></i>                            
                                <i class="box-img-txt"><notempty name="gxlting.ting_continu">第<php>echo preg_replace('/\D/s', '', $gxlting['ting_continu']);</php>集<else />{$gxlting.ting_title}</notempty></i><i class="bg"></i><em class="icon-play"></em></a>
                            <div class="box-b2-dub">
                                <div class="box-b2-nt box-b2-w">
                                    <p class="box-b2-n"><a href="{$gxlting.ting_readurl}" target="_blank" title="{$gxlting.ting_name}">{$gxlting.ting_name}</a></p>
                                    <p class="box-b2-t">{$gxlting.ting_actor|msubstr=0,12,'...'}</p>
                                </div>
                                <span class="box-b2-score">{$gxlting.ting_gold}分</span>
                            </div>
                        </li>
                        </volist>
                         <else /><div class="kong">抱歉，没有找到相关作品！</div></notempty> 
                          </ul>           
                <div class="uipages page-layout mt30 clear" id="long-page">{:preg_replace(array('/<em class="prev".*?em>/','/<strong>.*?strong>/','/下一页/','/上一页/'),array('','','下一页&raquo;','&laquo;上一页'),$page)}</div>
            </div>