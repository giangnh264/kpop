<?php

class UserMonfeeModel extends BaseUserMonfeeModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserMonfee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function inserUser($number=1)
	{
		$sql = "truncate table user_monfee";
		Yii::app()->db->createCommand($sql)->execute();
		
		$toDay = date('Y-m-d');
		
		// Insert cac TB extend
		$cr = new CDbCriteria();
		$cr->condition = "status = 1 AND expired_time <= '$toDay 23:59:59' AND expired_time >= '$toDay 00:00:00' AND remain_status <> 1";
		$users = UserSubscribeModel::model()->findAll($cr);
		$limit = ceil(count($users) / $number);
		$total = 0;
		$thread = 1;
		foreach ($users as $user) {
			if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($user->user_phone))){
				continue;
			}
			
			$exits = UserMonfeeModel::model()->exists('msisdn = :PHONE', array(':PHONE' => $user->user_phone));
			if ($exits) {
				continue;
			}
			$model = new UserMonfeeModel();			
			$model->setAttributes(array(
					'msisdn' => $user->user_phone,
					'expired_time' => $user->expired_time,
					'page' => $thread,
					'created_time' => date('Y-m-d H:i:s'),
					'update_time' => date('Y-m-d H:i:s'),
					'package_id'=>$user->package_id,
					'type'=>'RENEW',
					'retry_on_day'=>0,
					'status'=>0,
			));
			$model->insert();
			$total++;
			if ($total % $limit == 0) {
				$thread++;
			}
		}
		
		// Insert cac TB retry
		$cr = new CDbCriteria();
		$cr->condition = "status = 1 AND expired_time < '$toDay 00:00:00' AND remain_status <> 1";
		$users = UserSubscribeModel::model()->findAll($cr);
		$limit = ceil(count($users) / $number);
		$total = 0;
		$thread = 1;
		foreach ($users as $user) {
			if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($user->user_phone))){
				continue;
			}
			
			$exits = UserMonfeeModel::model()->exists('msisdn = :PHONE', array(':PHONE' => $user->user_phone));
			if ($exits) {
				continue;
			}
			$model = new UserMonfeeModel();
			$model->setAttributes(array(
					'msisdn' => $user->user_phone,
					'expired_time' => $user->expired_time,
					'page' => $thread,
					'created_time' => date('Y-m-d H:i:s'),
					'update_time' => date('Y-m-d H:i:s'),
					'package_id'=>$user->package_id,
					'type'=>'RETRY',
					'retry_on_day'=>0,
					'status'=>0,
			));
			$model->insert();
			$total++;
			if ($total % $limit == 0) {
				$thread++;
			}
		}

		
		return $total;
	}
	
	
	public function getUser($thread, $type='RENEW', $limit = 1000) {
		$now = date('Y-m-d 23:59:59');
		$str = " AND (retry_on_day=0 OR (retry_on_day=1 AND HOUR(NOW()) >= 13))"; // 2 khung gio
		$cr = new CDbCriteria();
		$cr->condition = "type=:TYPE AND page=:THREAD AND status<>:STATUS AND expired_time <= :NOW AND retry_on_day < 2 $str";
		$cr->order = "retry_on_day ASC";
		
		$cr->limit = (int) $limit;
		$cr->params = array(':THREAD' => $thread, ':STATUS' => 1, ':NOW' => $now,":TYPE"=>$type);
		$result = self::model()->findAll($cr);
		return $result;
	}
}