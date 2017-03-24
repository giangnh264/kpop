<?php

Yii::import('application.models.db.UserQuotaModel');

class BmUserQuotaModel extends UserQuotaModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function getUq($msisdn,$packageId) {
		return  self::model()->find( array(
            'condition'=>'user_phone = :PHONE AND package_id =:PACKAGE',
            'params'=>array(
                ':PHONE'=>$msisdn,
				':PACKAGE'=>$packageId,
		),
		));
	}
	public function  isRegisteredThisMonth($phone, $packageId) {
		$criteria = new CDbCriteria();
		$criteria->condition = "user_phone = :PHONE AND package_id = :PACKAGE_ID";
		$criteria->params = array(
			':PHONE' 	  => $phone,
			':PACKAGE_ID' => $packageId,
		);
		$criteria->addCondition("month(created_time) = month(now()) AND year(created_time) = year(now())");
		return self::model()->find($criteria);
	}
	public function add($params) {
		//not allow insert if exits
		if(!$this->getUq($params["msisdn"], $params["packageId"])) 
		{
			$userQuota = new BmUserQuotaModel();
			$userQuota->time = '0'; // edit here if have promotion
			$userQuota->songs = '0';
			$userQuota->package_id = $params["packageId"];
			$userQuota->user_phone = $params["msisdn"];
			$userQuota->created_time = $params["createdDatetime"];
			$userQuota->expired_time = $params["quota"];
			$userQuota->save();
		}
	}
	public function get($msisdn) {
		return  self::model()->findAll( array(
            'condition'=>'user_phone = :PHONE',
            'params'=>array(
                ':PHONE'=>$msisdn,
		),
		));
	}
}