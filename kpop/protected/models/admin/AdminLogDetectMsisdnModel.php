<?php

Yii::import('application.models.db.LogDetectMsisdnModel');

class AdminLogDetectMsisdnModel extends LogDetectMsisdnModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}