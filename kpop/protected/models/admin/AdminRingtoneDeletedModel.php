<?php

Yii::import('application.models.db.RingtoneDeletedModel');

class AdminRingtoneDeletedModel extends RingtoneDeletedModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}