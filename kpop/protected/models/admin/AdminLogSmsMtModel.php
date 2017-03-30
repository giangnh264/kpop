<?php

Yii::import('application.models.db.LogSmsMtModel');

class AdminLogSmsMtModel extends LogSmsMtModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('sms_id',$this->sms_id,true);
		$criteria->compare('receive_phone',$this->receive_phone,true);
		//$criteria->compare('send_datetime',$this->send_datetime,true);
		$criteria->compare('sms_type',$this->sms_type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('charge',$this->charge);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('status',$this->status,true);

		if(!empty($this->send_datetime)){
			$criteria->addBetweenCondition('send_datetime',$this->send_datetime['fromTime'],$this->send_datetime['toTime']);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 'id DESC'),
			'pagination'=>array(
            		'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}