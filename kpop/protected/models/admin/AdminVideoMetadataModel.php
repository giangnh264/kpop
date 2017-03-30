<?php

Yii::import('application.models.db.VideoMetadataModel');

class AdminVideoMetadataModel extends VideoMetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}