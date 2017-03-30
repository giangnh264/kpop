<?php

Yii::import('application.models.db.DeviceSubscribeModel');

class AdminDeviceSubscribeModel extends DeviceSubscribeModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}