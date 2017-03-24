<?php
class Transaction {
	private static $_url_charg;
	private static $_user_charg;
	private static $_pass_charg;
	private static $_logger = null;
	
	/* public function __construct(){
		self::$_url_charg = Yii::app()->params["charging_proxy"]["url"];
		self::$_user_charg = Yii::app()->params["charging_proxy"]["username"];
		self::$_pass_charg = Yii::app()->params["charging_proxy"]["password"];
		
		if($this->_logger==null){
			$this->_logger = new KLogger('log_transaction_core', KLogger::INFO);
		}		
	} */
	public static  function  init()
	{
		self::$_url_charg = Yii::app()->params["charging_proxy"]["url"];
		self::$_user_charg = Yii::app()->params["charging_proxy"]["username"];
		self::$_pass_charg = Yii::app()->params["charging_proxy"]["password"];
		
		if(self::$_logger==null){
			self::$_logger = new KLogger('log_transaction_core', KLogger::INFO);
		}
	}
	private static function initSubscribeParams($params) {
		$defaultParams = array (
				'cmd' => "",
				'msisdn' => "",
				'price' => "",
				'reason' => "",
				'originprice' => 0,
				'promotion ' => 0,
				'note' => "",
				'charge_note' => "",
				'source' => "",
				'charging' => 1 
		);
		
		return array_merge ( $defaultParams, $params );
	}
	private static function isUserVip($msisdn) {
		if ($userVip = UserVipModel::model ()->findByAttributes ( array (
				'user_phone' => $msisdn 
		) ))
			return true;
		return false;
	}
	
	/**
	 * ChageSubscribe
	 * 
	 * @param array $params
	 *        	= array(
	 *        	cmd: subscribe/unsubscribe/subscribe_ext
	 *        	msisdn
	 *        	price
	 *        	reasson
	 *        	originPrice
	 *        	promotion
	 *        	charge_note
	 *        	source
	 *        	call_ccggw
	 *        	)
	 * @param type $isExt        	
	 * @return string
	 */
	public static function doChargeSubscribe($params) {
		self::init();
		try{
			$result['ERROR'] = 1;
			$result['ERROR_DESC'] = 'System error!';
			if ($params ['price'] > 0) {
				if (self::isUserVip ( $params ['msisdn'] )) {
					$params ['promotion'] = 1;
				}
			}
			$params = self::initSubscribeParams ( $params );
			
			if ($params ['promotion']) {
				$params ['promotion'] = 1;
				$params ['price'] = 0;
			} else
				$params ['promotion'] = 0;
			
			$params ['request_id'] = date ( "YmdHis" );
			$package_code = $params['itemCode'];
			$otherParams = array(
								"packageCode"=>$params['itemCode'],
								"contentId"=>$params['contentId'],
								"categoryId"=>$params['contentId']					
							);
			
			$result = self::_processCharging($params['msisdn'], $params['price'], $params ['cmd'],$otherParams);
			
			$result['ERROR'] = $result['errorCode'];
			$result['ERROR_DESC'] = $result['errorDesc'];
			$transParams = $params;
			$transParams ['return_code'] = $result ['errorCode'];		
			$transParams ['promotion'] = $transParams ['promotion'] || $result ['PROMOTION'];
			
			if (($transParams ['source'] == "SUBNOTEXIST") || ($transParams ['source'] == "MAXRETRY"))
				$transParams ['source'] = "auto";
				
			// chuan hoa params[note], loai bo cac note trung nhau
			$note = isset ( $transParams ['note'] ) ? $transParams ['note'] : '';
			if ($note) {
				$items = explode ( "|", $note );
				$notes = array ();
				foreach ( $items as $item ) {
					if ($item)
						$notes [$item] = $item;
				}
				$note = implode ( "|", $notes );
			}
			$transParams ['note'] = $note;
			if(isset($result['note'])){
				// Luu ma loi tra ve tu charging vao truong note ex: CPS-000, CPS-007
				$transParams ['note'] .= "|".$result['note'];
			}
			//Update vao DB theo request time
//			$transParams["createdDatetime"] = isset($result["timeRequest"])?$result["timeRequest"]:date("Y-m-d H:i:s");
            $transParams["createdDatetime"] = isset($result["timeRequest"])?$result["timeRequest"] : $params['createdDatetime'];


            // Log CDR: MSISDN|CMD|PACKAGE_CODE|PRICE
			if (($params ['charging'] == 1) && ($result ['ERROR'] == 0)){
				self::logCDR ( $transParams );
			}
			self::logToTransaction ( $transParams );
		}catch (Exception $e)
		{
			$result['ERROR'] = '500';
			$result['ERROR_DESC'] = 'Exception:'.$e->getMessage();
		}	
		return $result;
	}
	
