<?php

class UserChargeRemainCycleModel extends BaseUserChargeRemainCycleModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserChargeRemainCycle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function removeExpired()
    {
        $endDay = date("Y-m-d 23:59:59");

        //Update trang thai remain trong user_subscribe
        $sql = "UPDATE user_subscribe t1, user_charge_remain_cycle t2 SET t1.remain_status = 0 
				WHERE t1.user_phone = t2.msisdn AND t2.end_date<:END";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":END", $endDay,PDO::PARAM_STR);
        $command->execute();

        // Xoa khoi bang user_charge_remain
        $sql = "DELETE FROM user_charge_remain_cycle WHERE end_date<:END";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":END", $endDay,PDO::PARAM_STR);
        $command->execute();
    }

    public function getList($limit=1000)
    {
        $beginDay = date("Y-m-d 00:00:00");
        $endDay = date("Y-m-d 23:59:59");
        $c = new CDbCriteria();
        $c->condition = "end_date>=:END AND retry_on_day < 2 AND (last_success_time < :BEGIN OR last_success_time IS NULL)";
        $c->params = array(":BEGIN"=>$beginDay,":END"=>$endDay);
        $c->limit = $limit;
        $c->order = "retry_on_day ASC, charge_date ASC";


        $userRemainList = self::model()->findAll($c);
        return $userRemainList;
    }

    public function addRemain($msisdn, $packageId, $chargTime, $endTime)
    {
        $sql = "INSERT INTO user_charge_remain_cycle(msisdn,package_id,end_date,charge_date)
							VALUE(:msisdn,:package_id,:end_date,:charge_date)
							ON DUPLICATE KEY UPDATE end_date=:end_date,charge_date=:charge_date													
							";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
        $command->bindParam(':package_id', $packageId, PDO::PARAM_STR);
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
            $userRemain->delete();
            //Update status remain for user_subscribe
            $userSubscribe = UserSubscribeModel::model()->findByAttributes(array("user_phone"=>$msisdn));
            if($userSubscribe){
                $userSubscribe->remain_status = 0;
                $userSubscribe->update();
            }
        }
    }

    public function reset_retry_on_day(){
        $sql = "UPDATE user_charge_remain_cycle SET retry_on_day = 0";
        Yii::app()->db->createCommand($sql)->execute();
    }
}