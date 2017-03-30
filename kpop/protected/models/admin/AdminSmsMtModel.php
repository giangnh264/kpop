<?php

Yii::import('application.models.db.SmsMtModel');

class AdminSmsMtModel extends SmsMtModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}