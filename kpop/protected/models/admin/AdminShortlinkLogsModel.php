<?php

Yii::import('application.models.db.ShortlinkLogsModel');

class AdminShortlinkLogsModel extends ShortlinkLogsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}