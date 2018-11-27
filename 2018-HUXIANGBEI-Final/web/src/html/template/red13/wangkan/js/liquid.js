if( document.documentElement )
	bodyStyle = document.documentElement.style;
else if( document.body )
	bodyStyle = document.body.style;

bodyStyle.visibility = "hidden";

function sizeContent(){
	var windowHeight = getWindowHeight();
	var footerHeight = document.getElementById("fbFooter").offsetHeight;

	var contentHeight = windowHeight - footerHeight;
	document.getElementById("fbContainer").style.height = contentHeight + "px";
	
	var altDiv = document.getElementById("altmsg");
	
	if( altDiv ){		
		var altH = altDiv.offsetHeight;
		var altW = altDiv.offsetWidth;
		altDiv.style.top = (contentHeight / 2 - altH /2)+ "px";
		altDiv.style.left = (getWindowWidth() / 2 - altW /2)+ "px";
	}
	
	if( bodyStyle )
		bodyStyle.visibility = "visible";
}

function addEvent( obj, type, fn )
{
	if (obj.addEventListener)
		obj.addEventListener( type, fn, false );
	else if (obj.attachEvent)
	{
		obj["e"+type+fn] = fn;
		obj.attachEvent( "on"+type, function() { obj["e"+type+fn](); } );
	}
}

function getWindowHeight() {
	var windowHeight=0;
	if ( typeof( window.innerHeight ) == 'number' ) {
		windowHeight=window.innerHeight;
	}
	else {
		if ( document.documentElement && document.documentElement.clientHeight) {
			windowHeight = document.documentElement.clientHeight;
		}
		else {
			if (document.body&&document.body.clientHeight) {
				windowHeight=document.body.clientHeight;
			}
		}
	}
	
	return windowHeight;
};

function getWindowWidth() {
	var ww = 0;
	if (self.innerWidth)
		ww = self.innerWidth;
	else if (document.documentElement && document.documentElement.clientWidth)
		ww = document.documentElement.clientWidth;
	else if (document.body)
		ww = document.body.clientWidth;
	return ww;
}

addEvent( window, "load", sizeContent);
addEvent( window, "resize", sizeContent );