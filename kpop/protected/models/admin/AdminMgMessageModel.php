<?php

Yii::import('application.models.db.MgMessageModel');

class AdminMgMessageModel extends MgMessageModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}