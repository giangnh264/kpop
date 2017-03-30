<?php

Yii::import('application.models.db.FeedbackModel');

class AdminFeedbackModel extends FeedbackModel
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
    	$criteria->compare('phone',$this->phone,true);
    	$criteria->compare('title',$this->title,true);
    	$criteria->compare('content',$this->content,true);
    	$criteria->compare('parent_id',$this->parent_id);
    	$criteria->compare('type',$this->type);
    	$criteria->compare('created_datetime',$this->created_datetime,true);
    	$criteria->compare('version',$this->version,true);
    	$criteria->compare('status',$this->status);
    	$criteria->order="id DESC";
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}