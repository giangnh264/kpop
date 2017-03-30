<?php

Yii::import('application.models.db.VideoPlaylistArtistModel');

class AdminVideoPlaylistArtistModel extends VideoPlaylistArtistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}