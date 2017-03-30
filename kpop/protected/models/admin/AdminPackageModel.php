<?php

Yii::import('application.models.db.PackageModel');

class AdminPackageModel extends PackageModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    
    public function getList()
    {
    	$c = new CDbCriteria();
    	$c->condition = "status = ".self::ACTIVE;
    	return self::model()->findAll($c);
    }
    
}