<?php

Yii::import('application.models.db.SmsKeywordModel');

class AdminSmsKeywordModel extends SmsKeywordModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}