	public static function doChargeContent($params) {
		self::init();
		
		$phone = bmCommon::formatMSISDN ( $params ['msisdn'], '84,0', '84' );
		if ($params ['checkLastActivity'] == 0) {
			if ($params ['price'] > 0) {
				if (self::isUserVip ( $params ['msisdn'] )) {
					$params ['price'] = 0;
				}
			}
			
			$params ['request_id'] = $params ['requestId'];
			$params ['request_xml'] = "";
			$params ['response_xml'] = "";
			
			$otherParams = array("channel"=>$params["source"],"action"=>$params["cmd"]);
			if(strpos($params["cmd"], "download")!==false) $otherParams["action"] = "download";
			if(strpos($params["cmd"], "play")!==false) $otherParams["action"] = "streaming";
			$otherParams["contentId"] = $params['obj1_id'];
			$otherParams["categoryId"] = 3;
			
			$params ['price'] = 0;
			$result = self::_processCharging($params ['msisdn'], $params ['price'], $params['cmd'],$otherParams);
			$transParams = $params;	
			
			// chuan hoa params[note], loai bo cac note trung nhau
			$note = isset ( $transParams ['note'] ) ? $transParams ['note'] : '';
			if ($note) {
				$items = explode ( "|", $note );
				$notes = array ();
				foreach ( $items as $item ) {
					if ($item)
						$notes [$item] = $item;
				}
				$note = implode ( "|", $notes );
			}			
			$transParams ['note'] = $note;
			if(isset($result['note'])){
				// Luu ma loi tra ve tu charging vao truong note ex: CPS-000, CPS-007
				$transParams ['note'] .= "|".$result['note'];
			}
			
			
			if($result['ERROR']==0){
				$transParams ['return_code'] = 0;
				self::logCDR ( $transParams );
				$error = 'success';
			}else{
				$transParams ['return_code'] = 1;
				$error = 'fail';
			}
			self::logToTransaction ( $transParams );
		} else {
			bmCommon::logFile ( 'Charging24h-' . $params ['cmd'] . '-' . $params ['msisdn'] . '-' . $params ['obj1_id'] . '-' . $params ['obj1_name'], 'CONTENT', 'Charging24h' );
			$error = 'success';
		}
		
		return $error;
	}
	
	/**
	 * function logToTransaction
	 * 
	 * @param array $params        	
	 */
	public static function logToTransaction($params) {
		// log to transaction
		try {
			if ($params ['checkLastActivity'] != 1) {
				$ret = BmUserTransactionModel::model ()->add ( $params );
				//elastic log
				$params['error_code'] = $params['return_code'];
				$params['error_mesage'] = $params['errorDesc'];
				$params["response_time"] = date('Y-m-d H:i:s');
				if($params['cmd']!='extend_subscribe' && $params['cmd']!='extend_subscribe_level1' && $params['cmd']!='extend_remain') {
					$logger = new MusicLogger(MusicLogger::INFO);
					$logger->logCharging($params);
				}
			}
		} catch ( Exception $e ) {
			$error_msg = $e->getMessage ();
			$userPhone = $params ['msisdn'];
			$to_phone = isset ( $params ['to_phone'] ) ? $params ['to_phone'] : $params ['msisdn'];
			$action = $params ['cmd'];
			
			//Log error
			$logger = new KLogger("ERROR_TRANS", KLogger::INFO);
			$logger->LogError("Exception save user_transaction: $userPhone|$action|$error_msg");
		}
	}
	
	/**
	 * function logCDR
	 * 
	 * @param array $params        	
	 */
	public static function logCDR($params) {
		// log to transaction
		try {
			$cdr = new LogCdrModel ();
			$cdr->user_id = isset ( $params ['user_id'] ) ? $params ['user_id'] : '0';
			$cdr->user_phone = $params ["msisdn"];
			$cdr->price = $params ["price"];
			$cdr->origin_price = isset ( $params ["originPrice"] ) ? $params ["originPrice"] : $params ["price"];
			$cdr->package_id = isset ( $params ['packageId'] ) ? $params ['packageId'] : '0';
			$cdr->transaction = $params ["cmd"];
			$cdr->channel = $params ["source"];
			$cdr->cp_id = isset ( $params ['cp_id'] ) ? $params ['cp_id'] : '0';
			$cdr->obj1_id = isset ( $params ['obj1_id'] ) ? $params ['obj1_id'] : '0';
			$cdr->obj1_name = isset ( $params ['obj1_name'] ) ? $params ['obj1_name'] : '';
			$cdr->obj2_id = isset ( $params ['obj2_id'] ) ? $params ['obj2_id'] : '0';
			$cdr->obj2_name = isset ( $params ['obj2_name'] ) ? $params ['obj2_name'] : '';
			//$cdr->created_time = new CDbExpression ( "NOW()" );
			$cdr->created_time = $params ['createdDatetime'];
			$cdr->genre_id = isset ( $params ['genre_id'] ) ? $params ['genre_id'] : '0';
			$cdr->promotion = isset ( $params ['promotion'] ) ? $params ['promotion'] : '0';
			$cdr->note = $params ['note'];
			$cdr->reason = isset ( $params ['reason'] ) ? $params ['reason'] : '';
			$cdr->content_code = isset ( $params ['itemCode'] ) ? $params ['itemCode'] : '';
			$cdr->content_type = isset ( $params ['content_type'] ) ? $params ['content_type'] : '';
			$cdr->genre_type = isset ( $params ['genre_type'] ) ? $params ['genre_type'] : '';
			$cdr->request_id = isset ( $params ['request_id'] ) ? $params ['request_id'] : '';
			$cdr->request_xml = isset ( $params ['request_xml'] ) ? $params ['request_xml'] : '';
			$cdr->response_xml = isset ( $params ['response_xml'] ) ? $params ['response_xml'] : '';
			
			if ($cdr->insert ()) {
			} else {
				bmCommon::logFile ( $params ['msisdn'] . '|' . $params ['cmd'] . '|' . $params ['packageId'] . '|' . $params ['price'] . '|' . $params ['obj1_id'] . "|" . var_export ( $cdr->getErrors (), true ), 'CDR_FAILED', $params ['cmd'] );
			}
		} catch ( Exception $e ) {
			//Log error
			$logger = new KLogger("ERROR_TRANS", KLogger::INFO);
			$logger->LogError("Exception save log_cdr: {$params ['msisdn']}|{$params ['cmd']}|".$e->getMessage ());
		}
	}
	
