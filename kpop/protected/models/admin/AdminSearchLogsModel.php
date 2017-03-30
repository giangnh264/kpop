<?php

Yii::import('application.models.db.SearchLogsModel');

class AdminSearchLogsModel extends SearchLogsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}