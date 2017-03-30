<?php

Yii::import('application.models.db.DeviceModel');

class AdminDeviceModel extends DeviceModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}