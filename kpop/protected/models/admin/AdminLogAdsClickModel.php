<?php

Yii::import('application.models.db.LogAdsClickModel');

class AdminLogAdsClickModel extends LogAdsClickModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}