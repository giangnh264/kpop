<?php
 class bmCommon {
 //get lastime user_activity
	public static function getLastTimeActivity($time) {
			return "date_sub(now(), interval {$time} hour)";
	}
	public static function logFile($msg,$level=CLogger::LEVEL_INFO,$category='application'){
        $logger = Yii::getLogger();
        if($logger===null){
                $logger = new CLogger;
                Yii::setLogger($logger);
        }
        $logger->log($msg,$level,$category);
    }
	public static function formatMSISDN($msisdn,$stripArray="84,0",$prefix="84"){
		foreach (explode(",",$stripArray) as $item){
			$length = strlen($item);
			if(substr($msisdn, 0, $length) === $item)
			{
				$msisdn = substr($msisdn, strlen($item));
			}
		}
		return $prefix.$msisdn;
	}
	
	public static function removePrefixPhone($msisdn){
	   if(strpos($msisdn,"84")===0){
	       $msisdn = "0".substr($msisdn,"2");
	   }else if(strpos($msisdn,"0")!==0){
	        $msisdn = "0".$msisdn;
	   }
	   return $msisdn;
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
		return array("realPass"=>$password,'encoderPass'=>md5($password));
    }
    public  static  function generateUsername() {
    	return 'Music'.md5('chacha'.rand().time());
    }
    
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
        $str = bmCommon::removeVietnamese($string);
        $result = trim(preg_replace("/[^A-Za-z0-9\s]/"," ",$str));
        return $result;
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
	
	public static function createFTPString($data) {
		$time = date('Ymd');
		$folder = '/home/vms/' . $time;
		if (!is_dir($folder)) mkdir($folder);
		$fileName = $folder . '/' . $time . '.txt';
		Yii::log($fileName, 'info', 'charging');
		$file = fopen($fileName, 'a+');
	
		$serviceId = 2461;
		$msisdn = substr($data['msisdn'], 2);
		$reqId = rand(0, 999) . date('YmdHis') . rand(0, 10);
		$reqTime = date('d/m/Y H:i:s');
		$status = $data['status'];
		$reqMsg = "\t";
		$extend = date('d/m/Y H:i:s', strtotime($data['expired_time']));
		$otherInfo = $data['package_id'];
	
		$tab = "\t";
	
		$line = $serviceId . $tab . $msisdn . $tab . $reqId . $tab . $reqTime . $tab . $status . $tab . $reqMsg . $tab . $extend . $tab . $otherInfo . "\n";
		Yii::log($line, 'info', 'charging');
		fwrite($file, $line);
		fclose($file);
	}
	
	public static function receiveMessage($msisdn, $status) {
		// $apiUrl = 'http://10.151.22.213:8088/SyncService/services/ReceiverInfo?wsdl';
		$apiUrl = 'http://localhost/ReceiverInfo.wsdl';
	
		if ($msisdn) {			
			$user = BmUserSubscribeModel::model()->getByPhone($msisdn);
	
			$client = new SoapClient($apiUrl);
			$params = array(
					'serviceid' => 2462,
					'msisdn' => $msisdn,
					'reqId' => rand(0, 999) . date('YmdHis') . rand(0, 10),
					'reqTime' => date('d/m/Y H:i:s'),
					'status' => $status,
					'reqMsg' => '',
					'extend' => date('d/m/Y H:i:s', strtotime($user->EXPIRED_TIME)),
					'otherInfo' => $user->PACKAGE_ID,
					'username' => 'MOBICLIP',
					'password' => 'MOBICLIP123'
			);
			$result = $client->receiveMessage($params);
			$params['result'] = $result;
			$params['extend'] = $user->EXPIRED_TIME;
			//self::updateSyncResult($params);
		}
	}
	
 }