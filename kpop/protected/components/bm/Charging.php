<?php
class Charging
{
	protected $originParams;
	
	function __construct($par) {
		$this->originParams = $par;
	}
	public function doCharg()
	{
		$return = new stdClass();
		$return->errorCode = -1;
		$return->message = "Unknown";
		
		//$params = json_decode(json_encode($this->originParams),true);// convert object to array
		$params = $this->originParams;
		 
		$otherParams = array(
				"action"=>$params["cmd"],
				"packageCode"=>$params['itemCode'],				
				"categoryId"=>$params['packageId'],
				"channel"=>$params["source"]
		);
		$result = Transaction::_processCharging($params ['msisdn'], $params ['price'], $params["cmd"],$otherParams);
		
		if($result['errorCode']==0 || $result['errorCode']=="0"){
			$return->errorCode = 0;
		}else{
			$return->errorCode = 1;
		}
		$return->message = $result['errorDesc'];
		$params['return_code'] = $return->errorCode;
		$params['errorDesc'] =  $result['errorDesc'];
		$params['note'] = isset($params['note'])?($params['note']."|".$result['errorCode']):$result['errorCode'];
		$params['note'] = substr($params['note'], 0,150);
		
		//Update vao DB theo request time
		$params["createdDatetime"] = isset($result["timeRequest"])?$result["timeRequest"]:date("Y-m-d H:i:s");
		
		// Log các giao dich thành công vào Log_CDR
		if ($return->errorCode == 0){
			Transaction::logCDR ( $params );
		}
		Transaction::logToTransaction ($params);
				
		return $return;
	}
}