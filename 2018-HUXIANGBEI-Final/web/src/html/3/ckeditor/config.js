/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'zh-cn'; // 配置语言   
    config.uiColor = '#e4e4e4'; // 背景颜色   
    config.width = 'auto'; // 宽度   
    config.height = '300px'; // 高度   
   	config.skin = 'kama';// 界面v2,kama,office2003   
    config.toolbar = 'MyToolbar';// 工具栏风格（基础'Basic'、全能'Full'、自定义）plugins/toolbar/plugin.js   
    config.toolbarCanCollapse = false;// 工具栏是否可以被收缩   
    config.resize_enabled = true;// 取消 “拖拽以改变尺寸”功能 plugins/resize/plugin.js   
    config.enterMode = CKEDITOR.ENTER_BR; //可选：CKEDITOR.ENTER_BR或CKEDITOR.ENTER_DIV 
	config.forcePasteAsPlainText =false; //是否强制复制来的内容去除格式 plugins/pastetext/plugin.js
	config.extraPlugins += (config.extraPlugins ?',lineheight' :'lineheight');//新扩展的,在\ckeditor\plugins\加了lineheight插件
	config.filebrowserImageUploadUrl = '/upforck.php?type=img';//新扩展的，加了上传图片选项卡，这里设定action处理页地址
	//config.filebrowserFlashUploadUrl = '/upforck.php?type=flash';
	config.entities = false;
	
	config.toolbar = 'MyToolbar'; 
	//config.toolbar = 'Full';
 	config.toolbar_MyToolbar2 =     
    [     
        ['NewPage','Preview'],     
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],     
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],     
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],     
        '/',     
        ['Styles','Format'],     
        ['Bold','Italic','Strike'],     
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],     
        ['Link','Unlink','Anchor'],     
        ['Maximize','-','About']     
    ];
	
	
config.toolbar_Full = [ 
['Source','-','Save','NewPage','Preview','-','Templates'], 
['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'], 
['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'], 
'/', 
['Bold','Italic','Underline','Strike','-','Subscript','Superscript'], 
['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'], 
['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], 
['Link','Unlink','Anchor'], 
['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'], 
'/', 
['Styles','Format','Font','FontSize'], 
['TextColor','BGColor'] 
]; 
   
    //自定义的工具栏       
    config.toolbar_MyToolbar =   
   [   
		['Source'], ['Image','Flash','Table','PageBreak'], 
		//   '/',   
		['FontSize','lineheight','TextColor','Bold','Italic','Strike','-','NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight'] ,
		['PasteText','RemoveFormat','Replace','Link','Unlink'],['Maximize','-','About'] 
   ];   
}; 