<?php

Yii::import('application.models.db.UserTransactionModel');

class BmUserTransactionModel extends UserTransactionModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	/**
	 *	get action = download, play video, song
	 *  params = $phone,songId,$action,$source
	 */
	public function checkCharging24h($params, $tophone="", $objId="", $type="", $baseId=0) {
		return parent::checkCharging24h($params['msisdn'], $params['msisdn'], $params['obj1_id'], $params['cmd']);
	}

    public static function checkExtend24h($params)
    {
        $criteria = new CDbCriteria();
        $result = false;
        $criteria->condition="user_phone=:PHONE AND obj1_id=:OBJ_ID AND transaction ='subscribe_ext' AND (return_code = '0' OR return_code = 0) AND price>0";
        $criteria->addCondition("created_time  >= '".date('Y-m-d H:i:s', strtotime('-1 day'))."'");
        $criteria->addCondition("created_time  <= '".date('Y-m-d H:i:s')."'");
        $criteria->params=array(
            ':PHONE'       => $params['obj2_name'],
            ':OBJ_ID'     => $params['obj1_id'],
        );
        $trasaction = BmUserTransactionModel::model()->find($criteria);
        if ($trasaction) return true;
        return $result;
    }

    public function countTransaction($phone, $transaction, $startTime, $endTime)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "user_phone = :PHONE AND transaction = :TRANSACTION AND created_time > :START_TIME AND created_time < :END_TIME AND obj2_name = :PHONE";
        $criteria->params = array(":PHONE" => $phone, ":TRANSACTION" => $transaction, ":START_TIME" => $startTime, ":END_TIME" => $endTime);
        $result = BmUserTransactionModel::model()->count($criteria);
        return $result;
    }
}