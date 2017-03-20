<?php
/**
 * class VegaCommonFunctions
 * define common functions to use in wapsite
 *
 * @author : longtv
 */
class VegaCommonFunctions
{
    /*
     * function removeVietnamese
     * change Vietnamese character to Latin
     * @param string $string
     * @return string $result
     */
    public static function removeVietnamese($string)
    {
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
                        "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề",
                        "ế","ệ","ể","ễ",
                        "ì","í","ị","ỉ","ĩ",
                        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ",
                        "ờ","ớ","ợ","ở","ỡ",
                        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
                        "ỳ","ý","ỵ","ỷ","ỹ",
                        "đ",
                        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
                        "Ằ","Ắ","Ặ","Ẳ","Ẵ",
                        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
                        "Ì","Í","Ị","Ỉ","Ĩ",
                        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
                        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
                        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
                        "Đ");

        $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a",
                        "a","a","a","a","a","a",
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
        $result = str_replace($marTViet,$marKoDau,$string);
        return $result;
    }

    /*
     * function removeSpecialCharacters
     * change Vietnamese character to Latin
     * remove other special characters
     * @param string $string
     * @return string $result
     */
    public static function removeSpecialCharacters($string)
    {
        $str = VegaCommonFunctions::removeVietnamese($string);
        $result = trim(preg_replace("/[^A-Za-z0-9\s]/"," ",$str));
        return $result;
    }
    

    /**
     * function substring
     * process long strings to shorter strings
     * @param string $string
     * @param character $space
     * @param integer $numspace
     * @return string
     */
    public static function substring($string, $space, $numspace){
        if (strlen($string) < 25)
        {
            return $string;
        }
        else
        {
            $arStr = explode($space, $string);
        }
        if (count($arStr) <= $numspace) return $string;
        $result = '';
        for ($i=0;$i<$numspace;$i++)
        {
            $result .= $arStr[$i].$space;
        }
        return $result."...";
    }

    /**
     * function isVinaphoneNumber
     * check if the phone number is vinaphone number
     * @param string $phone
     * @return bool $result
     */
    public static function isVinaphoneNumber($phone)
    {
        $phone = trim($phone);
        if (strpos($phone, "84") === 0)
        {
            $phone = "0" . substr($phone, "2");
        }
        else if (strpos($phone, "0") !== 0)
        {
            $phone = "0".$phone;
        }    
        $pattern = "/^(091|094|0123|0125|0127|0129|0124)([0-9]{6,7})/";
        $result = preg_match($pattern, $phone);
        return $result;
    }

    /**
     * function addLog
     * add a log string to a file
     * @param string $string
     * @param string $filePath
     */
    public static function addLog($string, $filePath)
    {
        $dir = substr($filePath, 0, strrpos($filePath, '/'));
        if (!file_exists($dir))
        {
            mkdir($dir);
        }
        $handle = fopen($filePath, "a");
		$maxLogSize = yii::app()->params['maxLogSize'];
		if (filesize($filePath) > $maxLogSize) {
			rename ($filePath, str_replace ( '.log', '_' . date ( 'YmdHis' ) . '.log', $filePath));
		}
		$fwrite = fwrite($handle, "$string \n");
		fclose ($handle);
    }

    /**
     * function nextDays
     * @param string $date
     * @param int $days
     * @return string
     */
    public static function nextDays($date, $days) {
        $timestam = strtotime($date);
        $timestam = $timestam + $days * 24 * 60 * 60;
        return date('Y-m-d H:i:s', $timestam);
    }

    /**
     * function str
     */
    public static function strNormalizer($str)
    {
        $str = self::removeVietnamese($str);
        $str = str_replace('.','', $str);
        $str = str_replace('%','',$str);
        $str = str_replace('#','',$str);
        $str = str_replace('?','',$str);
        $str = str_replace('/','',$str);
        $str = str_replace('(','',$str);
        $str = str_replace(')','',$str);
        $str = str_replace('[','',$str);
        $str = str_replace(']','',$str);
        $str = str_replace('{','',$str);
        $str = str_replace('}','',$str);
        $str = str_replace('+','-',$str);
        $str = str_replace('_','-',$str);
        $str = str_replace(' ','-',$str);
        $str = str_replace('"','',$str);
        $str = mb_strtolower($str, 'UTF-8');
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

    /**
     *
     * @param string $str_time
     * @param string $format
     * @return string
     */
    public static function getDate($str_time, $format = 'full_date') {
		$date = explode ( ' ', $str_time );
		$date = explode ( '-', $date [0] );
		switch ($format) {
			case 'full_date' :
				return $date [2] . '/' . $date [1] . '/' . $date [0];
				break;
			case 'date' :
				return $date [2] . '/' . $date [1];
				break;
		}
	}
    
    
    public static function generateUsername() {
    	return 'chacha'.md5('chacha'.rand().time());
    }    
   
    public static function randomPassword($length=6) {
        $str = "0123456789abcdefghijklmopqrstuxyz";
        $min = 0;
        $max = strlen($str)-1;
        $password = "";
        for($i=0; $i<$length; $i++)
        {
            $char = $str[mt_rand($min, $max)];
            $password .= $char;
        }
        
        return $password;
    }
    public static function getConnectMysql()
    {
    	$connString = Yii::app()->db->connectionString;
    	$extString = explode(';', $connString);
    	$hostExp = explode('=', $extString[0]);
    	$dbnameExp = explode('=', $extString[1]);
    	$hostName = $hostExp[1];
    	$dbName = $dbnameExp[1];
    	
    	$conn = mysql_connect($hostName, Yii::app()->db->username, Yii::app()->db->password);
    	mysql_select_db($dbName, $conn);
    	return $conn;
    }
}
?>
