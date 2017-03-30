<?php

Yii::import('application.models.db.LogAppModel');

class AdminLogAppModel extends LogAppModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}