<?php

Yii::import('application.models.db.UserSubscribeModel');

class AdminUserSubscribeModel extends UserSubscribeModel {

    var $className = __CLASS__;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return CMap::mergeArray(parent::relations(), array(
                    'package' => array(self::BELONGS_TO, 'AdminPackageModel', 'package_id', 'select' => 'id, name, code', 'joinType' => 'LEFT JOIN'),
                ));
    }

    public function getTotal() {
        $sql = "
	    	SELECT 
				COUNT(*) AS total_subs,
				SUM(CASE WHEN status=1 THEN 1 ELSE 0 END) AS total_subs_active, 
				SUM(CASE WHEN status<>1 THEN 1 ELSE 0 END) AS total_subs_notactive 
			FROM user_subscribe";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.user_phone', Formatter::formatPhone($this->user_phone), true);
        $criteria->compare('t.package_id', $this->package_id);
        //$criteria->compare('created_time',$this->created_time,true);
        $criteria->compare('t.expired_time', $this->expired_time, true);
        $criteria->compare('t.status', $this->status);

        if (!empty($this->created_time)) {
            $criteria->addBetweenCondition('t.created_time', $this->created_time[0], $this->created_time[1]);
        }
        $criteria->with = array('package');
        $criteria->order = "t.created_time DESC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    public function getSubscribeExtIVR($time) {
        
//        $sql = "CREATE TABLE IF NOT EXISTS tmp_phone (user_phone VARCHAR(16) PRIMARY KEY)";
//        Yii::app()->dbroot->createCommand($sql)->execute();
//        
//        //$empty = "truncate table tmp_phone";
//        $empty = "DELETE FROM tmp_phone";
//        Yii::app()->db->createCommand($empty)->execute();
//
//        $where = "created_time>='{$time["from"]}' and created_time<='{$time["to"]}'";
//        $insert = "INSERT INTO tmp_phone select distinct user_phone from user_transaction where transaction='subscribe' and return_code=0 and channel='ivr' AND created_time>='2012-05-01 00:00:00' and created_time<=NOW()";
//        Yii::app()->db->createCommand($insert)->execute();
        /* $sql1 = "select count(*) as total 
        		from user_transaction as user 
        		inner join tmp_phone as tmp on user.user_phone=tmp.user_phone 
        		where user.transaction='subscribe_ext' and user.return_code=0 and user.created_time>='{$time["from"]}' and user.created_time<='{$time["to"]}'";
         */
        /* $sql = "SELECT count(*) as total
				FROM user_transaction as user 
        		INNER join user_transaction as tmp on user.user_phone=tmp.user_phone
				WHERE user.transaction='subscribe_ext' and user.return_code=0 and user.created_time>='{$time["from"]}' and user.created_time<='{$time["to"]}' AND tmp.transaction='subscribe' and tmp.return_code=0 and tmp.channel='ivr' and tmp.created_time>='{$time["from"]}' and tmp.created_time<='{$time["to"]}'";
        $count = Yii::app()->db->createCommand($sql)->queryAll();
        return $count[0]; */
        $sql = "SELECT sum(total_subscribe_ext_ivr) as total
        FROM statistic_transaction
        WHERE channel='ivr' and (date BETWEEN '{$time["from"]}' AND '{$time["to"]}')
        ";
        return Yii::app()->db->createCommand($sql)->queryScalar();
        
    }
    public function getUnSubscribeExtIVR($time) {
        
       /*  $sql = "SELECT count(distinct user.user_phone) as total
				FROM user_transaction as user
				INNER join user_transaction as tmp on user.user_phone=tmp.user_phone
				WHERE user.transaction='unsubscribe' and user.return_code=0 and user.created_time>='{$time["from"]}' and user.created_time<='{$time["to"]}' AND tmp.transaction='subscribe' and tmp.return_code=0 and tmp.channel='ivr' and tmp.created_time>='{$time["from"]}' and tmp.created_time<='{$time["to"]}'";
        $count = Yii::app()->db->createCommand($sql)->queryAll();
        return $count[0]; */
    	$sql = "SELECT sum(total_unsubscribe_ext_ivr) as total
    			FROM statistic_transaction
    			WHERE channel='ivr' and (date BETWEEN '{$time["from"]}' AND '{$time["to"]}')
    			";
    	return Yii::app()->db->createCommand($sql)->queryScalar();
    }

    public function dropTmpPhone() {
        $sql = "drop table if exists tmp_phone";
        //return Yii::app()->dbroot->createCommand($sql)->execute();
    }

}