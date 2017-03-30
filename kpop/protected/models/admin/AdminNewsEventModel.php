<?php

Yii::import('application.models.db.NewsEventModel');

class AdminNewsEventModel extends NewsEventModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function beforeSave()
    {
    	$this->updated_time = new CDbExpression('NOW()');
    	return parent::beforeSave();
    }
}