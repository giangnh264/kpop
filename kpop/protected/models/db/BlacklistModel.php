<?php

class BlacklistModel extends BaseBlacklistModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Blacklist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkBlacklist($msisdn){
	    $blacklist =  self::model()->findByPk($msisdn);
        if(!empty($blacklist)) return true;
        else return false;
    }
}