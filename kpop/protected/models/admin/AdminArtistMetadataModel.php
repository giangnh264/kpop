<?php

Yii::import('application.models.db.ArtistMetadataModel');

class AdminArtistMetadataModel extends ArtistMetadataModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}