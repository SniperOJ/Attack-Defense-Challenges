/**
 * 请将下面的代码保存为"Jtimer.js"文件.
 * 在程序中调用示例:
 * <html>
 * <head>
 *  <script language="javascript" src="Jtimer.js"></script>
 * </head>
 * <body>
 *  <input type="text" readonly onclick="JTC.setday(this)"/>全部可选(无任何限制)<br />
 *  <input type="text" readonly onclick="JTC.setday(this,this,1,0)"/>往前日期 (不包含今天)<br />
 *  <input type="text" readonly onclick="JTC.setday(this,this,1,1,'yyyyMMdd')"/>往前日期 (包含今天,日期格式为:yyyyMMdd)<br />
 * </body>
 * </html>
 **/


/********************************************************************
* JavaScript Timer Control - Timer Select Control for Internet
* Copyright (C) 2010-2020 FreshFlower
*
* @author FreshFlower <wpt206@163.com>
* @site http://hi.baidu.com/wangpeng205/
* @version 1.0.2
*********************************************************************/


var JTC = {};

JTC.config = {
    
    //日期背景颜色与字体颜色 依次: 可选择; 今天; 鼠标移过; 不可选择
    dayBgColor : [ '#B1ED89', '#FF66E0', '#F9D23A','#EDECF0'],
    dayColor : [ '#303136', '#303136', '#303136', '#6F6F6F'],
    
    forward : 0 ,   //控制日期可选择的范围  0:无限制;  1:仅可选择过去的日期; 2.仅可选择未来的日期
    includeToday : 1 ,  //是否可以选择今天: 0: 不可选  1: 可以选择; 
    format : 'yyyy-MM-dd',  //返回日期值的格式
    outObject : null ,
    
    bgDivID : 'JTC_BG_DIV',
    yearSpan : 'JTC_TheCurYear',
    yearSelectSpan : 'JTC_SelectYearLayer',
    yearSelectCtrl : 'JTC_SelectYearCtrl',
    
    monthSpan : 'JTC_TheCurMonth',
    monthSelectSpan : 'JTC_SelectMonthLayer',
    monthSelectCtrl : 'JTC_SelectMonthCtrl',
    dayPanelId : 'JTC_TheCurDay'
};
   
JTC.$ = function(id,doc){
    var doc = doc || document;
    return doc.getElementById(id);
};

JTC.$$ = function(name, doc){
	var doc = doc || document;
	return doc.createElement(name);
};   

JTC.browser = (function() {
	var ua = navigator.userAgent.toLowerCase();
	return {
		VERSION: ua.match(/(msie|firefox|webkit|opera)[\/:\s](\d+)/) ? RegExp.$2 : '0',
		IE: (ua.indexOf('msie') > -1 && ua.indexOf('opera') == -1),
		GECKO: (ua.indexOf('gecko') > -1 && ua.indexOf('khtml') == -1),
		WEBKIT: (ua.indexOf('applewebkit') > -1),
		OPERA: (ua.indexOf('opera') > -1)
	};
})();