	public static function _processCharging($msisdn, $mainCredit, $cmd,$options = array()) {
		self::init();
		
		/*DEBUG AT LOCAL*/
		/*if(Yii::app()->params['local_mode']){
			$return['errorCode'] = 0;
			$return['errorDesc'] = 'Success';
			$return["timeRequest"] = date("Y-m-d H:i:s");
			return $return;
		}*/
        if ($mainCredit > 0) {
            if (self::isUserVip ( $msisdn)) {
                $mainCredit = 0;
            }
        }

		/* Chi goi charging khi price >0 */
		if($mainCredit==0){
			$return['errorCode'] = 0;
			$return['errorDesc'] = 'Success';
//			$return["timeRequest"] = date("Y-m-d H:i:s");
            $return["timeRequest"] = $options['createdDatetime'];
			return $return;
		}
		/*check blacklist mobifone*/
		$blacklist_phone = BlacklistModel::model()->checkBlacklist($msisdn);
        if($blacklist_phone){
            $return['errorCode'] = 201;
            $return['errorDesc'] = 'backlist charging mobifone';
            $return["timeRequest"] = date("Y-m-d H:i:s");
            return $return;
        }
		
		$return['errorCode'] = 1;
		$return['errorDesc'] = 'None';
		$msisdn = Formatter::formatPhone($msisdn);
		$packageCode = isset($options["packageCode"])?$options["packageCode"]:"";
		$contentId  = isset($options["contentId"])?$options["contentId"]:"1";
		$contentId = str_pad($contentId, 10, "0", STR_PAD_LEFT);
		$categoryId  = isset($options["categoryId"])?$options["categoryId"]:"1";
		$categoryId = ($categoryId>0)?$categoryId:1;
		$categoryId = str_pad($categoryId, 6, "0", STR_PAD_LEFT);
		if(isset($options["action"])){
			$cmd = $options["action"];
		}
		try {
			$client = new SoapClient(Yii::app()->params["charging_proxy"]["url"]);

			$params = array(
					"username"=> Yii::app()->params["charging_proxy"]["username"],
					"password"=> Yii::app()->params["charging_proxy"]["password"],
					"msisdn"=> $msisdn,
					"action"=> $cmd,
					"amount"=> $mainCredit,
					"contentid"=> "0000000001",
					"categoryid"=> $categoryId,
					"packageid"=> $packageCode,
			);
			$ret = $client->__soapCall('chargingRequest', array($params));
			$ret = $ret->return;
			if($ret->errorCode=="CPS-0000"){
				$return['errorCode'] = 0;
			} elseif ($ret->errorCode=="CPS_1007"){//thue bao da cat huy
                //gap loi nay  Không retry gia hạn va Thực hiện hủy thuê bao
                $params = array(
                    'user_id' => 0,
                    'user_phone' => $msisdn,
                    'package' => $options["packageCode"],
                    'source' => 'cskh',
                    'note_event' => "CPS_1007",
                    'options'=>array('send_sms'=>0),
                );

                $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
                $client = new SoapClient($bmUrl, array('trace' => 1));
                $result = $client->__soapCall('userUnRegister', $params);

            }else{
				$return['errorCode'] = 1;
			}
			$return['errorDesc'] = $ret->return;
			$return['note'] = $ret->errorCode;
			$return["timeRequest"] = $ret->timeRequest;
			
		}catch (Exception $e){
			$return['errorCode'] = 201;
			$return['errorDesc'] = 'Exception on charging '.$e->getMessage();
			$return["timeRequest"] = date("Y-m-d H:i:s");
		}
		self::$_logger->LogInfo("Charing $msisdn|$cmd|$mainCredit|$packageCode=>".json_encode($return));
		
		return $return;		
	}
	
	public static  function formatPhone($msisdn) {
		if (preg_match('/^84/', $msisdn)) {
			return substr($msisdn, 2);
		}
		if (preg_match('/^0/', $msisdn)) {
			return substr($msisdn, 1);
		}
		return $msisdn;
	}
}