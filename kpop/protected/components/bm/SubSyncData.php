<?php
class SubSyncData
{
	private static $_logger = null;
	private static $_config;
	private static $_session;
		
	protected static $_instance = null;
	
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct()
	{
		/* self::$_config = array(
				'url'=>'http://10.50.9.60:18088',
				'user'=>'Amusic',
				'pass'=>'Amusic@123',
				'cp_id'=>'001',				
				'sp_id'=>'001',		
				'shortcode'=>'049166',		
				'service_name'=>'SOG_AMUSIC',
				'content_id' => "0000000001",
		); */
		self::$_config = Yii::app()->params["freedata"];
		
		if(!self::$_logger){
			self::$_logger = new KLogger("SUB_SYNC_DATA", KLogger::INFO);
		}
	}
	
	/**
	 * @Description: Đăng ký freedata cho 1 TB
	 * @param type string $userPhone
	 * @param type string $stopDate //format: d/m/Y H:i:s
	 * @param type string $category_id
	 * @return array
	 */
	public function create($userPhone, $stopDate, $category_id)
	{
        return $return = array(
            'errorCode'	=> 0,
            'message'	=> 'success',
        );
		$return = array(
				'errorCode'	=> 505,
				'message'	=> 'Unknow error',
		);
		$userPhone = Formatter::removePrefixPhone($userPhone);
		$userPhone = substr($userPhone,1);
		$sessionID = $this->_login();
		
		$xmlReg = "<!DOCTYPE cp_request SYSTEM \"cp_req_websvr.dtd\">
					<?xml version='1.0' encoding='UTF-8'?>
					<cp_request>
					       <session>:SESSION_ID</session>
					       <cp_id>".self::$_config["user"]."</cp_id>
					       <cp_transaction_id>".self::$_config["user"]."</cp_transaction_id>
					       <transaction_description>".self::$_config["user"]."</transaction_description>
					       <op_transaction_id></op_transaction_id>
					       <application>5</application>
					       <action>0</action>
					       <user_id type=\"MSISDN\">".$userPhone."</user_id>
					       <srofgref>".self::$_config["service_name"]."</srofgref>
					       <stopdat>".$stopDate."</stopdat>
				       	   <spid>".self::$_config["sp_id"]."</spid>
						   <cpid>".self::$_config["cp_id"]."</cpid>
						   <categoryid>".$category_id."</categoryid>
						   <contentid>".self::$_config["content_id"]."</contentid>
						   <shortcode>".self::$_config["shortcode"]."</shortcode>
						   <b_isdn></b_isdn>
					</cp_request>";
		
		$xml = str_replace(":SESSION_ID", $sessionID, $xmlReg);
		$reps = $this->_postUrl($xml);
		
		$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
		$repsData = ArrayHelper::xml2array($reps);
		$repStatus = 1404;
		
		if(empty($repsData)){
			self::log("REQUEST: {$userPhone} - SUBSCRIBE NO RESPONSE");
			return $return = array(
					'errorCode'	=> $repStatus,
					'message'	=> 'No response',
			);
		}
		
		$msg = "REQUEST: {$userPhone} - StopDate $stopDate - SUBSCRIBE RESPONSE: ".$repsData["cp_reply"]["result"];
		if(isset($repsData["cp_reply"]["error"])){
			$msg .= " - Des: ".$repsData["cp_reply"]["error"];
		}
		self::log($msg);
		
		if($repsData["cp_reply"]["result"] == "CPS-2011"){
			// Gap loi 2011 Login va requet lai
			self::log("Try Login");
			$sessionID = $this->_login(true); // Try login
			$xml = str_replace(":SESSION_ID", $sessionID, $xmlReg);
			$reps = $this->_postUrl($xml);
			$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
			$repsData = ArrayHelper::xml2array($reps);
			
			$msg = "TRY REQUEST: {$userPhone} - StopDate $stopDate - SUBSCRIBE RESPONSE: ".$repsData["cp_reply"]["result"];
			if(isset($repsData["cp_reply"]["error"])){
				$msg .= " - Des: ".$repsData["cp_reply"]["error"];
			}
			self::log($msg);
			
			if(empty($repsData)){
				self::log("TRY REQUEST: {$userPhone} - SUBSCRIBE NO RESPONSE");
				return $return = array(
					'errorCode'	=> $repStatus,
					'message'	=> 'No response',
				);
			}
		}
		
		// Thanh cong
		if(isset($repsData["cp_reply"]) && $repsData["cp_reply"]["result"] == '0'){
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		/**************************************************************
		 * TH: Đăng ký nhưng đã tồn tại bản ghi trên hệ thống CPS DATA
		 * Mã lỗi thường trả về: result: CPS-3000 error: SUBSCRIPTION MUST BE UNIQUE
		 * Xử lý như trường hợp đăng ký thành công
		 * Thay đổi stopdate theo stopdate mới truyền vào 
		 * ************************************************************/
		if($repsData["cp_reply"]["result"] == "CPS-3000" && trim($repsData["cp_reply"]["error"]) == "SUBSCRIPTION MUST BE UNIQUE" ){
			$ret = $this->update($userPhone, $stopDate, $category_id);
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		return $return = array(
				'errorCode'	=> $repsData["cp_reply"]["result"],
				'message'	=> $repsData["cp_reply"]["error"],
		);
	}
	
	/**
	 * @Description: Update freedata cho 1 TB
	 * @param type string $userPhone
	 * @param type string $stopDate //format: d/m/Y H:i:s
	 * @param type string $category_id
	 * @return array
	 */	
	public function update($userPhone, $stopDate, $category_id)
	{
		$return = array(
				'errorCode'	=> 505,
				'message'	=> 'Unknow error',
		);
		$userPhone = Formatter::removePrefixPhone($userPhone);
		$userPhone = substr($userPhone,1);
        try{
            self::log("BEGIN REQUEST: {$userPhone} ");
            $sessionID = $this->_login();

            $xmlChange = "<!DOCTYPE cp_request SYSTEM \"cp_req_websvr.dtd\"> 
						<?xml version='1.0' encoding='UTF-8'?>
						 <cp_request> 
							<session>:SESSION_ID</session>
							<cp_id>".self::$_config["user"]."</cp_id>
							<cp_transaction_id>".self::$_config["user"]."</cp_transaction_id>
					        <transaction_description>".self::$_config["user"]."</transaction_description>
							<op_transaction_id></op_transaction_id> 
							<application>5</application> 	
							<action>2</action> 
							<user_id type=\"MSISDN\">".$userPhone."</user_id>
							<srofgref>".self::$_config["service_name"]."</srofgref>
							<stopdat>".$stopDate."</stopdat>
							<spid>".self::$_config["sp_id"]."</spid>
						   <cpid>".self::$_config["cp_id"]."</cpid>
						   <categoryid>".$category_id."</categoryid>
						   <contentid>".self::$_config["content_id"]."</contentid>
						   <shortcode>".self::$_config["shortcode"]."</shortcode>
						   <b_isdn></b_isdn>
						 </cp_request>";

            $xml = str_replace(":SESSION_ID", $sessionID, $xmlChange);
            $reps = $this->_postUrl($xml);
            self::log("REQUEST: {$userPhone} " . json_encode($reps));
            $reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
            $repsData = ArrayHelper::xml2array($reps);
            $repStatus = 1404;
        }catch (Exception $ex){
            $repStatus = 1404;
            self::log("REQUEST: {$userPhone} " . json_encode($ex->getMessage()));
            return $return = array(
                'errorCode'	=> $repStatus,
                'message'	=> 'No response',
            );
        }

		
		if(empty($repsData)){
			self::log("REQUEST: {$userPhone} - EXTEND NO RESPONSE");
			return $return = array(
					'errorCode'	=> $repStatus,
					'message'	=> 'No response',
			);
		}
		
		$msg = "REQUEST: {$userPhone} - StopDate $stopDate - EXTEND RESPONSE: ".$repsData["cp_reply"]["result"];
		if(isset($repsData["cp_reply"]["error"])){
			$msg .= " - Des: ".$repsData["cp_reply"]["error"];
		}
		self::log($msg);
		
		// Gap loi 2011 Login va requet lai
		if($repsData["cp_reply"]["result"] == "CPS-2011"){
			self::log("Try Login");
			$sessionID = $this->_login(true); // Try login
			$xml = str_replace(":SESSION_ID", $sessionID, $xmlChange);
			$reps = $this->_postUrl($xml);
			$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
			$repsData = ArrayHelper::xml2array($reps);
				
			$msg = "TRY REQUEST: {$userPhone} - StopDate $stopDate - EXTEND RESPONSE: ".$repsData["cp_reply"]["result"];
			if(isset($repsData["cp_reply"]["error"])){
				$msg .= " - Des: ".$repsData["cp_reply"]["error"];
			}
			self::log($msg);
			
			if(empty($repsData)){
				self::log("TRY REQUEST: {$userPhone} - EXTEND NO RESPONSE");
				return $return = array(
						'errorCode'	=> $repStatus,
						'message'	=> 'No response',
				);
			}
		}
		
		// Thanh cong
		if(isset($repsData["cp_reply"]) && $repsData["cp_reply"]["result"] == '0'){
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		/**************************************************************
		* TH: UPDATE nhưng stopdate không đổi
		* Mã lỗi thường trả về: result: CPS-3000 error: AT LEAST ONE INPUT PARAMETER IS REQUIRED BY THIS METHOD
		* Xử lý như trường hợp đăng ký thành công		
		* ************************************************************/
		if($repsData["cp_reply"]["result"] == "CPS-3000" && trim($repsData["cp_reply"]["error"]) == "AT LEAST ONE INPUT PARAMETER IS REQUIRED BY THIS METHOD" ){
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		/**************************************************************
		 * TH: UPDATE nhưng thuê bao không tồn tại
		* Mã lỗi thường trả về: result: CPS-3000 error: SUBSCRIPTION NOT FOUND
		* Xử lý đăng ký lại cho thuê bao này và return success
		* ************************************************************/
		if($repsData["cp_reply"]["result"] == "CPS-3000" && trim($repsData["cp_reply"]["error"]) == "SUBSCRIPTION NOT FOUND" ){
			$this->create($userPhone, $stopDate, $category_id);			
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		
		
		return $return = array(
				'errorCode'	=> $repsData["cp_reply"]["result"],
				'message'	=> $repsData["cp_reply"]["error"],
		);		
	}
	
	/**
	 * @Description: Xóa freedata cho 1 TB
	 * @param type string $userPhone
	 * @param type string $category_id
	 * @return array
	 */
	
	public function delete($userPhone,$category_id)
	{
		$return = array(
				'errorCode'	=> 505,
				'message'	=> 'Unknow error',
		);
		$userPhone = Formatter::removePrefixPhone($userPhone);
		$userPhone = substr($userPhone,1);
		$sessionID = $this->_login();
		
		$xmUnreg = "<!DOCTYPE cp_request SYSTEM \"cp_req_websvr.dtd\">
					<?xml version='1.0' encoding='UTF-8'?>
					<cp_request>
					       <session>:SESSION_ID</session>
					       <cp_id>".self::$_config["user"]."</cp_id>
					       <cp_transaction_id>".self::$_config["user"]."</cp_transaction_id>
					       <transaction_description>".self::$_config["user"]."</transaction_description>
					       <op_transaction_id></op_transaction_id>
					       <application>5</application>
					       <action>1</action>
					       <user_id type=\"MSISDN\">".$userPhone."</user_id>
					       <srofgref>".self::$_config["service_name"]."</srofgref>
				       	   <spid>".self::$_config["sp_id"]."</spid>
						   <cpid>".self::$_config["cp_id"]."</cpid>
						   <categoryid>".$category_id."</categoryid>
						   <contentid>".self::$_config["content_id"]."</contentid>
						   <shortcode>".self::$_config["shortcode"]."</shortcode>
						   <b_isdn></b_isdn>
					</cp_request>";
		
		$xml = str_replace(":SESSION_ID", $sessionID, $xmUnreg);
		$reps = $this->_postUrl($xml);
		
		$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
		$repsData = ArrayHelper::xml2array($reps);
		$repStatus = 1404;
		
		if(empty($repsData)){
			self::log("REQUEST: {$userPhone} - UNSUB NO RESPONSE");
			return $return = array(
					'errorCode'	=> $repStatus,
					'message'	=> 'No response',
			);
		}
		
		$msg = "REQUEST: {$userPhone} - UNSUB RESPONSE: ".$repsData["cp_reply"]["result"];
		if(isset($repsData["cp_reply"]["error"])){
			$msg .= " - Des: ".$repsData["cp_reply"]["error"];
		}
		self::log($msg);
		
		// Gap loi 2011 Login va requet lai
		if($repsData["cp_reply"]["result"] == "CPS-2011"){
			self::log("Try Login");
			$sessionID = $this->_login(true); // Try login
			$xml = str_replace(":SESSION_ID", $sessionID, $xmUnreg);
			$reps = $this->_postUrl($xml);
			$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
			$repsData = ArrayHelper::xml2array($reps);

			$msg = "REQUEST: {$userPhone} - UNSUB RESPONSE: ".$repsData["cp_reply"]["result"];
			if(isset($repsData["cp_reply"]["error"])){
				$msg .= " - Des: ".$repsData["cp_reply"]["error"];
			}
			self::log($msg);
			
			if(empty($repsData)){
				self::log("TRY REQUEST: {$userPhone} - UNSUB NO RESPONSE");
				return $return = array(
						'errorCode'	=> $repStatus,
						'message'	=> 'No response',
				);
			}
		}
		
		// Thanh cong
		if(isset($repsData["cp_reply"]) && $repsData["cp_reply"]["result"] == '0'){
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		/**************************************************************
		* TH: UNSUB nhưng thuê bao không tồn tại
		* Mã lỗi thường trả về: result: CPS-3000 error: SUBSCRIPTION NOT FOUND
		* Xử lý như trường hợp đăng ký thành công		
		* ************************************************************/
		if($repsData["cp_reply"]["result"] == "CPS-3000" && trim($repsData["cp_reply"]["error"]) == "SUBSCRIPTION NOT FOUND" ){
			return $return = array(
					'errorCode'	=> 0,
					'message'	=> 'success',
			);
		}
		
		
		return $return = array(
				'errorCode'	=> $repsData["cp_reply"]["result"],
				'message'	=> $repsData["cp_reply"]["error"],
		);	
	}
	
	public function getStatus($userPhone)
	{
		$userPhone = Formatter::removePrefixPhone($userPhone);
		$userPhone = substr($userPhone,1);
		$sessionID = $this->_login();
		
		$xmlGet = "<!DOCTYPE cp_request SYSTEM \"cp_req_websvr.dtd\">
					<?xml version='1.0' encoding='UTF-8'?>
					 <cp_request>
						<session>:SESSION_ID</session>
				        <cp_id>".self::$_config["user"]."</cp_id>
				        <cp_transaction_id>".self::$_config["user"]."</cp_transaction_id>
				        <transaction_description>".self::$_config["user"]."</transaction_description>
				        <op_transaction_id></op_transaction_id>
						<application>5</application>
						<action>3</action>
						<user_id type=\"MSISDN\">".$userPhone."</user_id>
						<srofgref>".self::$_config["service_name"]."</srofgref>
						<spid>".self::$_config["sp_id"]."</spid>
					    <cpid>".self::$_config["cp_id"]."</cpid>
					    <categoryid>000001</categoryid>
					    <contentid>0000000001</contentid>
						<shortcode>".self::$_config["shortcode"]."</shortcode>
						<b_isdn></b_isdn>
						</cp_request>";
		
		$xml = str_replace(":SESSION_ID", $sessionID, $xmlGet);
		$reps = $this->_postUrl($xml);
		$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
		$repsData = ArrayHelper::xml2array($reps);
		
			// Gap loi 2011 Login va requet lai
		if($repsData["cp_reply"]["result"] == "CPS-2011"){
			self::log("Try Login");
			$sessionID = $this->_login(true); // Try login
			$xml = str_replace(":SESSION_ID", $sessionID, $xmlGet);
			$reps = $this->_postUrl($xml);
			$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
			$repsData = ArrayHelper::xml2array($reps);
		}
		
		
		
		return $repsData;
	}
	
	
	
	function _login($renew = false)
	{
		//Get session from file stogare
		$path = Yii::app()->getRuntimePath()."/sub_sync_data_session.txt";
		if(file_exists($path) && !$renew){
			$sessionID = file_get_contents($path);
			if(isset($sessionID) && $sessionID!="")
			return trim($sessionID);
		}	
			
		
		$xmlPost = "<cp_request>
					<login>".self::$_config["user"]."</login>
					<password>".self::$_config["pass"]."</password>
					<command>login</command>
					<session>0</session>
					</cp_request>";
		$reps = $this->_postUrl($xmlPost);				
		$reps = trim(str_replace('<!DOCTYPE cp_reply SYSTEM "cp_reply.dtd">', '', $reps));
		$repsData = ArrayHelper::xml2array($reps);
		if(!empty($repsData) && $repsData["cp_reply"]["result"]=="CPS-0000"){
			$sessionID =  $repsData["cp_reply"]["session"];
			file_put_contents($path, $sessionID);
			return $sessionID;
		}else{
			$response = json_encode($repsData);
			self::log("Cannot get Session from server. RESPONSE:$response");
			return false;
		}
		return false;
	}
	
	function _logout($sessionID)
	{
		$xmlPost = "<cp_request>
					<command>logout</command>
					<session>{$sessionID}</session>
					</cp_request>";
		$reps = $this->_postUrl($xmlPost);
	}
	
	function _postUrl($data){
		if(YII_DEBUG){
			self::log("REQUEST:".$data);
		}
	
		$url = self::$_config["url"];		
	    try{
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 3);
            curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $response  = curl_exec($curl);
            self::log("Curl Error" . json_encode(curl_error($curl)));
        }catch (Exception $ex){
            self::log("Exception" . json_encode($ex->getMessage()));
        }
		if(curl_errno( $curl )) {
		}else{
		}
		curl_close($curl);
	
		if(YII_DEBUG){
			self::log("RESPONSE:".$response);
		}
		return $response;
	}
	
	
	static function log($message,$level="INFO")
	{
		if(!self::$_logger){
			self::$_logger = new KLogger("SUB_SYNC_DATA", KLogger::INFO);
		}
		if($level == "ERROR"){
			self::$_logger->LogError($message);
		}else{
			self::$_logger->LogInfo($message);
		}
	}
}
