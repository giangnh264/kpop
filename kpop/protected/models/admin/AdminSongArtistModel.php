<?php

Yii::import('application.models.db.SongArtistModel');

class AdminSongArtistModel extends SongArtistModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}