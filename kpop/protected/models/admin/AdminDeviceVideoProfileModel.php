<?php

Yii::import('application.models.db.DeviceVideoProfileModel');

class AdminDeviceVideoProfileModel extends DeviceVideoProfileModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}