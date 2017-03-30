<?php

Yii::import('application.models.db.SongGenreModel');

class AdminSongGenreModel extends SongGenreModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}