<?php

Yii::import('application.models.db.RbtStatusModel');

class AdminRbtStatusModel extends RbtStatusModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}