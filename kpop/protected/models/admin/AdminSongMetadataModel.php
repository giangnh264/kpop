<?php

Yii::import('application.models.db.SongMetadataModel');

class AdminSongMetadataModel extends SongMetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}