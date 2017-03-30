<?php

Yii::import('application.models.db.EmailTemplateModel');

class AdminEmailTemplateModel extends EmailTemplateModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}