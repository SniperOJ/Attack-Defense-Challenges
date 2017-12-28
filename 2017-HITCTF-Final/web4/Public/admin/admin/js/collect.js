function insertText(id, text)
{
	$('#'+id).focus();
    var str = document.selection.createRange();
	str.text = text;
}


function show_url_type(obj) {
	var num = 4;
	for (var i=1; i<=num; i++){
		if (obj==i){ 
			$('#url_type_'+i).show();
		} else {
			$('#url_type_'+i).hide();
		}
	}
}




//obj=document.getElementById('data[field]');


function show_switch(obj,id,value) {
  if(value=='show'){
	  if (obj.checked == true) {	
			$('#'+id).show();
		} else {
			$('#'+id).hide();
	  }
  }else  if(value=='hide'){
		  if (obj.checked == true) {	
				$('#'+id).hide();
			} else {
				$('#'+id).show();
		  }
  }
}


function show_div(id) {
	for (var i=1;i<=4;i++) {
		if (id==i) {
			$('#tab_'+i).addClass('on');
			$('#set_'+i).addClass('now');
			$('#show_div_'+i).show();
		} else {
			$('#tab_'+i).removeClass('on');
 
			$('#set_'+i).removeClass('now');
			$('#show_div_'+i).hide();
		}
	}
}


function show_url() {
	var type = $("input[type='radio'][name='data[sourcetype]']:checked").val();
	//var url=encodeURIComponent($('#urlpage_'+type).val());
	var url=$('#urlpage_'+type).val();
	url=encodeURIComponent(url.replace(/\//g,'@'));
	art.dialog({id:'test_url',iframe:'?s=Admin-Customcollect-TestUrl-sourcetype-'+type+'-urlpage-'+url+'-pagesize_start-'+$("input[name='data[pagesize_start]']").val()+'-pagesize_end-'+$("input[name='data[pagesize_end]']").val()+'-par_num-'+$("input[name='data[par_num]']").val(), title:'测试地址', width:'600', height:'450'}, '', function(){art.dialog({id:'test_url'}).close()});
			
}



function col_test() {
 
	var type = $("input[type='radio'][name='data[sourcetype]']:checked").val();
	//var url=encodeURIComponent($('#urlpage_'+type).val());
	var url=$('#urlpage_'+type).val();
	url=encodeURIComponent(url.replace(/\//g,'@'));
	art.dialog({id:'test_url',iframe:'?s=Admin-Customcollect-TestUrl-sourcetype-'+type+'-urlpage-'+url+'-pagesize_start-'+$("input[name='data[pagesize_start]']").val()+'-pagesize_end-'+$("input[name='data[pagesize_end]']").val()+'-par_num-'+$("input[name='data[par_num]']").val(), title:'测试地址', width:'600', height:'450'}, '', function(){art.dialog({id:'test_url'}).close()});
			
}


function selectall(value) {
	$("input[name='filter']").each(function(i,n){
		if (this.checked) {
			this.checked = false;
		} else {
			this.checked = true;
		}});
}

function show_nextpage(value) {
	if (value == 2) {
		$('#nextpage').show();
	} else {
		$('#nextpage').hide();
	}
}

var i =0;
function add_customize() {
	var html = '<tbody id="customize_config_'+i+'"><tr style="background-color:#FBFFE4"><td>规则名：</td><td><input type="text" name="customize_config[name][]" class="input-text" /></td><td>规则英文名：</td><td><input type="text" name="customize_config[en_name][]" class="input-text" /></td></tr><tr><td width="120">匹配规则：</td><td><textarea rows="5" cols="40" name="customize_config[rule][]" id="rule_'+i+'"></textarea> <br>使用"<a href="javascript:insertText(\'rule_'+i+'\', \'[内容]\')">[内容]</a>"作为通配符</td><td width="120">过滤选项：</td><td><textarea rows="5" cols="50" name="customize_config[filter][]" id="content_filter_'+i+'"></textarea><input type="button" value="选择" class="button"  onclick="html_role(\'content_filter_'+i+'\', 1)"></td></tr></tbody>';
	$('#customize_config').append(html);
	i++;
}



