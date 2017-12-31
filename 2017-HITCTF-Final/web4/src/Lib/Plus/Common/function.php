<?php
function json($arr) {
    header("Content-type:application/json; charset=utf-8");
    $json = json_encode($arr);
    return $json;
}
function arr($arr) {
    header("Content-Type:text/html; charset=utf-8");
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
function xml($arr, $dom = 0, $item = 0) {
    if (!$dom) {
        $dom = new DOMDocument("1.0" ,"utf-8");
    }
    if (!$item) {
        $item = $dom->createElement("video");
        $dom->appendChild($item);
    }
    foreach ($arr as $key => $val) {
        $itemx = $dom->createElement(is_string($key) ? $key : "item");
        $item->appendChild($itemx);
        if (!is_array($val)) {
            $text = $dom->createTextNode($val);
            $itemx->appendChild($text);
        } else {
            xml($val, $dom, $itemx);
        }
    }
    header("Content-Type: text/xml; charset=utf-8");
    return $dom->saveXML();
}
class ArrayToXML {
    public static function toXml($data, $rootNodeName = 'data', $xml = null) {
        if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set('zend.ze1_compatibility_mode', 0);
        }
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = "unknownNode_" . (string)$key;
            }
            $key = preg_replace('/[^a-z]/i', '', $key);
            if (is_array($value)) {
                $node = $xml->addChild($key);
                ArrayToXML::toXml($value, $rootNodeName, $node);
            } else {
                $value = htmlentities($value);
                $xml->addChild($key, $value);
            }
        }
        return $xml->asXML();
    }
}
function trimall($str)//É¾³ý¿Õ¸ñ
{
    $qian=array(" ","¡¡","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);    
}


function tingletters($name)
{
	$rs = M("Ting");
	$ting["ting_letters"] = getpy($name);
	$where["ting_letters"] = $ting["ting_letters"];

	if (0 < $rs->where($where)->count()) {
		$ting["ting_letters"] = getpy($name);
		$where["ting_letters"] = $ting["ting_letters"];
		$i = 1;

		while (0 < $rs->where($where)->count()) {
			$ting["ting_letters"] = getpy($name) . $i;
			$where["ting_letters"] = $ting["ting_letters"];
			$i++;
		}
	}

	return $ting["ting_letters"];
}

function specialletters($name)
{
	$rs = M("Special");
	$special["special_letters"] = getpy($name);
	$where["special_letters"] = $special["special_letters"];

	if (0 < $rs->where($where)->count()) {
		$special["special_letters"] = getpy($name);
		$where["special_letters"] = $special["special_letters"];
		$i = 1;

		while (0 < $rs->where($where)->count()) {
			$special["special_letters"] = getpy($name) . $i;
			$where["special_letters"] = $special["special_letters"];
			$i++;
		}
	}

	return $special["special_letters"];
}


