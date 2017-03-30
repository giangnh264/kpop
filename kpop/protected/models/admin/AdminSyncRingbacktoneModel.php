<?php

Yii::import('application.models.db.SyncRingbacktoneModel');

class AdminSyncRingbacktoneModel extends SyncRingbacktoneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}