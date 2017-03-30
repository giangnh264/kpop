<?php

class UserChargeRemainModel extends BaseUserChargeRemainModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChargeRemain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function addRemain($msisdn, $packageId, $price, $chargTime, $endTime)
	{
		$sql = "INSERT INTO user_charge_remain(msisdn,package_id,remain,end_date,charge_date)
							VALUE(:msisdn,:package_id,:remain,:end_date,:charge_date)
							ON DUPLICATE KEY UPDATE end_date=:end_date,
													charge_date=:charge_date													
							";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
		$command->bindParam(':package_id', $packageId, PDO::PARAM_STR);
		$command->bindParam(':remain', $price, PDO::PARAM_STR);
		$command->bindParam(':end_date', $endTime, PDO::PARAM_STR);
		$command->bindParam(':charge_date', $chargTime, PDO::PARAM_STR);
		$ret = $command->execute();
		
		//Update status remain for user_subscribe
		$userSubscribe = UserSubscribeModel::model()->findByAttributes(array("user_phone"=>$msisdn));
		
		if($userSubscribe){
			$userSubscribe->remain_status = 1;
			$ret = $userSubscribe->save(false);
		}
	}
	
	public function removeRemain($msisdn)
	{
		$userRemain = self::model()->findByAttributes(array("msisdn"=>$msisdn));
		if($msisdn){
			$msisdn->delete();
			
			//Update status remain for user_subscribe
			$userSubscribe = UserSubscribeModel::model()->findByAttributes(array("user_phone"=>$msisdn));
			if($userSubscribe){
				$userSubscribe->remain_status = 0;
				$userSubscribe->update();
			}			
		}
	}
	
	public function removeExpired()
	{
		$beginDay = date("Y-m-d 00:00:00");
		$endDay = date("Y-m-d 23:59:59");
		
		//Update trang thai remain trong user_subscribe
		$sql = "UPDATE user_subscribe t1, user_charge_remain t2 SET t1.remain_status = 0 
				WHERE t1.user_phone = t2.msisdn AND t2.end_date<:END";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(":END", $endDay,PDO::PARAM_STR);
		$command->execute();
		
		// Xoa khoi bang user_charge_remain
		$sql = "DELETE FROM user_charge_remain WHERE end_date<:END";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(":END", $endDay,PDO::PARAM_STR);
		$command->execute();
	}
	
	
	public function getList($limit=1000)
	{
		$beginDay = date("Y-m-d 00:00:00");
		$endDay = date("Y-m-d 23:59:59");
		$c = new CDbCriteria();
		$c->condition = "charge_date>=:BEGIN AND end_date>=:END AND retry_on_day < 2";
		$c->params = array(":BEGIN"=>$beginDay,":END"=>$endDay);
		$c->limit = $limit;
		$c->order = "retry_on_day ASC, charge_date ASC";
		
		
		$userRemainList = self::model()->findAll($c);
		return $userRemainList; 
	}
}