var img = {
	
	 imageNum: 5  ,
	 imageNumWidth:160,//152+(4*2)加上两个间距的长度
	 num:0,
	 count:document.getElementById("imagebg").getElementsByTagName("li").length,
	 
	 current:document.getElementById("current"),
	 imagebg:document.getElementById("imagebg"),
	 imagebg_li:document.getElementById("imagebg").getElementsByTagName("li"),
	 small_pic:document.getElementById("small_pic"),
	 
	 imageShow:document.getElementById("imageShow"),
	 scrollbg:document.getElementById("scrollbg"),
	 
	 left_img_btn:document.getElementById("left_img_btn"),
	 right_img_btn:document.getElementById("right_img_btn"),
	 
	 small_pic_html:[],
	 
	 animate:null,
	 autoplay:null,
	 
	 init:function(){
		 img.imagebg.innerHTML = img.imagebg.innerHTML+img.imagebg.innerHTML+img.imagebg.innerHTML;
		for(var i=0;i<img.imagebg_li.length;i++){
			//console.log(img.imagebg_li[i]+" is OK")
			if(i!=0){
				img.small_pic_html.push("<li onclick='img.play("+i+")'><img src='"+img.imagebg_li[i].getAttribute("data-sPic")+"' height=75 width=152/></li>");
				img.imagebg.getElementsByTagName("li")[i].style.display ="none";
			}else{
				img.small_pic_html.push("<li onclick='img.play("+i+")' class='currently'><img src='"+img.imagebg_li[i].getAttribute("data-sPic")+"' height=75 width=152/></li>");
			}
			//console.log(img.small_pic_html);
		}
		//console.log(img.small_pic_html)
		
		img.small_pic.innerHTML = img.small_pic_html.join("");
		img.current.style.left = "2px";//当前样式左边距
		img.small_pic.style.left = "0px";
		img.imagebg_li[0].style.filter = "alpha(opacity=100)";
		img.imagebg_li[0].style.opacity = 1;
		
		img.left_img_btn.onclick = function(){img.play(img.num-1);}
		img.right_img_btn.onclick = function(){img.play(img.num+1)};
		
		img.autoplay= setInterval(function(){img.play(img.num+1)},5000);
		
		img.imageShow.onmouseover = function(){clearInterval(img.autoplay);}
		img.imageShow.onmouseout = function(){img.autoplay= setInterval(function(){img.play(img.num+1)},5000); }
		
	},
	
	play:function(i){
		var small_pic_left = parseInt(img.small_pic.style.left);
		var current_left = parseInt(img.current.style.left);
		var op = 0;
		
		if(i == img.num|| img.animate!=null || i>img.count*3 || i<-1){return;}
		
		
		
		for(var x=0;x<img.imagebg_li.length;x++){
			
			img.small_pic.getElementsByTagName("li")[x].className = "";
			img.imagebg_li[x].style.filter = "alpha(opacity="+op*10+")";
			img.imagebg_li[x].style.opacity = op/10;
			img.imagebg_li[x].style.display = "none";
		}
		
		
		if(i>(img.count*3-1)){
			i-=img.count;
			img.num -=img.count;
			
			img.small_pic.style.left = small_pic_left + img.imageNumWidth*(i-img.count) +"px" ;
			img.small_pic.getElementsByTagName("li")[i].className="currently";
			
			small_pic_left = parseInt(img.small_pic.style.left);
			current_left = parseInt(img.current.style.left);
			
		}else if(i<0){
			i+=img.count;
			img.num +=img.count;
			
			img.small_pic.style.left = small_pic_left - img.imageNumWidth*img.count +"px" ;
			img.small_pic.getElementsByTagName("li")[i].className="currently";
			
			small_pic_left = parseInt(img.small_pic.style.left);
			current_left = parseInt(img.current.style.left);
		}
	
		if(i>img.num){
			//如果比当前大;
			img.imagebg_li[i].style.display = "block";
			if(parseInt(img.current.style.left)>400){
				//如果活动框到了最右边--完成
				//小图片向左
				img.animate = setInterval(function(){
					if(parseInt(img.small_pic.style.left)>(small_pic_left- img.imageNumWidth*(i-img.num)+img.imageNumWidth*(i-img.num)/10)){
						img.small_pic.style.left = parseInt(img.small_pic.style.left) - img.imageNumWidth*(i-img.num)/10 +"px" ;
						img.imagebg_li[i].style.filter = "alpha(opacity="+(++op)*11+")";
						img.imagebg_li[i].style.opacity = op/9;
					}else{
						img.small_pic.style.left = small_pic_left - img.imageNumWidth*(i-img.num) +"px" ;
						img.small_pic.getElementsByTagName("li")[i].className="currently";
						clearInterval(img.animate);
						img.num = i;
						img.animate = null;
					}
				},30);
			}else{
				//活动框向右--完成
				img.animate = setInterval(function(){
					if(parseInt(img.current.style.left)<(current_left + img.imageNumWidth*(i-img.num)-img.imageNumWidth*(i-img.num)/10)){
						img.current.style.left = parseInt(img.current.style.left) + img.imageNumWidth*(i-img.num)/10 +"px" ;
						//为了IE联盟
						
						img.imagebg_li[i].style.filter = "alpha(opacity="+(++op)*11+")"; //"alpha(opacity=100)";
						
						//为了火狐部落
						img.imagebg_li[i].style.opacity = op/9;
					}else{
						img.current.style.left = current_left + img.imageNumWidth*(i-img.num) +"px" ;
						img.small_pic.getElementsByTagName("li")[i].className="currently";
						clearInterval(img.animate);
						img.num = i;
						img.animate = null;
					}
				},30);
			}
			
		}else if(i<img.num){
			img.imagebg_li[i].style.display = "block";
			//如果比当前小;
			if(parseInt(img.current.style.left)<100){
				//如果活动框到了最左边
				//小图片向右
				img.animate = setInterval(function(){
					//console.log(small_pic_left+"+"+ img.imageNumWidth*(img.num-i))
					if(parseInt(img.small_pic.style.left)<(small_pic_left- img.imageNumWidth*(i-img.num)+img.imageNumWidth*(i-img.num)/10)){
						img.small_pic.style.left = parseInt(img.small_pic.style.left) - img.imageNumWidth*(i-img.num)/10 +"px" ;
						img.imagebg_li[i].style.filter = "alpha(opacity="+(++op)*11+")";
						img.imagebg_li[i].style.opacity = op/9;
					}else{
						img.small_pic.style.left = small_pic_left - img.imageNumWidth*(i-img.num) +"px" ;
						img.small_pic.getElementsByTagName("li")[i].className="currently";
						clearInterval(img.animate);
						img.num = i;
						img.animate = null;
					}
				},30);
			}else{
				//活动框向左
				img.animate = setInterval(function(){
					if(parseInt(img.current.style.left)>(current_left - img.imageNumWidth*(img.num-i)+img.imageNumWidth*(img.num-i)/10)){
						img.current.style.left = parseInt(img.current.style.left) - img.imageNumWidth*(img.num-i)/10 +"px" ;
						img.imagebg_li[i].style.filter = "alpha(opacity="+(++op)*11+")";
						img.imagebg_li[i].style.opacity = op/9;
					}else{
						img.current.style.left = current_left - img.imageNumWidth*(img.num-i) +"px" ;
						img.small_pic.getElementsByTagName("li")[i].className="currently";
						clearInterval(img.animate);
						img.num = i;
						img.animate = null;
					}
				},30);
			}
		}
	}
	
	
}