<?php
/**
 * 
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
if(!defined('duomi_INC'))
{
	exit("Request Error!");
}

function _FilterAll($fk,&$svar)
{
	global $cfg_notallowstr,$cfg_replacestr;
	if( is_array($svar) )
	{
		foreach($svar as $_k => $_v)
		{
			$svar[$_k] = _FilterAll($fk,$_v);
		}
	}
	else
	{
		if($cfg_notallowstr!='' && m_eregi($cfg_notallowstr,$svar))
		{
			//ShowMsg(" $fk has not allow words!",'-1');
			//exit();
			$svar = str_replace($cfg_replacestr,"***",$svar);

		}
		if($cfg_replacestr!='')
		{
			$svar = m_eregi_replace($cfg_replacestr,"***",$svar);
		}
	}
	return $svar;
}


function _Replace_Badword(&$var)
{
	global $cfg_notallowstr;
	
	$myarr = split ('[|.-]',$cfg_notallowstr);
	
	for($i=0;$i<count($myarr);$i++)
	{
		$var = str_replace($myarr[$i],"*",$var);	
	}
	return $var;
}
/*foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v)
	{
		${$_k} = _FilterAll($_k,$_v);
	}
}
*/?>