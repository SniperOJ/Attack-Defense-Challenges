var FUNCS = {
	replyCommentPage: function (tId, pos, pId, author) {
		var pId = pId || '';
		var author = author || '';
		var extra = '';
		extra += '&viewpid=' + pId || '';
		extra += author ? '&author=' + encodeURIComponent(author) : '';
		TOOLS.openNewPage('?a=' + pos + '&tid=' + tId + '&login=yes&pos=yes' + extra);
	},
	newThreadPage: function (uid, fId) {
		TOOLS.openNewPage('?a=newthread' + '&fid=' + fId + '&login=yes');
	},
	jumpToLoginPage: function (url) {
		TOOLS.openNewPage('?' + url + '&login=yes');
	}
};

var initWXShare = function (opts) {
	if(SITE_INFO.openApi.wx != undefined){
		wx.config({
		    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: SITE_INFO.openApi.wx.appid, // 必填，公众号的唯一标识
		    timestamp: SITE_INFO.openApi.wx.js_timestamp, // 必填，生成签名的时间戳
		    nonceStr: SITE_INFO.openApi.wx.js_noncestr, // 必填，生成签名的随机串
		    signature: SITE_INFO.openApi.wx.js_signature,// 必填，签名，见附录1
		    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});
		wx.ready(function(){
			var url = window.location.href + '&siteid=' + SITE_ID;
			if (member_uid) {
				url += '&fromuid=' + member_uid;
			}
			url += '&source=';
			wx.onMenuShareTimeline({
			    title: opts.title, // 分享标题
			    link: url + 'pyq', // 分享链接
			    imgUrl: opts.img, // 分享图标
			    success: function () { 
			        // 用户确认分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    }
			});
			wx.onMenuShareAppMessage({
			    title: opts.title, // 分享标题
			    desc: opts.desc, // 分享描述
			    link: url + 'wxhy', // 分享链接
			    imgUrl: opts.img, // 分享图标
			    type: '', // 分享类型,music、video或link，不填默认为link
			    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			    success: function () { 
			        // 用户确认分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    }
			});
			wx.onMenuShareQQ({
			    title: opts.title, // 分享标题
			    desc: opts.desc, // 分享描述
			    link: url + 'qq', // 分享链接
			    imgUrl: opts.img, // 分享图标
			    success: function () { 
			       // 用户确认分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    },
			    cancel: function () { 
			       // 用户取消分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    }
			});
			wx.onMenuShareWeibo({
				title: opts.title, // 分享标题
			    desc: opts.desc, // 分享描述
			    link: url + 'wb', // 分享链接
			    imgUrl: opts.img, // 分享图标
			    success: function () { 
			       // 用户确认分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    },
			    cancel: function () { 
			       // 用户取消分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    }
			});
			wx.onMenuShareQZone({
				title: opts.title, // 分享标题
			    desc: opts.desc, // 分享描述
			    link: url + 'qzone', // 分享链接
			    imgUrl: opts.img, // 分享图标
			    success: function () { 
			       // 用户确认分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    },
			    cancel: function () { 
			       // 用户取消分享后执行的回调函数
			    	$('.tipInfo').hide();
					$('.maskLayer').hide();
			    }
			});
		});
	}
	
	/*
	WeixinJSBridge.on('menu:share:timeline', function (argv) {
		var url = window.location.href + '&source=pyq&siteid=' + SITE_ID;
		if (member_uid) {
			url += '&fromuid=' + member_uid;
		}
		setTimeout(
			function () {
				WeixinJSBridge.invoke('shareTimeline', {
					'img_url': opts.img,
					'img_width': '120',
					'img_height': '120',
					'link': url,
					'desc': opts.desc,
					'title': opts.title
				}, function (res) {
					$('.tipInfo').hide();
					$('.maskLayer').hide();
				});
			}
		, 300
			);
	});
	WeixinJSBridge.on('menu:share:appmessage', function (argv) {
		var url = window.location.href + '&source=wxhy&siteid=' + SITE_ID;
		setTimeout(
			function () {
				WeixinJSBridge.invoke('sendAppMessage', {
					//'appid': 'wx9324b266aa4818d0',
					'img_url': opts.img,
					'img_width': '120',
					'img_height': '120',
					'link': url,
					'desc': opts.desc,
					'title': opts.title
				}, function (res) {
					$('.tipInfo').hide();
					$('.maskLayer').hide();
				});
			}
		, 300
			);
	});
	WeixinJSBridge.on('menu:share:weibo', function (argv) {
		var url = window.location.href + '&source=wb&siteid=' + SITE_ID;
		setTimeout(
			function () {
				WeixinJSBridge.invoke('shareWeibo', {
					'img_url': opts.img,
					'img_width': '120',
					'img_height': '120',
					'link': url,
					'desc': opts.desc,
					'title': opts.title,
					'url': url,
					'content': opts.desc
				}, function (res) {
					$('.tipInfo').hide();
					$('.maskLayer').hide();
				});
			}
		, 300
			);
	});
	WeixinJSBridge.on('menu:share:qq', function (argv) {
		var url = window.location.href + '&source=qq&siteid=' + SITE_ID;
		setTimeout(
			function () {
				WeixinJSBridge.invoke('shareQQ', {
					'img_url': opts.img,
					'img_width': '120',
					'img_height': '120',
					'link': url,
					'desc': opts.desc,
					'title': opts.title,
					'url': url,
					'content': opts.desc
				}, function (res) {
					$('.tipInfo').hide();
					$('.maskLayer').hide();
				});
			}
		, 300
			);
	});
	WeixinJSBridge.on('menu:share:qzone', function (argv) {
		var url = window.location.href + '&source=qz&siteid=' + SITE_ID;
		setTimeout(
			function () {
				WeixinJSBridge.invoke('shareQZone', {
					'img_url': opts.img,
					'img_width': '120',
					'img_height': '120',
					'link': url,
					'desc': opts.desc,
					'title': opts.title,
					'url': url,
					'content': opts.desc
				}, function (res) {
					$('.tipInfo').hide();
					$('.maskLayer').hide();
				});
			}
		, 300
			);
	});
	*/
};