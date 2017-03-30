<?php

Yii::import('application.models.db.MgGiftModel');

class AdminMgGiftModel extends MgGiftModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('from_phone', $this->from_phone, true);
        $criteria->compare('to_phone', $this->to_phone, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('song_id', $this->song_id);
        $criteria->compare('song_code', $this->song_code, true);
        $criteria->compare('song_nicename', $this->song_nicename, true);
        $criteria->compare('song_path', $this->song_path, true);
        $criteria->compare('status_sms_receive', $this->status_sms_receive);
        $criteria->compare('status_sms_send', $this->status_sms_send);
        $criteria->compare('count_call', $this->count_call);
        $criteria->compare('last_call', $this->last_call, true);
        $criteria->compare('status_receiver', $this->status_receiver);
        $criteria->compare('status_sender', $this->status_sender);
        $criteria->compare('type_send', $this->type_send);
        $criteria->compare('delivery_time', $this->delivery_time, true);
        if(!empty($this->created_time)){
            $criteria->addBetweenCondition('created_time', $this->created_time[0],$this->created_time[1]);
        }
        $criteria->compare('updated_time', $this->updated_time, true);
		$criteria->order = "t.id DESC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }
}