<?php

Yii::import('application.models.db.CpModel');

class AdminCpModel extends CpModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}