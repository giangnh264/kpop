<?php

Yii::import('application.models.db.CDRFILEModel');

class AdminCDRFILEModel extends CDRFILEModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}