<?php

Yii::import('application.models.db.UserSubscribeModel');

class BmUserSubscribeModel extends UserSubscribeModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

    public function getInactiveSubscribe($phone = null) {
		return  self::model()->find( array(
            'condition'=>'user_phone = :PHONE AND status<>:STATUS',
            'params'=>array(
                ':PHONE'=>$phone,
                ':STATUS'=>BmUserSubscribeModel::ACTIVE,
		),
		));
	}
	public function getRegisteredPhone($phone =null) {
		return  self::model()->find( array(
            'condition'=>'user_phone = :PHONE AND status =:STATUS',
            'params'=>array(
                ':PHONE'=>$phone,
                ':STATUS'=>BmUserSubscribeModel::ACTIVE,
		),
		));
	}
        
}