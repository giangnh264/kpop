<?php

Yii::import('application.models.db.LogPlayerModel');

class AdminLogPlayerModel extends LogPlayerModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}