<?php

Yii::import('application.models.db.AdsSourceModel');

class AdminAdsSourceModel extends AdsSourceModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}