<?php

Yii::import('application.models.db.RingtoneStatisticModel');

class AdminRingtoneStatisticModel extends RingtoneStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}