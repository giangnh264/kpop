<?php
//	require_once dirname(dirname(dirname(__FILE__))) . '/vega_common/Telco/mobifone/ChargingConnector.php';
//	Yii::import('application.components.common.sms.*');
/**
 * Ðng b? online tr?ng tháthuêao lêVASGATE
 */
class VasSync {

    protected static $_instance = null;
    
    public function __construct() {
    }
    
    public static function instance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
		}
    
    public function receiveMessageFull($params) {
        
        if ($params['msisdn'] == 'N/A') return false;
        $apiUrl = 'http://10.54.47.25/SyncVas/services/ReceiverInfoNew?wsdl';
        $client = new SoapClient($apiUrl);
                
        #SERVICEID
        $serviceId = 3542;
        
        #Thue bao
        $msisdn = $params['msisdn'];
        
        $reqId = $this->formatRequestId($msisdn);
        
        #REQ_TIME = dd/MM/yyyy HH24:mm:ss 
        $reqTime = date('d/m/Y H:i:s', time());
        
        #STATUS: 0-H?y d?ch v?, 1-Ðng ký v?, 2-D?ng d?ch v?, 3-Kí ho?t d?ch v?, 4-Gia h?n d?ch v?
        #Thuêao: SUBSCRIBE, H? th?ng: SYSTEM
        $action = $params['action'];
        $status = null;
        
        switch($action)
        {
            case 'unsubscribe':
                $status = 0;
                break;
            case 'subscribe':
                $status = 1;
                break;
            case 'extend_remain':
            case 'extend_subscribe':
                $status = 4;
                break;
        }
        
        $reqMsg = 'SUBSCRIBER';
        if($action == 'extend_remain' || $action == 'extend_subscribe')
            $reqMsg = 'SYSTEM';
        
        #EXTEND_TIME
        $extend_time = $params['expired_time'];
        
        #PRICE
        //$price = $package->PRICE;
        $price = $params['price'];
        
        #PACKAGE CODE (MC1, MC7, MC30)
        $package_code = $params['package_code'];
        $channel = $params['channel_type'];
        #Mã kênh khách hàng sử dụng để đăng ký / hủy / gia hạn. Đối với trường hợp gia hạn thì để là  SYSTEM, đối với kênh SMS thì truyền SMS, đối với WAP thì truyền WAP, đối với USSD thì truyền USSD, đối với APPLICATION thì truyền APP
        switch($channel){
            case "wap":
                $real_channel = "WAP";
                break;
            case "api-android":
            case "api-windowphone":
            case "api-ios":
                $real_channel = "APP";
                break;
            case "sms":
                $real_channel = "SMS";
                break;
            case "web":
                $real_channel = "WEB";
                break;
            case "system":
                $real_channel = "SYSTEM";
                break;
            case "cskh":
                $real_channel = "CSKH";
                break;
            case "admin":
                $real_channel = "ADMIN";
                break;
            default:
                $real_channel = "WAP";
                break;

        }
        $otherInfo = '';
        $username = 'amusic';
        $password = 'amusic123';
        
	$param = array(
                'serviceid' =>$serviceId,
                'msisdn' => $msisdn,
                'reqId' => $reqId,
                'reqMsg' => $reqMsg,
                'reqTime' => $reqTime,
                'status' => $status,
                'extend_time' => $extend_time,
                'price' => $price,
                'package_code' => $package_code,
                'channel' => $real_channel,
				'otherInfo' => $otherInfo,
				'username' => $username,
				'password' => $password,
				
            );
    	$vasResult = $client->__call("receiveMessageFull", array('parameters' => $param));
        $result = explode('|', $vasResult->return);
        $errorCode = $result[0];
        $errorDesc = $result[1];
        return array('code'=>$errorCode, 'error'=>$errorDesc);
    }
    
    function formatRequestId($str) {
        $tmp = ''.time();
        
        if(strlen($tmp) < 15)
        {
            for ($i = 0;$i < (15 - strlen($str));$i++) {
                $tmp .= rand(0,9);
            }
            $str .= $tmp;
        }
        elseif(strlen($tmp) > 15)
        {
            $str = substr($tmp, 0, 14);
        }

        return $tmp;
    }
    
}

