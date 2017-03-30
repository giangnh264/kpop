<?php

Yii::import('application.models.db.MgActivityLogModel');

class AdminMgActivityLogModel extends MgActivityLogModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}