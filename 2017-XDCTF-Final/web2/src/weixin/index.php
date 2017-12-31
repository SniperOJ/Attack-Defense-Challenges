<?php                   
require_once('../include/common.php');
require_once('../include/main.class.php');
require_once('../include/link.func.php');
require_once('../data/admin/weixin.php');
require_once('../data/common.inc.php');

if(isopen=="n"){die('ERROR');}
define("TOKEN", "weixin");	 
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
class wechatCallbackapiTest
{	
	public function CheckUrl($url)
	{		
	return preg_match('/(http|https|ftp):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$url);	
	}
	public function valid()
    {
        $echoStr = $_GET["echostr"];
		if($echoStr==""){		
			$this->responseMsg();
		 }elseif($this->checkSignature()){
        	echo $echoStr;
        	exit;
           }
    }
	
    public function responseMsg()
    {
		global $dsql;
		$this->dsql = $dsql;
		$postStr = addslashes(file_get_contents('php://input'));
		if (!empty($postStr)){
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);

				$event = $postObj->Event;			
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";    		
				switch($postObj->MsgType)
				{
					case 'event':
						if($event == 'subscribe')
						{
						//关注后的回复
							$contentStr = follow;
							$msgType = 'text';
							$textTpl = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $textTpl;
						}
						break;
					case 'text':
						if(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$keyword))
						{	
							$newsTplHeader = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
							<Articles>";
							$newsTplItem = "<item>
							<Title><![CDATA[%s]]></Title> 
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
							</item>";
							$newsTplFooter="</Articles>
							</xml>";
									
									//$con = mysql_connect(sql_url,sql_name,sql_pass);								
									//$this->dsql->SetQuery("SET NAMES UTF8");
									//$this->dsql->SetQuery("set character_set_client=utf8"); 
									//$this->dsql->SetQuery("set character_set_results=utf8");
									//mysql_select_db(sql_db, $con);
									$sql = "SELECT * FROM `sea_data` WHERE `v_name` like '%".$keyword."%'  LIMIT 0 ,".sql_num."";
							        $this->dsql->SetQuery($sql);
						            $this->dsql->Execute('zz');
									$itemCount = 0;
									$aa=$this->dsql->GetTotalRow('zz');

								if($aa>0){
								while($row = $this->dsql->GetAssoc('zz'))
								{
									$title = "".$row['v_name']."";
									$des ="";
									$rq=date('Y-n',$row['v_addtime']);
									if(topage == "d")
									{$url =url.getContentLink($row['tid'],$row['v_id'],'',$rq,$row['v_enname']);}
									else
                                    {
										require_once('../data/config.cache.inc.php');
										$url =url."/video/?".$row['v_id']."-0-0".$GLOBALS['cfg_filesuffix2'];}
									
									 // 检测图片是否本地									
									if($this->CheckUrl("".$row['v_pic']."")){										
										$picUrl1 ="".$row['v_pic']."";										
									}else{										
										$picUrl1 =url."/".$row['v_pic'];
										}
									// 添加更多链接									
									if ($itemCount==(sql_num-1) ) {
																				
							         $title='更多请点击>>';
								     $url="".url."/search.php?searchword=".$keyword."";
							   																	
								   }
								$contentStr .= sprintf($newsTplItem, $title, $des, $picUrl1, $url);																													
									++$itemCount;	
								}							
								$newsTplHeader = sprintf($newsTplHeader, $fromUsername, $toUsername, $time, $itemCount);
								$resultStr =  $newsTplHeader. $contentStr. $newsTplFooter;
								echo $resultStr; 
								}
								else
								{
									$newsTpl = "<xml>
										<ToUserName><![CDATA[%s]]></ToUserName>
										<FromUserName><![CDATA[%s]]></FromUserName>
										<CreateTime>%s</CreateTime>
										<MsgType><![CDATA[news]]></MsgType>
										<ArticleCount>1</ArticleCount>
										<Articles>
										<item>
										<Title><![CDATA[%s]]></Title> 
										<Description><![CDATA[%s]]></Description>
										<PicUrl><![CDATA[%s]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
										</item>							
										</Articles>
										</xml>";						
								
								//没有查找到的时候的回复
										$title = noc;										
										$des1 ="";										
										$picUrl1 =dpic;										
										$url="".url."/gbook.php";
										$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;
									    echo $resultStr; 	

								}
				
									
								}
						elseif(is_numeric($keyword))
						{
							$newsTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
							<Articles>
							<item>
							<Title><![CDATA[%s]]></Title> 
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
							</item>							
							</Articles>
							</xml>";	
							
							$row=$this->dsql->GetOne("SELECT * FROM `sea_data` WHERE `v_id` =$keyword");
							$psd=$row['v_psd'];
							$vname=$row['v_name'];
							if(empty($vname) OR $vname==NULL)
							{$txt="该视频ID不存在。";}
							elseif(empty($psd) OR $psd==NUlL)
							{$txt="视频《".$vname."》不需要密码。";}
							else
							{$txt="视频《".$vname."》的观看密码是：".$psd;}
						
							$contentStr = "$txt";

							$msgType = 'text';
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}
						else
						{
							$newsTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
							<Articles>
							<item>
							<Title><![CDATA[%s]]></Title> 
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
							</item>							
							</Articles>
							</xml>";	
 						
						
						if($keyword=="h")
						
						{
			
						 $contentStr = help;

						 $msgType = 'text';
						 $textTpl = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						 echo $textTpl;

						
						}						
						
						if($keyword=="g")
						{
										$title = '点击进入留言本';
										
										$des1 ="";
										//图片地址
										$picUrl1 =dpic;
										//跳转链接
										$url="".url."/gbook.php";
										$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;
									
										echo $resultStr; 	
						}
						
						//VIP播放									
						if($this->CheckUrl(".$keyword."))
					    {
										
										
								       $title = '点击开始播放';
										
										$des1 ="";
										//图片地址
										$picUrl1 =dpic;
										//跳转链接
										$url="".ckmov_url."".$keyword."";

										$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, $title, $des1, $picUrl1, $url) ;
									
										echo $resultStr; 		
													
																													
					 }
						
						
						
						
							$contentStr = help;

							$msgType = 'text';
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}					
						
						
						break;
					default:
						break;
				}						

        }else {
        	echo "你好！欢迎进入".title."微信公众号";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>