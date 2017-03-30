<?php

Yii::import('application.models.db.PackageOfflineModel');

class AdminPackageOfflineModel extends PackageOfflineModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}