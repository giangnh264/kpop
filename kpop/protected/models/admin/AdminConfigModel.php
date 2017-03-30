<?php

Yii::import('application.models.db.ConfigModel');

class AdminConfigModel extends ConfigModel
{
    var $className = __CLASS__;

    CONST CHANNEL = 'all,wap,web,app,api';
    CONST CATEGORY = 'basic,advance';
    CONST TYPE = 'int,string,array';
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}