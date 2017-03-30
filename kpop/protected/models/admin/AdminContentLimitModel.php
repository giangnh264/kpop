<?php

Yii::import('application.models.db.ContentLimitModel');

class AdminContentLimitModel extends ContentLimitModel
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
    
    	$criteria->compare('id',$this->id);
    	$criteria->compare('content_id',$this->content_id);
    	$criteria->compare('content_name',$this->content_name,true);
    	$criteria->compare('content_type',$this->content_type,true);
    	$criteria->compare('apply',$this->apply,true);
    	$criteria->compare('begin_time',$this->begin_time,true);
    	$criteria->compare('end_time',$this->end_time,true);
    	$criteria->compare('channel',$this->channel,true);
    	$criteria->compare('msg_warning',$this->msg_warning,true);
    	$criteria->order = "id DESC";
    
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}