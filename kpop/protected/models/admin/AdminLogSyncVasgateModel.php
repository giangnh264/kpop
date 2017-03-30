<?php

Yii::import('application.models.db.LogSyncVasgateModel');

class AdminLogSyncVasgateModel extends LogSyncVasgateModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}