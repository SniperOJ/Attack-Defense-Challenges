

function FocusImg(bigDiv,smallDiv,titleDiv,imgW,imgH,imgList,sTime,introDiv)
{
	var $=function (obj){return document.getElementById(obj);}
	this.bigDiv=bigDiv;this.smallDiv=smallDiv,this.imgW=imgW;this.imgH=imgH;
	this.imgList=[];
	this.sTime=sTime;
	this.titleDiv=titleDiv;
	this.introDiv=introDiv;
	var scrollDiv;
	var smallImgList=[];
	var imgHeight,_bigDiv;
	var timer,autoTimer;
	var ctitle;
	var t=this;
	var cintro;
	this.curId=0;
	var smallPicArr=[];
	var mypic=document.createElement("img");
	var mypicLink=document.createElement("a");
	this.init=function()//初始化
	{						
		mypic.width=this.imgW;
		mypic.height=this.imgH;
		imgHeight=this.imgH;
		_bigDiv=this.bigDiv;
		_titleDiv=this.titleDiv;
		_introDiv=this.introDiv;
		_imgList=this.imgList;
		scrollDiv=document.createElement("div");
		mypicLink.target="_blank";
		mypicLink.appendChild(mypic);
		scrollDiv.appendChild(mypicLink);
 
		for ( var i = 0; i < this.imgList.length ; i++ )
		{
 
			//创建小图区域
			var slspan=document.createElement("div");
			slspan.className="small_div";
			var slimglink=document.createElement("a");
			slimglink.target="_blank";
			slimglink.href=this.imgList[i].url;
			var slimg=document.createElement("img");
			slimg.src=this.imgList[i].bigimg;
			slimglink.appendChild(slimg);
			slimglink.innerHTML += this.imgList[i].intro;
			slspan.appendChild(slimglink);
			smallPicArr.push(slspan);
			(function(){
				var itemid=i;				
				slspan.onmouseover=function()
				{
					t.doPic(itemid);
					t.curId=itemid;
					clearInterval(autoTimer);
					t.autoPlay();
				}
 
			})();
			$(this.smallDiv).appendChild(slspan);
 
		}
		$(this.bigDiv).style.width=this.imgW+"px";
		$(this.bigDiv).style.height=this.imgH+"px";
		$(this.bigDiv).style.overflow="hidden";
		$(this.bigDiv).appendChild(scrollDiv);
		this.doPic(0);
 
	};
	this.doPic=function(id)
	{		
		try{clearTimeout(timer)}catch(e){};
		$(this.titleDiv).innerHTML=this.imgList[id].title;
		if ($(this.introDiv) && this.imgList[id].intro)
			$(this.introDiv).innerHTML=this.imgList[id].intro ;
		else if($(this.introDiv) || (!this.imgList[id].intro))
			$(this.introDiv).innerHTML="";
		//animate($(this.bigDiv).scrollTop,id * imgHeight);
		mypicLink.href=this.imgList[id].url;
		if (document.all)
		{
			mypic.filters.revealTrans.Transition=23;
			mypic.filters.revealTrans.apply();
			mypic.filters.revealTrans.play();
		}
		mypic.src=this.imgList[id].bigimg;
		//小图区域特效
		for (i = 0; i < smallPicArr.length ; i++ )
		{
			smallPicArr[i].className = smallPicArr[i].className.replace("selected" , "");
		}
		smallPicArr[id].className += " selected";
	}
	this.autoPlay=function()
	{
		autoTimer=setInterval(function(){
			t.curId++;
			if (t.curId >= t.imgList.length)
			  t.curId = 0 ;
			t.doPic(t.curId);
		},this.sTime);
	}
	function callback(v)
	{
		$(_bigDiv).scrollTop = v;
	}
	function animate(beginV,endV)
	{
		x = endV - beginV;
		beginV += (x/4);
		if (Math.abs(beginV-endV) <= 1)
		{
			beginV = endV ;
			callback(endV);
		}
		else
		{			
			callback(beginV);
			timer=setTimeout(function(){animate( beginV  , endV)},10);
		}
	}
}