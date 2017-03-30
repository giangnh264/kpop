<?php

Yii::import('application.models.db.ObdActivityModel');

class AdminObdActivityModel extends ObdActivityModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}