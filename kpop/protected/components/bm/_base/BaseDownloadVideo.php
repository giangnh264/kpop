<?php
abstract class BaseDownloadVideo extends BaseBusiness {
	protected $videoObj;
	public function doDownloadVideo() {
		if ($this->_prepare() == 'success') {  
			if ($this->_doBiz() == 'success') {  
				$this->_success();
				return $this->result;
			}
		}
		$this->_error();
		return $this->result;
	}
	/**
	 * Check param then
	 * Get song, price, quota
	 * Define Business
	 * @return 0 if success, others if not
	 */
	private function  _prepare() {

		//set Params for execute
		$this->params['cmd'] = Yii::app()->params['cmd.video.download'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction
		/*if ($this->params['source'] != 'web' && $this->params['source'] != 'sms' && $this->params['source'] != 'wap')
        {
            $this->params['send_sms'] = "not_send";
        }*/
		$this->params['send_sms'] = "not_send";
		//return ERROR if params invalided
		if (!(($this->params['msisdn']) &&
              ($this->params['itemCode']) &&     //Code
              (isset($this->params['source'])))
           	){
            $this->result['error'] = 'invalid_params';                                  
            return $this->result['error'];
        }   

        
		//get Video Object
		$this->videoObj = BmVideoModel::model()->getVideoByCode($this->params['itemCode']);
		if ($this->videoObj) {
			$this->result['error'] =  $this->defineBiz();  
		}else {
			$this->result['error'] = 'video_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error'];
		}
        bmCommon::logFile('['.$this->params['msisdn'].'][download video]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']','userActivity','download');
		//save activity
		try {
            //log Db
            BmUserActivityModel::model()->add($this->params);
        }
        catch (Exception $e)
        {
            //add log file
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'download_video');
        }	
		return $this->result['error'];

	}
    
    /**
     * Charging and Update User_subscribe
     * @return type 
     */
    private function _doBiz() {
        
        //start transaction (update memcached)
        if ($this->_startTransaction()) {
        
            $this->result['error'] = Transaction::doChargeContent($this->params);
			
            //finish transaction
            $this->_finishTransaction();
        }else {
            $this->result['error'] = 'transaction_forbidden';            
        }
        
        return $this->result['error'];
        
    }
	/**
	 * Create new transaction in memcached if last not exist
	 *
	 */
	private function _startTransaction(){
		return 1;
	}

	/**
	 * Reset transaction in memcached if Register Success or Charging Fail
	 *
	 */
	private function _finishTransaction(){
		 
	}
    
	/**
	 * Update Activity
	 */
	private function _success() {
		
		if (!isset($this->params['send_sms'])){
			if($this->params['msisdn'] != $this->params['to_phone']) {
				 //send video
				 $content     = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendVideo']['content'], array('{FROMPHONE}'=>$this->params['msisdn'], '{VIDEO_ID}'=>$this->videoObj->id, '{VIDEO_NAME}'=>$this->videoObj->name));
				 //$description = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendVideo']['desc'], array('{FROMPHONE}'=>$this->params['msisdn'], '{VIDEO_NAME}'=>$this->videoObj->name));
			} else { //download video
				$content	 = Yii::t('bm',Yii::app()->params['sms.messageMT']['downloadVideo']['content'], array('{VIDEO_NAME}'=>$this->videoObj->name, '{VIDEO_ID}'=>$this->videoObj->id));
				//$description = Yii::t('bm',Yii::app()->params['sms.messageMT']['downloadVideo']['desc'], array('{VIDEO_NAME}'=>$this->videoObj->name));
			}
			
			//set for send MT
    		$serviceNumber  = Yii::app()->params['sms.sendMT']['serviceNumber'];
    		$receiver 		= ($this->params['msisdn'] != $this->params['to_phone'])? $this->params['to_phone']: $this->params['msisdn'];
			$receiver 		=  bmCommon::formatMSISDN($receiver);
			$msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
			$charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
			$description 	= '';
			$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
			$smsc	= Yii::app()->params['sms.sendMT']['serviceNumber'];
			
			$smsClient = new SmsClient();
	 		$smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);
            bmCommon::logFile($ret,'sendMT','download_video');
            if ($this->params['msisdn'] != $this->params['to_phone'])
            {
                $receiver 		=  $this->params['msisdn'];
                $msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
                $charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
                $description 	= '';
                $smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
                $content = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendVideoSuccess']['content'], array('{TOPHONE}'=>$this->params['to_phone']));
                $smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);
            }
		}        
	}

	/**
	 * Log error
	 */
	private function _error(){
	//error here
		if (!isset($this->params['send_sms']) && $this->result['error'] != 'invalid_params'){
			
			if (isset(Yii::app()->params['downloadVideo'][$this->result['error']])){
                $content = Yii::app()->params['downloadVideo'][$this->result['error']]; // get Message by errorCode
            }else{
            	$content = Yii::app()->params['downloadVideo']['default'];
            }
        	//set for send MT
			$serviceNumber  = Yii::app()->params['sms.sendMT']['serviceNumber'];
			$receiver 		=  bmCommon::formatMSISDN($this->params['msisdn']);
			$msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
			$charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
			$description 	= "";
			$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
			$smsc	= Yii::app()->params['sms.sendMT']['serviceNumber'];
			
			$smsClient = new SmsClient();
	 		$smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);
		
		}
	}
}