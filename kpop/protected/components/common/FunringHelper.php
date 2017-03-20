<?php
class FunringHelper{
	protected static $_instance = null;
	
	protected static $url = null;
	protected static $sid = null;
	protected static $seq = null;
	protected static $sidpwd = null;
	protected static $modulecode = null;
	
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct()
	{
		self::$url = Yii::app()->params["crbt"]["url"];
		self::$sid = Yii::app()->params["crbt"]["sid"];
		self::$seq = Yii::app()->params["crbt"]["seq"];
		self::$sidpwd = Yii::app()->params["crbt"]["sidpwd"];
		self::$modulecode = Yii::app()->params["crbt"]["modulecode"];
	}
	
	public function checkStatus($msisdn)
	{
		$url = self::$url."qryuserstatusbysp.do?";
		$url .= 'sid='.self::$sid;
		$url .= '&seq='.self::$seq;
		$url .= '&sidpwd='.self::$sidpwd;
		$url .= '&phonenumber='.$msisdn;
		
		$content = self::_getContentCurl($url);
		$retXml = ArrayHelper::xml2array($content);
		if(isset($retXml["returncode"]) && $retXml["returncode"] ==15003){
			$ret = 4; // Chua co thong tin tren CRBT => dang ky moi
		}else if(isset($retXml["qryuserstatus"]["returncode"]) && $retXml["qryuserstatus"]["returncode"]==0){
			$ret = isset($retXml["qryuserstatus"]["value"])?$retXml["qryuserstatus"]["value"]:-1;
		}else{
			$ret = -1;
		}		
		return $ret;		
	}
	
	public function register($msisdn)
	{
		$url = self::$url."dealaccount.do?";
		$url .= 'sid='.self::$sid;
		$url .= '&seq='.self::$seq;
		$url .= '&sidpwd='.self::$sidpwd;
		$url .= '&phonenumber='.$msisdn;
		$url .= '&type=0';
		$url .= '&modulecode='.self::$modulecode;
		
		$content = self::_getContentCurl($url);
		$retXml = ArrayHelper::xml2array($content);
		
		if(isset($retXml["openaccount"]["returncode"])){
			return $retXml["openaccount"]["returncode"];
		}else{
			return -1;
		}		
	}
	
	public function orderTone($msisdn, $tonecode)
	{
		$url = self::$url."downtone.do?";
		$url .= 'sid='.self::$sid;
		$url .= '&seq='.self::$seq;
		$url .= '&sidpwd='.self::$sidpwd;
		$url .= '&randomsessionkey='.$msisdn;
		$url .= '&tonecode='.$tonecode;
		$url .= '&flag=0';
		$url .= '&backurl=/';
		$url .= '&modulecode='.self::$modulecode;
		
		$content = self::_getContentCurl($url);
		$retXml = ArrayHelper::xml2array($content);
		
		if(isset($retXml["downtone"]["returncode"])){
			return $retXml["downtone"]["returncode"];
		}else{
			return -1;
		}
	}
	
	public function giftTone($msisdn, $tonecode, $toPhone)
	{
		$url = self::$url."delivetone.do?";
		$url .= 'sid='.self::$sid;
		$url .= '&seq='.self::$seq;
		$url .= '&sidpwd='.self::$sidpwd;
		$url .= '&randomsessionkey='.$msisdn;
		$url .= '&receiver='.$toPhone;
		$url .= '&tonecode='.$tonecode;
		$url .= '&type=0';
		$url .= '&backurl=/';
		$url .= '&modulecode='.self::$modulecode;
	
		$content = self::_getContentCurl($url);
		$retXml = ArrayHelper::xml2array($content);
		
		if(isset($retXml["delivetone"]["returncode"])){
			return $retXml["delivetone"]["returncode"];
		}else{
			return -1;
		}
	}
	
	public static function _getContentCurl($url)
	{
		$logger = new KLogger("RBT_GET", KLogger::OFF);		
		// timeout in seconds
		$timeOut = 5;
	
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_BINARYTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeOut );
		$rawdata = curl_exec ( $ch );
		if (! curl_errno ( $ch )) {
			if ($rawdata) {
				curl_close ( $ch );
				$logger->LogInfo("REQ:".$url." - RES: ".$rawdata);
				return $rawdata;
			}
		}
		curl_close ( $ch );
		$logger->LogInfo("REQ:".$url." - RES: FAIL");
		return false;
	}
	
}
