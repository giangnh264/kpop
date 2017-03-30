<?php

Yii::import('application.models.db.PushNotifSettingModel');

class AdminPushNotifSettingModel extends PushNotifSettingModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}