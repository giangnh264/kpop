<?php

Yii::import('application.models.db.ObdPhoneModel');

class AdminObdPhoneModel extends ObdPhoneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}