function openwindow(pageurl,iWidth,iHeight){
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open (pageurl,"","height="+iHeight+",width="+iWidth+",left="+iLeft+",top="+iTop+",toolbar =no,menubar=no,scrollbars=no,resizable=no, location=no,status=no");
}
function setbgcolor(obj){
	var objChildCheck = document.all ? obj.children[0].children[0] : obj.childNodes[1].childNodes[1];
	if(objChildCheck.checked){
	obj.style.backgroundColor = '#E6E6E6';
	}	
	else{
	obj.style.backgroundColor = '';
	}
	return true;
}

function anyCheck(form,aa){//form没有启用
	var checks = document.getElementsByName("id[]");
	n = 0;
	for(i=0;i<checks.length;i++){
		if(checks[i].checked)
			n++;
	}
	if(aa=='duibi') {
	if (n<2){
	alert("至少选择 2 项才能进行比较");
	return false;
	}
	}
	if(aa=='xuanzhe') {
	if (n>5){
	alert("最多只能选择 5 项")
	return false; 
	} 
	}
}
 
function showfilter(obj2) {
	if (obj2.style.visibility == "visible") {
        obj2.style.visibility = "hidden";
    }else {
		//obj2.filters[0].apply();//只有IE支持，其它浏览器下加上后不能显示出图片
        obj2.style.visibility = "visible";
		//obj2.filters[0].play();
    }   
}
 
function showfilter2(obj2) {
	if (obj2.style.display=="block") {
        obj2.style.display="none";
    }else {
        obj2.style.display="block";
    }   
}
function doClick(o,items,currentstyle){
	o.className=currentstyle;
	var j,id,e;
	var item_num = document.getElementById(items).getElementsByTagName("li").length;//获得LI的个数
	//alert(item_num);
	if (item_num==0){
		var item_num = document.getElementById(items).getElementsByTagName("td").length;//获得td的个数
		}
	for(var i=1;i<=item_num;i++){
	id =items+i;
	j = document.getElementById(id);
	e = document.getElementById(items+"_con"+i);
		if(id != o.id){
		j.className="";
		e.style.display = "none";
		}else{
		e.style.display = "block";
		}
	 }
}
function CheckUserForm(){
	if(document.UserLogin.username.value==""){
	alert("请输入用户名！");
	document.UserLogin.username.focus();
	return false;
	}
	if(document.UserLogin.password.value == ""){
	alert("请输入密码！");
	document.UserLogin.password.focus();
	return false;
	}
	/*if(document.UserLogin.codestr.value == ""){
		alert("请输验证码！");
		document.UserLogin.codestr.focus();
		return false;
	}*/
}
function checkpage(){
//创建正则表达式
var re=/^[0-9]*$/;		
	if(document.formpage.page.value==""){
		alert("请输入页码！");
		document.formpage.page.focus();
		return false;
	}
	if(document.formpage.page.value.search(re)==-1)  {
    alert("请输入有效页码！");
	document.formpage.page.value="";
	document.formpage.page.focus();
	return false;
  	}
}	
function PSetBg(obj){
	obj.style.backgroundColor = '#FFFFFF';
}
function PReBg(obj){	
	obj.style.backgroundColor = '';
}

function CheckAll(form){
  for (var i=0;i<form.elements.length;i++)//elements
    {
    var e = form.elements[i];
    if (e.Name != "chkAll")
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

function AddContentFromDiv(obj1,obj2){
document.getElementById(obj1).value=document.getElementById(obj2).innerHTML;
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
                "SymbianOS", "Windows Phone",
                "iPad", "iPod"];
   
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
			document.cookie="agent="+Agents[v];
			if(Agents[v]!='iPad'){//如果不是iPad才转，是的话，就不用转了，直接显示index.htm就行了
            location.href='/index.php';
			}
            break;
        }
    }
}
//var width = window.screen.width; 页面宽度
//document.cookie="screen="+width;
// 加入收藏 兼容360和IE6 
function shoucang(sURL,sTitle) { 
try { window.external.addFavorite(sURL, sTitle); } 
catch (e) { 
try { window.sidebar.addPanel(sTitle, sURL, ""); } 
catch (e) { 
alert("加入收藏失败，请使用Ctrl+D进行添加"); } 
} 
} 

function delCookie(name) {
    var date=new Date();
    date.setTime(date.getTime()-10000);
    document.cookie=name+"=; expire="+date.toGMTString()+"; path=/";//要加上 path=/否则清不掉的
}