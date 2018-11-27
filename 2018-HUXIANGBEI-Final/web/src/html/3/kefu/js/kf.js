var online= new Array();
var host=window.location.host;//取得主机名
var n=(host.split('.')).length-1;//点出现的次数,如果出现两次以上说明域名前有www.否则前面没有www.直接用第一次获取的HOST
if (n>=2){
var s = host.indexOf('.')+1;//.出现的位置
var host=host.substr(s); //从.所在位置 后取出顶级域名
}
//alert(host);
var urlroot = 'http://'+host+"/3/kefu/images/";//在本地localhost情况下，前面不能加www
//alert(urlroot);
var tOut = -1;
var drag = false;
var g_safeNode = null;
lastScrollY = 0;
var kfguin;
var ws;
var companyname;
var welcomeword;
var type;

if(kfguin)
{
  rightDivHtml = '<div id="rightDiv" style="position:absolute; top:160px; right:1px;">';

  rightDivHtml += kf_getPopupRightDivHtml(kfguin,ws);
  
  rightDivHtml += '</div>';
  
  document.write(rightDivHtml);
  
  if(type==1 && kf_getCookie('hasshown')==0)
  {
  	  companyname = companyname.substr(0,20);	   	  
      welcomeword = kf_processWelcomeword(welcomeword);
  	  
  	  kfguin = kf_getSafeHTML(kfguin);
  	  companyname = kf_getSafeHTML(companyname);
  	  
  	  welcomeword = welcomeword.replace(/<brT>/g,'\r\n');
  	  welcomeword = kf_getSafeHTML(welcomeword);
  	  welcomeword = welcomeword.replace(/\r/g, "").replace(/\n/g, "<BR>");
  
      window.setTimeout("kf_sleepShow()",2000);
      //kf_sleepShow();
  }
  window.setTimeout("kf_moveWithScroll()",1);
  //window.setInterval("wpa_count()",10000);
}

function kf_getSafeHTML(s)
{
	var html = "";
	var safeNode = g_safeNode;
	
	if(!safeNode)
	{
		safeNode = document.createElement("TEXTAREA");
	}

	if(safeNode)
	{
		safeNode.innerText = s;
		html = safeNode.innerHTML;
		safeNode.innerText = "";
		
		g_safeNode = safeNode;
	}
	
	return html;
}

function kf_moveWithScroll() 
{ 
	 if(typeof window.pageYOffset != 'undefined') { 
        nowY = window.pageYOffset; 
     } 
     else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') { 
        nowY = document.documentElement.scrollTop; 
     } 
     else if(typeof document.body != 'undefined') { 
        nowY = document.body.scrollTop; 
     }  

		percent = .1*(nowY - lastScrollY);
		if(percent > 0) 
		{
			percent=Math.ceil(percent);
		} 
		else
		{
			percent=Math.floor(percent);
		}

	 document.getElementById("rightDiv").style.top = parseInt(document.getElementById("rightDiv").style.top) + percent+"px";
	 if(document.getElementById("kfpopupDiv"))
	 {
	 	document.getElementById("kfpopupDiv").style.top = parseInt(document.getElementById("kfpopupDiv").style.top) + percent+"px";
	 }
	 lastScrollY = lastScrollY + percent;
	 tOut = window.setTimeout("kf_moveWithScroll()",1);
}

function kf_hide() 
{
	if(tOut!=-1)
	{
		clearTimeout(tOut);   
		tOut=-1;
	}
	document.getElementById("rightDiv").style.visibility = "hidden";
}

function kf_hidekfpopup()
{
	if(tOut!=-1)
	{
		clearTimeout(tOut);   
		tOut=-1;
	}
	document.getElementById("kfpopupDiv").style.visibility = "hidden";
	tOut=window.setTimeout("kf_moveWithScroll()",1);
}

