<?php

Yii::import('application.models.db.SmsQueuePushSystemModel');

class AdminSmsQueuePushSystemModel extends SmsQueuePushSystemModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}