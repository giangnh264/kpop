<?php

Yii::import('application.models.db.LogSmsMoModel');

class AdminLogSmsMoModel extends LogSmsMoModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('sms_id',$this->sms_id,true);
		$criteria->compare('sender_phone',$this->sender_phone,true);
		//$criteria->compare('receive_time',$this->receive_time,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('auth_user',$this->auth_user,true);
		$criteria->compare('auth_pass',$this->auth_pass,true);
		$criteria->compare('output_id',$this->output_id);
		$criteria->compare('status',$this->status,true);
		
		if(!empty($this->receive_time)){
			$criteria->addBetweenCondition('receive_time',$this->receive_time['fromTime'],$this->receive_time['toTime']);
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