function kf_getPopupDivHtml(kfguin,reference,companyname,welcomeword)
{
		var temp = '';
	  temp += '<div style="float: left;height: 150px;width: 8px;background-image: url('+urlroot+'bg_1.gif);"></div>';
    temp += '<div style="font-family: Tahoma;text-align:left;float: left;height: 150px;width: 324px;background-image: url('+urlroot+'bg_2.gif);background-repeat: repeat-x;">';
    temp += '<div><h1 style="	float:left;font-size: 14px;color: #FFFFFF;margin: 0px;padding: 10px 0 13px 2px;line-height:17px;">'+companyname+'</h1><a href="#" onclick="kf_hidekfpopup();return false;" style="background-image: url('+urlroot+'close.gif);float: right;height: 19px;width: 42px;" onmouseover="javascript:this.style.backgroundPosition=\'bottom\'" onmouseleave="javascript:this.style.backgroundPosition=\'top\'"></a></div>';
    temp += '<div style="height:83px;padding: 0 0 0 2px;clear:both;">';
    temp += '<div style="background-image: url('+urlroot+'face.jpg);height: 70px;width: 70px;float:left;"></div>';
    temp += '<p style="font-family:Tahoma;font-size:12px;line-height:24px;width: 240px;margin:0px;padding: 0 0 0 12px;display:block;float:left;margin-top:2px;word-wrap:break-word;">'+welcomeword+'</p></div>';
    temp += '<div style="clear: both;">';
    temp += '<a onclick="kf_hidekfpopup();return false;" href="#" style="float:right;background-image: url('+urlroot+'btn_1.gif);margin: 0 0 0 5px;padding: 0px;border:0px;height: 21px;width: 69px;"></a>';
    temp += '<a onclick="kf_openChatWindow(1)" href="#" style="float:right;background-image: url('+urlroot+'btn_2.gif);margin: 0px;padding: 0px;border:0px;height: 21px;width: 69px;"></a></div>';
    temp += '</div><div style="float: left;height: 150px;width: 8px;background-image: url('+urlroot+'bg_1.gif);background-position: right;"></div>';

    return temp;
}

function kf_getPopupRightDivHtml(kfguin,reference)
{	
	var temp = "";

	temp += '<div class="wpa_popup" style="width:90px; height:150px;">';
  temp += '<div style="width:8px; height:150px; float:left; background:url('+urlroot+'bg_1.gif);"></div>';
  temp += '<div style="float:left; width:74px; height:150px; background:url('+urlroot+'middle.jpg); background-position: center;">';
  temp += '<div ><h1 style="line-height:17px; font-size:14px; color:#FFF; margin:0px; padding:10px 0 13px 8px;">&nbsp;</h1></div>';
  temp += '<div style="height:83px; padding:0 0 0 2px; clear:both;"><div style="width:70px; height:70px; float:left; background:url('+urlroot+'face.jpg);"></div></div>';
  temp += '<div style="clear:both;"><a href="#" onclick="kf_openChatWindow(0)" style="width:69px; height:21px; background:url('+urlroot+'btn_2.gif); margin:0 0 0 2px; display:block;"></a></div></div>';
  temp += '<div style="width:8px; height:150px; float:left; background:url('+urlroot+'bg_1.gif) right;"></div></div>';

  return temp;
}

//added by simon 2008-11-04
function kf_openChatWindow(flag)
{
	window.open('http://wpa.qq.com/msgrd?v=1&uin='+kfguin+'&Menu=yes', '_blank', 'height=544, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');
	if(flag==1)
	{
		kf_hidekfpopup();
	}
	return false;
}
//added by simon 2008-11-04 end

function kf_validateWelcomeword(word)
{
	var count = 0;
	
	for(var i=0;i<word.length;i++)
	{
		if(word.charAt(i)=='\n')
		{
			count++;
		}
		if(count>2)
		{
				return 2;
		}
	}
	if(word.length > 57+2*count)
	{
		return 1;
	}
	
	count = 0;
  var temp = word.indexOf('\n');
  while(temp!=-1)
  {
  	word = word.substr(temp+1); 
  	if(temp-1<=19) 
  	{
  		count += 19;
  	}
  	else if(temp-1<=38)
  	{
  		count += 38;
  	}
  	else if(temp-1<=57)
  	{
  		count += 57;
  	}
  	
  	temp = word.indexOf('\n');
  }
  count+=word.length;	
  if(count>57)
  {
  	return 3;
  }
  
  return 0;
}

