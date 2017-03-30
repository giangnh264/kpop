<?php

class UserChachaVipModel extends BaseUserChachaVipModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChachaVip the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function isVipChacha($msisdn)
	{
		$curTime = date('Y-m-d H:i:s');
		$criteria = new CDbCriteria();
		$criteria->condition = "user_phone=:phone AND from_datetime<=:time AND to_datetime>=:time";
		$criteria->params = array(':phone'=>$msisdn,':time'=>$curTime);
		return self::model()->find($criteria);
	}
}