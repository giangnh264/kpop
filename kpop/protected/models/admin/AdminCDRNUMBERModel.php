<?php

Yii::import('application.models.db.CDRNUMBERModel');

class AdminCDRNUMBERModel extends CDRNUMBERModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}