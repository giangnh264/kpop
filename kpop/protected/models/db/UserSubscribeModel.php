<?php
class UserSubscribeModel extends BaseUserSubscribeModel
{
	const ACTIVE = 1;
	const EXPIRED = 0;
	const DELETE = 2;
	const PENDING = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function register($params, $us) {
		/* Them nguoi dung vao bang user, voi thong tin "suggested_list" */
		///UserModel::addUser($params["msisdn"]);
		$newPackage = true;
		if(isset($params['changePackage']) && ($params['changePackage'] == false)) {
			// giu nguyen package hien tai
		} else {	// thay doi package su dung
			if($us) {	// thue bao da ton tai
				// update thoi gian con lai cho package dang dung
				/* $usPackage = UserSubscribePackageModel::model()->findByPk(array('user_phone' => $params['msisdn'], 'package_id' => $us->package_id));
				if($usPackage) {
					$usPackage->source = $us->source;
					$usPackage->event = $us->event;
					$usPackage->duration = floor((strtotime($us->expired_time) - strtotime(date("Y-m-d")))/(24*60*60));
					$usPackage->update();

					$newPackage = false;
				} */

				// thay doi package
				$us->user_id 		= isset($params['user_id'])? $params['user_id']: '0'; //fix here
				$us->package_id 	= $params["packageId"];
				$us->bundle         = $params["bundle"];
				$us->updated_time 	= $params["createdDatetime"];
				//$us->extended_time 	= $params["createdDatetime"];
				$us->expired_time 	= $params["expired_time"];
				$us->source      	= ($params["source"])?$params["source"]:"";
				$us->event          = isset($params['event'])? $params['event']: '';
				$us->extended_retry_times = 0;
				$us->status 		= self::ACTIVE;
				$us->extended_count 	= 0;
				$us->last_action 	= "SUBSCRIBE";
				$us->last_subscribe_time 	= new CDbExpression("NOW()");

				$us->update();
			}
			else { //add new
					$sql = "INSERT INTO user_subscribe(user_id,user_phone,package_id,bundle,created_time,expired_time,updated_time,source,event,status,extended_count,last_action,last_subscribe_time)
							VALUE(:user_id,:user_phone,:package_id,:bundle,:created_time,:expired_time,:updated_time,:source,:event,1,0,'SUBSCRIBE',NOW())
							ON DUPLICATE KEY UPDATE expired_time=:expired_time,
													package_id=:package_id,
													source = :source,
													event=:event,
													extended_retry_times=0,
													status=1,
													last_action='SUBSCRIBE',
													last_subscribe_time = NOW()
							";

					$userId = isset($params['user_id'])? $params['user_id']: '0';
					$source = ($params["source"])?$params["source"]:"";
					$event  = isset($params['event'])? $params['event']: '';

					$command = Yii::app()->db->createCommand($sql);
					$command->bindParam(':user_id', $userId);
					$command->bindParam(':user_phone', $params["msisdn"], PDO::PARAM_STR);
					$command->bindParam(':package_id', $params["packageId"], PDO::PARAM_INT);
					$command->bindParam(':bundle', $params["bundle"]);
					$command->bindParam(':created_time', $params["createdDatetime"], PDO::PARAM_STR);
					//$command->bindParam(':extended_time', $params["createdDatetime"], PDO::PARAM_STR);
					$command->bindParam(':expired_time', $params["expired_time"], PDO::PARAM_STR);
					$command->bindParam(':updated_time', $params["createdDatetime"], PDO::PARAM_STR);
					$command->bindParam(':source', $source);
					$command->bindParam(':event', $event);
					$ret = $command->execute();
			}
		}

		// save to user_subscribe_package
		/* if($newPackage = true) {
			$usPackage = UserSubscribePackageModel::model()->findByPk(array('user_phone' => $params['msisdn'], 'package_id' => $params["packageId"]));
			if(!$usPackage) {
				$usPackage = new UserSubscribePackageModel();
				$usPackage->user_phone  	= $params["msisdn"];
				$usPackage->package_id  	= $params["packageId"];
			}
			$usPackage->bundle          = $params["bundle"];
			$usPackage->source      	= ($params["source"])?$params["source"]:"";
			$usPackage->event           = isset($params['event'])? $params['event']: '';
			$usPackage->duration		= floor((strtotime($params["expired_time"]) - strtotime(date("Y-m-d")))/(24*60*60));
			$usPackage->created_time 	= $params["createdDatetime"];
			$usPackage->status		 	= UserSubscribePackageModel::ACTIVE;
			$usPackage->save();
		} */
		
		// Luu vao bang user_sub_syncdata de goi api free data
		/* $sql = "INSERT INTO user_sub_syncdata (msisdn,action,package_id,expired_time,created_time,updated_time)
				VALUES (:MSISDN,'SUBSCRIBE',:PACK_ID,:EXPIRED, NOW(),NOW())";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(":MSISDN", $params["msisdn"], PDO::PARAM_STR);
		$command->bindParam(":PACK_ID", $params["packageId"], PDO::PARAM_INT);
		$command->bindParam(":EXPIRED", $params["expired_time"], PDO::PARAM_STR);
		$command->execute(); */
		
	}

