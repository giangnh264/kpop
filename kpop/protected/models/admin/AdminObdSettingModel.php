<?php

Yii::import('application.models.db.ObdSettingModel');

class AdminObdSettingModel extends ObdSettingModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}