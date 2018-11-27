// JavaScript Document
function showsubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none"){
eval("submenu" + sid + ".style.display=\"\";");
}
}
function hidesubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == ""){
eval("submenu" + sid + ".style.display=\"none\";");
}
}

function CheckForms(){
	if (document.ly.contents.value==""){	
	document.ly.contents.style.border = '1px solid #FA8072';
	window.document.getElementById('ts_contents').innerHTML='<span class=boxuserreg>留言内容不能为空</span>';
	document.ly.contents.focus();	
	return false;
	}
	if (document.ly.contents2.value=="no"){	
	document.ly.contents.style.border = '1px solid #FF0000';
	return false;
	}
	if (document.ly.name.value==""){	
	document.ly.name.style.border = '1px solid #FA8072';
	window.document.getElementById('ts_name').innerHTML='<span class=boxuserreg>请输入姓名</span>';
	document.ly.name.focus();	
	return false;
	}
	if (document.ly.name2.value=="no"){	
	document.ly.name.style.border = '1px solid #FF0000';
	return false;
	}
					
	if (document.ly.tel.value==""){	
	document.ly.tel.style.border = '1px solid #FF0000';
	window.document.getElementById('ts_tel').innerHTML='<span class=boxuserreg>请输入手机</span>';
	document.ly.tel.focus();	
	return false;
	}
	if (document.ly.tel2.value=="no"){	
	document.ly.tel.style.border = '1px solid #FF0000';
	return false;
	}
	
	//email非强制输入，可以为空
	if (document.ly.email2.value=="no"){	
	document.ly.email.style.border = '1px solid #FF0000';
	return false;
	}
	
	if (document.ly.yzm.value==""){
	document.ly.yzm.style.border = '1px solid #FF0000';
	window.document.getElementById('ts_yzm').innerHTML='<span class=boxuserreg><span class=error></span>请输入验证码</span>';
	document.ly.yzm.focus();	
	return false;
	}
	if (document.ly.yzm2.value=="no"){	
	document.ly.yzm.style.border = '1px solid #FF0000';
	return false;
	}
	document.getElementById("tj").disabled=true; 
	document.getElementById("tj").value ="正在提交中，请稍候...";
}

function check_contents(){
	if (document.ly.contents.value ==""){
	window.document.getElementById('ts_contents').innerHTML='<span class=boxuserreg>留言内容不能为空</span>';
    window.document.ly.contents2.value='no';
	}else{
	window.document.getElementById('ts_contents').innerHTML='';
	window.document.ly.contents2.value='yes';
	window.document.ly.contents.style.border = '1px solid #dddddd';
	}
}

function check_mobile(){ 
if (document.ly.tel.value ==""){	
	document.getElementById('ts_tel').innerHTML='<span class=boxuserreg>请输入手机</span>';
    document.ly.tel2.value='no';
}else{
	var phone = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
	if(!phone.test(document.ly.tel.value)){
	window.document.getElementById('ts_tel').innerHTML='<span class=boxuserreg>手机号码不正确</span>';
    window.document.ly.tel2.value='no';
	}else{
	window.document.getElementById('ts_tel').innerHTML='<img src=/image/dui2.png>';
	window.document.ly.tel2.value='yes';
	window.document.ly.tel.style.border = '1px solid #dddddd';
	}
} 
} 
function check_somane(){
if (document.ly.name.value ==""){	
	document.getElementById('ts_name').innerHTML='<span class=boxuserreg>请输入姓名</span>';
    document.ly.name2.value='no';
}else{
    var re=/^[\u4e00-\u9fa5]{2,10}$/; //只输入汉字的正则
    if(document.ly.name.value.search(re)==-1){
	window.document.getElementById('ts_name').innerHTML='<span class=boxuserreg>联系人只能为汉字，字符介于2到10个。</span>';
    window.document.ly.name2.value='no';
	}else{
	window.document.getElementById('ts_name').innerHTML='<img src=/image/dui2.png>';
	window.document.ly.name2.value='yes';
	window.document.ly.name.style.border = '1px solid #dddddd';
	}
}
}

function check_email(){
var email=document.ly.email.value;
email=email.replace(/[ ]/g,"");//去空格用 
if (email ==""){
window.document.getElementById('ts_email').innerHTML='';//当不输入内容时清空提示
}else{
//var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
var reg = /^[-._A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
	if(!reg.test(email)){
	window.document.getElementById('ts_email').innerHTML='<span class=boxuserreg>E_mail格式不正确</span>';
    window.document.ly.email2.value='no';	
	}else{
	window.document.getElementById('ts_email').innerHTML='<img src=/image/dui2.png>';
	window.document.ly.email2.value='yes';
	window.document.ly.email.style.border = '1px solid #dddddd';
	}
}
}

function check_yzm(){
if (document.ly.yzm.value !=""){
   var re=/^([0-9]+)$/; //只输入数字
    	if(document.ly.yzm.value.search(re)==-1){
		window.document.getElementById('ts_yzm').innerHTML='<span class=boxuserreg>验证码答案只能为数字</span>';
		window.document.ly.yzm2.value='no';
		}else{
		window.document.getElementById('ts_yzm').innerHTML='';
		window.document.ly.yzm2.value='yes';
		window.document.ly.yzm.style.border = '1px solid #dddddd';
		}
}
}

function showinfo(names,n){
	var chList=document.getElementsByName("ch"+names);
	var TextArea=document.getElementById("contents");
	if(chList[n-1].checked){ //数组从0开始
		var temp= TextArea.value; 
		TextArea.value = temp.replace(document.getElementById(names+n).innerHTML,"");
		TextArea.value+= document.getElementById(names+n).innerHTML;
	}else{
		var temp= TextArea.value; 
		TextArea.value = temp.replace(document.getElementById(names+n).innerHTML,"");
	}
}

function CheckAllProvince(form){
  for (var i=0;i<40;i++)//表单内有其它原素
    {
    var e = form.elements[i];
    if (e.Name != "chkAll" )
       e.checked = form.chkAll.checked;
    }
}
function resizeimg(maxWidth,maxHeight,objImg){
var img = new Image();
img.src = objImg.src;
var hRatio;
var wRatio;
var Ratio = 1;
var w = img.width;
var h = img.height;
wRatio = maxWidth / w;
hRatio = maxHeight / h;
if (maxWidth ==0 && maxHeight==0){
Ratio = 1;
}else if (maxWidth==0){//
if (hRatio<1) Ratio = hRatio;
}else if (maxHeight==0){
if (wRatio<1) Ratio = wRatio;
}else if (wRatio<1 || hRatio<1){
Ratio = (wRatio<=hRatio?wRatio:hRatio);
}
if (Ratio<1){
w = w * Ratio;
h = h * Ratio;
}
objImg.height = h;
objImg.width = w;
}	 