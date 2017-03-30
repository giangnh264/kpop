<?php

Yii::import('application.models.db.StatisticDetectMsisdnModel');

class AdminStatisticDetectMsisdnModel extends StatisticDetectMsisdnModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getStatisticDetect($time)
    {
    	$sql = "SELECT * 
    			FROM statistic_detect_msisdn 
    			WHERE date >= '{$time['from']}' AND date <= '{$time['to']}' 
    			ORDER BY date DESC";
    	return Yii::app()->db->createCommand($sql)->queryAll();
    }
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('date',$this->date,true);
		$criteria->compare('total_count',$this->total_count,true);
		$criteria->compare('sucessful_count',$this->sucessful_count,true);
		$criteria->compare('subs_count',$this->subs_count);
		$criteria->compare('total_count_wap',$this->total_count_wap);
		$criteria->compare('sucessful_count_wap',$this->sucessful_count_wap);
		$criteria->compare('subs_count_wap',$this->subs_count_wap);
		$criteria->compare('total_count_ios',$this->total_count_ios);
		$criteria->compare('sucessful_count_ios',$this->sucessful_count_ios);
		$criteria->compare('subs_count_ios',$this->subs_count_ios);
		$criteria->compare('total_count_android',$this->total_count_android);
		$criteria->compare('sucessful_count_android',$this->sucessful_count_android);
		$criteria->compare('subs_count_android',$this->subs_count_android);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'date DESC'),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
	
	
}