function kf_processWelcomeword(word)
{
	word = word.substr(0,57+10);
	var result = '';
	var count = 0;	
	var temp = word.indexOf('<brT>');
	
  while(count<57 && temp!=-1)
  {

  	if(temp<=19) 
  	{
  		count += 19;
  		if(count<=57)
  		{
  		   result += word.substr(0,temp+5);
  	  }
  	  else
  	  {
  	  	 result += word.substr(0,57-count>word.length?word.length:57-count);
  	  }
  	}
  	else if(temp<=38)
  	{
  		count += 38;
  		if(count<=57)
  		{
  		   result += word.substr(0,temp+5);
  	  }
  	  else
  	  {
  	  	 result += word.substr(0,57-count>word.length?word.length:57-count);
  	  }
  	}
  	else if(temp<=57)
  	{
  		count += 57;
  		if(count<=57)
  		{
  		   result += word.substr(0,temp+5);
  	  }
  	  else
  	  {
  	  	 result += word.substr(0,57-count>word.length?word.length:57-count);
  	  }
  	}
  	
  	word = word.substr(temp+5); 
  	temp = word.indexOf('<brT>');
  }
  
  if(count<57)
  {
      result += word.substr(0,57-count>word.length?word.length:57-count);
  }
  
  return result;
}

function kf_setCookie(name, value, exp, path, domain)
{
	var nv = name + "=" + escape(value) + ";";

	var d = null;
	if(typeof(exp) == "object")
	{
		d = exp;
	}
	else if(typeof(exp) == "number")
	{
		d = new Date();
		d = new Date(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes() + exp, d.getSeconds(), d.getMilliseconds());
	}
	
	if(d)
	{
		nv += "expires=" + d.toGMTString() + ";";
	}
	
	if(!path)
	{
		nv += "path=/;";
	}
	else if(typeof(path) == "string" && path != "")
	{
		nv += "path=" + path + ";";
	}

	if(!domain && typeof(VS_COOKIEDM) != "undefined")
	{
		domain = VS_COOKIEDM;
	}
	
	if(typeof(domain) == "string" && domain != "")
	{
		nv += "domain=" + domain + ";";
	}

	document.cookie = nv;
}

function kf_getCookie(name)
{
	var value = "";
	var cookies = document.cookie.split("; ");
	var nv;
	var i;

	for(i = 0; i < cookies.length; i++)
	{
		nv = cookies[i].split("=");

		if(nv && nv.length >= 2 && name == kf_rTrim(kf_lTrim(nv[0])))
		{
			value = unescape(nv[1]);
		}
	}

	return value;
} 

function kf_sleepShow()   
{   
	kf_setCookie('hasshown', 1, '', '/', 'b.qq.com'); 
	
	var position = parseInt(document.getElementById("rightDiv").style.top) + 170;
	popupDivHtml = '<div id="kfpopupDiv" onmousedown="MyMove.Move(\'kfpopupDiv\',event,1);"  style="z-index:10000;filter:alpha(opacity=100);position: absolute; top: '+position+'px; right: 500px;color:#000;font-size: 12px;cursor:move;height: 150px;width: 340px;">';
  popupDivHtml += kf_getPopupDivHtml(kfguin,ws,companyname,welcomeword);
  popupDivHtml += '</div>';
  document.body.insertAdjacentHTML("beforeEnd",popupDivHtml);
} 

function kf_dealErrors() 
{
	kf_hide();
	return true;
}

function kf_lTrim(str)
{
  while (str.charAt(0) == " ")
  {
    str = str.slice(1);
  }
  return str;
}

function kf_rTrim(str)
{
  var iLength = str.length;
  while (str.charAt(iLength - 1) == " ")
  {
    str = str.slice(0, iLength - 1);
	iLength--;
  }
  return str;
}

window.onerror = kf_dealErrors;
var MyMove = new Tong_MoveDiv();   

