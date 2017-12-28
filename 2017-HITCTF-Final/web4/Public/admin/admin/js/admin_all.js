$(document).ready(function(){
	//Tabs切换
	$("#tabs>a").click(function(){
		$("#tabs>a").removeClass("on");
		$(this).addClass("on");
		$arr = $(this).attr("name").split(',');
		for(var i=0;i<=$arr[1];i++){
			$('#showtab_'+i).hide();
		}
		$('#showtab_'+$arr[0]).show();
	});
	//全反选
	$("#checkall").click(function(){
		$("input[name='ids[]']").each(function(){
			if(this.checked == false)
				this.checked = true;
			else
			   this.checked = false;
		});
	});
	//批量移动
	$("#changecid").click(function(){
		$('#changeciddiv').show();
	});
	//批量生成
	$("#createhtml").click(function(){
		$model = $("#createhtml").attr('name');
		var $check = $("input:checked"); 
		var $html_id;
		$check.each(function($i){
			if($i == 0){
				$html_id = $(this).val();
			}else{
				$html_id += ','+$(this).val();
			}
		});
		if($html_id){
			var htm = '<iframe src="?s=Admin/Html/'+$model+'/ids/'+$html_id+'" width="100%" height="90%" frameborder="0" scrolling="auto"></iframe>';
			$("#dialog>#dia_title>span").html('生成静态网页');
			$("#dialog>#dia_content").html(htm);
			$("#dialog").jqmShow(); 
		}else{
			alert('请选择需要批量生成的数据!');
		}
	});
});
//分页跳转
function jumpurl($url,$total){
	$page = $('#page').val();
	if ($page>0 && ($page<=$total)){
		$url = $url.replace('{!page!}',$page);
		location.href = $url;
	}
	return false;
}
//pop弹出层：ajax请求 - 弹出评论详细信息
function dialogPop(strPath,Msg){
	var htm = '<iframe src="'+strPath+'" width="100%" height="90%" frameborder="0" scrolling="auto" style="overflow-x:hidden;"></iframe>';
	$("#dialog>#dia_title>span").html(Msg);
	$("#dialog>#dia_content").html(htm);
	$("#dialog").jqmShow();
}