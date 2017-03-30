<?php

Yii::import('application.models.db.AlbumMetadataModel');

class AdminAlbumMetadataModel extends AlbumMetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}