	public function unRegister($packageId) {
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$unReg = UserSubscribePackageModel::model()->findByPk(array('user_phone' => $this->user_phone, 'package_id' => $packageId));
			if($unReg) {
				$unReg->status = UserSubscribePackageModel::INACTIVE;
				$unReg->update();
			}

			if($packageId == $this->package_id) {
				// thay the bang 1 goi cuoc khac da dang ky truoc do
				$cr = new CDbCriteria();
				$cr->alias = "t";
				$cr->join = "INNER JOIN package t2 ON t.package_id=t2.id";
				$cr->condition = "t.user_phone=:PHONE AND t.status=".UserSubscribePackageModel::ACTIVE." AND t2.status=".PackageModel::ACTIVE;
				$cr->order = "t2.sorder ASC";
				$cr->params = array(":PHONE" => $this->user_phone);
				$newPackage = UserSubscribePackageModel::model()->find($cr);
				if($newPackage) {
					$this->package_id = $newPackage->package_id;
					$this->bundle = $newPackage->bundle;
					$this->source = $newPackage->source;
					$this->event = $newPackage->event;
					//$this->expired_time = date_format(date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("{$newPackage->duration} days")), "Y-m-d H:i:s");
					$nextTime = date("Y-m-d H:i:s",(time() + ($newPackage->duration*24*60*60)));
					$this->expired_time = $nextTime;
				} else {
					$this->status = BmUserSubscribeModel::EXPIRED;
				}

				$this->updated_time = new CDbExpression("NOW()");
				$this->last_action 	= "UNSUBSCRIBE";
				$this->last_unsubscribe_time 		= new CDbExpression("NOW()");
				$this->notify_sms = 0;
				$this->update();
				
				// Luu vao bang user_sub_syncdata de goi api free data
				/* $sql = "INSERT INTO user_sub_syncdata (msisdn,action,package_id,created_time,updated_time)
				VALUES (:MSISDN,'UNSUBSCRIBE',:PACK_ID,NOW(),NOW())";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindParam(":MSISDN", $this->user_phone);
				$command->bindParam(":PACK_ID", $this->package_id);
				$command->execute(); */
			}

			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollback();
		}
	}

    public function getByPhone($phone = null) {
		return  self::model()->find( array(
            'condition'=>'user_phone = :PHONE AND status = :STT',
            'params'=>array(
                ':PHONE'=>$phone,
				':STT'=>self::ACTIVE
		),
		));
	}

	public function get($phone = null) {
		return  self::model()->find( array(
            'condition'=>'user_phone = :PHONE AND status=:STATUS',
            'params'=>array(
                ':PHONE'=>$phone,
                ':STATUS'=>self::ACTIVE,
            ),
            'order'=>'id desc'
		));
	}

    public function checkPromotion($phone=null)
    {
    	if(!$phone) return false;
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

    public function checkPromotionContent($phone)
    {
        /*
         * 08/05/2013: Close kich ban KM thue bao MT
         * @author: Tungnv
         */
        return false;

    	$sql = "SELECT COUNT(*) AS total FROM phone_book WHERE phone = '{$phone}' AND group_code='MIENTAY' ";
    	$data = Yii::app()->db->createCommand($sql)->queryRow();
    	if($data['total']>0){
    		return true;
    	}
    	return false;

    }
	public function check_promotion($phone) {
		$sql = "SELECT *
	        	FROM user_subscribe_km
	        	WHERE phone = '{$phone}'
        		AND (type = 0 OR (type = 1 AND created_time >= date_sub(NOW(), interval 2160 hour)))
        		";
		$subscribe = Yii::app()->db->createCommand($sql)->queryAll();
		if (!empty($subscribe)) {
			return false;
		}
		return true;
	}

	public function check_promotion_kmtq($phone, $event = "KMTQ")
	{

		$sql = "SELECT * FROM user_transaction WHERE user_phone = '{$phone}' AND note like '%{$event}%' AND `transaction` = 'subscribe' AND return_code = 0";
		$subscribe = Yii::app()->db->createCommand($sql)->queryAll();
		if(!empty($subscribe)){
			return false;
		}
		return true;
	}
}