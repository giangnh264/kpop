<?php

Yii::import('application.models.db.ObdBlacklistModel');

class AdminObdBlacklistModel extends ObdBlacklistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}