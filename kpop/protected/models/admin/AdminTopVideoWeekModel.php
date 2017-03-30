<?php

Yii::import('application.models.db.TopVideoWeekModel');

class AdminTopVideoWeekModel extends TopVideoWeekModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}