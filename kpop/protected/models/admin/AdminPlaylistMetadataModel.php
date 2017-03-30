<?php

Yii::import('application.models.db.PlaylistMetadataModel');

class AdminPlaylistMetadataModel extends PlaylistMetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}