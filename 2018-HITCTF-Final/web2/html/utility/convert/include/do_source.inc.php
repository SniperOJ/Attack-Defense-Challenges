<?php

$datadir = DISCUZ_ROOT.'./source/';

showtips('<li><strong>在开始转换之前，请确保本程序目录下的 data 目录为可写权限，否则无法存储转换设置</strong></li><li><strong>如果有Discuz!和UChome同时需要升级，请务必先升级Discuz!论坛</strong></li><li>请正确选择转换程序，否则可能造成无法转换成功</li><li>本转换程序不会破坏原始数据，所以转换需要2倍于原始数据空间</li>');

if(is_dir($datadir)) {

	$cdir = dir($datadir);
	show_table_header();
	show_table_row(array(
			'原始版本',
			'目标版本',
			array('width="50%"', '简介'),
			array('width="5%"', '说明'),
			array('width="5%"', '设置'),
			array('width="5%"', ''),
		), 'header title');
	while(($entry = $cdir->read()) !== false) {
		if(($entry != '.' && $entry != '..') && is_dir($datadir.$entry)) {
			$settingfile = $datadir.$entry.'/setting.ini';
			$readmefile = $datadir.$entry.'/readme.txt';

			$readme = file_exists($readmefile) ? '<a target="_blank" href="source/'.$entry.'/readme.txt">查看</a>' : '';

			if(file_exists($settingfile) && $setting = loadsetting($entry)) {
				$trclass = $trclass == 'bg1' ? 'bg2' : 'bg1';
				show_table_row(
					array(
						$setting['program']['source'],
						$setting['program']['target'],
						$setting['program']['introduction'],
						array('align="center"', $readme),
						array('align="center"', '<a href="index.php?a=setting&source='.rawurlencode($entry).'">修改</a>'),
						array('align="center"', '<a href="index.php?a=config&source='.rawurlencode($entry).'">开始</a>'),
					), $trclass
				);
			}
		}
	}
	$cdir->close();
	show_table_footer();
} else {
	showmessage('config_child_error');
}