<?php

Yii::import('application.models.db.SqlStatisticModel');

class AdminSqlStatisticModel extends SqlStatisticModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}