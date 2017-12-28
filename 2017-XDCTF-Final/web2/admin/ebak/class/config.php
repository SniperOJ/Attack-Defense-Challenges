<?php
error_reporting(0);
if(!defined('InEmpireBak'))
{
	exit();
}
define('EmpireBakConfig',TRUE);

@include('../../../data/common.inc.php');
@include('../../../../data/common.inc.php');
//Database
$phome_db_dbtype='';
$phome_db_ver='';
$phome_db_server=$cfg_dbhost;
$phome_db_port='';
$phome_db_username=$cfg_dbuser;
$phome_db_password=$cfg_dbpwd;
$phome_db_dbname=$cfg_dbname;
$baktbpre='';
$phome_db_char='utf8';

//USER
$set_username='admin';
$set_password='c3284d0f94606de1fd2af172aba15bf3';
$set_loginauth='';
$set_loginrnd='LhnkTyUfhHJV7A6vqsKSkasbDJG6iM';
$set_outtime='60';
$set_loginkey='1';
$ebak_set_keytime=60;
$ebak_set_ckuseragent='';

//COOKIE
$phome_cookiedomain='';
$phome_cookiepath='/';
$phome_cookievarpre='jbyuyv_';

//LANGUAGE
$langr=ReturnUseEbakLang();
$ebaklang=$langr['lang'];
$ebaklangchar=$langr['langchar'];

//BAK
$bakpath='bdata';
$bakzippath='zip';
$filechmod='1';
$phpsafemod='';
$php_outtime='1000';
$limittype='';
$canlistdb='1';
$ebak_set_moredbserver='';
$ebak_set_hidedbs='';
$ebak_set_escapetype='1';

//EBMA
$ebak_ebma_open=1;
$ebak_ebma_path='phpmyadmin';
$ebak_ebma_cklogin=0;

//SYS
$ebak_set_ckrndvar='ugjdkfjuajff';
$ebak_set_ckrndval='60e9dcc6b6aad544935160f5844bbd34';
$ebak_set_ckrndvaltwo='ca9895c8572d2e310bcfea83f95026e7';
$ebak_set_ckrndvalthree='5ccda9a4cab8fc954fd29ebf68c077ce';
$ebak_set_ckrndvalfour='f383636eba6a26b797e30d1fac1c55eb';

//------------ SYSTEM ------------
HeaderIeChar();
?>