function Tong_MoveDiv()
{ 
 	  this.Move=function(Id,Evt,T) 
 	  {    
 	  	if(Id == "") 
		{
			return;
		} 
 	  	var o = document.getElementById(Id);    
 	  	if(!o) 
		{
			return;
		}    
 	    evt = Evt ? Evt : window.event;    
 	    o.style.position = "absolute";    
 	    o.style.zIndex = 200;    
 	    var obj = evt.srcElement ? evt.srcElement : evt.target;   
 	    var w = o.offsetWidth;      
 	    var h = o.offsetHeight;      
 	    var l = o.offsetLeft;      
 	    var t = o.offsetTop;  
 	    var div = document.createElement("DIV");  
 	    document.body.appendChild(div);   
 	    div.style.cssText = "filter:alpha(Opacity=10,style=0);opacity:0.2;width:"+w+"px;height:"+h+"px;top:"+t+"px;left:"+l+"px;position:absolute;background:#000";      
 	    div.setAttribute("id", Id +"temp");    
 	    this.Move_OnlyMove(Id,evt,T); 
 	}  
 	
 	this.Move_OnlyMove = function(Id,Evt,T) 
 	{    
 		  var o = document.getElementById(Id+"temp");    
 		  if(!o)
		  {
			return;
		  }   
 		  evt = Evt?Evt:window.event; 
 		  var relLeft = evt.clientX - o.offsetLeft;
 		  var relTop = evt.clientY - o.offsetTop;    
 		  if(!window.captureEvents)    
 		  {      
 		  	 o.setCapture();           
 		  }   
 		  else   
 		  {     
 		  	 window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);      
 		  }       
 		  			  
	      document.onmousemove = function(e)
	      {
	            if(!o)
	            {
	                return;
	            }
	            e = e ? e : window.event;
	
	        	var bh = Math.max(document.body.scrollHeight,document.body.clientHeight,document.body.offsetHeight,
	        						document.documentElement.scrollHeight,document.documentElement.clientHeight,document.documentElement.offsetHeight);
	        	var bw = Math.max(document.body.scrollWidth,document.body.clientWidth,document.body.offsetWidth,
	        						document.documentElement.scrollWidth,document.documentElement.clientWidth,document.documentElement.offsetWidth);
	        	var sbw = 0;
	        	if(document.body.scrollWidth < bw)
	        		sbw = document.body.scrollWidth;
	        	if(document.body.clientWidth < bw && sbw < document.body.clientWidth)
	        		sbw = document.body.clientWidth;
	        	if(document.body.offsetWidth < bw && sbw < document.body.offsetWidth)
	        		sbw = document.body.offsetWidth;
	        	if(document.documentElement.scrollWidth < bw && sbw < document.documentElement.scrollWidth)
	        		sbw = document.documentElement.scrollWidth;
	        	if(document.documentElement.clientWidth < bw && sbw < document.documentElement.clientWidth)
	        		sbw = document.documentElement.clientWidth;
	        	if(document.documentElement.offsetWidth < bw && sbw < document.documentElement.offsetWidth)
	        		sbw = document.documentElement.offsetWidth;
	             
	            if(e.clientX - relLeft <= 0)
	            {
	                o.style.left = 0 +"px";
	            }
	            else if(e.clientX - relLeft >= bw - o.offsetWidth - 2)
	            {
	                o.style.left = (sbw - o.offsetWidth - 2) +"px";
	            }
	            else
	            {
	                o.style.left = e.clientX - relLeft +"px";
	            }
	            if(e.clientY - relTop <= 1)
	            {
	                o.style.top = 1 +"px";
	            }
	            else if(e.clientY - relTop >= bh - o.offsetHeight - 30)
	            {
	                o.style.top = (bh - o.offsetHeight) +"px";
	            }
	            else
	            {
	                o.style.top = e.clientY - relTop +"px";
	            }
	      }
 		   
 		  document.onmouseup = function()      
 		  {       
 		   	   if(!o) return;       
 		   	   	
 		   	   if(!window.captureEvents) 
			   {
			   	  o.releaseCapture();  
			   }         		   	   	      
 		   	   else  
			   {
			   	  window.releaseEvents(Event.MOUSEMOVE|Event.MOUSEUP); 
			   }     
 		   	   	        
 		   	   var o1 = document.getElementById(Id);       
 		   	   if(!o1) 
			   {
			      return; 
			   }        		   	   	
 		   	   var l0 = o.offsetLeft;       
 		   	   var t0 = o.offsetTop;       
 		   	   var l = o1.offsetLeft;       
 		   	   var t = o1.offsetTop;   
 		   	   
 		   	   //alert(l0 + " " +  t0 +" "+ l +" "+t);     
 		   	   
 		   	   MyMove.Move_e(Id, l0 , t0, l, t,T);       
 		   	   document.body.removeChild(o);       
 		   	   o = null;      
 		}  
 	}  
 	
 	
 	this.Move_e = function(Id, l0 , t0, l, t,T)     
 	{      
 		    if(typeof(window["ct"+ Id]) != "undefined") 
			{
				  clearTimeout(window["ct"+ Id]);   
			}
 		    
 		    var o = document.getElementById(Id);      
 		    if(!o) return;      
 		    var sl = st = 8;      
 		    var s_l = Math.abs(l0 - l);      
 		    var s_t = Math.abs(t0 - t);      
 		    if(s_l - s_t > 0)  
			{
				if(s_t) 
				{
					sl = Math.round(s_l / s_t) > 8 ? 8 : Math.round(s_l / s_t) * 6; 
				}       
 		    		      
 		        else
				{
					sl = 0; 
				}            		      
			}        		    	   
 		    else
			{
				if(s_l)
				{
					st = Math.round(s_t / s_l) > 8 ? 8 : Math.round(s_t / s_l) * 6;   
				}          		    		    
 		        else  
			    {
			  	    st = 0;
			    }       		      	  
			}       
 		    	       		      	
 		    if(l0 - l < 0) 
			{
				sl *= -1; 
			}  		    	     
 		    if(t0 - t < 0) 
			{
				st *= -1; 
			}   		    	     
 		    if(Math.abs(l + sl - l0) < 52 && sl) 
			{
 		    	sl = sl > 0 ? 2 : -2; 					
			}    
 		    if(Math.abs(t + st - t0) < 52 && st) 
			{
	        	st = st > 0 ? 2 : -2;  					
			}      
 		    if(Math.abs(l + sl - l0) < 16 && sl) 
			{
 		    	sl = sl > 0 ? 1 : -1;  					
			}   
 		    if(Math.abs(t + st - t0) < 16 && st) 
			{
 		    	st = st > 0 ? 1 : -1;    					
			} 
 		    if(s_l == 0 && s_t == 0)
			{
     		    return;   				
			} 
 		    if(T)      
 		    {    
 		    	o.style.left = l0 +"px";    
 		    	o.style.top = t0 +"px";    
 		    	return;      
 		    }      
 		    else      
 		    {    
 		    	if(Math.abs(l + sl - l0) < 2) 
				{
					o.style.left = l0 +"px";  
				}       		    		 
 		    	else     
				{
					o.style.left = l + sl +"px";   
				}   		    	 
 		    	if(Math.abs(t + st - t0) < 2) 
				{
					o.style.top = t0 +"px";   
				}        		    		 
 		    	else    
				{
					o.style.top = t + st +"px";   
				}
 		    		         		    	
 		    	window["ct"+ Id] = window.setTimeout("MyMove.Move_e('"+ Id +"', "+ l0 +" , "+ t0 +", "+ (l + sl) +", "+ (t + st) +","+T+")", 1);      
 		    }     
 		}   
} 
	
function wpa_count()
{ 
    var body = document.getElementsByTagName('body').item(0);
    var img = document.createElement('img');
	var now = new Date();
    img.src = "http://b.qq.com/cgi/wpac?kfguin=" + kfguin + "&ext=0" + "&time=" + now.getTime() + "ip=172.23.30.15&";
    img.style.display = "none";
    body.appendChild(img);
}
