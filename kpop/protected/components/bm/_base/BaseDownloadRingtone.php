<?php
abstract class BaseDownloadRingtone extends BaseBusiness {

	protected $rtObj;
	public function doDownloadRingtone() {
		if ($this->_prepare() == 'success'){  // errorCode = 0
			if ($this->_doBiz() == 'success'){  //errorCode = 0
				$this->_success();
				return $this->result;
			}
		}
		$this->_error();
		return $this->result;
	}
	/**
	 * Check param then
	 * Get ringtone, price, quota
	 * Define Business
	 * @return 
	 */
	private function  _prepare() {

		//prepare params for execute
		$this->params['cmd'] = Yii::app()->params['cmd.ringtone.download'];
		$this->params['obj2_name'] = $this->params['to_phone'];
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime; //set time for log user_transaction
		if ($this->params['source'] != 'web' && $this->params['source'] != 'sms' && $this->params['source'] != 'wap' && $this->params['source'] != 'chachastar')
        {
            $this->params['send_sms'] = "not_send";
        }
		//check valid params
		if (!(($this->params['msisdn']) &&
              ($this->params['itemCode']) &&     //Code
              (isset($this->params['source'])))
           	){
            $this->result['error'] = 'invalid_params';
            return $this->result['error'];
        }

		//get Song Object by Code
		$this->rtObj = BmRingtoneModel::model()->getRingtoneByCode($this->params['itemCode']);
		if ($this->rtObj) {
			$this->result['error'] =  $this->defineBiz();

		}else {
			//prepare params to log
			$this->result['error'] = 'ringtone_not_exist';
			$this->params['obj1_name'] = '[code]['.$this->params['itemCode'].'] '.$this->result['error'];
		}
        bmCommon::logFile('['.$this->params['msisdn'].'][download ringtone]['.$this->params['obj1_name'].']['.$this->params['itemCode'].']'.$this->params['source'],'userActivity','download');
        //save activity
		try {
            //log Db
            BmUserActivityModel::model()->add($this->params);
        }
        catch (Exception $e)
        {
            //add log file
            bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userActivity', 'download_ringtone');
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
            $this->result['error'] = 'transaction_forbidden'; // TRANSACTION_FORBIDDEN
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
				 //send ringtone
				 $content  = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendRingtone']['content'], array('{FROMPHONE}'=>$this->params['msisdn'], '{RT_NAME}'=>$this->rtObj->name, '{RT_ID}'=>$this->rtObj->id));
			} else { //download ringtone
				$content	 = Yii::t('bm',Yii::app()->params['sms.messageMT']['downloadRingtone']['content'], array('{RT_NAME}'=>$this->rtObj->name, '{RT_ID}'=>$this->rtObj->id));
			}

			//set for send MT
    		$serviceNumber  = Yii::app()->params['sms.sendMT']['serviceNumber'];
    		$receiver 		= ($this->params['msisdn'] != $this->params['to_phone'])? $this->params['to_phone']: $this->params['msisdn'];
			$msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
			$charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
			$description = '';
            $smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
			$smsc	= Yii::app()->params['sms.sendMT']['serviceNumber'];

			$smsClient = new SmsClient();
            $ret = $smsClient->sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $smsc);

            if ($this->params['msisdn'] != $this->params['to_phone'])
            {
                $receiver 		=  $this->params['msisdn'];
                $msgType 		= Yii::app()->params['sms.sendMT']['text.smsType'];
                $charge 		= Yii::app()->params['sms.sendMT']['freeCharge'];
                $description 	= '';
                $smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
                $content = Yii::t('bm',Yii::app()->params['sms.messageMT']['sendRingtoneSuccess']['content'], array('{TOPHONE}'=>$this->params['to_phone']));
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

			if (isset(Yii::app()->params['downloadRingtone'][$this->result['error']])){
                $content = Yii::app()->params['downloadRingtone'][$this->result['error']]; // get Message by errorCode
            }else{
            	$content = Yii::app()->params['downloadRingtone']['default'];
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