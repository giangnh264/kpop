<?php

Yii::import('application.models.db.EmailServerModel');

class AdminEmailServerModel extends EmailServerModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}