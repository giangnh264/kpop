<?php

Yii::import('application.models.db.RbtStatisticModel');

class AdminRbtStatisticModel extends RbtStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}