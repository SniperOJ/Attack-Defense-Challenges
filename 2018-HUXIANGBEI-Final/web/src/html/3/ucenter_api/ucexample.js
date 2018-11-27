function $(id) {
	return document.getElementById(id);
}

function pmwin(action, param) {
	var objs = document.getElementsByTagName("OBJECT");
	if(action == 'open') {
		for(i = 0;i < objs.length; i ++) {
			if(objs[i].style.visibility != 'hidden') {
				objs[i].setAttribute("oldvisibility", objs[i].style.visibility);
				objs[i].style.visibility = 'hidden';
			}
		}
		var clientWidth = document.body.clientWidth;
		var clientHeight = document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		var scrollTop = document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;
		var pmwidth = 800;
		var pmheight = clientHeight * 0.9;
		if(!$('pmlayer_bg')) {
			div = document.createElement('div');div.id = 'pmlayer_bg';
			div.style.position = 'absolute';
			div.style.left = div.style.top = '0px';
			div.style.width = '100%';
			div.style.height = (clientHeight > document.body.scrollHeight ? clientHeight : document.body.scrollHeight) + 'px';
			div.style.backgroundColor = '#000';
			div.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=80,finishOpacity=100,style=0)';
			div.style.opacity = 0.8;
			div.style.zIndex = '998';
			$('append_parent').appendChild(div);
			div = document.createElement('div');div.id = 'pmlayer';
			div.style.width = pmwidth + 'px';
			div.style.height = pmheight + 'px';
			div.style.left = ((clientWidth - pmwidth) / 2) + 'px';
			div.style.position = 'absolute';
			div.style.zIndex = '999';
			$('append_parent').appendChild(div);
			$('pmlayer').innerHTML = '<div style="width: 800px; background: #666666; margin: 5px auto; text-align: left;">' +
				'<div style="width: 800px; height: ' + pmheight + 'px; padding: 1px; background: #FFFFFF; border: 1px solid #7597B8; position: relative; left: -6px; top: -3px;">' +
				'<a href="###" onclick="pmwin(\'close\')"><img style="position: absolute;right: 20px;top: 15px" border="0" src="close.gif" title="¹Ø±Õ" /></a>' +
				'<iframe id="pmframe" name="pmframe" style="width:' + pmwidth + 'px;height:100%" allowTransparency="true" frameborder="0"></iframe></div></div>';
		}
		$('pmlayer_bg').style.display = '';
		$('pmlayer').style.display = '';
		$('pmlayer').style.top = ((clientHeight - pmheight) / 2 + scrollTop) + 'px';
		if(!param) {
			pmframe.location = 'ucexample_1.php?example=pmwin';
		} else {
			pmframe.location = 'ucexample_1.php?example=pmwin&' + param;
		}
		document.body.style.overflow = "hidden";
		document.body.scroll = "no";
	} else if(action == 'close') {
		for(i = 0;i < objs.length; i ++) {
			if(objs[i].attributes['oldvisibility']) {
				objs[i].style.visibility = objs[i].attributes['oldvisibility'].nodeValue;
				objs[i].removeAttribute('oldvisibility');
			}
		}
		$('pmlayer').style.display = 'none';
		$('pmlayer_bg').style.display = 'none';
		document.body.style.overflow = "auto";
		document.body.scroll = "auto";
	}
}