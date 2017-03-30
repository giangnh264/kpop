<?php

Yii::import('application.models.db.LogApiProviderModel');

class AdminLogApiProviderModel extends LogApiProviderModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}