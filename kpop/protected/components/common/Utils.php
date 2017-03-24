<?php
class Utils {
	public static function formatMSISDN($msisdn,$stripArray="84,0",$prefix=""){
		foreach (explode(",",$stripArray) as $item){
			$length = strlen($item);
			if(substr($msisdn, 0, $length) === $item)
			{
				$msisdn = substr($msisdn, strlen($item));
			}
		}
		return $prefix.$msisdn;
	}
    public static function khongdau($str){

        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
                "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
                ,"ế","ệ","ể","ễ",
                "ì","í","ị","ỉ","ĩ",
                "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
                ,"ờ","ớ","ợ","ở","ỡ",
                "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
                "ỳ","ý","ỵ","ỷ","ỹ",
                "đ",
                "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
                ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
                "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
                "Ì","Í","Ị","Ỉ","Ĩ",
                "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
                ,"Ờ","Ớ","Ợ","Ở","Ỡ",
                "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
                "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
                "Đ");

                $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
                ,"a","a","a","a","a","a",
                    "e","e","e","e","e","e","e","e","e","e","e",
                    "i","i","i","i","i",
                    "o","o","o","o","o","o","o","o","o","o","o","o"
                    ,"o","o","o","o","o",
                    "u","u","u","u","u","u","u","u","u","u","u",
                    "y","y","y","y","y",
                    "d",
                    "A","A","A","A","A","A","A","A","A","A","A","A"
                    ,"A","A","A","A","A",
                    "E","E","E","E","E","E","E","E","E","E","E",
                    "I","I","I","I","I",
                    "O","O","O","O","O","O","O","O","O","O","O","O"
                    ,"O","O","O","O","O",
                    "U","U","U","U","U","U","U","U","U","U","U",
                    "Y","Y","Y","Y","Y",
                    "D");

                    $str = str_replace($marTViet,$marKoDau,$str);
                    return $str;
    }
    public static function logFile($msg,$level=CLogger::LEVEL_INFO,$category='application'){
        $logger = Yii::getLogger();
        if($logger===null){
                $logger = new CLogger;
                Yii::setLogger($logger);
        }
        $logger->log($msg,$level,$category);
    }

    public static function appleDevice($device='iPad'){
		switch ($device) {
			case 'iPad':
				if (strpos($_SERVER['HTTP_USER_AGENT'],'iPad') !== false){
					return true;
				} else {
					return false;
				}
				break;
			case 'iPod':
				if (strpos($_SERVER['HTTP_USER_AGENT'],'iPod') !== false){
					return true;
				} else {
					return false;
				}
				break;
			case 'iPhone':
				if (strpos($_SERVER['HTTP_USER_AGENT'],'iPhone') !== false){
					return true;
				} else {
					return false;
				}
				break;
			default:
				return false;
				break;
		}
	}

    /**
     * send data to recomendation system
     * @param string $action
     * @param array $params
     */
    public static function sendToRS($action, $params) {
        if(Yii::app()->params['recomendation']['active']) {
            $logUrl = "http://".Yii::app()->params['web.domain']."/log/rs";
            $params['action'] = $action;
            self::curlOpenAsync($logUrl, $params);
        }
    }

	public static function curlOpen($url, $params) {
		foreach ($params as $key => &$val) {
            if (is_array($val)) $val = implode(',', $val);
            $post_params[] = $key.'='.urlencode($val);
        }
        $post_string = implode('&', $post_params);

		$url = $url."?".$post_string;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
	}

    /**
     * Open url in sync mode
     * @param type $url
     * @param string $method: GET, POST
     * @param type $params
     */
    public static function curlOpenAsync($url, $params = array(),  $method="POST"){

        $post_params = array();

        foreach ($params as $key => &$val) {
            if (is_array($val)) $val = implode(',', $val);
            $post_params[] = $key.'='.urlencode($val);
        }
        $post_string = implode('&', $post_params);

        $parts=parse_url($url);

        $fp = fsockopen($parts['host'], isset($parts['port'])?$parts['port']:80,$errno, $errstr, 30);

        $out = "$method ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out.= $post_string;

        fwrite($fp, $out);
        fclose($fp);
		//Yii::log("RS: {$parts['host']} : {$parts['port']} DATA: $out", "error");
    }

    public static function makeDir($path)
    {
    	$path = str_replace(DS, "/", $path);
    	$folders = explode('/',$path);
    	$tmppath = "/";
    	for($i=1;$i < count($folders); $i++){
    		if(!file_exists($tmppath.$folders[$i]) && !mkdir($tmppath.$folders[$i],0755)) {
    			return false;
    		}
    		@chmod($tmppath.$folders[$i], 0755);
    		$tmppath = $tmppath.$folders[$i].'/';
    	}
    	return true;
    }

    public static function emptyDir($dir, $DeleteMe = false) {
    	if(!$dh = @opendir($dir)) return;
    	while (false !== ($obj = readdir($dh))) {
    		if($obj=='.' || $obj=='..') continue;
    		if (!@unlink($dir.'/'.$obj)) self::emptyDir($dir.'/'.$obj, true);
    	}
    	closedir($dh);
    	if ($DeleteMe){
    		@rmdir($dir);
    	}
    }
    public static function getExtension($fileName)
    {
    	$FileExtension = strrpos($fileName, ".", 1) + 1;
    	if ($FileExtension != false)
    		return strtolower(substr($fileName, $FileExtension, strlen($fileName) - $FileExtension));
    	else
    		return "";
    }
    public static  function getCurentSite()
    {
    	return Yii::app()->request->baseUrl;
    }

    public static function priceFormat ($price) {
    	return number_format($price, 2, ',', ' ');

    	$price = sprintf('%.0f', $price);
    	$price = str_replace('.', ',', $price);
    	while (true) {
    		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $price);
    		if ($replaced != $price) {
    			$price = $replaced;
    		} else {
    			break;
    		}
    	}
    	$price = str_replace(',', '.', $price);
    	$price .= ' '.'đ';

    	return $price;
    }

    public static function getFirstDayOfWeek($year, $weeknr)
    {
    	$offset = date('w', mktime(0,0,0,1,1,$year));
    	$offset = ($offset < 5) ? 1-$offset : 8-$offset;
    	$monday = mktime(0,0,0,1,1+$offset,$year);
    	$date = strtotime('+' . ($weeknr - 1) . ' weeks', $monday);
    	return $date;
    }

    public static function getFirstDayCtkm($year, $week, $display_vn = false){
        if($display_vn) return date("d-m-Y", strtotime("+3 day", self::getFirstDayOfWeek($year, $week)));
        return date("Y-m-d", strtotime("+3 day", self::getFirstDayOfWeek($year, $week)));
    }
    public static function getEndDayCtkm($year, $week, $display_vn = false){
        if($display_vn) return date("d-m-Y", strtotime("+9 day", self::getFirstDayOfWeek($year, $week)));
        return date("Y-m-d", strtotime("+9 day", self::getFirstDayOfWeek($year, $week)));
    }
}
