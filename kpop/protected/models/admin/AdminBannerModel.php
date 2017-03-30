<?php

Yii::import('application.models.db.BannerModel');

class AdminBannerModel extends BannerModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}