JTC.util = {
    
    createTable : function(doc){
        var table = JTC.$$('table',doc);
        table.cellPadding = 0;
		table.cellSpacing = 0;
		table.border = 0;
		return {table: table, cell: table.insertRow(0).insertCell(0)};
    },
    
    formatDate : function(date, format){
        var lang = {
            'M+' : date.getMonth() + 1,
            'd+' : date.getDate()
        };
        if(/(y+)/.test(format)){
            format = format.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for(var key in lang){
            if(new RegExp('(' + key + ')').test(format)){
                format = format.replace(RegExp.$1, RegExp.$1.length==1 ? lang[key] : ('00' + lang[key]).substr(('' + lang[key]).length));
            }
        }
        return format;
    },
    
    addEvent : function(el, event, listener) {
		if (el.addEventListener){
			el.addEventListener(event, listener, false);
		} else if (el.attachEvent){
			el.attachEvent('on' + event, listener);
		}
	},
	
	getCoords : function(ev) {
	    ev = ev || window.event;
	    return {
		    x : ev.clientX,
		    y : ev.clientY
	    };
    },
    
	getDocumentElement : function(doc) {
		doc = doc || document;
		return (doc.compatMode != "CSS1Compat") ? doc.body : doc.documentElement;
	},
	
	getScrollPos : function() {
		var x, y;
		if (JTC.browser.IE || JTC.browser.OPERA) {
			var el = this.getDocumentElement();
			x = el.scrollLeft;
			y = el.scrollTop;
		} else {
			x = window.scrollX;
			y = window.scrollY;
		}
		return {x : x, y : y};
	},
	
	getElementPos : function(el) {
		var x = 0, y = 0, x1 = 0, y1 = 0;
		if (el.getBoundingClientRect) {
			var box = el.getBoundingClientRect();
			var el = this.getDocumentElement();
			var pos = this.getScrollPos();
			x = box.left + pos.x - el.clientLeft;
			y = box.top + pos.y - el.clientTop;
		} else {
            x = el.offsetLeft;
            y = el.offsetTop;
            var parent = el.offsetParent;
            while (parent) {
                x += parent.offsetLeft;
                y += parent.offsetTop;
                parent = parent.offsetParent;
            }
		}
		return {x : x, y : y };
	}
};

JTC.dialog = function(){
    
    this.getYMSelect = function(){
        var table = JTC.util.createTable().table;
        table.setAttribute('style','width:100%;height:25px;cursor:default;font-size:12px;');
        table.style.cssText = 'width:100%;height:25px;cursor:default;font-size:12px;';
        var row = table.insertRow(0);
        
        var cell = row.insertCell(0);
        cell.style.width = '50px';
        cell.style.height = '25px';
        cell.style.textAlign = 'right';
        var html = '<span id="'+ JTC.config.yearSpan +'" title="点击这里选择年份" style="width:50px;cursor:pointer;" onclick="JTC.events.beginToSelectYear()"></span>';
        html += '<span id="'+ JTC.config.yearSelectSpan +'" style="display:none; width:50px;"></span>';
        cell.innerHTML = html;
        
        cell = row.insertCell(1);
        cell.style.width = '40px';
        cell.style.textAlign = 'left';
        html = '<span id="'+ JTC.config.monthSpan +'" title="点击这里选择月份" style="width:40px;cursor:pointer;" onclick="JTC.events.beginToSelectMonth()"></span>';
        html += '<span id="'+ JTC.config.monthSelectSpan +'" style="display:none; width:40px;"></span>';
        cell.innerHTML = html;
        
        return table;
    };
    
    this.getHeadPanel = function(){
        var table = JTC.util.createTable().table;
        table.setAttribute('style','width:100%;height:25px;');
        table.style.cssText = 'width:100%;height:25px;';
        
        var row = table.insertRow(0);
        var cell = row.insertCell(0);
        cell.setAttribute('style','width:23px; height:25px;');
        cell.style.cssText = 'width:23px; height:25px;';
        cell.title = '往前翻 月';
        cell.innerHTML = '<input type="button" value="<" style="width:23px; height:23px;" onclick="JTC.events.turnTheMonth(-1)" />';
        
        cell = row.insertCell(1);
        cell.appendChild(this.getYMSelect());
        
        cell = row.insertCell(2);
        cell.setAttribute('style','width:23px; height:25px;');
        cell.style.cssText = 'width:23px; height:25px;';
        cell.title = '往后翻 月';
        cell.innerHTML = '<input type="button" value=">" style="width:23px; height:23px;" onclick="JTC.events.turnTheMonth(1)" />';
        
        return table;
    };
    
    this.getWeekPanel = function(){
        var table = JTC.util.createTable().table;
        table.setAttribute('style','width:100%; font-size:12px;');
        table.style.cssText = 'width:100%; font-size:12px;';
        table.cellSpacing = 1;
        var row = table.insertRow(0);
        var weekDay = ['日','一','二','三','四','五','六'];
        for(var i = 0; i< 7; i++)
        {
            var cell = row.insertCell(i);
            cell.style.width = '20px';
            cell.style.height = '20px';
            cell.style.backgroundColor = '#858F5F';
            cell.style.textAlign = 'center';
            cell.innerHTML = weekDay[i];
        }
        return table;
    };
    
    this.getDayPanel = function()
    {
        var table = JTC.util.createTable().table;
        table.setAttribute('style','width:100%;font-size:12px;');
        table.style.cssText = 'width:100%;font-size:12px;';
        table.cellSpacing = 1;
        
        var count = 0;
        for(var i=0; i<= 5; i++){
            var row = table.insertRow(i);
            for(var j=0; j< 7; j++){
                var cell = row.insertCell(j);
                cell.setAttribute('style','width:20px;height:20px;text-align:center;font-weight:bold;');
                cell.style.cssText = 'width:20px;height:20px;text-align:center;font-weight:bold;';
                cell.id = JTC.config.dayPanelId + count;
                cell.innerHTML = '';
                if(count > 36){
                    cell.colSpan = 5;
                    cell.style.textAlign = 'right';
                    cell.innerHTML = '<input type="button" value="关闭" style="width:45px; height:20px;" onclick="JTC.events.hideLayout()" />';
                    break;
                }
                count ++;
            }
        }
        return table;
    };
    
    this.getBottomPanel = function()
    {
        var table = JTC.util.createTable().table;
        table.style.width = '140px';
        
        var row = table.insertRow(0);
        var cell = row.insertCell(0);
        cell.style.width = '25px';
        cell.style.height = '25px';
        cell.title = '往前翻 年';
        cell.innerHTML = '<input type="button"  value="<<" style="width:25px;height:auto;" onclick="JTC.events.turnTheYear(-1)" />';
        
        cell = row.insertCell(1);
        cell.style.width = '25px';
        cell.title = '往前翻 月';
        cell.innerHTML = '<input type="button"  value="<" style="width:25px;height:auto;" onclick="JTC.events.turnTheMonth(-1)" />';
        
        cell = row.insertCell(2);
        cell.style.width = '40px';
        cell.style.textAlign = 'center';
        cell.innerHTML = '<input type="button"  value="今天"  onclick="JTC.events.resetToToday()" />';
        
        cell = row.insertCell(3);
        cell.style.width = '25px';
        cell.title = '往后翻 月';
        cell.innerHTML = '<input type="button"  value=">" style="width:25px;height:auto;" onclick="JTC.events.turnTheMonth(1)" />';
        
        cell = row.insertCell(4);
        cell.style.width = '25px';
        cell.title = '往后翻 年';
        cell.innerHTML = '<input type="button"  value=">>" style="width:25px;height:auto;" onclick="JTC.events.turnTheYear(1)" />';
        
        return table;
    };
    
    var load = JTC.util.createTable().table;
    load.setAttribute('style','width:140px;height:190px;font-size:12px;background-color:#ffffff; position:absolute;border-collapse:collapse;');
    load.style.cssText = 'width:140px;height:190px;font-size:12px;background-color:#ffffff; position:absolute;border-collapse:collapse;'; 
    load.border = 1;
    load.borderColor = '#858F5F';
    
    var row = load.insertRow(0);
    var cell = row.insertCell(0);
    cell.style.height = '25px';
    cell.appendChild(this.getHeadPanel());
    
    row = load.insertRow(1);
    cell = row.insertCell(0);
    cell.style.height = '20px';
    cell.appendChild(this.getWeekPanel());
    
    row = load.insertRow(2);
    cell = row.insertCell(0);
    cell.style.height = '120px';
    cell.appendChild(this.getDayPanel());
    
    row = load.insertRow(3);
    cell = row.insertCell(0);
    cell.style.height = '25px';
    cell.appendChild(this.getBottomPanel());
    
    var div = JTC.$$('div');
    div.id = JTC.config.bgDivID;
    div.setAttribute('style','position:absolute; width:142px; height:190px;z-index:20000; font-size:12px; background-color:lightgreen;display:none;');
    div.style.cssText = 'position:absolute; width:142px; height:190px;z-index:20000; font-size:12px; background-color:lightgreen;display:none;';
    div.appendChild(load);
    
    document.body.appendChild(div);
    JTC.util.addEvent(document, 'keydown',JTC.events.keyDown);
    JTC.util.addEvent(document, 'mousedown',JTC.events.mouseDown);
};

JTC.events = {
    //是否为闰年
    isLeapYear : function(year){
        if( 0==year%4 && ((year% 100 != 0)||(year% 400 ==0))) {
            return true;
        }else{ 
            return false;
        }
    },
    
    isToday : function(yy,mm,dd){
        var today = new Date();
        var y = today.getFullYear();
        var m = today.getMonth()>= 9 ? today.getMonth() + 1 : '0' + (today.getMonth() + 1);
        var d = today.getDate()> 9 ? today.getDate() : '0' + today.getDate();
        var num = parseInt('' + y + m + d);
        
        mm = mm> 9 ? mm : '0' + mm;
        dd = dd> 9 ? dd : '0' + dd;
        
        var num2 = parseInt('' + yy + mm + dd);
        if(num == num2){
            return 0;
        }else if(num> num2){
            return -1;
        }else{
            return 1;
        }
    },
    
    setHeadTip : function(yy,mm){
        JTC.$(JTC.config.yearSpan).innerHTML = yy + ' 年';
        JTC.$(JTC.config.monthSpan).innerHTML = mm + ' 月';
    },
    
    getMonthCount : function(yy,mm){
        var count = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var days = count[mm-1];
        if(mm==2 && JTC.events.isLeapYear(yy)){
            days ++;
        }
        return days;
    },
    
    createDay : function(yy, mm)
    {
        JTC.events.setHeadTip(yy,mm);
        
        var RevealDay = new Array(37);
        for(var i=0;i< 37; i++){
            RevealDay[i] = '';
        }
        
        var nday = 1;
        firstCount = new Date(yy,mm-1,1).getDay();
        for(var i = firstCount; nday<= JTC.events.getMonthCount(yy,mm); i++){
            RevealDay[i] = nday ;
            nday++;   
        }

        for(var i=0; i< 37; i++)
        {
            var obj = JTC.$(JTC.config.dayPanelId + i);
            obj.innerHTML = RevealDay[i];   //填充日期
            
            if(RevealDay[i]==''){   //空白区的背景及鼠标样式
                obj.style.backgroundColor = '#FFFFFF';
                obj.style.cursor = 'default';
                continue;
            }
           
            var isDay = JTC.events.isToday(yy,mm,RevealDay[i]);
            //设置背景
            if(isDay==0)
            {
                obj.style.backgroundColor = JTC.config.dayBgColor[1];
                obj.style.color = JTC.config.dayColor[1];
                
                if(JTC.config.includeToday ==1 || JTC.config.forward==0){
                    obj.style.cursor = 'pointer';
                }
                else{
                    obj.style.cursor = 'default';
                }
            }
            else if(isDay >0 ){
                if(JTC.config.forward == 1)
                {
                    obj.style.backgroundColor = JTC.config.dayBgColor[3];
                    obj.style.color = JTC.config.dayColor[3];
                    obj.style.cursor = 'default';
                }
                else{
                    obj.style.backgroundColor = JTC.config.dayBgColor[0];
                    obj.style.color = JTC.config.dayColor[0];
                    obj.style.cursor = 'pointer';
                }
            }else{
                if(JTC.config.forward == 2)
                {
                    obj.style.backgroundColor = JTC.config.dayBgColor[3];
                    obj.style.color = JTC.config.dayColor[3];
                    obj.style.cursor = 'default';
                }
                else{
                    obj.style.backgroundColor = JTC.config.dayBgColor[0];
                    obj.style.color = JTC.config.dayColor[0];
                    obj.style.cursor = 'pointer';
                }
            }
            
            //添加事件
            obj.onmouseover = function(){
                if(this.innerHTML == ''){ return;}
                var cur = this.style.cursor;
                if(cur == 'pointer'){
                    this.style.backgroundColor = JTC.config.dayBgColor[2];
                    this.style.color = JTC.config.dayColor[2];
                }
            }; 
            obj.onmouseout = function(){
                if(this.innerHTML == ''){ return;}
            
                var nDay = JTC.events.isToday(yy, mm,this.innerHTML);
                var cur = this.style.cursor;
                if(nDay==0){
                    this.style.backgroundColor = JTC.config.dayBgColor[1];
                    this.style.color = JTC.config.dayColor[1];
                }else if(cur=='pointer'){
                    this.style.backgroundColor = JTC.config.dayBgColor[0];
                    this.style.color = JTC.config.dayColor[0];
                }
            };
            obj.onclick = function(){
                var cur = this.style.cursor;
                if(cur == 'pointer'){
                    JTC.events.tdDayClick(this.innerHTML);
                }
            };
        }  
    },
    
    turnTheMonth : function(num)
    {
        this.hidenYearSelectCtrl();
        this.hiddenMonthSelectCtrl();
        var flag = num>0 ? 1 : -1;
        var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g));
        var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
        
        if(month == 1 && flag < 0 ){
            year --;  month = 12;
        }
        else if(month == 12 && flag >0 ){
            year ++; month = 1;
        }
        else{
            month += flag;
        }
        
        JTC.events.createDay(year,month);
    },
    
    turnTheYear : function(num)
    {
        this.hidenYearSelectCtrl();
        this.hiddenMonthSelectCtrl();
        var flag = num> 0 ? 1 : -1;
        var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g)) + flag;
        var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
        JTC.events.createDay(year,month);
    },
    
    resetToToday : function()
    {
        this.hidenYearSelectCtrl();
        this.hiddenMonthSelectCtrl();
        var year = new Date().getFullYear(); 
        var month = new Date().getMonth() + 1;
        JTC.events.createDay(year,month);
    },
    
    beginToSelectYear : function()
    {
        JTC.events.hiddenMonthSelectCtrl();
        var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g));
        JTC.$(JTC.config.yearSpan).style.display = 'none';
        var obj = JTC.$(JTC.config.yearSelectSpan);
        var html = '<select id="' + JTC.config.yearSelectCtrl + '" Author="fresh" style="font-size:12px;width:50px;"';
        html += ' onblur="JTC.events.hidenYearSelectCtrl()" onchange="JTC.events.hidenYearSelectCtrl()" >';
        for(var i=year + 10 ;i> year-20; i--){
	        if(i == year){
	            html += '<option value="'+ i +'年" selected>'+ i +'年</option>';
	        }else{
	            html += '<option value="'+ i +'年">'+ i +'年</option>';
	        }
	    }
	    html +='</select>';
	    obj.innerHTML = html;
	    obj.style.display = 'block';
    },
    
    hidenYearSelectCtrl : function()
    {
        var obj = JTC.$(JTC.config.yearSelectCtrl);
        if(obj==null || obj == 'undefined'){ return; }
        var year = parseInt(obj.options[obj.selectedIndex].value);
        var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
        
        JTC.$(JTC.config.yearSelectSpan).innerHTML = '';
        JTC.$(JTC.config.yearSelectSpan).style.display = 'none';
        JTC.$(JTC.config.yearSpan).innerHTML = year;
        JTC.$(JTC.config.yearSpan).style.display = 'block';
        
        JTC.events.createDay(year,month);
    },
    
    beginToSelectMonth : function()
    {
        JTC.events.hidenYearSelectCtrl();
        var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
        JTC.$(JTC.config.monthSpan).style.display = 'none';
        var obj = JTC.$(JTC.config.monthSelectSpan);
        var html = '<select id="' + JTC.config.monthSelectCtrl + '" Author="fresh" style="font-size:12px;width:40px;" ';
        html += ' onblur="JTC.events.hiddenMonthSelectCtrl()" onchange="JTC.events.hiddenMonthSelectCtrl()">';
        for(var i=1; i<=12; i++)
        {
            if(i == month){
                html += '<option value="'+ i + '月" selected>' + i + '月</option>';
            }else{
                html += '<option value="'+ i + '月">' + i + '月</option>';
            }
        }
        html +="</select>";
        
        obj.innerHTML = html;
        obj.style.display = 'block';
    },
    
    hiddenMonthSelectCtrl : function()
    {
        var obj = JTC.$(JTC.config.monthSelectCtrl);
        if(obj==null || obj == 'undefined'){ return; }
        var month = parseInt(obj.options[obj.selectedIndex].value);
        var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g));
        JTC.$(JTC.config.monthSelectSpan).innerHTML = '';
        JTC.$(JTC.config.monthSelectSpan).style.display = 'none';
        JTC.$(JTC.config.monthSpan).innerHTML = month;
        JTC.$(JTC.config.monthSpan).style.display = 'block';
        JTC.events.createDay(year,month);
    },
    
    hideLayout : function()
    {
        var div = JTC.$(JTC.config.bgDivID);
        JTC.events.hiddenMonthSelectCtrl();
        JTC.events.hidenYearSelectCtrl();
        div.style.display = 'none';
    },
    
    show : function(top, left)
    {
        var div = JTC.$(JTC.config.bgDivID);
        if(div == null || div == 'undefined'){
            JTC.dialog();
            var year = new Date().getFullYear(); 
            var month = new Date().getMonth() + 1;
            JTC.events.createDay(year,month);
            div = JTC.$(JTC.config.bgDivID);
        }
        else{
            var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g));
            var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
            JTC.events.createDay(year,month);
        }
        div.style.top = top + 'px';
        div.style.left = left + 'px';
        div.style.display = 'block';
    },
    
    tdDayClick : function(num)
    {
        var year = parseInt(JTC.$(JTC.config.yearSpan).innerHTML.match(/\d+/g)) ;
        var month = parseInt(JTC.$(JTC.config.monthSpan).innerHTML.match(/\d+/g));
        var date = new Date(year + '/' + month + '/' + num);
        try{
            JTC.config.outObject.value = JTC.util.formatDate(date,JTC.config.format); 
        }catch(e){ alert('传入的控件不支持Value属性！'); }
        JTC.events.hideLayout();
    },
    
    keyDown : function(ev){
        ev = ev || window.event;
        if(ev.keyCode == 27){
            JTC.events.hideLayout();
        }
    },
    
    mouseDown : function(ev){
        var div = JTC.$(JTC.config.bgDivID);
        if(div.style.display == 'none'){ return;}
        if(JTC.$(JTC.config.yearSelectCtrl)){ return;}
        if(JTC.$(JTC.config.monthSelectCtrl)){ return; }
        
        var minLeft,minTop,maxLeft,maxTop;
        var pos = JTC.util.getElementPos(div);
        minLeft = pos.x; minTop = pos.y;
        maxLeft = minLeft + 150;
        maxTop = minTop + 208;

        var scrol = JTC.util.getScrollPos();
        var mouse = JTC.util.getCoords(ev)
        var x = scrol.x + mouse.x;
        var y = scrol.y + mouse.y;
        if( x < minLeft || x > maxLeft || y < minTop || y > maxTop){ 
            JTC.events.hideLayout();
        }
    }
};

