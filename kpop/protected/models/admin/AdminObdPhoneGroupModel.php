<?php

Yii::import('application.models.db.ObdPhoneGroupModel');

class AdminObdPhoneGroupModel extends ObdPhoneGroupModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}