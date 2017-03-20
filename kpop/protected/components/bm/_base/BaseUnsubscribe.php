<?php
Yii::import('application.modules.gamification.models.*');
Yii::import('application.modules.gamification.models._base.*');

abstract class BaseUnsubscribe extends BaseBusiness {
	/**
	 * Description of BaseUnsubscribe
	 *
	 *
	 */
	protected $packageObj;

	public function doUnsubscribe() {
		$ret = $this->_prepare(); 
		if ($ret['error'] == 0) {
			//update status for user_phone
			try {
				$chargeResult = $this->charging();
				if($chargeResult['ERROR'] == 0){

                    $unsub = $this->userSubscribe->unRegister($this->params['packageId']);
					$this->userSubscribe->update();
					
					//Huy freedata
					$category_id =  str_pad($this->params['packageId'], 6, "0", STR_PAD_LEFT);
					$subSync = SubSyncData::getInstance()->delete($this->params['msisdn'], $category_id);

					$this->result['error'] = 0;
					$this->result['message'] = 'success_'.  strtolower($this->packageObj->code);
					
                    $this->_success();
                    return $this->result;
                }
			}catch (Exception $e){
				$this->result['error'] = 0;
				$this->result['message'] = 'exception:'.$e->getMessage();
				return $this->result;
			}
		}
        $this->_error();
        return $this->result;
	}

    /**
     * goi Charging
     */
    private function  charging(){
        $this->params['reason'] = 'UNREG_'.$this->packageObj->code;
		
        $this->params['price'] = $this->params['originPrice'] = $this->params['promotion'] = 0;
        $this->params['charge_note'] = 'unsubscribe';

        $return = Transaction::doChargeSubscribe($this->params);
        return $return;
    }

    /**
	 * Check param then
	 * Check phone exist
	 * @return 0 if success, others if not
	 */
	private function  _prepare() {
		//prepare params for execute
		$createdTime = date("Y-m-d H:i:s",time());
        if(isset($this->params['client_options']['createdDatetime'])){
            $createdTime = $this->params['client_options']['createdDatetime'];
        }
		$this->params['createdDatetime'] = $createdTime;
		$this->params['cmd'] = Yii::app()->params['cmd.unsubscribe'];
		$this->params['obj2_name'] = $this->params['msisdn'];
		$this->params['note'] = "";

		// send sms or not, default is send
		$this->params['send_sms'] = 1;
		if(isset($this->params['client_options']['send_sms'])) $this->params['send_sms'] = ($this->params['client_options']['send_sms'] == 1)?1:0;

		 if (!(($this->params['msisdn']) && (isset($this->params['source'])))){
            $this->result['error'] = 1;
            $this->result['message'] = 'invalid_params';
            return $this->result;
        }

		// package
        // Mac dinh la huy goi cuoc dang active
        $this->packageObj = BmPackageModel::model()->getById($this->userSubscribe->package_id);
        
		if(!$this->packageObj || empty($this->userSubscribe)) {
			$this->result['error'] = 2;
			$this->result['message'] = 'subscribe_user_not_exist';
			$this->params['obj1_name'] = $this->result['message'];
			//add log
			self::addLog($this->params);
			return $this->result;
		}


        $this->params['obj1_id'] = $this->packageObj->id;
        $this->params['obj1_name'] = $this->packageObj->code;
        $this->params['user_id'] = $this->userSubscribe->user_id;
        $this->params['packageId'] =  $this->packageObj->id;
		$this->params['note'] = $this->userSubscribe->event;
		self::addLog($this->params);
		$this->result['error'] = 0;
		$this->result['message'] = 'success';
		return $this->result;

	}
	/**
	 * Update Activity
	 */
	private function _success() {
		//send SMS here
		$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();

	 if ($this->params['send_sms'] == 1){
			if (isset(Yii::app()->params['unsubscribe'][$this->result['message']])){
                $content = Yii::app()->params['unsubscribe'][$this->result['message']]; // get Message by errorCode
            }else{
            	$content = Yii::app()->params['unsubscribe']['default'];
            }
            SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
         $list_phone = Yii::app()->params['ctkm']['phone_check'];
         if(in_array($this->params['msisdn'], $list_phone)){


             $loger = new KLogger('UNREG_TEST', KLogger::INFO);
             $loger->LogInfo('test');
             $user = GUserModel::model()->findByAttributes(array('user_phone'=>$this->params['msisdn']));

             $loger->LogInfo('user :' . json_encode($user), false);
             //$content_km = Yii::t('bm',Yii::app()->params['ctkm_sms']['sms_unsubcribe'],array(':POINT'=>$user->point));
             //SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content_km);
         }
		}

	}
	/**
	 * Log error
	 */
	private function _error(){
		//send SMS here
		$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();

		if ($this->params['send_sms'] == 1){

			if (isset(Yii::app()->params['unsubscribe'][$this->result['message']])){
                $content = Yii::app()->params['unsubscribe'][$this->result['message']]; // get Message by errorCode
            }else{
            	$content = Yii::app()->params['unsubscribe']['error_default'];
            }
            if($this->params['source']!='wap'){
            	SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
            }
		}
    }
	public static function addLog($params) {
    	try {
			//log Db
			BmUserActivityModel::model()->add($params);
		} catch (Exception $e){
			//add log file
			bmCommon::logFile($params['msisdn'].'-'.$e->getMessage(),'userActivity', 'unsubscribe');
		}
	}
}