//函数调用入口 
// inObj: 触发控件; outObj:输出控件; forward:选择方向; today:是否包含今天; format:返回日期的格式
JTC.setday = function(inObj, outObj, forward, today, format)
{
    if(arguments.length > 5){
        alert('对不起！传入本控件的参数太多！');
        return;
    }
    if(arguments.length < 1){
        alert('对不起！传入本控件的参数太少！');
        return;
    }
    
    if(typeof(inObj)!='object'){
        alert('传入本控件的第一个参数类型不正确！必须是控件！');
        return ;
    }
    
    forward = typeof(forward)!='number' ?  0 : forward;
    today = typeof(today)!='number' ?  1 : today;
    JTC.config.forward = (forward != 1 && forward != 2) ? 0 : forward;
    JTC.config.outObject = arguments.length > 1 ? outObj : inObj;
    JTC.config.includeToday = today == 1 ?  1 : 0 ;
    if(format){
        JTC.config.format = format;
    }else{
        JTC.config.format = 'yyyy-MM-dd';
    }
    var top = inObj.offsetTop;
    var left = inObj.offsetLeft;
    var height = inObj.clientHeight;
    
    while(inObj = inObj.offsetParent){
        top += inObj.offsetTop; 
        left += inObj.offsetLeft;
    }
    
    var objTop = (typeof(inObj)=='image')? top + height : top + height + 5;
    JTC.events.show(objTop,left);
};