<?php

Yii::import('application.models.db.RingtoneStatusModel');

class AdminRingtoneStatusModel extends RingtoneStatusModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}