<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MainUserIdentity extends CUserIdentity {

    const ERROR_NONE = 0;
    const ERROR_USERNAME_INVALID = 8;
    const ERROR_PASSWORD_INVALID = 9;
    const ERROR_NOT_SUBSCRIBE = 10;
    const ERROR_EXPIRED_TRIAL = 11;
    const ERROR_TRIAL_MODE = 12;
    const ERROR_NOT_DETECT_MSISDN = -1;
    const ERROR_3G_NOT_SUBSCRIBE = 16;
    const ERROR_3G_NOT_USER = 17;
    const ERROR_NO_VALID_PHONE=13;

    public $_msisdn;
    private $_package;
    static $_os;

    /**
     * function _detectMSISDN
     * call to detect user phone number
     * @return string $phone
     */
    static function _detectMSISDN($channel = 'wap', $deviceId = NULL, $os = '') {
    	if (isset($_GET['test']) && $_GET['test'] != "") {
    		switch ($_GET['test']) {
    			case 1:
    				$phone = "841266046664";
    				break;
    			case 2:
    				$phone = "841205126493";
    				break;
    		}
    		return $phone;
    	}

        self::$_os = !empty($os) ? $os : '';
        $msisdn = '';

        // F5: 10.x.y.z
        $F5IPPattern = "/^10(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/";
        // WAPGW: 172.16.30.[11-12], 113.185.0.16
        $WAPGWIPPattern = "/^(172\.16\.30\.1[1-2]|113\.185\.0\.16)$/";
        // Dai ip 113.185.[1-31].0/24 thuoc F5 tuy nhien khong nhan dien duoc
        $OtherIpPattern = "/^113\.185\.([1-9]|1[0-9]|2[0-9]|3[0-1])\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/";

        $remoteIp = rtrim(ltrim($_SERVER['REMOTE_ADDR']));
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Opera') !== false) {
            $isOpera = true;
            $remoteIp = isset($_SERVER['HTTP_X_IPADDRESS']) ? $_SERVER['HTTP_X_IPADDRESS'] : $_SERVER['REMOTE_ADDR'];
            $remoteIp = trim($remoteIp);
        } else {
            $isOpera = false;
        }

        /*if(YII_DEBUG){
            $check_mobifone_ip = IpHelper::getIspNameByIp($remoteIp);
        }*/
        $check_mobifone_ip = IpHelper::getIspNameByIp($remoteIp);
//        if($check_mobifone_ip == 'MOBIFONE'){
        if(true){
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP_X_WAP_MSISDN']) && $_SERVER['HTTP_X_WAP_MSISDN']) ? $_SERVER['HTTP_X_WAP_MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['X_WAP_MSISDN']) && $_SERVER['X_WAP_MSISDN']) ? $_SERVER['X_WAP_MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['X-WAP-MSISDN']) && $_SERVER['X-WAP-MSISDN']) ? $_SERVER['X-WAP-MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['X-Wap-MSISDN']) && $_SERVER['X-Wap-MSISDN']) ? $_SERVER['X-Wap-MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['MSISDN']) && $_SERVER['MSISDN']) ? $_SERVER['MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['msisdn']) && $_SERVER['msisdn']) ? $_SERVER['msisdn'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP-X-WAP-MSISDN']) && $_SERVER['HTTP-X-WAP-MSISDN']) ? $_SERVER['HTTP-X-WAP-MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP_X_WAP_MSISDN']) && $_SERVER['HTTP_X_WAP_MSISDN']) ? $_SERVER['HTTP_X_WAP_MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP-MSISDN']) && $_SERVER['HTTP-MSISDN']) ? $_SERVER['HTTP-MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN']) ? $_SERVER['HTTP_MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['X-MSISDN']) && $_SERVER['X-MSISDN']) ? $_SERVER['X-MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['X_MSISDN']) && $_SERVER['X_MSISDN']) ? $_SERVER['X_MSISDN'] : $msisdn;
            if ($msisdn == '')
                $msisdn = (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID']) ? $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] : $msisdn;
            $lastLog = isset(Yii::app()->session['log_detect']) ? Yii::app()->session['log_detect'] : 0;
            
            if($msisdn != ""){
            	self::_logDetectMSISDN($msisdn, "F5", $channel, $deviceId);
            	Yii::app()->session['log_detect'] = time();
            }else if (time() - $lastLog > 600) {
                self::_logDetectMSISDN($msisdn, "F5", $channel, $deviceId);
                Yii::app()->session['log_detect'] = time();
            }
        }
        $type = '';
        // Truy cap tu mang Mobifone, ko nhan dien dc => sau 10ph log vao DB de thong ke
        /* if ((!$msisdn || $msisdn == '') && (preg_match($F5IPPattern, $remoteIp))) {
            $lastTimeLog = isset(Yii::app()->session['fail_detect']) ? Yii::app()->session['fail_detect'] : 0;
            if (time() - $lastTimeLog > 600) {
                self::_logDetectMSISDN("", $type, $channel, $deviceId);
                Yii::app()->session['fail_detect'] = time();
            }
        } */
        return $msisdn;
    }

    public function getId() {
        return $this->_msisdn;
    }

    /**
     * Log nhan dien thue bao
     * @param string $phone
     * @param string $type
     */
    public static function _logDetectMSISDN($phone, $type, $channel = 'wap', $deviceId=null) {
        if (!isset($deviceId))
            $deviceId = yii::app()->session['deviceId'];
        // log to file
        $xAddress = isset($_SERVER['HTTP_X_IPADDRESS']) ? $_SERVER['HTTP_X_IPADDRESS'] : '';
        VegaCommonFunctions::logFile('PHONE:' . $phone . ' |-|REMOTE_ADDR:' . $_SERVER['REMOTE_ADDR'] . ' |-| HTTP_X_IPADDRESS:' . $xAddress . ' |-|DEVICE:' . Yii::app()->session['deviceId'], 'detectMsisdn', $type);
        $os = self::$_os;
        // log to DB
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $userSubscribe = UserSubscribeModel::model()->get($phone); //get user_subscribe record by phone
        $packageId = $userSubscribe ? $userSubscribe->package_id : 0;
        $event = $userSubscribe ? $userSubscribe->event : '';
        $referral = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
        LogDetectMsisdnModel::model()->logDetect($phone, $_SERVER['REMOTE_ADDR'], $deviceId, $channel, 1, $type, $os, $userAgent, $packageId, $event, $referral, $uri);
    }

    /**
     *
     */
    private function isOperaBrowse() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Opera') !== false) {
            return true;
        }
        return false;
    }

}
