<?php

Yii::import('application.models.db.RbtExtraModel');

class AdminRbtExtraModel extends RbtExtraModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}