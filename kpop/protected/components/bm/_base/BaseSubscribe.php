<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseSubscribe
 *
 * @author tienbm
 */
abstract class BaseSubscribe extends BaseBusiness {
	protected $packageObj;
	protected $chargeResult;

	public function doSubscribe() {
		$result = $this->_prepare(); 
		if ($result['error'] == 0 || $result['error']=='0'){  // errorCode = 0
			$doBiz = $this->_doBiz();			
			if ($doBiz['error'] == 0){  //errorCode = 0
				$this->_success();
				return $this->result;
			}
		}
		$this->_error();
		return $this->result;

	}

	/**
	 * Check param then
	 * Get package, price, quota
	 * Define Business
	 * @return 0 if success, others if not
	 */
	private function  _prepare() {
		$createdTime = date("Y-m-d H:i:s",time());
		$this->params['createdDatetime'] = $createdTime;
		$this->params['cmd'] = Yii::app()->params['cmd.subscribe'];
		$this->params['obj2_name'] = $this->params['msisdn'];

		// send sms or not, default is send
		$this->params['send_sms'] = 1;
		if(isset($this->params['client_options']['send_sms'])) $this->params['send_sms'] = ($this->params['client_options']['send_sms'] == 1)?1:0;

		//return ERROR if params invalided
		if (!(($this->params['msisdn']) && ($this->params['itemCode']) && (isset($this->params['source'])))){
			$this->result = array('error'=>1,'message'=>'invalid_params');
			return $this->result;
		}
        //check blacklist phone
        $blacklist = BlacklistModel::model()->checkBlacklist($this->params['msisdn']);
        if($blacklist){
            $this->result = array('error'=>4,'message'=>'blacklist_phone');
            return $this->result;
        }
		//get Package
		$packCode = $this->params['itemCode'];
		try {
			$this->packageObj = PackageModel::model()->findByAttributes(array("code"=>$packCode,"status"=>1));
		}catch (Exception $e){
			$this->result = array('error'=>500,'message'=>'exception '.$e->getMessage());
			return $this->result;
		}
		
		//check if package existed
		if ($this->packageObj) {
			$this->result =  $this->defineBiz();  //0 if success
			$this->params['obj1_name'] = ($this->result['error']==0)?$this->packageObj->code:$this->result['error'].$this->result['message'];
		}else {
			$this->result = array('error'=>2,'message'=>'package_not_exist');
			$this->params['obj1_name'] = $this->result['message'];
		}
		
		if($this->result["error"] != 0){
			return $this->result;
		}

        //CHECK KM
		//gọi từ promotion mobibonus thì luon tru tien
		$mobibonus = isset($this->params['client_options']['charge']) ? $this->params['client_options']['charge'] : 0;
        if((!$this->params['promotion']) && ($mobibonus == 0)) {
			if(empty($this->params['client_options']['ncycle'])){//neu goi tu kmtq thi k check promotion
				$this->params['promotion'] = $this->check_promotion($this->params['msisdn']);
				if($this->params['promotion']){
				    if($this->params['itemCode'] == 'A30') $day = 7;
                    else $day = 5;
                    $this->params['charge_note'] = "PROMOTION";
					$this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), $day);
				}
			}
        }else{
			//mobibonus luon goi qua day
			//check cho truong hop la update
			$free_day = isset($this->params['client_options']['free_day']) ? $this->params['client_options']['free_day'] : 0;
			if($free_day == 1){
				$this->params['promotion_big'] = $this->check_promotion_big($this->params['msisdn']);
				if($this->params['promotion_big']){
					$this->params['price'] = 0;
					$this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), $free_day);
				}
			}

		}
        if($this->params['note'] == 'VOICE_BROADCAST'){
            $check_promotion_note = UserTransactionModel::model()->check_promotion_note($this->params['msisdn'], 'VOICE_BROADCAST');
            if($check_promotion_note){
                $this->params['price'] = 0;
                $this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), 1);
                $this->params['sms_voice_broad_cast'] = 1;
            }
        }

        if($this->params['note'] == 'KMTQ_2017'){
            $ncycle = (int) $this->params['client_options']['ncycle'];
            $this->params['price'] = 0;
            $this->params['expired_time'] = bmCommon::nextDays(date('Y-m-d H:i:s'), $ncycle);
            $this->params['sms_kmtq'] = 1;
            $this->params['send_sms'] = 1;
        }
        //END CHECK KM
        
        // Dang ky FREE DATA = ngay het han + 45day
        
        $stopDate = date("d/m/Y H:i:s",strtotime($this->params['expired_time']) + 45*24*60*60);
        $category_id =  str_pad($this->packageObj->id, 6, "0", STR_PAD_LEFT);
        $subSync = SubSyncData::getInstance()->create($this->params['msisdn'], $stopDate, $category_id);
        if($subSync['errorCode'] != '0'){
        	$this->result = array('error'=>103,'message'=>'fail_feedata');
        }
        //END FREE DATA
        if($this->params['msisdn'] == '841262346571'){
            $this->result = array('error'=>0,'message'=>'success');
        }
		//save activity
		/* try {
			//log Db
			BmUserActivityModel::model()->add($this->params);
		} catch (Exception $e){
			//add log file
			$userPhone 	= $this->params['msisdn'] ;
			$action 	= $this->params['cmd'];
			$type		= "SUBSCRIBE";
			bmCommon::logFile('['.$userPhone.']['.$action.']['.$this->result['error'].']','userActivity',$type);
		}
 		*/
		return $this->result;
	}

	/**
	 * Charging and Update User_subscribe
	 * @return type
	 */
	private function _doBiz() {
		$this->params['cmd'] 		= 'subscribe';
		$this->params['contentId']  = $this->packageObj->id;
		$this->params['description']= $this->packageObj->code;
		//set for add user

		$pass = bmCommon::randomPassword();
		$this->params['username'] = $this->params['msisdn'];
		$this->params['password'] = $pass['encoderPass'];
		$this->params['realPass'] = $pass['realPass'];
		$this->params['new_user'] = 0;
		//start transaction (update memcached)
		
		if ($this->_startTransaction()) {
			$chargeResult = Transaction::doChargeSubscribe($this->params);
			$this->chargeResult = $chargeResult;
			
			
			if ($chargeResult['ERROR'] == 0){
                $this->result = array('error'=>0,'message'=>'success_'.strtolower($this->packageObj->code));
				//start transaction
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$checkUser = BmUserModel::model()->checkUserPhone($this->params['msisdn']);
					$userSub = BmUserSubscribeModel::model()->getByPhone($this->params['msisdn']);

					if(!$this->params['event']) $this->params['event'] = $chargeResult['NOTE'];

					if (!$checkUser)
					{
						$this->params['new_user'] = 1;
						$user = BmUserModel::model()->add($this->params);
						$this->params['user_id'] = $user->id;
						BmUserSubscribeModel::model()->register($this->params, $userSub);
					}
					else
					{
						$this->params['user_id'] = $checkUser->id;
						BmUserSubscribeModel::model()->register($this->params, $userSub);
					}
					
					//Gui lai SMS password khi dang ky lan dau
					if($this->params['new_user'] == 1){
						UserModel::model()->updateCustom($this->params['user_id'],array('password' => $this->params['password']));
					}					
					
					if ($this->params['promotion'] == 1 || $chargeResult['PROMOTION'] == 1)
					{
						$this->result['message'] =  'success_km_'.strtolower($this->packageObj->code);
						$this->log_promotion($this->params['msisdn']);
						
						//Truong hop dc KM chu ky cuoc dau -> update lai truong notify_sms
						if(empty($userSub)){
							$userSub = BmUserSubscribeModel::model()->getByPhone($this->params['msisdn']);
						}
						$userSub->notify_sms = 1;
						$userSub->update();
					}
					if ($this->params['promotion_big'] == 1){
						$this->result['message'] =  'success_km_big';
						$this->log_promotion($this->params['msisdn']);
					}
					if (isset($this->params['kmtq']) && $this->params['kmtq'] == 1){
						$this->result['message'] =  'success_kmtq';
						//update notify_sms = 1; gui tn cho tap thue bao kmtq
						$userSub = BmUserSubscribeModel::model()->getByPhone($this->params['msisdn']);
						$userSub->notify_sms = 1;
						$userSub->update();
					}

					$params = array();
					$params['msisdn']       = $this->params['msisdn'];
					$params['action']       = "subscribe";
					$params['expired_time'] = date("d/m/Y H:i:s", strtotime($userSub->expired_time)); 
					
					$params['price']        = $this->params ['price'];
					$params['package_code'] = $this->packageObj->code;
					$params['channel_type'] = strtoupper($this->params["source"]);
					
					$transaction->commit();
				} catch (Exception $e){
					$contentLog = $e->getMessage(); //must log file
					$this->result['error'] = 500;
					$this->result['message'] = 'update_subscribe_user_failed'; //must log file
					bmCommon::logFile($this->params['msisdn'].'-'.$this->result['message'].'-'.$contentLog ,'userSubscribe','subscribe');
					$transaction->rollback();
				}
			} else {
				//Huy freedata
				$category_id =  str_pad($this->packageObj->id, 6, "0", STR_PAD_LEFT);
				$subSync = SubSyncData::getInstance()->delete($this->params['msisdn'], $category_id);
				
				if ($chargeResult['ERROR'] == 1){
					$this->result = array('error'=>11,'message'=>'balance_too_low_'.strtolower($this->packageObj->code));
				} else{
					$this->result = array('error'=>$chargeResult['ERROR'],'message'=>$chargeResult['ERROR_DESC']);
				} 
			}

			//finish transaction
			$this->_finishTransaction();
		}else {
			$this->result = array('error'=>102,'message'=>'transaction_forbidden');
		}
		return $this->result;
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


	private function _success() {
		//send SMS here		

		$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
		if ($this->params['send_sms'] == 1){
			//set for send MT
			/*$content = Yii::app()->params['subscribe'][$this->result['message']];
			SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);*/
            //set for send MT
            $sms_voice_broad_cast = isset( $this->params['sms_voice_broad_cast']) ? $this->params['sms_voice_broad_cast'] : 0;
            if($sms_voice_broad_cast == 1){
                $content = Yii::app()->params['subscribe']['voice_broadcast'];
            }else{
                $sms_kmtq = isset( $this->params['sms_kmtq']) ? $this->params['sms_kmtq'] : 0;
                if($sms_kmtq == 1){
                    $content = Yii::app()->params['subscribe']['sms_kmtq'];
                }else{
                    $content = Yii::app()->params['subscribe'][$this->result['message']];
                }
            }
            SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
		}
		
		if ($this->params['new_user'] == 1){
			$content = Yii::t('bm',Yii::app()->params['subscribe']['success_send_password'],array(':PHONE'=>$this->params['msisdn'], ':PASS'=>$this->params['realPass']));
			SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
		}
        /*        if(strtoupper($this->packageObj->code) == 'A1'){
                    $point = 2000;
                    $content_km = Yii::t('bm',Yii::app()->params['ctkm_sms']['subscribe_firstime'],array(':POINT'=>$point));
                    SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content_km);
                }
                if(strtoupper($this->packageObj->code) == 'A7'){
                    $point = 7000;
                    $content_km = Yii::t('bm',Yii::app()->params['ctkm_sms']['subscribe_firstime'],array(':POINT'=>$point));
                    SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content_km);
                }*/

	}

	/**
	 * Log error
	 */
	private function _error(){
		
		//send SMS here
		$smsId 			= (isset($this->params['smsId']) && $this->params['smsId']!="")?$this->params['smsId']:time();
		if (($this->params['send_sms'] == 1) && $this->result['message'] != 'invalid_params' && $this->params['source']!='wap'){
			if(isset(Yii::app()->params['subscribe'][$this->result['message']])){
				if(isset(Yii::app()->params['subscribe'][$this->result['message']])){
					$content = Yii::app()->params['subscribe'][$this->result['message']];
					$content = str_replace(":EXPIRED", date("d/m/Y",strtotime($this->userSubscribe->expired_time)), $content);
				}else{
					$content = Yii::app()->params['subscribe']["default"];
				}
			}else{
				$content = Yii::app()->params['subscribe']["default"];
			}
			if($this->result['error'] == 3){
				if(!empty($this->userSubscribe)){
					$content = str_replace(":EXPIRED", date("d/m/Y",strtotime($this->userSubscribe->expired_time)), $content);
				}else{
					$content = Yii::app()->params['subscribe']["duplicate_package"];
				}	
			}
			SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
		}elseif ($this->result['error'] == 4){
            $content = Yii::app()->params['subscribe']["blacklist_phone"];
            SmsClient::getInstance()->sentSmsText($this->params['msisdn'], $content, $smsId);
        }

	}
	private function getUserSubscribe($phone)
	{
		$currDate = date('Y-m-d H:i:s');
		return  UserSubscribeModel::model()->find( array(
				'condition'=>'user_phone = :PHONE AND status=:STATUS AND expired_time < :CURRDATE',
				'params'=>array(
						':PHONE'=>$phone,
						':STATUS'=>UserSubscribeModel::ACTIVE,
						':CURRDATE'=>$currDate,
				),
				'order'=>'id desc'
		));
	}
	private function check_promotion($phone)
	{
		$sql = "SELECT *
	        	FROM user_subscribe_km
	        	WHERE phone = '{$phone}'
        		AND (type = 0 OR (type = 1 AND created_time >= date_sub(NOW(), interval 2160 hour)))
        		";

		$subscribe = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($subscribe)){
			return false;
		}
		return true;
	}

	private function log_promotion($phone)
	{
	 try
	 {
	 	$sql = "SELECT * FROM user_subscribe_km WHERE phone = '{$phone}'";
	 	$data =   Yii::app()->db->createCommand($sql)->queryAll();
	 	if(empty($data)){
	 		Yii::app()->db->createCommand()->insert('user_subscribe_km',array(
                        			'phone'=>$phone,
                        			'created_time'=> new CDbExpression("NOW()"),
                        			'type' => 1
	 		));
	 	}else{
	 		Yii::app()->db->createCommand()->update('user_subscribe_km', array(
	                        		'created_time'=> new CDbExpression("NOW()"),
	 		),'id='.$data[0]['id']
	 		);
	 	}
	 }
	 catch (Exception $e)
	 {
	 	bmCommon::logFile($this->params['msisdn'].'-'.$e->getMessage(),'userSubscribe','subscribe');
	 }

	}

	private function check_promotion_big($phone)
	{
		$sql = "SELECT * FROM user_transaction WHERE user_phone = '{$phone}' AND note like '%BIGTET_2016%' AND `transaction` = 'subscribe' AND return_code = 0";
		$subscribe = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($subscribe)){
			return false;
		}
		return true;
	}


}
