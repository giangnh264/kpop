<?php

Yii::import('application.models.db.SmsTemplateModel');

class AdminSmsTemplateModel extends SmsTemplateModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}