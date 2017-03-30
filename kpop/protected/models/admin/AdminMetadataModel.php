<?php

Yii::import('application.models.db.MetadataModel');

class AdminMetadataModel extends MetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}