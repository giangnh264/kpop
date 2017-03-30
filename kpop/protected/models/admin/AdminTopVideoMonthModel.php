<?php

Yii::import('application.models.db.TopVideoMonthModel');

class AdminTopVideoMonthModel extends TopVideoMonthModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}