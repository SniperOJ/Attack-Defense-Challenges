var mbstr='<style type="text/css">' +
'<!--' +
'.msgbox_title{background-color:#b4cceb;color:#333333;height:30px;position:relative;font-size:14px;line-height:30px;padding-left:10px;}' +
'.msgbox_close{float:right;text-align:center;}' +
'.msgbox_close a{color:#FFF;font-weight:bold;text-decoration:none;background-color:#CC0000;line-height:30px;height:30px;font-size:16px;padding:0 5px}' +
'.msgbox_close a:hover{background-color:#FF0000}' +
'.msgbox_content{float:left;background:#FFF;}' +
'.msgbox_mask{position:absolute;left:0px;top:0px;z-index:99999;background-color:#333333;width:100%;height:100%}' +
'.msgbox{position:fixed;height:auto;top:50%;left:50%;border:solid 5px #dddddd;}' +
'-->' +
'</style>' +
'<div id="msgBoxMask" class="msgbox_mask" style="filter:alpha(opacity=5);display:none;"></div>' +
'<div class="msgbox" style="display:none; z-index:100000;" id="msgBox">' +
'<div class="msgbox_title" id="msgBoxTitle"></div>' +
'<div class="msgbox_content" id="msgBoxContent"></div>' +
'</div>'
var Timer = null;
document.write(mbstr);
function MsgBox(tt,url,wd,ht,tp){
	var Control = "<div class=\"msgbox_close\"><a href=\"javascript:CloseMsg();\" title=\"关闭\">×</a></div>";
	var Control2 = "<div class=\"msgbox_close\"><a href=\"index.htm\" title=\"返回首页\"><<</a></div>";
	var titleHeight= 30//标题高度
	var Frame = "<iframe name=\"MsgFrame\" src=\""+url+"\" scrolling=\"no\" style=\"width:"+(wd)+"px;height:"+(ht-titleHeight)+"px;\" frameborder=\"0\" hspace=\"0\"></iframe>";//ht-titleHeight即高度=总高度-标题高度
	//解决　FF 下会复位
	ScrollTop = GetBrowserDocument().scrollTop;
	ScrollLeft = GetBrowserDocument().scrollLeft;
	//GetBrowserDocument().style.overflow = "hidden";//无滚动条
	GetBrowserDocument().scrollTop = ScrollTop;
	GetBrowserDocument().scrollLeft = ScrollLeft;
	if (tp==1){
		document.getElementById("msgBoxTitle").innerHTML = Control + tt;
	}
	else{
		document.getElementById("msgBoxTitle").innerHTML = Control2 + tt;
	}
	document.getElementById("msgBoxContent").innerHTML = Frame;
	OpacityValue = 0;
	document.getElementById("msgBox").style.display = "";
	try{document.getElementById("msgBoxMask").filters("alpha").opacity = 0;}catch(e){};
	document.getElementById("msgBoxMask").style.opacity = 0;
	document.getElementById("msgBoxMask").style.display = "";
	document.getElementById("msgBoxMask").style.height = GetBrowserDocument().scrollHeight + "px";//不加值达不到全屏高度
	document.getElementById("msgBoxMask").style.width = GetBrowserDocument().scrollWidth + "px";
	Timer = setInterval("DoAlpha()",1);
	//设置位置
	document.getElementById("msgBox").style.width = wd + "px";
	document.getElementById("msgBox").style.height = ht + "px";
	document.getElementById("msgBox").style.marginTop = (-document.getElementById("msgBox").offsetHeight/2 + GetBrowserDocument().scrollTop) + "px";
	document.getElementById("msgBox").style.marginLeft = (-document.getElementById("msgBox").offsetWidth/2 + GetBrowserDocument().scrollLeft) + "px";
	//$("msgBox").style.width = ($("msgBoxIcon").offsetWidth + $("msgBoxContent").offsetWidth + 2) + "px";
}

function CloseMsg(){
	document.getElementById("msgBox").style.display = "none";
	document.getElementById("msgBoxMask").style.display = "none";
	//GetBrowserDocument().style.overflow = "";
	//GetBrowserDocument().scrollTop = ScrollTop;
	//GetBrowserDocument().scrollLeft = ScrollLeft;
}
var OpacityValue = 0;
var ScrollTop = 0;
var ScrollLeft = 0;
function GetBrowserDocument(){
	var _dcw = document.documentElement.clientHeight;
	var _dow = document.documentElement.offsetHeight;
	var _bcw = document.body.clientHeight;
	var _bow = document.body.offsetHeight;
	if(_dcw == 0) return document.body;
	if(_dcw == _dow) return document.documentElement;
	if(_bcw == _bow && _dcw != 0)
		return document.documentElement;
	else
		return document.body;
}
function SetOpacity(obj,opacity){
	if(opacity >=1 ) opacity = opacity / 100;
	try{obj.style.opacity = opacity; }catch(e){}
	try{
		if(obj.filters){
			obj.filters("alpha").opacity = opacity * 100;
		}
	}catch(e){}
}
function DoAlpha(){
	if (OpacityValue > 50){
		clearInterval(Timer);
		return 0;
	}
	OpacityValue += 30;
	SetOpacity(document.getElementById("msgBoxMask"),OpacityValue);
}
String.prototype.toFormatString = function(){
	var _str = this;
	for(var i = 0; i < arguments.length; i++){
		_str = eval("_str.replace(/\\{"+ i +"\\}/ig,'" + arguments[i] + "')");
	}
	return _str;
}
function $(obj){
	return document.getElementById(obj);
}
//window.onresize=function(){
//	$("msgBoxMask").style.height = GetBrowserDocument().scrollHeight + "px";
//	$("msgBoxMask").style.width = GetBrowserDocument().scrollWidth + "px";
//}
if (window.attachEvent){
	window.attachEvent("onresize", _resize);
}
else if (window.addEventListener){
	window.addEventListener("resize", _resize, false);
}              
function _resize(){
	document.getElementById("msgBoxMask").style.height = GetBrowserDocument().scrollHeight + "px";
	document.getElementById("msgBoxMask").style.width = GetBrowserDocument().scrollWidth + "px"; 
}  