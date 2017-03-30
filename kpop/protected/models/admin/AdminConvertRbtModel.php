<?php

Yii::import('application.models.db.ConvertRbtModel');

class AdminConvertRbtModel extends ConvertRbtModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}